<?php

return [
    'equipment' => [
        'section_details' => 'Anlagendetails',
        'section_ownership' => 'Eigentum & Termine',
        'section_notes' => 'Notizen',
        'category' => 'Kategorie',
        'work_center' => 'Arbeitsplatz',
        'model' => 'Modell',
        'responsible_technician' => 'Verantwortlicher Techniker',
        'owner' => 'Eigentümer',
        'in_service_since' => 'In Betrieb seit',
        'expected_mtbf_days' => 'Erwartete MTBF (Tage)',
    ],

    'equipment_category' => [
        'section_details' => 'Kategoriedetails',
    ],

    'maintenance_team' => [
        'section_details' => 'Teamdetails',
        'section_members' => 'Teammitglieder',
    ],

    'maintenance_request' => [
        'section_details' => 'Anfragedetails',
        'section_description' => 'Details',
        'equipment' => 'Anlage',
        'category' => 'Kategorie',
        'technician' => 'Techniker',
        'requested_by' => 'Angefordert von',
        'duration_hours' => 'Dauer (Stunden)',
    ],

    'preventive_schedule' => [
        'section_details' => 'Plandetails',
        'section_instructions' => 'Anweisungen',
        'equipment' => 'Anlage',
        'frequency_days' => 'Häufigkeit (Tage)',
        'default_technician' => 'Standardtechniker',
        'next_scheduled_date' => 'Nächstes geplantes Datum',
        'maintenance_instructions' => 'Wartungsanweisungen',
    ],

    'relation_managers' => [
        'maintenance_requests' => [
            'team' => 'Team',
            'technician' => 'Techniker',
        ],
        'preventive_schedules' => [
            'frequency_days' => 'Häufigkeit (Tage)',
            'team' => 'Team',
            'technician' => 'Techniker',
            'next_scheduled_date' => 'Nächstes geplantes Datum',
        ],
    ],
];
