<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * User Model (ERP READY)
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property string $role
 * @property int $status
 * @property int|null $branch_id
 * @property int $created_at
 * @property int $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    //virtual attributes(not db fields)
    public $password;



    
    // =====================
    // STATUS CONSTANTS
    // =====================
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    // =====================
    // ROLE CONSTANTS
    // =====================
    public const ROLE_OWNER = 'owner';
    public const ROLE_SELLER = 'seller';

    /**
     * TABLE NAME
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * BEHAVIORS
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * VALIDATION RULES
     */
    public function rules(): array
    {
        return [

            [['username', 'email'], 'required'],

            [['username', 'email'], 'unique'],

            ['email', 'email'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],

            [
                'status',
                'in',
                'range' => [
                    self::STATUS_ACTIVE,
                    self::STATUS_INACTIVE,
                    self::STATUS_DELETED,
                ]
            ],

            ['role', 'required'],

            [
                'role',
                'in',
                'range' => [
                    self::ROLE_OWNER,
                    self::ROLE_SELLER,
                ]
            ],

            ['role', 'default', 'value' => self::ROLE_SELLER],

            ['branch_id', 'integer'],
        ];
    }

    // =====================
    // RELATIONS
    // =====================

    /**
     * Seller belongs to one branch
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['id' => 'branch_id']);
    }

    // =====================
    // ROLE HELPERS
    // =====================

    public function isOwner(): bool
    {
        return $this->role === self::ROLE_OWNER;
    }

    public function isSeller(): bool
    {
        return $this->role === self::ROLE_SELLER;
    }

    public function getRoleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_OWNER => 'Owner',
            self::ROLE_SELLER => 'Seller',
            default => 'Unknown',
        };
    }

    // =====================
    // IDENTITY METHODS
    // =====================

    public static function findIdentity($id): ?User
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findIdentityByAccessToken($token, $type = null): never
    {
        throw new NotSupportedException('Not supported');
    }

    public static function findByUsername(string $username): ?User
    {
        return static::findOne([
            'username' => $username,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    // =====================
    // PASSWORD HANDLING
    // =====================

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword(
            $password,
            $this->password_hash
        );
    }

    public function setPassword(string $password): void
    {
        $this->password_hash =
            Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey(): void
    {
        $this->auth_key =
            Yii::$app->security->generateRandomString();
    }

    // =====================
    // TOKENS
    // =====================

    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token =
            Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken(): void
    {
        $this->verification_token =
            Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    // =====================
    // AUTH INTERFACE
    // =====================

    public function getId(): int
    {
        return (int) $this->getPrimaryKey();
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }
}