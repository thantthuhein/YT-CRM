<?php

namespace App;

use ScoutElastic\SearchRule;
use Illuminate\Support\Facades\Log;

class CustomerSearchRule extends SearchRule
{
    /**
     * @inheritdoc
     */
    public function buildHighlightPayload()
    {
        //
    }

    /**
     * @inheritdoc
     */
    public function buildQueryPayload()
    {
        //
        $query = $this->builder->query;
        return [
            'should' => [
                [
                    'match' => [
                        'name' => $query
                    ]
                ],
            ]
        ];
    }
}