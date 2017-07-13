<?php

namespace App\Traits;

use App\UserLog;

trait Loggable
{
    public static $typeName;

    public static function bootLoggable()
    {
        static::created(function($model) {
            $userId = auth()->id();
            static::storeAction(self::$typeName, $userId, $model, $model->toArray());
        });

        static::updated(function($model) {
            $userId = auth()->id();
            $changes = static::getChanges($model);
            static::storeAction(self::$typeName, $userId, $model, $changes);
        });

        static::deleted(function($model) {
            $userId = auth()->id();
            static::storeAction(self::$typeName, $userId, $model);
        });
    }

    public static function getChanges($model)
    {
        $changes = [];

        foreach ($model->getDirty() as $key => $value) {
            if (!in_array($key, static::getIgnoreKeys($model))) {
                $original = $model->getOriginal($key);

                if ($original == $value) continue;

                $changes[$key] = [
                    'old' => $original,
                    'new' => $value,
                ];
            }
        }

        $changes = array_merge($changes, ['ip' => request()->ip()]);

        return $changes ?: NULL;
    }

    public static function storeAction($actionTypeName, $userId, $model, $changes = [])
    {
        UserLog::create([
            'user_id' => $userId,
            'action_id' => $model->id,
            'action_type' => get_class($model),
            'action' => $actionTypeName,
            'changes' => $changes,
        ]);
    }

    public static function setActionTypeName($value)
    {
        self::$typeName = $value;
    }

    public static function getIgnoreKeys($model)
    {
        $modelIgnoreKeys = $model->changeIgnoreKeys?:[];

        return array_merge($modelIgnoreKeys, ['updated_at','created_at','deleted_at']);
    }
}
