<?php

namespace Laravue\Database;

use Laravue\Database\Eloquent\HtmlTableBuilder;

/**
 * Trait HasTable
 *
 * Created by allancarvalho in agosto 26, 2022
 */
trait HasHtmlTable
{
    public static function htmlTable(): HtmlTableBuilder
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = (new static());

        $builder = (new HtmlTableBuilder($model->newBaseQueryBuilder()))->setModel($model);

        if (! empty(static::$globalScopes[self::class])) {
            foreach (static::$globalScopes[self::class] as $identifier => $scope) {
                $builder->withGlobalScope($identifier, $scope);
            }
        }

        return $builder;
    }
}
