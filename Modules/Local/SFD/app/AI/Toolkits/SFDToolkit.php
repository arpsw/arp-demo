<?php

namespace Modules\SFD\AI\Toolkits;

use Modules\Ai\Neuron\Contracts\ToolMetadataInterface;
use Modules\Ai\Neuron\Traits\HasToolMetadata;
use Modules\SFD\AI\Tools\CreateManufacturingOrderTool;
use Modules\SFD\AI\Tools\ReadManufacturingOrdersTool;
use Modules\SFD\AI\Tools\ReadWorkCentersTool;
use Modules\SFD\AI\Tools\ReadWorkOrdersTool;
use Modules\SFD\AI\Tools\UpdateManufacturingOrderTool;
use Modules\SFD\AI\Tools\UpdateWorkOrderTool;
use NeuronAI\Tools\Toolkits\AbstractToolkit;
use NeuronAI\Tools\Toolkits\ToolkitInterface;

class SFDToolkit extends AbstractToolkit implements ToolkitInterface, ToolMetadataInterface
{
    use HasToolMetadata;

    public function __construct()
    {
        $this->setDisplayName('Shop Floor Toolkit')
            ->setDescription('Tools for managing manufacturing orders, work orders, and production work centers in the SFD module.')
            ->setIcon('building-office-2')
            ->setCategory('Production')
            ->setTags(['sfd', 'manufacturing', 'production', 'work-orders', 'toolkit'])
            ->setVersion('1.0.0')
            ->setAuthor('SFD Module')
            ->setRequiresAuth(true);
    }

    public function provide(): array
    {
        return [
            app(ReadManufacturingOrdersTool::class),
            app(ReadWorkOrdersTool::class),
            app(ReadWorkCentersTool::class),
            app(CreateManufacturingOrderTool::class),
            app(UpdateManufacturingOrderTool::class),
            app(UpdateWorkOrderTool::class),
        ];
    }

    public function guidelines(): ?string
    {
        return <<<'GUIDELINES'
This toolkit manages the Shop Floor Data (SFD) module for a bicycle manufacturing facility.

**Manufacturing Order (MO) lifecycle:**
Draft → Confirmed (generates work orders from BOM) → InProgress (first WO started) → Done

**Work Order (WO) lifecycle:**
Pending → InProgress (started) → Done (completed)
InProgress → Ready (paused, can resume) → InProgress
InProgress → Paused (malfunction reported, triggers maintenance automation)

**Key rules:**
- An MO must be in Draft to confirm it. Confirming generates work orders from the bill of materials operations.
- Starting a work order automatically transitions the parent MO from Confirmed to InProgress.
- Completing a work order calculates total duration from time logs.
- Reporting a malfunction pauses the work order and records the problem description, which triggers the maintenance agent.
- Use Read Work Centers to understand the production layout and equipment at each station.
GUIDELINES;
    }
}
