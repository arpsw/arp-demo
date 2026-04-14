<?php

namespace Modules\SFD\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\SFD\Enums\ManufacturingOrderPriority;
use Modules\SFD\Enums\ManufacturingOrderStatus;
use Modules\SFD\Enums\ProductType;
use Modules\SFD\Enums\QualityCheckResult;
use Modules\SFD\Enums\QualityCheckType;
use Modules\SFD\Enums\WorkOrderStatus;
use Modules\SFD\Models\SfdBillOfMaterial;
use Modules\SFD\Models\SfdManufacturingOrder;
use Modules\SFD\Models\SfdProduct;
use Modules\SFD\Models\SfdQualityCheck;
use Modules\SFD\Models\SfdTimeLog;
use Modules\SFD\Models\SfdWorkCenter;
use Modules\SFD\Models\SfdWorkOrder;

class SFDSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory(8)->create();
        }

        // ── Delovna mesta ──
        $wcWeld = SfdWorkCenter::create(['name' => 'Varilnica okvirjev', 'code' => 'WC-WELD', 'capacity' => 2, 'cost_per_hour' => 65.00, 'time_before_production' => 15, 'time_after_production' => 10, 'sort_order' => 1]);
        $wcPaint = SfdWorkCenter::create(['name' => 'Lakirnica', 'code' => 'WC-PAINT', 'capacity' => 3, 'cost_per_hour' => 45.00, 'time_before_production' => 20, 'time_after_production' => 30, 'sort_order' => 2]);
        $wcWheel = SfdWorkCenter::create(['name' => 'Montaža koles', 'code' => 'WC-WHEEL', 'capacity' => 2, 'cost_per_hour' => 40.00, 'time_before_production' => 5, 'time_after_production' => 5, 'sort_order' => 3]);
        $wcComp = SfdWorkCenter::create(['name' => 'Montaža komponent', 'code' => 'WC-COMP', 'capacity' => 2, 'cost_per_hour' => 50.00, 'time_before_production' => 5, 'time_after_production' => 5, 'sort_order' => 4]);
        $wcQc = SfdWorkCenter::create(['name' => 'Kontrola in pakiranje', 'code' => 'WC-QC', 'capacity' => 1, 'cost_per_hour' => 35.00, 'time_before_production' => 0, 'time_after_production' => 10, 'sort_order' => 5]);

        // ── Končni izdelki ──
        $trailBlazer = SfdProduct::create(['name' => 'Trail Blazer 29', 'sku' => 'TB-29', 'type' => ProductType::Finished, 'description' => 'Premium gorsko kolo 29" s kromoli okvirjem', 'unit_cost' => 1850.00]);
        $urbanGlide = SfdProduct::create(['name' => 'Urban Glide 700', 'sku' => 'UG-700', 'type' => ProductType::Finished, 'description' => 'Lahkotno mestno kolo 700c za vsakodnevno vožnjo', 'unit_cost' => 1200.00]);
        $juniorSprint = SfdProduct::create(['name' => 'Junior Sprint 20', 'sku' => 'JS-20', 'type' => ProductType::Finished, 'description' => 'Vzdržljivo otroško kolo 20" za mlade kolesarje', 'unit_cost' => 450.00]);

        // ── Podsestavi ──
        $frontWheel29 = SfdProduct::create(['name' => 'Sprednje kolo 29"', 'sku' => 'FW-29', 'type' => ProductType::SubAssembly, 'unit_cost' => 180.00]);
        $rearWheel29 = SfdProduct::create(['name' => 'Zadnje kolo 29"', 'sku' => 'RW-29', 'type' => ProductType::SubAssembly, 'unit_cost' => 210.00]);
        $frontWheel700 = SfdProduct::create(['name' => 'Sprednje kolo 700c', 'sku' => 'FW-700', 'type' => ProductType::SubAssembly, 'unit_cost' => 150.00]);
        $rearWheel700 = SfdProduct::create(['name' => 'Zadnje kolo 700c', 'sku' => 'RW-700', 'type' => ProductType::SubAssembly, 'unit_cost' => 175.00]);

        // ── Surovine ──
        $chromolyTubing = SfdProduct::create(['name' => 'Komplet kromoli cevi', 'sku' => 'RM-CHRM', 'type' => ProductType::RawMaterial, 'unit_cost' => 120.00]);
        $aluminumTubing = SfdProduct::create(['name' => 'Komplet aluminijastih cevi', 'sku' => 'RM-ALUM', 'type' => ProductType::RawMaterial, 'unit_cost' => 85.00]);
        $rim29 = SfdProduct::create(['name' => 'Aluminijast obroč 29"', 'sku' => 'RM-RIM29', 'type' => ProductType::RawMaterial, 'unit_cost' => 45.00]);
        $rim700 = SfdProduct::create(['name' => 'Aluminijast obroč 700c', 'sku' => 'RM-RIM700', 'type' => ProductType::RawMaterial, 'unit_cost' => 38.00]);
        $hub = SfdProduct::create(['name' => 'Pesta z zaprtimi ležaji', 'sku' => 'RM-HUB', 'type' => ProductType::RawMaterial, 'unit_cost' => 35.00]);
        $spokes = SfdProduct::create(['name' => 'Napere iz nerjavečega jekla (32 kosov)', 'sku' => 'RM-SPK32', 'type' => ProductType::RawMaterial, 'unit_cost' => 18.00]);
        $tire29 = SfdProduct::create(['name' => 'Continental Trail King 29x2.4', 'sku' => 'RM-TRE29', 'type' => ProductType::RawMaterial, 'unit_cost' => 55.00]);
        $tire700 = SfdProduct::create(['name' => 'Continental Ultra Sport 700x28', 'sku' => 'RM-TRE700', 'type' => ProductType::RawMaterial, 'unit_cost' => 32.00]);
        $shimanoDeore = SfdProduct::create(['name' => 'Shimano Deore 12-hitrostni komplet', 'sku' => 'RM-SHDR', 'type' => ProductType::RawMaterial, 'unit_cost' => 280.00]);
        $shimanoClaris = SfdProduct::create(['name' => 'Shimano Claris komplet', 'sku' => 'RM-SHCL', 'type' => ProductType::RawMaterial, 'unit_cost' => 165.00]);
        $brakeSetMtb = SfdProduct::create(['name' => 'Komplet hidravličnih disk zavor', 'sku' => 'RM-BRKH', 'type' => ProductType::RawMaterial, 'unit_cost' => 120.00]);
        $brakeSetRoad = SfdProduct::create(['name' => 'Komplet čeljustnih zavor', 'sku' => 'RM-BRKC', 'type' => ProductType::RawMaterial, 'unit_cost' => 60.00]);
        $handlebarMtb = SfdProduct::create(['name' => 'MTB krmilo in predstavek', 'sku' => 'RM-HBMTB', 'type' => ProductType::RawMaterial, 'unit_cost' => 55.00]);
        $handlebarCity = SfdProduct::create(['name' => 'Mestno krmilo in predstavek', 'sku' => 'RM-HBCTY', 'type' => ProductType::RawMaterial, 'unit_cost' => 40.00]);
        $saddle = SfdProduct::create(['name' => 'Ergonomski sedež', 'sku' => 'RM-SADL', 'type' => ProductType::RawMaterial, 'unit_cost' => 35.00]);
        $seatpost = SfdProduct::create(['name' => 'Aluminijasta sedežna cev', 'sku' => 'RM-SEAT', 'type' => ProductType::RawMaterial, 'unit_cost' => 22.00]);
        $paint = SfdProduct::create(['name' => 'Prašno barvilo', 'sku' => 'RM-PNT', 'type' => ProductType::RawMaterial, 'unit_cost' => 15.00]);
        $fork29 = SfdProduct::create(['name' => 'Vzmetena vilica 29"', 'sku' => 'RM-FRK29', 'type' => ProductType::RawMaterial, 'unit_cost' => 320.00]);
        $forkCity = SfdProduct::create(['name' => 'Toga vilica 700c', 'sku' => 'RM-FRK700', 'type' => ProductType::RawMaterial, 'unit_cost' => 65.00]);

        // ── Kosovnice podsestavov (kolesa) ──
        $bomFw29 = SfdBillOfMaterial::create(['product_id' => $frontWheel29->id, 'name' => 'Sestav sprednjega kolesa 29"', 'quantity' => 1]);
        $bomFw29->components()->createMany([
            ['product_id' => $hub->id, 'quantity' => 1, 'sort_order' => 1],
            ['product_id' => $spokes->id, 'quantity' => 1, 'sort_order' => 2],
            ['product_id' => $rim29->id, 'quantity' => 1, 'sort_order' => 3],
            ['product_id' => $tire29->id, 'quantity' => 1, 'sort_order' => 4],
        ]);
        $bomFw29->operations()->createMany([
            ['work_center_id' => $wcWheel->id, 'name' => 'Spletanje in centriranje sprednjega kolesa', 'duration_minutes' => 45, 'description' => 'Spletanje 32 naper v pesto in obroč, napenjanje in centriranje kolesa', 'sort_order' => 1],
            ['work_center_id' => $wcWheel->id, 'name' => 'Montaža sprednje pnevmatike', 'duration_minutes' => 10, 'description' => 'Montaža pnevmatike in zračnice, napolniti na predpisan tlak', 'sort_order' => 2],
        ]);

        $bomRw29 = SfdBillOfMaterial::create(['product_id' => $rearWheel29->id, 'name' => 'Sestav zadnjega kolesa 29"', 'quantity' => 1]);
        $bomRw29->components()->createMany([
            ['product_id' => $hub->id, 'quantity' => 1, 'sort_order' => 1],
            ['product_id' => $spokes->id, 'quantity' => 1, 'sort_order' => 2],
            ['product_id' => $rim29->id, 'quantity' => 1, 'sort_order' => 3],
            ['product_id' => $tire29->id, 'quantity' => 1, 'sort_order' => 4],
        ]);
        $bomRw29->operations()->createMany([
            ['work_center_id' => $wcWheel->id, 'name' => 'Spletanje in centriranje zadnjega kolesa', 'duration_minutes' => 50, 'description' => 'Spletanje 32 naper s pravilnim vzorcem križa, napenjanje in centriranje', 'sort_order' => 1],
            ['work_center_id' => $wcWheel->id, 'name' => 'Montaža zadnje pnevmatike in kasete', 'duration_minutes' => 15, 'description' => 'Montaža pnevmatike in zračnice, namestitev kasete', 'sort_order' => 2],
        ]);

        // ── Kosovnica Trail Blazer 29 ──
        $bomTb = SfdBillOfMaterial::create(['product_id' => $trailBlazer->id, 'name' => 'Trail Blazer 29 - Standardna sestava', 'quantity' => 1]);
        $bomTb->components()->createMany([
            ['product_id' => $chromolyTubing->id, 'quantity' => 1, 'sort_order' => 1],
            ['product_id' => $paint->id, 'quantity' => 1, 'sort_order' => 2],
            ['product_id' => $fork29->id, 'quantity' => 1, 'sort_order' => 3],
            ['product_id' => $frontWheel29->id, 'quantity' => 1, 'sort_order' => 4],
            ['product_id' => $rearWheel29->id, 'quantity' => 1, 'sort_order' => 5],
            ['product_id' => $shimanoDeore->id, 'quantity' => 1, 'sort_order' => 6],
            ['product_id' => $brakeSetMtb->id, 'quantity' => 1, 'sort_order' => 7],
            ['product_id' => $handlebarMtb->id, 'quantity' => 1, 'sort_order' => 8],
            ['product_id' => $saddle->id, 'quantity' => 1, 'sort_order' => 9],
            ['product_id' => $seatpost->id, 'quantity' => 1, 'sort_order' => 10],
        ]);
        $bomTb->operations()->createMany([
            ['work_center_id' => $wcWeld->id, 'name' => 'Varjenje cevi okvirja', 'duration_minutes' => 90, 'description' => 'TIG varjenje kromoli cevi: glavna cev, spodnja cev, sedežna cev, verižne opore, sedežne opore', 'sort_order' => 1],
            ['work_center_id' => $wcWeld->id, 'name' => 'Varjenje izpadnikov in nastavkov', 'duration_minutes' => 30, 'description' => 'Varjenje zadnjih izpadnikov, spajkanje vodil kablov in nastavkov za bidon', 'sort_order' => 2],
            ['work_center_id' => $wcPaint->id, 'name' => 'Peskanje in priprava okvirja', 'duration_minutes' => 20, 'description' => 'Peskanje okvirja, razmaščevanje in maskiranje navojev/ležajnih površin', 'sort_order' => 3],
            ['work_center_id' => $wcPaint->id, 'name' => 'Prašno lakiranje okvirja', 'duration_minutes' => 60, 'description' => 'Nanašanje temeljnega sloja in prašnega laka, pečenje v peči pri 200 °C', 'sort_order' => 4],
            ['work_center_id' => $wcComp->id, 'name' => 'Montaža vilice in glavnega ležaja', 'duration_minutes' => 20, 'description' => 'Vtiskanje ležajnih pokal, montaža vilice in predstavka', 'sort_order' => 5],
            ['work_center_id' => $wcComp->id, 'name' => 'Montaža pogona', 'duration_minutes' => 45, 'description' => 'Montaža sredinske osi, gonilke, zadnjega prestavnika, verige in prestavljalke', 'sort_order' => 6],
            ['work_center_id' => $wcComp->id, 'name' => 'Montaža zavor', 'duration_minutes' => 30, 'description' => 'Montaža hidravličnih disk zavor, napeljava in odzračevanje cevi', 'sort_order' => 7],
            ['work_center_id' => $wcComp->id, 'name' => 'Končna montaža', 'duration_minutes' => 20, 'description' => 'Montaža koles, krmila, sedeža, sedežne cevi, pedalov', 'sort_order' => 8],
            ['work_center_id' => $wcQc->id, 'name' => 'Kontrola kakovosti in pakiranje', 'duration_minutes' => 30, 'description' => 'Popoln pregled kolesa, testna vožnja, nastavitve, pakiranje za odpremo', 'sort_order' => 9],
        ]);

        // ── Kosovnica Urban Glide 700 ──
        $bomUg = SfdBillOfMaterial::create(['product_id' => $urbanGlide->id, 'name' => 'Urban Glide 700 - Standardna sestava', 'quantity' => 1]);
        $bomUg->components()->createMany([
            ['product_id' => $aluminumTubing->id, 'quantity' => 1, 'sort_order' => 1],
            ['product_id' => $paint->id, 'quantity' => 1, 'sort_order' => 2],
            ['product_id' => $forkCity->id, 'quantity' => 1, 'sort_order' => 3],
            ['product_id' => $frontWheel700->id, 'quantity' => 1, 'sort_order' => 4],
            ['product_id' => $rearWheel700->id, 'quantity' => 1, 'sort_order' => 5],
            ['product_id' => $shimanoClaris->id, 'quantity' => 1, 'sort_order' => 6],
            ['product_id' => $brakeSetRoad->id, 'quantity' => 1, 'sort_order' => 7],
            ['product_id' => $handlebarCity->id, 'quantity' => 1, 'sort_order' => 8],
            ['product_id' => $saddle->id, 'quantity' => 1, 'sort_order' => 9],
            ['product_id' => $seatpost->id, 'quantity' => 1, 'sort_order' => 10],
        ]);
        $bomUg->operations()->createMany([
            ['work_center_id' => $wcWeld->id, 'name' => 'Varjenje aluminijastega okvirja', 'duration_minutes' => 75, 'description' => 'TIG varjenje aluminijastih cevi s pravilnim upravljanjem toplote', 'sort_order' => 1],
            ['work_center_id' => $wcPaint->id, 'name' => 'Priprava in lakiranje okvirja', 'duration_minutes' => 50, 'description' => 'Brušenje, temeljni premaz in mokro lakiranje', 'sort_order' => 2],
            ['work_center_id' => $wcComp->id, 'name' => 'Montaža vilice in komponent', 'duration_minutes' => 40, 'description' => 'Montaža glavnega ležaja, vilice, pogona, zavor', 'sort_order' => 3],
            ['work_center_id' => $wcComp->id, 'name' => 'Končna montaža', 'duration_minutes' => 20, 'description' => 'Montaža koles, krmila, sedeža, dodatkov', 'sort_order' => 4],
            ['work_center_id' => $wcQc->id, 'name' => 'Kontrola in pakiranje', 'duration_minutes' => 25, 'description' => 'Pregled, testna vožnja, pakiranje', 'sort_order' => 5],
        ]);

        // ── Kosovnica Junior Sprint 20 ──
        $bomJs = SfdBillOfMaterial::create(['product_id' => $juniorSprint->id, 'name' => 'Junior Sprint 20 - Standardna sestava', 'quantity' => 1]);
        $bomJs->components()->createMany([
            ['product_id' => $aluminumTubing->id, 'quantity' => 0.7, 'sort_order' => 1],
            ['product_id' => $paint->id, 'quantity' => 0.8, 'sort_order' => 2],
            ['product_id' => $brakeSetRoad->id, 'quantity' => 1, 'sort_order' => 3],
            ['product_id' => $saddle->id, 'quantity' => 1, 'sort_order' => 4],
            ['product_id' => $seatpost->id, 'quantity' => 1, 'sort_order' => 5],
        ]);
        $bomJs->operations()->createMany([
            ['work_center_id' => $wcWeld->id, 'name' => 'Varjenje otroškega okvirja', 'duration_minutes' => 45, 'description' => 'Varjenje manjšega aluminijastega okvirja', 'sort_order' => 1],
            ['work_center_id' => $wcPaint->id, 'name' => 'Lakiranje in nalepke', 'duration_minutes' => 40, 'description' => 'Nanašanje živahne barve in zabavnih nalepk', 'sort_order' => 2],
            ['work_center_id' => $wcComp->id, 'name' => 'Celotna montaža', 'duration_minutes' => 30, 'description' => 'Montaža vseh komponent in koles', 'sort_order' => 3],
            ['work_center_id' => $wcQc->id, 'name' => 'Varnostni pregled in pakiranje', 'duration_minutes' => 20, 'description' => 'Dodatni varnostni pregledi za otroško kolo, pakiranje s pomožnimi kolesi', 'sort_order' => 4],
        ]);

        // ── Proizvodni nalogi ──
        // MO-0001: Zaključen Trail Blazer
        $mo1 = SfdManufacturingOrder::create([
            'reference' => 'MO-0001',
            'product_id' => $trailBlazer->id,
            'bom_id' => $bomTb->id,
            'quantity' => 5,
            'status' => ManufacturingOrderStatus::Done,
            'priority' => ManufacturingOrderPriority::Normal,
            'scheduled_date' => now()->subDays(14),
            'deadline' => now()->subDays(3),
            'completed_at' => now()->subDays(5),
        ]);
        foreach ($bomTb->operations()->orderBy('sort_order')->get() as $op) {
            $wo = SfdWorkOrder::create([
                'manufacturing_order_id' => $mo1->id,
                'operation_id' => $op->id,
                'work_center_id' => $op->work_center_id,
                'name' => $op->name,
                'status' => WorkOrderStatus::Done,
                'expected_duration' => $op->duration_minutes,
                'actual_duration' => $op->duration_minutes + fake()->numberBetween(-10, 15),
                'started_at' => now()->subDays(12),
                'completed_at' => now()->subDays(5),
                'assigned_to' => $users->random()->id,
                'sort_order' => $op->sort_order,
            ]);
            SfdTimeLog::create([
                'work_order_id' => $wo->id,
                'user_id' => $wo->assigned_to,
                'started_at' => $wo->started_at,
                'ended_at' => $wo->completed_at,
                'duration_minutes' => $wo->actual_duration,
            ]);
        }

        // MO-0002: V teku Urban Glide (nekateri DN zaključeni, nekateri v teku)
        $mo2 = SfdManufacturingOrder::create([
            'reference' => 'MO-0002',
            'product_id' => $urbanGlide->id,
            'bom_id' => $bomUg->id,
            'quantity' => 10,
            'status' => ManufacturingOrderStatus::InProgress,
            'priority' => ManufacturingOrderPriority::High,
            'scheduled_date' => now()->subDays(5),
            'deadline' => now()->addDays(7),
        ]);
        $ugOps = $bomUg->operations()->orderBy('sort_order')->get();
        foreach ($ugOps as $index => $op) {
            $status = match (true) {
                $index < 2 => WorkOrderStatus::Done,
                $index === 2 => WorkOrderStatus::InProgress,
                default => WorkOrderStatus::Pending,
            };
            $wo = SfdWorkOrder::create([
                'manufacturing_order_id' => $mo2->id,
                'operation_id' => $op->id,
                'work_center_id' => $op->work_center_id,
                'name' => $op->name,
                'status' => $status,
                'expected_duration' => $op->duration_minutes,
                'actual_duration' => $status === WorkOrderStatus::Done ? $op->duration_minutes + fake()->numberBetween(-5, 10) : null,
                'started_at' => $status !== WorkOrderStatus::Pending ? now()->subDays(3) : null,
                'completed_at' => $status === WorkOrderStatus::Done ? now()->subDay() : null,
                'assigned_to' => $status !== WorkOrderStatus::Pending ? $users->random()->id : null,
                'sort_order' => $op->sort_order,
            ]);
            if ($status !== WorkOrderStatus::Pending) {
                SfdTimeLog::create([
                    'work_order_id' => $wo->id,
                    'user_id' => $wo->assigned_to,
                    'started_at' => $wo->started_at,
                    'ended_at' => $status === WorkOrderStatus::Done ? $wo->completed_at : null,
                    'duration_minutes' => $status === WorkOrderStatus::Done ? $wo->actual_duration : null,
                ]);
            }
        }

        // MO-0003: Potrjen Trail Blazer (delovni nalogi pripravljeni, niso začeti)
        $mo3 = SfdManufacturingOrder::create([
            'reference' => 'MO-0003',
            'product_id' => $trailBlazer->id,
            'bom_id' => $bomTb->id,
            'quantity' => 3,
            'status' => ManufacturingOrderStatus::Confirmed,
            'priority' => ManufacturingOrderPriority::Normal,
            'scheduled_date' => now()->addDays(3),
            'deadline' => now()->addDays(14),
        ]);
        foreach ($bomTb->operations()->orderBy('sort_order')->get() as $op) {
            SfdWorkOrder::create([
                'manufacturing_order_id' => $mo3->id,
                'operation_id' => $op->id,
                'work_center_id' => $op->work_center_id,
                'name' => $op->name,
                'status' => WorkOrderStatus::Pending,
                'expected_duration' => $op->duration_minutes,
                'sort_order' => $op->sort_order,
            ]);
        }

        // MO-0004: Osnutek Junior Sprint
        SfdManufacturingOrder::create([
            'reference' => 'MO-0004',
            'product_id' => $juniorSprint->id,
            'bom_id' => $bomJs->id,
            'quantity' => 15,
            'status' => ManufacturingOrderStatus::Draft,
            'priority' => ManufacturingOrderPriority::Low,
            'scheduled_date' => now()->addDays(10),
            'deadline' => now()->addDays(30),
            'notes' => 'Sezonska serija za pomladansko kolekcijo',
        ]);

        // MO-0005: Nujen v teku Junior Sprint
        $mo5 = SfdManufacturingOrder::create([
            'reference' => 'MO-0005',
            'product_id' => $juniorSprint->id,
            'bom_id' => $bomJs->id,
            'quantity' => 2,
            'status' => ManufacturingOrderStatus::InProgress,
            'priority' => ManufacturingOrderPriority::Urgent,
            'scheduled_date' => now()->subDays(2),
            'deadline' => now()->addDays(2),
            'notes' => 'Nujna naročila za predstavitev stranki',
        ]);
        $jsOps = $bomJs->operations()->orderBy('sort_order')->get();
        foreach ($jsOps as $index => $op) {
            $status = $index === 0 ? WorkOrderStatus::Done : ($index === 1 ? WorkOrderStatus::InProgress : WorkOrderStatus::Pending);
            SfdWorkOrder::create([
                'manufacturing_order_id' => $mo5->id,
                'operation_id' => $op->id,
                'work_center_id' => $op->work_center_id,
                'name' => $op->name,
                'status' => $status,
                'expected_duration' => $op->duration_minutes,
                'actual_duration' => $status === WorkOrderStatus::Done ? $op->duration_minutes - 5 : null,
                'started_at' => $status !== WorkOrderStatus::Pending ? now()->subDay() : null,
                'completed_at' => $status === WorkOrderStatus::Done ? now()->subHours(6) : null,
                'assigned_to' => $status !== WorkOrderStatus::Pending ? $users->random()->id : null,
                'sort_order' => $op->sort_order,
            ]);
        }

        // MO-0006: Preklican
        SfdManufacturingOrder::create([
            'reference' => 'MO-0006',
            'product_id' => $urbanGlide->id,
            'bom_id' => $bomUg->id,
            'quantity' => 8,
            'status' => ManufacturingOrderStatus::Cancelled,
            'priority' => ManufacturingOrderPriority::Normal,
            'notes' => 'Stranka je preklicala naročilo',
        ]);

        // ── Kontrole kakovosti na zaključenih/tekočih delovnih nalogih ──
        $doneWos = SfdWorkOrder::where('status', WorkOrderStatus::Done)->get();
        foreach ($doneWos->take(5) as $wo) {
            SfdQualityCheck::create([
                'work_order_id' => $wo->id,
                'name' => 'Vizualni pregled',
                'type' => QualityCheckType::Visual,
                'result' => QualityCheckResult::Pass,
                'checked_by' => $users->random()->id,
                'checked_at' => $wo->completed_at,
                'sort_order' => 1,
            ]);
        }

        // Preverjanje poravnave okvirja na varilnih DN
        $weldWos = SfdWorkOrder::where('name', 'like', '%Varjenje%')->where('status', WorkOrderStatus::Done)->get();
        foreach ($weldWos as $wo) {
            SfdQualityCheck::create([
                'work_order_id' => $wo->id,
                'name' => 'Preverjanje poravnave okvirja',
                'type' => QualityCheckType::Measurement,
                'result' => QualityCheckResult::Pass,
                'measured_value' => fake()->randomFloat(1, 0.1, 0.5).' mm odstopanje',
                'checked_by' => $users->random()->id,
                'checked_at' => $wo->completed_at,
                'sort_order' => 2,
            ]);
        }

        // Debelina laka na lakirnih DN
        $paintWos = SfdWorkOrder::where('name', 'like', '%akiranje%')->where('status', WorkOrderStatus::Done)->get();
        foreach ($paintWos as $wo) {
            SfdQualityCheck::create([
                'work_order_id' => $wo->id,
                'name' => 'Debelina laka',
                'type' => QualityCheckType::Measurement,
                'result' => QualityCheckResult::Pass,
                'measured_value' => fake()->numberBetween(60, 80).' μm',
                'checked_by' => $users->random()->id,
                'checked_at' => $wo->completed_at,
                'sort_order' => 1,
            ]);
        }
    }
}
