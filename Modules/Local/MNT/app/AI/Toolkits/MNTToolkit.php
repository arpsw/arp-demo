<?php

namespace Modules\MNT\AI\Toolkits;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\MNT\AI\Tools\CreateMaintenanceRequestTool;
use Modules\MNT\AI\Tools\ReadEquipmentTool;
use Modules\MNT\AI\Tools\ReadMaintenanceRequestsTool;
use Modules\MNT\AI\Tools\ReadMaintenanceTeamsTool;
use Modules\MNT\AI\Tools\UpdateMaintenanceRequestTool;
use NeuronAI\Tools\Toolkits\AbstractToolkit;
use NeuronAI\Tools\Toolkits\ToolkitInterface;

class MNTToolkit extends AbstractToolkit implements ToolkitInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        $this->setDisplayName('Maintenance Toolkit')
            ->setDescription('Tools for managing equipment maintenance, requests, and preventive schedules in the MNT module')
            ->setIcon('wrench-screwdriver')
            ->setCategory('Maintenance')
            ->setTags(['maintenance', 'equipment', 'preventive', 'corrective', 'toolkit'])
            ->setVersion('1.0.0')
            ->setAuthor('MNT Module')
            ->setRequiresAuth(true);
    }

    public function provide(): array
    {
        return [
            app(ReadEquipmentTool::class),
            app(ReadMaintenanceRequestsTool::class),
            app(ReadMaintenanceTeamsTool::class),
            app(CreateMaintenanceRequestTool::class),
            app(UpdateMaintenanceRequestTool::class),
        ];
    }

    public function guidelines(): ?string
    {
        return 'This toolkit provides access to maintenance management data. Use it to query equipment status, '
            .'search maintenance requests, create new requests, and update existing ones. '
            .'Equipment is linked to SFD work centers. Maintenance requests can be corrective (breakdowns) '
            .'or preventive (scheduled). Stages flow: New → In Progress → Repaired (or Scrap).';
    }
}
