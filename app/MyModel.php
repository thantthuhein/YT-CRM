<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

class MyModel extends Model
{
    use Searchable;

    /**
     * @var string
     */
    protected $indexConfigurator = MyIndexConfigurator::class;

    /**
     * @var array
     */
    protected $searchRules = [
        //
    ];

    /**
     * @var array
     */
    protected $mapping = [
        //
    ];
}