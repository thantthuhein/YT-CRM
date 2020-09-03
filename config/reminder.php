<?php

/**
 * type must be one of the keys of ReminderType::TYPES
 */
return [
    'quotation' => [
        'followup' => [
            'day' => '7',
            'type' => 'followup'
        ],
    ],
    'sale_contract' => [
        'estimated_date' => [
            'day' => '3',
            'type' => 'sale_contract_estimated_date'
        ],
        'uploaded_by_sale_engineer' => [
            'day' => '7',
            'type' => 'uploaded_by_sale_engineer'
        ],
        'installation_progress' => [
            'day' => '7',
            'type' => "installation_weekly_update"
        ],
        'necesssary_docs' => [
            'day' => '7',
            'type' => 'installation_necessary_docs'
        ],
        'actual_installation_report' => [
            'day' => '7',
            'type' => 'actual_installation_report_pdf'
        ]
    ],
    'servicing' => [
        'maintenance' => [
            'month' => '1',
            'type' => 'maintenance'
        ],
        'contract_maintenance' => [
            'month' => '1',
            'type' => 'contract_maintenance'
        ],
        'maintenance_estimated_date' => [
            'day' => '1',
            'type' => 'maintenance_estimated_date'
        ],
        'service_report' => [
            'day' => '3',
            'type' => 'service_report'
        ],
    ],
    'warranty' => [
        'warranty_claim_form' => [
            'day' => '3',
            'type' => 'warranty_claim_form'
        ],
        'warranty_estimated_date'=> [
            'day' => '1',
            'type' => 'warranty_estimated_date'
        ],
        'warranty_action_pdfs' => [
            'day' => '3',
            'type' => 'warranty_action_pdfs'
        ],
        'warranty_claim_approve' => [
            'day'   => '7',
            'type'  => 'warranty_claim_approve'
        ],
    ],
    'repair' => [
        'repair_estimated_date' => [
            'day' => '1',
            'type' => 'repair_estimated_date'
        ],
        'repair_service_report' => [
            'day' => '3',
            'type' => 'repair_service_report'
        ]
    ]
];