<?php

return [
    'manufacturing_orders' => [
        'confirm_action' => 'Confirm & Generate Work Orders',
        'confirm_modal_description' => 'This will generate work orders from the BOM operations. Continue?',
        'confirmed_title' => 'Manufacturing order confirmed',
        'confirmed_body' => 'Work orders have been generated from the BOM operations.',
        'complete_action' => 'Mark as Done',
        'completed_title' => 'Manufacturing order completed',
        'cancel_action' => 'Cancel',
        'cancelled_title' => 'Manufacturing order cancelled',
    ],

    'work_orders' => [
        'start_action' => 'Start',
        'complete_action' => 'Complete',
        'pause_action' => 'Pause',
        'malfunction_action' => 'Report Malfunction',
        'malfunction_description_label' => 'Describe the problem',
        'malfunction_description_placeholder' => 'e.g. Sparks coming from the welding station, unusual noise from motor...',
        'malfunction_modal_description' => 'Report a malfunction to pause this work order and notify the maintenance team.',
        'malfunction_title' => 'Malfunction reported',
        'malfunction_body' => 'Work order paused. The maintenance team has been notified.',
        'started_title' => 'Work order started',
        'completed_title' => 'Work order completed',
        'paused_title' => 'Work order paused',
    ],

    'infolist' => [
        'order_details' => 'Order Details',
        'work_order_details' => 'Work Order Details',
        'bom' => 'BOM',
        'mo_reference' => 'MO Reference',
        'operator' => 'Operator',
        'work_center' => 'Work Center',
        'work_center_name' => 'Name',
        'work_center_code' => 'Code',
        'work_center_capacity' => 'Capacity',
        'work_center_cost' => 'Cost / Hour',
        'equipment_at_work_center' => 'Equipment at Work Center',
        'equipment_name' => 'Equipment',
        'equipment_serial' => 'Serial Number',
        'equipment_category' => 'Category',
        'equipment_status' => 'Status',
        'equipment_manufacturer' => 'Manufacturer',
    ],

    'relation_managers' => [
        'equipment' => 'Equipment',
    ],
];
