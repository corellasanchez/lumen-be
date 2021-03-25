<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilters
{
    protected $request;
    protected $builder;
    protected $table;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder, $model)
    {
        $this->builder = $builder;
        $this->table = $model->getTable();

        foreach ($this->filters() as $name => $value) {
            if (!method_exists($this, $name)) {
                $this->generateCriteria($name, $value);
            } else {
                if (strlen($value)) {
                    $this->$name($value);
                } else {
                    $this->$name();
                }
            }
        }
        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }

    public function generateCriteria($filterName, $filterValue)
    {
        $criteria = array_key_exists($filterName, $this->filterCriterias) ? $this->filterCriterias[$filterName] : '=';
        $value = $criteria === 'LIKE' ?  "%$filterValue%" : $filterValue;
        return $this->builder->where( $this->table .'.'. $filterName,  $criteria , $value);
    }
}

