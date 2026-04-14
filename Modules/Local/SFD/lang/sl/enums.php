<?php

return [
    'manufacturing_order_priority' => [
        'low' => 'Nizka',
        'normal' => 'Normalna',
        'high' => 'Visoka',
        'urgent' => 'Nujna',
    ],

    'manufacturing_order_status' => [
        'draft' => 'Osnutek',
        'confirmed' => 'Potrjeno',
        'in_progress' => 'V izvajanju',
        'done' => 'Zaključeno',
        'cancelled' => 'Preklicano',
    ],

    'product_type' => [
        'finished' => 'Končni izdelek',
        'sub_assembly' => 'Podsklop',
        'raw_material' => 'Surovina',
    ],

    'quality_check_result' => [
        'pending' => 'V čakanju',
        'pass' => 'Ustrezno',
        'fail' => 'Neustrezno',
    ],

    'quality_check_type' => [
        'pass_fail' => 'Ustrezno/Neustrezno',
        'measurement' => 'Meritev',
        'visual' => 'Vizualni pregled',
    ],

    'work_order_status' => [
        'pending' => 'V čakanju',
        'ready' => 'Pripravljeno',
        'in_progress' => 'V izvajanju',
        'paused' => 'Zaustavljeno',
        'done' => 'Zaključeno',
        'cancelled' => 'Preklicano',
    ],
];
