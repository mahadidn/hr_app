<?php

namespace App\Traits;

use Ramsey\Uuid\Provider\Node\RandomNodeProvider;
use Ramsey\Uuid\Uuid;

/**
 * @method static void creating(\Closure $callback)
 * implement manually auto generated uuid v6 + random node trait to more secure
 */
trait HasUuid
{
    /**
     * Boot the trait.
     */
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {

            // If ID is empty, then generate UUIDv6 + random node automatically
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Uuid::uuid6(
                    (new RandomNodeProvider())->getNode(),
                    null
                )->toString();
            }
        });
    }

    /**
     * tell the laravel that the primary key isn't incrementing
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * tell the laravel that the key type of the primary key is string 
     */
    public function getKeyType()
    {
        return 'string';
    }
}
