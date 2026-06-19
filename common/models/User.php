<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * USER MODEL (CLEAN + RBAC READY + SIGNUP SAFE)
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * =====================
     * VIRTUAL ATTRIBUTE
     * =====================
     */
    public $password;

    /**
     * =====================
     * STATUS CONSTANTS
     * =====================
     */
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    /**
     * =====================
     * ROLE CONSTANTS
     * =====================
     */
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
     * =====================
     * VALIDATION RULES (FIXED)
     * =====================
     */
    public function rules(): array
    {
        return [

            [['username', 'email'], 'required'],

            [['username', 'email'], 'unique'],

            ['email', 'email'],

            ['username', 'string', 'min' => 3, 'max' => 50],

            // password optional here (handled in SignupForm)
            ['password', 'safe'],

            // status default
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

            // role default FIX (IMPORTANT)
            ['role', 'default', 'value' => self::ROLE_OWNER],

            [
                'role',
                'in',
                'range' => [
                    self::ROLE_OWNER,
                    self::ROLE_SELLER,
                ]
            ],

            ['branch_id', 'integer'],
        ];
    }

    /**
     * =====================
     * 
     * RELATIONS
     * =====================
     */


    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['id' => 'branch_id']);

    }
    //business via branch
    public function getBusiness()
    {
        return $this->hasOne(Business::class, ['id' => 'business_id']
        )->via('branch');
    }

    /**
     * =====================
     * ROLE HELPERS
     * =====================
     */
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

    /**
     * =====================
     * IDENTITY METHODS
     * =====================
     */
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

    /**
     * =====================
     * PASSWORD HANDLING
     * =====================
     */
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

    /**
     * =====================
     * TOKENS
     * =====================
     */
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

    /**
     * =====================
     * IDENTITY INTERFACE
     * =====================
     */
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