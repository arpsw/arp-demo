<?php

namespace Modules\MNT\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\MNT\AI\Toolkits\MNTToolkit;
use Modules\MNT\AI\Tools\CreateMaintenanceRequestTool;
use Modules\MNT\AI\Tools\ReadEquipmentTool;
use Modules\MNT\AI\Tools\ReadMaintenanceRequestsTool;
use Modules\MNT\AI\Tools\ReadMaintenanceTeamsTool;
use Modules\MNT\AI\Tools\UpdateMaintenanceRequestTool;

class ToolServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            ReadEquipmentTool::class,
            ReadMaintenanceRequestsTool::class,
            ReadMaintenanceTeamsTool::class,
            CreateMaintenanceRequestTool::class,
            UpdateMaintenanceRequestTool::class,
        ], 'ai.tools');

        $this->app->tag([
            MNTToolkit::class,
        ], 'ai.toolkits');
    }
}
