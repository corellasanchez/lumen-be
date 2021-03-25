<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter($query, QueryFilters $filters, $model)
    {
        return $filters->apply($query, $model);
    }
}
