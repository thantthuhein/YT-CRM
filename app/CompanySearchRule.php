<?php

namespace App;

use ScoutElastic\SearchRule;

class CompanySearchRule extends SearchRule
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