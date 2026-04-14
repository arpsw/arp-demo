<?php

return [
    'equipment' => [
        'section_details' => 'Podrobnosti opreme',
        'section_ownership' => 'Lastništvo in datumi',
        'section_notes' => 'Opombe',
        'category' => 'Kategorija',
        'work_center' => 'Delovno mesto',
        'model' => 'Model',
        'responsible_technician' => 'Odgovorni tehnik',
        'owner' => 'Lastnik',
        'in_service_since' => 'V uporabi od',
        'expected_mtbf_days' => 'Pričakovani MTBF (dni)',
    ],

    'equipment_category' => [
        'section_details' => 'Podrobnosti kategorije',
    ],

    'maintenance_team' => [
        'section_details' => 'Podrobnosti ekipe',
        'section_members' => 'Člani ekipe',
    ],

    'maintenance_request' => [
        'section_details' => 'Podrobnosti zahtevka',
        'section_description' => 'Podrobnosti',
        'equipment' => 'Oprema',
        'category' => 'Kategorija',
        'technician' => 'Tehnik',
        'requested_by' => 'Zahteval',
        'duration_hours' => 'Trajanje (ure)',
    ],

    'preventive_schedule' => [
        'section_details' => 'Podrobnosti razporeda',
        'section_instructions' => 'Navodila',
        'equipment' => 'Oprema',
        'frequency_days' => 'Pogostost (dni)',
        'default_technician' => 'Privzeti tehnik',
        'next_scheduled_date' => 'Naslednji načrtovani datum',
        'maintenance_instructions' => 'Navodila za vzdrževanje',
    ],

    'relation_managers' => [
        'maintenance_requests' => [
            'team' => 'Ekipa',
            'technician' => 'Tehnik',
        ],
        'preventive_schedules' => [
            'frequency_days' => 'Pogostost (dni)',
            'team' => 'Ekipa',
            'technician' => 'Tehnik',
            'next_scheduled_date' => 'Naslednji načrtovani datum',
        ],
    ],
];
