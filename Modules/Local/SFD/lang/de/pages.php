<?php

return [
    'manufacturing_orders' => [
        'confirm_action' => 'Bestätigen & Arbeitsaufträge erzeugen',
        'confirm_modal_description' => 'Es werden Arbeitsaufträge aus den Stücklisten-Arbeitsgängen erzeugt. Fortfahren?',
        'confirmed_title' => 'Fertigungsauftrag bestätigt',
        'confirmed_body' => 'Arbeitsaufträge wurden aus den Stücklisten-Arbeitsgängen erzeugt.',
        'complete_action' => 'Als erledigt markieren',
        'completed_title' => 'Fertigungsauftrag abgeschlossen',
        'cancel_action' => 'Stornieren',
        'cancelled_title' => 'Fertigungsauftrag storniert',
    ],

    'work_orders' => [
        'start_action' => 'Starten',
        'complete_action' => 'Abschließen',
        'pause_action' => 'Pausieren',
        'malfunction_action' => 'Störung melden',
        'malfunction_description_label' => 'Beschreiben Sie das Problem',
        'malfunction_description_placeholder' => 'z.B. Funkenflug an der Schweißstation, ungewöhnliche Geräusche vom Motor...',
        'malfunction_modal_description' => 'Melden Sie eine Störung, um diesen Arbeitsauftrag zu pausieren und das Wartungsteam zu benachrichtigen.',
        'malfunction_title' => 'Störung gemeldet',
        'malfunction_body' => 'Arbeitsauftrag pausiert. Das Wartungsteam wurde benachrichtigt.',
        'started_title' => 'Arbeitsauftrag gestartet',
        'completed_title' => 'Arbeitsauftrag abgeschlossen',
        'paused_title' => 'Arbeitsauftrag pausiert',
    ],

    'infolist' => [
        'order_details' => 'Auftragsdetails',
        'work_order_details' => 'Arbeitsauftragsdetails',
        'bom' => 'Stückliste',
        'mo_reference' => 'FA-Referenz',
        'operator' => 'Bediener',
        'work_center' => 'Arbeitsplatz',
        'work_center_name' => 'Name',
        'work_center_code' => 'Code',
        'work_center_capacity' => 'Kapazität',
        'work_center_cost' => 'Kosten / Stunde',
        'equipment_at_work_center' => 'Ausrüstung am Arbeitsplatz',
        'equipment_name' => 'Ausrüstung',
        'equipment_serial' => 'Seriennummer',
        'equipment_category' => 'Kategorie',
        'equipment_status' => 'Status',
        'equipment_manufacturer' => 'Hersteller',
    ],

    'relation_managers' => [
        'equipment' => 'Ausrüstung',
    ],
];
