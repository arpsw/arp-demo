<?php

return [
    'manufacturing_order_priority' => [
        'low' => 'Niedrig',
        'normal' => 'Normal',
        'high' => 'Hoch',
        'urgent' => 'Dringend',
    ],

    'manufacturing_order_status' => [
        'draft' => 'Entwurf',
        'confirmed' => 'Bestätigt',
        'in_progress' => 'In Bearbeitung',
        'done' => 'Erledigt',
        'cancelled' => 'Storniert',
    ],

    'product_type' => [
        'finished' => 'Fertigerzeugnis',
        'sub_assembly' => 'Unterbaugruppe',
        'raw_material' => 'Rohmaterial',
    ],

    'quality_check_result' => [
        'pending' => 'Ausstehend',
        'pass' => 'Bestanden',
        'fail' => 'Nicht bestanden',
    ],

    'quality_check_type' => [
        'pass_fail' => 'Bestanden/Nicht bestanden',
        'measurement' => 'Messung',
        'visual' => 'Sichtprüfung',
    ],

    'work_order_status' => [
        'pending' => 'Ausstehend',
        'ready' => 'Bereit',
        'in_progress' => 'In Bearbeitung',
        'paused' => 'Pausiert',
        'done' => 'Erledigt',
        'cancelled' => 'Storniert',
    ],
];
