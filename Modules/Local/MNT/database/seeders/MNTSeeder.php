<?php

namespace Modules\MNT\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\MNT\Enums\EquipmentStatus;
use Modules\MNT\Enums\MaintenancePriority;
use Modules\MNT\Enums\MaintenanceRequestType;
use Modules\MNT\Enums\MaintenanceStage;
use Modules\MNT\Enums\TeamMemberRole;
use Modules\MNT\Models\MntEquipment;
use Modules\MNT\Models\MntEquipmentCategory;
use Modules\MNT\Models\MntMaintenanceRequest;
use Modules\MNT\Models\MntMaintenanceTeam;
use Modules\MNT\Models\MntPreventiveSchedule;
use Modules\SFD\Models\SfdWorkCenter;

class MNTSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->count() < 5) {
            User::factory(5 - $users->count())->create();
            $users = User::all();
        }

        // ── Delovna mesta (iz SFD) ──
        $wcWeld = SfdWorkCenter::where('code', 'WC-WELD')->first();
        $wcPaint = SfdWorkCenter::where('code', 'WC-PAINT')->first();
        $wcWheel = SfdWorkCenter::where('code', 'WC-WHEEL')->first();
        $wcComp = SfdWorkCenter::where('code', 'WC-COMP')->first();
        $wcQc = SfdWorkCenter::where('code', 'WC-QC')->first();

        // ── Kategorije opreme ──
        $catWelding = MntEquipmentCategory::create(['name' => 'Varilni stroji', 'color' => '#e74c3c']);
        $catPaint = MntEquipmentCategory::create(['name' => 'Lakirni stroji', 'color' => '#3498db']);
        $catAssembly = MntEquipmentCategory::create(['name' => 'Montažno orodje', 'color' => '#2ecc71']);
        $catQc = MntEquipmentCategory::create(['name' => 'Merilna in kontrolna oprema', 'color' => '#9b59b6']);

        // ── Oprema ──
        $tigWelder1 = MntEquipment::create([
            'name' => 'TIG varilnik #1',
            'serial_number' => 'TW-2021-001',
            'category_id' => $catWelding->id,
            'work_center_id' => $wcWeld?->id,
            'technician_id' => $users->random()->id,
            'location' => 'Varilnica A',
            'model' => 'Dynasty 280 DX',
            'manufacturer' => 'Miller Electric',
            'purchase_date' => '2021-03-15',
            'warranty_expiry' => '2026-03-15',
            'cost' => 8500.00,
            'effective_date' => '2021-04-01',
            'status' => EquipmentStatus::Operational,
            'expected_mtbf' => 120,
        ]);

        $tigWelder2 = MntEquipment::create([
            'name' => 'TIG varilnik #2',
            'serial_number' => 'TW-2022-002',
            'category_id' => $catWelding->id,
            'work_center_id' => $wcWeld?->id,
            'location' => 'Varilnica B',
            'model' => 'Dynasty 280 DX',
            'manufacturer' => 'Miller Electric',
            'purchase_date' => '2022-06-10',
            'warranty_expiry' => '2027-06-10',
            'cost' => 8500.00,
            'effective_date' => '2022-07-01',
            'status' => EquipmentStatus::Operational,
            'expected_mtbf' => 120,
        ]);

        $powderOven = MntEquipment::create([
            'name' => 'Peč za prašno lakiranje',
            'serial_number' => 'PC-2020-001',
            'category_id' => $catPaint->id,
            'work_center_id' => $wcPaint?->id,
            'technician_id' => $users->random()->id,
            'location' => 'Lakirnica',
            'model' => 'Batch Cure 4x6',
            'manufacturer' => 'Reliant Finishing Systems',
            'purchase_date' => '2020-01-20',
            'warranty_expiry' => '2025-01-20',
            'cost' => 15000.00,
            'effective_date' => '2020-02-15',
            'status' => EquipmentStatus::Operational,
            'expected_mtbf' => 180,
        ]);

        $sprayBooth = MntEquipment::create([
            'name' => 'Lakirna kabina',
            'serial_number' => 'SB-2021-001',
            'category_id' => $catPaint->id,
            'work_center_id' => $wcPaint?->id,
            'location' => 'Lakirnica',
            'model' => 'Open Face 8ft',
            'manufacturer' => 'Global Finishing Solutions',
            'purchase_date' => '2021-05-10',
            'cost' => 12000.00,
            'effective_date' => '2021-06-01',
            'status' => EquipmentStatus::Maintenance,
        ]);

        $wheelTruing = MntEquipment::create([
            'name' => 'Stojalo za centriranje koles',
            'serial_number' => 'WT-2019-001',
            'category_id' => $catAssembly->id,
            'work_center_id' => $wcWheel?->id,
            'technician_id' => $users->random()->id,
            'location' => 'Prostor za montažo koles',
            'model' => 'Professional TS-4.2',
            'manufacturer' => 'Park Tool',
            'purchase_date' => '2019-08-01',
            'cost' => 350.00,
            'effective_date' => '2019-08-15',
            'status' => EquipmentStatus::Operational,
        ]);

        $spokeTensioner = MntEquipment::create([
            'name' => 'Merilnik napetosti naper',
            'serial_number' => 'ST-2018-001',
            'category_id' => $catAssembly->id,
            'work_center_id' => $wcWheel?->id,
            'location' => 'Prostor za montažo koles',
            'model' => 'TM-1',
            'manufacturer' => 'Park Tool',
            'purchase_date' => '2018-03-01',
            'cost' => 80.00,
            'status' => EquipmentStatus::Retired,
        ]);

        $torqueWrench = MntEquipment::create([
            'name' => 'Komplet momentnih ključev',
            'serial_number' => 'TQ-2022-001',
            'category_id' => $catAssembly->id,
            'work_center_id' => $wcComp?->id,
            'location' => 'Postaja za montažo komponent',
            'model' => 'Adjustable Click 1/4" + 3/8"',
            'manufacturer' => 'Tekton',
            'purchase_date' => '2022-01-15',
            'cost' => 250.00,
            'effective_date' => '2022-02-01',
            'status' => EquipmentStatus::Operational,
        ]);

        $brakeBleeder = MntEquipment::create([
            'name' => 'Naprava za odzračevanje zavor',
            'serial_number' => 'BB-2023-001',
            'category_id' => $catAssembly->id,
            'work_center_id' => $wcComp?->id,
            'location' => 'Postaja za montažo komponent',
            'model' => 'Pro Bleed Kit',
            'manufacturer' => 'Shimano',
            'purchase_date' => '2023-04-01',
            'cost' => 120.00,
            'effective_date' => '2023-04-15',
            'status' => EquipmentStatus::Operational,
        ]);

        $alignmentJig = MntEquipment::create([
            'name' => 'Priprava za poravnavo',
            'serial_number' => 'AJ-2020-001',
            'category_id' => $catQc->id,
            'work_center_id' => $wcQc?->id,
            'technician_id' => $users->random()->id,
            'location' => 'Kontrolna postaja',
            'model' => 'FAG-2',
            'manufacturer' => 'Park Tool',
            'purchase_date' => '2020-11-01',
            'cost' => 450.00,
            'effective_date' => '2020-12-01',
            'status' => EquipmentStatus::Operational,
            'expected_mtbf' => 365,
        ]);

        $caliper = MntEquipment::create([
            'name' => 'Komplet digitalnih pomičnih meril',
            'serial_number' => 'DC-2021-001',
            'category_id' => $catQc->id,
            'work_center_id' => $wcQc?->id,
            'location' => 'Kontrolna postaja',
            'model' => 'Absolute Digimatic 6"',
            'manufacturer' => 'Mitutoyo',
            'purchase_date' => '2021-02-01',
            'cost' => 180.00,
            'effective_date' => '2021-02-15',
            'status' => EquipmentStatus::Operational,
        ]);

        // ── Vzdrževalne ekipe ──
        $mechTeam = MntMaintenanceTeam::create(['name' => 'Mehanska ekipa', 'color' => '#e67e22']);
        $mechTeam->members()->createMany([
            ['first_name' => 'Marko', 'last_name' => 'Kovač', 'phone' => '+38631614683', 'role' => TeamMemberRole::Leader],
            ['first_name' => 'Janez', 'last_name' => 'Novak', 'phone' => '+38651234567', 'role' => TeamMemberRole::Member],
            ['first_name' => 'Peter', 'last_name' => 'Horvat', 'phone' => '+38631234567', 'role' => TeamMemberRole::Member],
        ]);

        $elecTeam = MntMaintenanceTeam::create(['name' => 'Elektro in kalibracijska ekipa', 'color' => '#2980b9']);
        $elecTeam->members()->createMany([
            ['first_name' => 'Iztok', 'last_name' => 'Smolič', 'phone' => '+38631614683', 'role' => TeamMemberRole::Leader],
            ['first_name' => 'Luka', 'last_name' => 'Zupančič', 'phone' => '+38670123456', 'role' => TeamMemberRole::Member],
        ]);

        // ── Preventivni urniki ──
        MntPreventiveSchedule::create([
            'equipment_id' => $tigWelder1->id,
            'name' => 'Mesečni pregled elektrod in plina',
            'frequency_days' => 30,
            'team_id' => $mechTeam->id,
            'priority' => MaintenancePriority::Normal,
            'description' => 'Pregled obrabe volframove elektrode, pretoka plina, čiščenje vpenjalne puše',
            'next_date' => now()->addDays(12),
            'is_active' => true,
        ]);

        MntPreventiveSchedule::create([
            'equipment_id' => $powderOven->id,
            'name' => 'Četrtletni pregled grelnih elementov',
            'frequency_days' => 90,
            'team_id' => $elecTeam->id,
            'priority' => MaintenancePriority::High,
            'description' => 'Pregled grelnih elementov, preverjanje natančnosti termočlenov, pregled tesnil na vratih',
            'next_date' => now()->addDays(25),
            'is_active' => true,
        ]);

        MntPreventiveSchedule::create([
            'equipment_id' => $wheelTruing->id,
            'name' => 'Tedensko preverjanje kalibracije',
            'frequency_days' => 7,
            'team_id' => $elecTeam->id,
            'priority' => MaintenancePriority::Normal,
            'description' => 'Preverjanje natančnosti merilne ure z referenčnim kolesom, mazanje ležajev',
            'next_date' => now()->addDays(3),
            'is_active' => true,
        ]);

        MntPreventiveSchedule::create([
            'equipment_id' => $sprayBooth->id,
            'name' => 'Dvotedenska menjava filtrov',
            'frequency_days' => 14,
            'team_id' => $mechTeam->id,
            'priority' => MaintenancePriority::Normal,
            'description' => 'Menjava vstopnih in izstopnih filtrov, čiščenje sten kabine',
            'next_date' => now()->addDays(5),
            'is_active' => true,
        ]);

        MntPreventiveSchedule::create([
            'equipment_id' => $alignmentJig->id,
            'name' => 'Mesečna kalibracija',
            'frequency_days' => 30,
            'team_id' => $elecTeam->id,
            'priority' => MaintenancePriority::High,
            'description' => 'Kalibracija priprave za poravnavo z referenčnim standardom, dokumentiranje odstopanj',
            'next_date' => now()->addDays(18),
            'is_active' => true,
        ]);

        MntPreventiveSchedule::create([
            'equipment_id' => $tigWelder2->id,
            'name' => 'Mesečni pregled elektrod in plina',
            'frequency_days' => 30,
            'team_id' => $mechTeam->id,
            'priority' => MaintenancePriority::Normal,
            'description' => 'Pregled obrabe volframove elektrode, pretoka plina, čiščenje vpenjalne puše',
            'next_date' => now()->addDays(20),
            'is_active' => true,
        ]);

        // ── Vzdrževalni zahtevki ──
        // Preventivni - zaključen
        MntMaintenanceRequest::create([
            'reference' => 'MR-0001',
            'name' => 'Mesečni pregled elektrod - TIG varilnik #1',
            'equipment_id' => $tigWelder1->id,
            'category_id' => $catWelding->id,
            'request_type' => MaintenanceRequestType::Preventive,
            'priority' => MaintenancePriority::Normal,
            'stage' => MaintenanceStage::Repaired,
            'team_id' => $mechTeam->id,
            'technician_id' => $users->get(1)->id,
            'scheduled_date' => now()->subDays(20),
            'close_date' => now()->subDays(18),
            'duration' => 1.5,
            'description' => 'Redni mesečni pregled elektrod in pretoka plina',
        ]);

        // Preventivni - zaključen
        MntMaintenanceRequest::create([
            'reference' => 'MR-0002',
            'name' => 'Tedenska kalibracija stojala za centriranje',
            'equipment_id' => $wheelTruing->id,
            'category_id' => $catAssembly->id,
            'request_type' => MaintenanceRequestType::Preventive,
            'priority' => MaintenancePriority::Normal,
            'stage' => MaintenanceStage::Repaired,
            'team_id' => $elecTeam->id,
            'technician_id' => $users->get(3)->id,
            'scheduled_date' => now()->subDays(10),
            'close_date' => now()->subDays(9),
            'duration' => 0.5,
            'description' => 'Tedensko preverjanje kalibracije opravljeno — znotraj toleranc',
        ]);

        // Preventivni - v teku
        MntMaintenanceRequest::create([
            'reference' => 'MR-0003',
            'name' => 'Menjava filtrov lakirne kabine',
            'equipment_id' => $sprayBooth->id,
            'category_id' => $catPaint->id,
            'request_type' => MaintenanceRequestType::Preventive,
            'priority' => MaintenancePriority::Normal,
            'stage' => MaintenanceStage::InProgress,
            'team_id' => $mechTeam->id,
            'technician_id' => $users->get(2)->id,
            'scheduled_date' => now()->subDays(2),
            'description' => 'Dvotedenska menjava filtrov in čiščenje kabine',
        ]);

        // Preventivni - nov
        MntMaintenanceRequest::create([
            'reference' => 'MR-0004',
            'name' => 'Mesečna kalibracija priprave za poravnavo',
            'equipment_id' => $alignmentJig->id,
            'category_id' => $catQc->id,
            'request_type' => MaintenanceRequestType::Preventive,
            'priority' => MaintenancePriority::High,
            'stage' => MaintenanceStage::New,
            'team_id' => $elecTeam->id,
            'scheduled_date' => now()->addDays(2),
            'description' => 'Mesečna kalibracija z referenčnim standardom',
        ]);

        // Korektivni - zaključen (puščanje plina na varilniku)
        MntMaintenanceRequest::create([
            'reference' => 'MR-0005',
            'name' => 'Popravilo puščanja plina - TIG varilnik #1',
            'equipment_id' => $tigWelder1->id,
            'category_id' => $catWelding->id,
            'request_type' => MaintenanceRequestType::Corrective,
            'priority' => MaintenancePriority::High,
            'stage' => MaintenanceStage::Repaired,
            'team_id' => $mechTeam->id,
            'technician_id' => $users->get(0)->id,
            'requested_by' => $users->get(1)->id,
            'scheduled_date' => now()->subDays(30),
            'close_date' => now()->subDays(28),
            'duration' => 4.0,
            'description' => 'Zaznano puščanje argona na priključku gorilnika. Zamenjano tesnilo in ponovni test.',
            'notes' => 'Vzrok: obrabljeno tesnilo zaradi termičnih ciklov. Dodano na kontrolni seznam preventivnega vzdrževanja.',
        ]);

        // Korektivni - v teku (odpoved ventilatorja lakirne kabine)
        MntMaintenanceRequest::create([
            'reference' => 'MR-0006',
            'name' => 'Odpoved motorja odsesovalnega ventilatorja - Lakirna kabina',
            'equipment_id' => $sprayBooth->id,
            'category_id' => $catPaint->id,
            'request_type' => MaintenanceRequestType::Corrective,
            'priority' => MaintenancePriority::Urgent,
            'stage' => MaintenanceStage::InProgress,
            'team_id' => $elecTeam->id,
            'technician_id' => $users->get(3)->id,
            'requested_by' => $users->get(2)->id,
            'scheduled_date' => now()->subDay(),
            'description' => 'Motor odsesovalnega ventilatorja se je zagozdil. Kabina neuporabna do zamenjave motorja.',
            'notes' => 'Nadomestni motor naročen — pričakovana dostava čez 2 dni.',
        ]);

        // Korektivni - nov (odmik pomičnega merila)
        MntMaintenanceRequest::create([
            'reference' => 'MR-0007',
            'name' => 'Odmik kalibracije - Digitalna pomična merila',
            'equipment_id' => $caliper->id,
            'category_id' => $catQc->id,
            'request_type' => MaintenanceRequestType::Corrective,
            'priority' => MaintenancePriority::Normal,
            'stage' => MaintenanceStage::New,
            'team_id' => $elecTeam->id,
            'requested_by' => $users->random()->id,
            'scheduled_date' => now(),
            'description' => 'Digitalna pomična merila kažejo 0,05 mm odmik od referenčnega merilnika. Potrebna rekalibracija ali zamenjava.',
        ]);

        // Korektivni - zaključen (momentni ključ)
        MntMaintenanceRequest::create([
            'reference' => 'MR-0008',
            'name' => 'Letna kalibracija momentnega ključa',
            'equipment_id' => $torqueWrench->id,
            'category_id' => $catAssembly->id,
            'request_type' => MaintenanceRequestType::Corrective,
            'priority' => MaintenancePriority::Normal,
            'stage' => MaintenanceStage::Repaired,
            'team_id' => $elecTeam->id,
            'technician_id' => $users->get(3)->id,
            'scheduled_date' => now()->subDays(45),
            'close_date' => now()->subDays(44),
            'duration' => 1.0,
            'description' => 'Letni kalibracijski pregled. Oba ključa znotraj specifikacij.',
        ]);

        // Razrez - star merilnik naper, nepopravljiv
        MntMaintenanceRequest::create([
            'reference' => 'MR-0009',
            'name' => 'Odpoved merilnika napetosti naper',
            'equipment_id' => $spokeTensioner->id,
            'category_id' => $catAssembly->id,
            'request_type' => MaintenanceRequestType::Corrective,
            'priority' => MaintenancePriority::Low,
            'stage' => MaintenanceStage::Scrap,
            'team_id' => $mechTeam->id,
            'technician_id' => $users->get(0)->id,
            'scheduled_date' => now()->subDays(60),
            'close_date' => now()->subDays(55),
            'duration' => 2.0,
            'description' => 'Notranji merilni mehanizem pokvarjen. Nadomestni del se ne proizvaja več. Oprema upokojena.',
            'notes' => 'Naročen nov merilnik napetosti naper (Park Tool TM-1).',
        ]);

        // Korektivni - zaključen (ventil naprave za odzračevanje)
        MntMaintenanceRequest::create([
            'reference' => 'MR-0010',
            'name' => 'Zamenjava ventila naprave za odzračevanje zavor',
            'equipment_id' => $brakeBleeder->id,
            'category_id' => $catAssembly->id,
            'request_type' => MaintenanceRequestType::Corrective,
            'priority' => MaintenancePriority::Normal,
            'stage' => MaintenanceStage::Repaired,
            'team_id' => $mechTeam->id,
            'technician_id' => $users->get(1)->id,
            'scheduled_date' => now()->subDays(15),
            'close_date' => now()->subDays(14),
            'duration' => 0.5,
            'description' => 'Enosmerni ventil na brizgi za odzračevanje ne tesni. Zamenjen sklop ventila.',
        ]);
    }
}
