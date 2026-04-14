<?php

return [
    'equipment' => [
        'section_details' => 'Equipment Details',
        'section_ownership' => 'Ownership & Dates',
        'section_notes' => 'Notes',
        'category' => 'Category',
        'work_center' => 'Work Center',
        'model' => 'Model',
        'responsible_technician' => 'Responsible Technician',
        'owner' => 'Owner',
        'in_service_since' => 'In Service Since',
        'expected_mtbf_days' => 'Expected MTBF (days)',
    ],

    'equipment_category' => [
        'section_details' => 'Category Details',
    ],

    'maintenance_team' => [
        'section_details' => 'Team Details',
        'section_members' => 'Team Members',
    ],

    'maintenance_request' => [
        'section_details' => 'Request Details',
        'section_description' => 'Details',
        'equipment' => 'Equipment',
        'category' => 'Category',
        'technician' => 'Technician',
        'requested_by' => 'Requested By',
        'duration_hours' => 'Duration (hours)',
    ],

    'preventive_schedule' => [
        'section_details' => 'Schedule Details',
        'section_instructions' => 'Instructions',
        'equipment' => 'Equipment',
        'frequency_days' => 'Frequency (days)',
        'default_technician' => 'Default Technician',
        'next_scheduled_date' => 'Next Scheduled Date',
        'maintenance_instructions' => 'Maintenance Instructions',
    ],

    'relation_managers' => [
        'maintenance_requests' => [
            'team' => 'Team',
            'technician' => 'Technician',
        ],
        'preventive_schedules' => [
            'frequency_days' => 'Frequency (days)',
            'team' => 'Team',
            'technician' => 'Technician',
            'next_scheduled_date' => 'Next Scheduled Date',
        ],
    ],
];
