<?php

return [
    'manufacturing_orders' => [
        'confirm_action' => 'Potvrdi i generiraj radne naloge',
        'confirm_modal_description' => 'Bit će generirani radni nalozi iz operacija sastavnice. Nastaviti?',
        'confirmed_title' => 'Proizvodni nalog potvrđen',
        'confirmed_body' => 'Radni nalozi su generirani iz operacija sastavnice.',
        'complete_action' => 'Označi kao završeno',
        'completed_title' => 'Proizvodni nalog završen',
        'cancel_action' => 'Otkaži',
        'cancelled_title' => 'Proizvodni nalog otkazan',
    ],

    'work_orders' => [
        'start_action' => 'Pokreni',
        'complete_action' => 'Završi',
        'pause_action' => 'Pauziraj',
        'malfunction_action' => 'Prijavi kvar',
        'malfunction_description_label' => 'Opišite problem',
        'malfunction_description_placeholder' => 'npr. Iskre na stanici za zavarivanje, neobičan zvuk motora...',
        'malfunction_modal_description' => 'Prijavite kvar kako biste pauzirali radni nalog i obavijestili tim za održavanje.',
        'malfunction_title' => 'Kvar prijavljen',
        'malfunction_body' => 'Radni nalog pauziran. Tim za održavanje je obaviješten.',
        'started_title' => 'Radni nalog pokrenut',
        'completed_title' => 'Radni nalog završen',
        'paused_title' => 'Radni nalog pauziran',
    ],

    'infolist' => [
        'order_details' => 'Detalji naloga',
        'work_order_details' => 'Detalji radnog naloga',
        'bom' => 'Sastavnica',
        'mo_reference' => 'Referenca PN',
        'operator' => 'Operater',
        'work_center' => 'Radno mjesto',
        'work_center_name' => 'Naziv',
        'work_center_code' => 'Šifra',
        'work_center_capacity' => 'Kapacitet',
        'work_center_cost' => 'Cijena / sat',
        'equipment_at_work_center' => 'Oprema na radnom mjestu',
        'equipment_name' => 'Oprema',
        'equipment_serial' => 'Serijski broj',
        'equipment_category' => 'Kategorija',
        'equipment_status' => 'Status',
        'equipment_manufacturer' => 'Proizvođač',
    ],

    'relation_managers' => [
        'equipment' => 'Oprema',
    ],
];
