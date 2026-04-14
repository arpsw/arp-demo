<?php

return [
    'maintenance_request' => [
        'start_work' => 'Arbeit starten',
        'mark_as_repaired' => 'Als repariert markieren',
        'scrap' => 'Verschrotten',
        'scrap_modal_description' => 'Die Anlage wird als stillgelegt markiert. Fortfahren?',
        'notification_started' => 'Wartungsarbeit gestartet',
        'notification_repaired' => 'Anlage erfolgreich repariert',
        'notification_scrapped' => 'Anlage als verschrottet markiert',
        'notification_request_generated' => 'Wartungsanfrage generiert',
    ],

    'infolist' => [
        'equipment' => [
            'section_details' => 'Anlagendetails',
            'section_personnel' => 'Zugewiesenes Personal',
            'section_statistics' => 'Statistiken',
            'section_notes' => 'Notizen',
            'category' => 'Kategorie',
            'work_center' => 'Arbeitsplatz',
            'in_service_since' => 'In Betrieb seit',
            'technician' => 'Techniker',
            'owner' => 'Eigentümer',
            'mtbf_days' => 'MTBF (Tage)',
            'mttr_hours' => 'MTTR (Stunden)',
            'expected_mtbf_days' => 'Erwartete MTBF (Tage)',
            'last_failure' => 'Letzter Ausfall',
            'next_preventive' => 'Nächste Prävention',
        ],
        'maintenance_request' => [
            'section_details' => 'Anfragedetails',
            'section_description' => 'Beschreibung',
            'section_notes' => 'Notizen',
            'equipment' => 'Anlage',
            'category' => 'Kategorie',
            'team' => 'Team',
            'technician' => 'Techniker',
            'requested_by' => 'Angefordert von',
        ],
    ],

    'widget' => [
        'pending_requests' => 'Offene Anfragen',
        'in_progress' => 'In Bearbeitung',
        'completed_this_month' => 'Diesen Monat abgeschlossen',
        'equipment_needing_attention' => 'Anlagen mit Handlungsbedarf',
        'upcoming_preventive' => 'Anstehende Präventivwartung',
        'next_7_days' => 'Nächste 7 Tage',
        'no_upcoming_preventive' => 'Keine anstehende Präventivwartung',
        'recent_activity' => 'Letzte Aktivitäten',
        'latest_requests' => 'Neueste Wartungsanfragen',
        'no_recent_activity' => 'Keine aktuellen Aktivitäten',
        'equipment_distribution' => 'Anlagenstatus-Verteilung',
    ],
];
