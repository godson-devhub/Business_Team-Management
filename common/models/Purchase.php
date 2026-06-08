<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Purchase (Stock IN)
 *
 * @property int $id
 * @property int $branch_id
 * @property int $created_by (seller/user)
 * @property float $total_amount
 * @property string|null $note
 * @property int $created_at
 * @property int $updated_at
 */
class Purchase extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%purchase}}';
    }

    public function behaviors(): array
    {
        return [TimestampBehavior::class];
    }

    public function rules(): array
    {
        return [
            [['branch_id', 'created_by'], 'required'],
            [['branch_id', 'created_by'], 'integer'],
            [['total_amount'], 'number'],
            [['note'], 'string'],
        ];
    }

    public function getItems()
    {
        return $this->hasMany(PurchaseItem::class, ['purchase_id' => 'id']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['id' => 'branch_id']);
    }
}