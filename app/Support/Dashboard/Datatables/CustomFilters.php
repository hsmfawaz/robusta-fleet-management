<?php

namespace App\Support\Dashboard\Datatables;

use Framework\Support\Traits\TranslatedSearch;
use Illuminate\Database\Eloquent\Builder;

class CustomFilters
{
    use TranslatedSearch;

    public static function translated($name)
    {
        return fn ($q, $k) => self::searchColumn($q, $name, $k);
    }

    public static function translatedRelation($relation)
    {
        return static function ($query, $keyword) use ($relation) {
            $listOfRelation = array_reverse(explode('.', $relation));
            self::deepRelation($query, $listOfRelation, $keyword);

            return $query;
        };
    }

    public static function deepRelation(Builder $builder, array $relationList, $keyword)
    {
        $relation = array_pop($relationList);
        if (count($relationList) === 0) {
            self::searchColumn($builder, $relation, $keyword);

            return;
        }
        $builder->whereHas($relation, function ($query) use ($keyword, $relationList) {
            self::deepRelation($query, $relationList, $keyword);
        });
    }

    public static function searchExactColumn(Builder $builder, string $name, string $value): Builder
    {
        $value = str_replace("'", "\\'", strtolower($value));

        return $builder->whereRaw("JSON_UNQUOTE(JSON_EXTRACT({$name}, '$.ar')) like '{$value}'")
            ->orWhereRaw("lower(JSON_UNQUOTE(JSON_EXTRACT({$name}, '$.en'))) like '{$value}'");
    }

    public static function searchColumn(Builder $builder, string $name, string $value)
    {
        $value = str_replace("'", "\\'", strtolower($value));
        $builder->whereRaw("JSON_EXTRACT({$name}, '$.ar') like '%{$value}%'")
            ->orWhereRaw("lower(JSON_EXTRACT({$name}, '$.en')) like '%{$value}%'");
    }
}
