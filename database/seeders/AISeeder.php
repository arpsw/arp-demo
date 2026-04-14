<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Ai\Data\OpenAIProviderConfigData;
use Modules\Ai\Enums\AutomationType;
use Modules\Ai\Models\Agent;
use Modules\Ai\Models\AIAutomation;
use Modules\SFD\Models\SfdWorkOrder;

class AISeeder extends Seeder
{
    public function run(): void
    {
        $factoryManager = Agent::firstOrCreate(
            ['name' => 'Vodja proizvodnje'],
            [
                'description' => 'AI agent za vodenje proizvodnje v tovarni koles Primorska Kolesa d.o.o. Nadzira proizvodne naloge, delovne naloge, vzdrževanje opreme in komunicira z vzdrževalnimi ekipami.',
                'system_message' => <<<'PROMPT'
Si AI vodja proizvodnje v podjetju Primorska Kolesa d.o.o. iz Kopra, Slovenija. Tovarna proizvaja gorska, mestna in otroška kolesa — od varjenja okvirjev, lakiranja, montaže koles, montaže komponent do končne kontrole kakovosti.

Imaš dostop do orodij za proizvodnjo (SFD) in vzdrževanje (MNT). Tvoje naloge so:

**Proizvodnja:**
- Pregled in upravljanje proizvodnih nalogov (MO) ter delovnih nalogov (WO)
- Ustvarjanje novih proizvodnih nalogov za izdelke iz kosovnic
- Potrjevanje osnutkov proizvodnih nalogov (generira delovne naloge iz operacij kosovnice)
- Spremljanje napredka delovnih nalogov po delovnih mestih

**Vzdrževanje in okvare:**
Ko prejmete podatke o spremembi delovnega naloga, jih natančno analizirajte:

1. **Če je status delovnega naloga "paused" in opombe opisujejo težavo:**
   - Preberite opombe za razumevanje okvare
   - Podatki sprožilca vključujejo delovno mesto in vso opremo na tem mestu. Ugotovite, katera oprema je najverjetneje prizadeta.
   - Z orodjem Read Maintenance Requests preverite, ali za to opremo že obstaja odprt zahtevek
   - Če ne, z orodjem Create Maintenance Request ustvarite korektivni zahtevek z:
     - Jasnim imenom, ki opisuje težavo
     - Pravilnim equipment_id
     - request_type: corrective
     - priority: glede na resnost (urgent pri varnostnem tveganju ali zaustavitvi proizvodnje, high pri vplivu na kakovost, normal sicer)
     - Podrobnim opisom, ki združuje operaterjeve opombe z vašo analizo
   - Po ustvarjanju zahtevka z orodjem Read Maintenance Teams poiščite ustrezno ekipo in njihove člane s telefonskimi številkami
   - Če je težava nujna ali visoke prioritete, z orodjem Retell Phone Call pokličite vodjo ekipe (role: "leader") in ga obvestite o okvari. V parameter `context` vključite reference na zapise (ID zahtevka, ime opreme, številka delovnega naloga).

2. **Če gre le za običajno spremembo statusa (začetek, zaključek ipd.):**
   - Nobeno dejanje ni potrebno, le potrditev.

**Telefonski klici:**
Pri telefonskih klicih komuniciraj v slovenščini. Bodi strokoven, jedrnat in spoštljiv do časa sogovornika. V navodilih za glasovnega agenta (parameter `task`) nikoli ne navajaj internih ID-jev zapisov — uporabljaj človeško razumljiva imena: ime opreme, naziv delovnega mesta, ime izdelka, opis težave. ID-je in reference na zapise shrani v parameter `context`, ki je namenjen za interno obdelavo po klicu.

**Splošno:**
Vedno bodi temeljit pri analizi. Seznam opreme v podatkih sprožilca prikazuje opremo na delovnem mestu. Orodja za vzdrževalne ekipe zagotavljajo kontaktne podatke.
PROMPT,
                'provider' => 'openai',
                'provider_config' => new OpenAIProviderConfigData(
                    model: 'gpt-5-mini'
                ),
                'tools' => ['s_f_d_toolkit', 'm_n_t_toolkit', 'retell_phone_call_tool'],
            ]
        );

        $admin = User::first();
        if ($admin) {
            AIAutomation::firstOrCreate(
                ['name' => 'Work Order Malfunction Monitor'],
                [
                    'agent_id' => $factoryManager->id,
                    'user_id' => $admin->id,
                    'prompt' => 'A work order has been updated. The data below includes the work order details, the work center, and all equipment at that work center. If the status is "paused" and the notes describe a malfunction, create a corrective maintenance request for the affected equipment. Then use Read Maintenance Teams to find the right team and call the team leader if the issue is urgent. If status is not "paused", no action needed.',
                    'type' => AutomationType::RecordChange,
                    'model_class' => SfdWorkOrder::class,
                    'model_events' => ['updated'],
                    'is_active' => true,
                ]
            );

            AIAutomation::firstOrCreate(
                ['name' => 'Retell Call Results Processor'],
                [
                    'agent_id' => $factoryManager->id,
                    'user_id' => $admin->id,
                    'prompt' => 'You are receiving the results of a completed phone call made by the Retell AI voice agent. Review the call transcript and outcome. If the call gathered useful information (e.g. technician availability, diagnosis of a problem, scheduled time for repair), use the appropriate maintenance tools to update existing maintenance requests or create new ones based on what was discussed during the call.',
                    'type' => AutomationType::Webhook,
                    'webhook_token' => 'retell-T0TKLzK4cWRdQE5VNUlEL46o3NqFD9mWRVM3RQ6zDe151JTB',
                    'is_active' => true,
                ]
            );
        }
    }
}
