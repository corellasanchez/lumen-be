<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\Filterable;

class Licence extends Model
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'licence',
        'customer',
        'activated_date',
        'expiration_date',
        'type',
        'email'
     ];

}
