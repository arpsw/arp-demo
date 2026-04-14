<?php

return [
    'manufacturing_order_priority' => [
        'low' => 'Low',
        'normal' => 'Normal',
        'high' => 'High',
        'urgent' => 'Urgent',
    ],

    'manufacturing_order_status' => [
        'draft' => 'Draft',
        'confirmed' => 'Confirmed',
        'in_progress' => 'In Progress',
        'done' => 'Done',
        'cancelled' => 'Cancelled',
    ],

    'product_type' => [
        'finished' => 'Finished Good',
        'sub_assembly' => 'Sub-Assembly',
        'raw_material' => 'Raw Material',
    ],

    'quality_check_result' => [
        'pending' => 'Pending',
        'pass' => 'Pass',
        'fail' => 'Fail',
    ],

    'quality_check_type' => [
        'pass_fail' => 'Pass/Fail',
        'measurement' => 'Measurement',
        'visual' => 'Visual Inspection',
    ],

    'work_order_status' => [
        'pending' => 'Pending',
        'ready' => 'Ready',
        'in_progress' => 'In Progress',
        'paused' => 'Paused',
        'done' => 'Done',
        'cancelled' => 'Cancelled',
    ],
];
