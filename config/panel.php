<?php

return [
    'date_format'         => 'Y-m-d',
    'date_format_2'       => 'Y-M-d',
    'time_format'         => 'H:i:s',
    'primary_language'    => 'en',
    'pdf_max_size'        => env('PDF_MAX_SIZE', 30000),
    'available_languages' => [
        'en' => 'English',
    ],
    'valid_phone_number'   => 'regex:/^[0-9]+$/',  
];
