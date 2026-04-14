<?php

namespace Modules\SFD\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\SFD\AI\Toolkits\SFDToolkit;
use Modules\SFD\AI\Tools\CreateManufacturingOrderTool;
use Modules\SFD\AI\Tools\ReadManufacturingOrdersTool;
use Modules\SFD\AI\Tools\ReadWorkCentersTool;
use Modules\SFD\AI\Tools\ReadWorkOrdersTool;
use Modules\SFD\AI\Tools\UpdateManufacturingOrderTool;
use Modules\SFD\AI\Tools\UpdateWorkOrderTool;

class ToolServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            ReadManufacturingOrdersTool::class,
            ReadWorkOrdersTool::class,
            ReadWorkCentersTool::class,
            CreateManufacturingOrderTool::class,
            UpdateManufacturingOrderTool::class,
            UpdateWorkOrderTool::class,
        ], 'ai.tools');

        $this->app->tag([
            SFDToolkit::class,
        ], 'ai.toolkits');
    }
}
