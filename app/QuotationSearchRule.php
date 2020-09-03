<?php

namespace App;

use ScoutElastic\SearchRule;

class QuotationSearchRule extends SearchRule
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
        $query = $this->builder->query;
        return [
            'should' => [
                'multi_match' => [
                    'query' => $this->builder->query,
                    'fields' => [
                        'number',
                        'quotation_number',
                        'quotation_number_type',
                        'year',
                        'status',
                    ]
                ]                    
            ]
        ];
    }
}