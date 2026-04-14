<?php

return [
    'manufacturing_order_priority' => [
        'low' => 'Nizak',
        'normal' => 'Normalan',
        'high' => 'Visok',
        'urgent' => 'Hitan',
    ],

    'manufacturing_order_status' => [
        'draft' => 'Nacrt',
        'confirmed' => 'Potvrđeno',
        'in_progress' => 'U tijeku',
        'done' => 'Završeno',
        'cancelled' => 'Otkazano',
    ],

    'product_type' => [
        'finished' => 'Gotov proizvod',
        'sub_assembly' => 'Podsklop',
        'raw_material' => 'Sirovina',
    ],

    'quality_check_result' => [
        'pending' => 'Na čekanju',
        'pass' => 'Zadovoljava',
        'fail' => 'Ne zadovoljava',
    ],

    'quality_check_type' => [
        'pass_fail' => 'Zadovoljava/Ne zadovoljava',
        'measurement' => 'Mjerenje',
        'visual' => 'Vizualni pregled',
    ],

    'work_order_status' => [
        'pending' => 'Na čekanju',
        'ready' => 'Spremno',
        'in_progress' => 'U tijeku',
        'paused' => 'Pauzirano',
        'done' => 'Završeno',
        'cancelled' => 'Otkazano',
    ],
];
