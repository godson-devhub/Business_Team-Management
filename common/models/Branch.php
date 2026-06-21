<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Branch Model (ERP CORE — COMPLETE)
 *
 * Business → has many branches
 * Branch → has sellers + products + sales + purchases
 *
 * @property int $id
 * @property int $business_id
 * @property string $name
 * @property string|null $location
 * @property int $created_at
 * @property int $updated_at
 *
 * Computed properties:
 * @property-read int $sellerCount
 * @property-read int $productCount
 * @property-read float $totalSales
 * @property-read float $totalSalesAmount
 * @property-read float $totalProfit
 * @property-read float $stockValue
 * @property-read int $stockQuantity
 * @property-read int $lowStockCount
 * @property-read int $totalSalesCount
 * @property-read User[] $activeSellers
 * @property-read Sale[] $recentSales
 */
class Branch extends ActiveRecord
{
    // =========================
    // TABLE
    // =========================
    public static function tableName(): string
    {
        return '{{%branch}}';
    }

    // =========================
    // BEHAVIORS
    // =========================
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    // =========================
    // RULES
    // =========================
    public function rules(): array
    {
        return [
            [['name', 'business_id'], 'required'],
            [['business_id'], 'integer'],
            [['location'], 'string'],
            [['name'], 'string', 'max' => 255],

            [
                ['business_id'],
                'exist',
                'targetClass' => Business::class,
                'targetAttribute' => ['business_id' => 'id'],
                'message' => 'Business does not exist'
            ],
        ];
    }

    // =========================
    // RELATIONS
    // =========================

    /**
     * Branch belongs to Business
     */
    public function getBusiness()
    {
        return $this->hasOne(Business::class, ['id' => 'business_id']);
    }

    /**
     * Branch has many sellers (users)
     */
    public function getSellers()
    {
        return $this->hasMany(User::class, ['branch_id' => 'id']);
    }

    /**
     * Active sellers in this branch
     */
    public function getActiveSellers()
    {
        return $this->hasMany(User::class, ['branch_id' => 'id'])
            ->andWhere(['status' => User::STATUS_ACTIVE])
            ->andWhere(['role' => User::ROLE_SELLER]);
    }

    /**
     * Branch has many products
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['branch_id' => 'id']);
    }

    /**
     * Branch has many sales
     */
    public function getSales()
    {
        return $this->hasMany(Sale::class, ['branch_id' => 'id']);
    }

    /**
     * Branch has many sale items (direct relation)
     */
    public function getSaleItems()
    {
        return $this->hasMany(SaleItem::class, ['branch_id' => 'id']);
    }

    /**
     * Branch has many purchases
     */
    public function getPurchases()
    {
        return $this->hasMany(Purchase::class, ['branch_id' => 'id']);
    }

    /**
     * Recent sales (last 30 days)
     */
    public function getRecentSales($limit = 10)
    {
        return $this->getSales()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    /**
     * Top selling products in this branch
     */
    public function getTopProducts($limit = 5)
    {
        return Product::find()
            ->alias('p')
            ->select([
                'p.*',
                'total_sold' => new Expression('SUM(si.quantity)'),
                'total_revenue' => new Expression('SUM(si.subtotal)'),
            ])
            ->leftJoin('{{%sale_items}} si', 'si.product_id = p.id')
            ->where(['p.branch_id' => $this->id])
            ->groupBy('p.id')
            ->orderBy(['total_sold' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    // =========================
    // COMPUTED PROPERTIES (ANALYTICS)
    // =========================

    /**
     * Total sellers count
     */
    public function getSellerCount(): int
    {
        return (int) $this->getSellers()->count();
    }

    /**
     * Active sellers count
     */
    public function getActiveSellerCount(): int
    {
        return (int) $this->getActiveSellers()->count();
    }

    /**
     * Total products count
     */
    public function getProductCount(): int
    {
        return (int) $this->getProducts()->count();
    }

    /**
     * Total sales TRANSACTIONS count (idadi ya mauzo)
     */
    public function getTotalSalesCount(): int
    {
        return (int) $this->getSales()->count();
    }

    /**
     * Total sales REVENUE (kiasi cha fedha — TZS)
     * @deprecated Use getTotalSalesAmount() for clarity
     */
    public function getTotalSales(): float
    {
        return $this->getTotalSalesAmount();
    }

    /**
     * Total sales REVENUE (kiasi cha fedha — TZS)
     * Uses COALESCE to handle NULL when no sales exist
     */
    public function getTotalSalesAmount(): float
    {
        return (float) Sale::find()
            ->where(['branch_id' => $this->id])
            ->andWhere(['status' => 'completed']) // only completed sales
            ->sum(new Expression('COALESCE(total_amount, 0)')) ?? 0;
    }

    /**
     * Total profit (TZS)
     * Uses COALESCE to handle NULL when no sales exist
     */
    public function getTotalProfit(): float
    {
        return (float) Sale::find()
            ->where(['branch_id' => $this->id])
            ->andWhere(['status' => 'completed'])
            ->sum(new Expression('COALESCE(total_profit, 0)')) ?? 0;
    }

    /**
     * Total stock VALUE (quantity × buying_price)
     * This is the inventory worth/cost
     */
    public function getStockValue(): float
    {
        return (float) Product::find()
            ->where(['branch_id' => $this->id])
            ->sum(new Expression('COALESCE(stock_quantity, 0) * COALESCE(buying_price, 0)')) ?? 0;
    }

    /**
     * Total stock QUANTITY (total units in inventory)
     */
    public function getStockQuantity(): int
    {
        return (int) Product::find()
            ->where(['branch_id' => $this->id])
            ->sum(new Expression('COALESCE(stock_quantity, 0)')) ?? 0;
    }

    /**
     * Low stock products count
     * Uses min_stock_alert from product table (not fixed 5)
     */
    public function getLowStockCount(): int
    {
        return (int) Product::find()
            ->where(['branch_id' => $this->id])
            ->andWhere(new Expression('stock_quantity <= min_stock_alert'))
            ->andWhere(['>', 'min_stock_alert', 0]) // avoid division by zero / invalid
            ->count();
    }

    /**
     * Out of stock products count
     */
    public function getOutOfStockCount(): int
    {
        return (int) Product::find()
            ->where(['branch_id' => $this->id])
            ->andWhere(['<=', 'stock_quantity', 0])
            ->count();
    }

    /**
     * Average profit per sale
     */
    public function getAverageProfitPerSale(): float
    {
        $count = $this->getTotalSalesCount();
        if ($count === 0) {
            return 0;
        }
        return $this->getTotalProfit() / $count;
    }

    /**
     * Profit margin percentage
     */
    public function getProfitMargin(): float
    {
        $sales = $this->getTotalSalesAmount();
        if ($sales <= 0) {
            return 0;
        }
        return ($this->getTotalProfit() / $sales) * 100;
    }

    // =========================
    // SCOPES (Query helpers)
    // =========================

    /**
     * Scope: Only branches with low stock
     */
    public static function findWithLowStock()
    {
        return self::find()
            ->joinWith('products')
            ->andWhere(new Expression('product.stock_quantity <= product.min_stock_alert'));
    }

    /**
     * Scope: Branches with sales today
     */
    public static function findWithSalesToday()
    {
        $todayStart = strtotime('today midnight');
        $todayEnd = strtotime('tomorrow midnight') - 1;

        return self::find()
            ->joinWith(['sales' => function ($q) use ($todayStart, $todayEnd) {
                $q->andWhere(['between', 'sale.created_at', $todayStart, $todayEnd]);
            }]);
    }

    // =========================
    // LABELS
    // =========================
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'business_id' => 'Business',
            'name' => 'Branch Name',
            'location' => 'Location',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    // =========================
    // TO STRING
    // =========================
    public function __toString(): string
    {
        return $this->name;
    }
}