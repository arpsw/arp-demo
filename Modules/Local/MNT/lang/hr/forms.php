<?php

return [
    'equipment' => [
        'section_details' => 'Podaci o opremi',
        'section_ownership' => 'Vlasništvo i datumi',
        'section_notes' => 'Bilješke',
        'category' => 'Kategorija',
        'work_center' => 'Radno mjesto',
        'model' => 'Model',
        'responsible_technician' => 'Odgovorni tehničar',
        'owner' => 'Vlasnik',
        'in_service_since' => 'U upotrebi od',
        'expected_mtbf_days' => 'Očekivani MTBF (dani)',
    ],

    'equipment_category' => [
        'section_details' => 'Podaci o kategoriji',
    ],

    'maintenance_team' => [
        'section_details' => 'Podaci o timu',
        'section_members' => 'Članovi tima',
    ],

    'maintenance_request' => [
        'section_details' => 'Podaci o zahtjevu',
        'section_description' => 'Pojedinosti',
        'equipment' => 'Oprema',
        'category' => 'Kategorija',
        'technician' => 'Tehničar',
        'requested_by' => 'Zatražio',
        'duration_hours' => 'Trajanje (sati)',
    ],

    'preventive_schedule' => [
        'section_details' => 'Podaci o rasporedu',
        'section_instructions' => 'Upute',
        'equipment' => 'Oprema',
        'frequency_days' => 'Učestalost (dani)',
        'default_technician' => 'Zadani tehničar',
        'next_scheduled_date' => 'Sljedeći planirani datum',
        'maintenance_instructions' => 'Upute za održavanje',
    ],

    'relation_managers' => [
        'maintenance_requests' => [
            'team' => 'Tim',
            'technician' => 'Tehničar',
        ],
        'preventive_schedules' => [
            'frequency_days' => 'Učestalost (dani)',
            'team' => 'Tim',
            'technician' => 'Tehničar',
            'next_scheduled_date' => 'Sljedeći planirani datum',
        ],
    ],
];
