<?php

namespace App;

use ScoutElastic\SearchRule;

class EnquirySearchRule extends SearchRule
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
                    'multi_match' => [
                        'query' => $this->builder->query,
                        'fields' => [
                            'location',
                            'receiver_name',
                            'status',
                            'customer',
                            'project',
                            'company',
                            'quotation'
                        ]
                    ]
                ],
            ]
        ];
    }
}