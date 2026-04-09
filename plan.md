# ARP - AgilERP ERP Modularization Plan

> **Repository**: [genumi-demo](https://github.com/agilerp)
> **Status**: Draft - planning general architecture and decisions. Current genumi-demo repo is a proof-of-concept with tightly coupled modules. Next step will be to create new project arp-kickstart with modular packages(pulled from remote repos) and test installation flow.
> **Confirmed**: Mono-repo with basic Filament resources, with ability to import external Agiledrop packages via Composer
> **Purpose**: Provide starter ARP kikcstart Laravel/Filament project with modular architecture for AgilERP clients

---

## 0. General architecture Overview

**Development Strategy: Mono-repo with ability to import composer packages/modules**

1. Project will be called arp-kickstart
2. Base project will live in a mono-repo (like genumi-demo)
3. Base project will contain current Core module logic, so Core module is basically not relavant as package anymore, but its logic will be in main app
    3.1. Users, Auth, Permissions
    3.2. Shared Filament configuration (SharedPanelConfiguration trait)
4. Base project will have ability to import additional modules via Composer packages
    4.1. agilerp/ai - git@github.com:agilerp/ai-module.git
    4.2. agilerp/cms - git@github.com:agilerp/cms-module.git
    4.3. agilerp/hr
    4.4. agilerp/fsf
    4.5. agilerp/crm
    4.6. agilerp/website
5. Base project will require agilerp/ai package, that will be pulled in via Composer
6. Client-specific modules will live in `Modules/ClientSpecific` directory
    6.1. Used by pattern, provided by https://github.com/nWidart/laravel-modules
---

## 1. Current State Analysis

### Module Inventory
| Module | Type | Dependencies | Complexity |
|--------|------|--------------|------------|
| **Core** | Foundation | Shield, Spatie Settings | Low | Wont be a package, its logic will be in main app | Will probably always include AI
| **AI** | Foundation | Neuron AI, Livewire Volt | Medium | Requires Core |
| **CMS** | Add-on | Media Library, Tags | High |
| **CRM** | Add-on | None specific | Low |
| **HR** | Add-on | None specific | Medium |
| **FSF** | Add-on | None specific | High |
| **Installations** | Add-on | None specific | Medium |
| **Website** | Add-on | None specific | Low |

### Current and Potential Coupling Points
- `User` model lives in `App\Models\User` (not in Core). It will probably stay the same in ARP kickstart project
- Permissions should be handled via Shield/Spatie Permission package, but should be set in main app(core package will note exist)
- `SharedPanelConfiguration` trait in Core - used by ALL module panels - TBD
- There would need to be some common filament theme setup across panels and packages and modules - TBD
- AI module has `PanelConfigurationResolver` fallback mechanism - TBD

## 2. Architecture Decisions Needed

### Decision 1: Where Does the User Model Live?

**Keep in App\Models (Current, base app)**
- Pros: Simple, no migration needed
- Cons: Each client app maintains its own User model

---

### Decision 2: Package Distribution Method

**LaravelModules/Composer packages as separete Github repositories**
- **Repo:** [genumi-demo](https://github.com/agilerp)


**LaravelModules - publish modules as composer packages**
- Dilemma: Install modules/packages via Composer and publish them into `Modules/` directory? or keep them in `vendor/` and load them from there?
- [ ] **Option A: Keep in `Modules/` directory**
  - Pros: Easy to develop locally, same as current
  - Cons: Need to handle publishing and updates carefully
- [ ] **Option B: Load from `vendor/` directory**
  - Pros: True package management, easier updates
  - Cons: More complex autoloading and module management

---

### Decision 3: SharedPanelConfiguration Strategy

**Decision: Separate panels per package** (AI → /ai, CRM → /crm, etc.)

**TODOs**
- [ ] How to handle SharedPanelConfiguration trait that is used by all module panel providers?
- [ ] How to handle common Filament theming across packages/modules or across Modules/ClientSpecific?

**See:** "Expanded: Package ServiceProvider" section for implementation details 

---

### Decision 4: Database Migrations Strategy

**Core Migrations(base kickstart app) + Module Migrations with Checks**
- Main app has migrations for core entities (users, settings)
- Each module/package has its own migrations
- On installation, module checks if core migrations exist before running its own
- On Module migration, check if Module migrations has table prefix to avoid conflicts

---

### Decision 5: Client-Specific Module Pattern

**How should client-specific modules reference shared entities (e.g., User)?**

**Service exposure with Service container binding**
- Provide certain services or contracts from core app to be used by client-specific modules
    - example: UserService in app/Services/UserService.php
        - method: getUserById($id)
- Dilemma: 
    - How to resolve currently logged-in user in client-specific modules without directly referencing App\Models\User?
    - A: [...]

---

## 3. Proposed Package Structure


### agilerp/ai Package
```
ai/
├── composer.json
├── src/
│   ├── AIServiceProvider.php
│   ├── Services/
│   │   ├── NeuronAgentFactory.php
│   │   └── ToolManager.php
│   ├── Models/
│   │   ├── Agent.php
│   │   └── Chat.php
│   ├── Filament/
│   └── Traits/
│       └── PanelConfigurationResolver.php
├── config/
│   └── ai.php
└── database/
    └── migrations/
```

### Client App Structure Example (After Extraction)
```
client-project/
├── app/
│   └── Models/
│       └── User.php                  # Extends/Implements Core contract
├── composer.json
│   # require:
│   #   "agilerp/ai": "^1.0"
│   #   "agilerp/cms": "^1.0"          # Optional
│   #   "agilerp/hr": "^1.0"           # Optional
├── Modules/
│   └── ClientSpecific/               # Client's custom module
└── config/
    └── agilerp.php                    # Module configuration
```

---

## 4. Installation Flow (Future State)
Provided is general installation steps for a new client project using ARP kickstart with modular packages.
Provided steps are for illustration; actual commands may vary.
Provided steps will be run by Agiledrop developers when setting up new client projects(eg. ARP for Client X, ARP for client CocaCola).

```bash
# 1. Clone agilerp-kickstart repository
git clone

cd agilerp-kickstart
# 2. Install base dependencies
composer install
# 3. Require necessary AgilERP packages
composer require agilerp/ai
# Optional packages
composer require agilerp/cms
composer require agilerp/hr
# 4. Publish package configurations and assets
php artisan vendor:publish --tag=agilerp-ai-config
php artisan vendor:publish --tag=agilerp-cms-config
# 5. Run migrations
php artisan migrate
# 6. Set up initial admin user
php artisan make:admin
# 7. (Optional) Create client-specific modules in Modules/ClientSpecific
php artisan module:make CocaColaShipping --path=Modules/CocaColaShipping
```

## 5. Next Steps

After decisions are made:
1. Create proof-of-concept with Core package extraction
2. Test installation on fresh Laravel project
3. Iterate on architecture based on findings
4. Document patterns for client-specific modules

---

## 6. Notes / Ideas

### Challenge: AI Module Extensibility (Knowledge Injection)

**Problem:** Custom client modules need to contribute knowledge/context to the AI module, but modifying AI would break composer updateability.

**Solution:** Service container tagging - packages register their tools via tagged services in their ServiceProvider.

**Status:** [x] Solved - packages use `$this->app->tag()` to register tools with `agilerp.ai.tools` tag

---

## 7. Proposed Solutions to Dilemmas

### Solution 1: Package Location (vendor/ vs Modules/)

**Recommendation: Keep packages in `vendor/`, use `Modules/` only for client-specific code**

```
arp-kickstart/
├── vendor/
│   └── agilerp/
│       ├── ai/              # Composer package (read-only)
│       ├── cms/             # Composer package (read-only)
│       └── hr/              # Composer package (read-only)
├── Modules/
│   └── ClientSpecific/      # nWidart module (editable, git-tracked)
└── app/                     # Core logic (auth, users, shared config)
```

**Why:**
- Clear separation: packages = external dependencies, Modules = project code
- `composer update` works naturally without conflicts
- Client modules are git-tracked in the project repo
- No publishing/syncing complexity

**Note: Filament Panel Switching Works Regardless of Location**

Filament panel switcher works identically whether panels come from `vendor/` or `Modules/`. Filament only cares that panels are **registered** via ServiceProvider - the file location is transparent.

```
Panel Switcher sees all registered panels equally:
├── /admin     ← Base app (app/)
├── /ai        ← Package (vendor/agilerp/ai)
├── /crm       ← Package (vendor/agilerp/crm)
└── /client-x  ← Client module (Modules/ClientX)
```

Requirements for panel switching:
1. Panel registered with `Filament::registerPanel()` in ServiceProvider
2. User passes `canAccessPanel()` check
3. Panel switcher enabled in configuration

---

### Solution 2: SharedPanelConfiguration Strategy

**Recommendation: Base app owns trait, packages use resolver pattern**

**Step 1:** Base app owns the trait
```php
// app/Filament/Traits/SharedPanelConfiguration.php
trait SharedPanelConfiguration { /* theming, colors, hooks */ }
```

**Step 2:** Packages use resolver pattern (AI already has this)
```php
// In agilerp/ai package
trait PanelConfigurationResolver
{
    protected function resolveSharedConfiguration(Panel $panel): Panel
    {
        if (trait_exists(\App\Filament\Traits\SharedPanelConfiguration::class)) {
            // Use app's shared config
        }
        return $this->applyFallbackConfiguration($panel);
    }
}
```

---

### Solution 3: User Reference in Client Modules

**Recommendation: Use `auth()->user()` + config binding for relationships**

**For current user:** `auth()->user()` (works everywhere)

**For relationships:**
```php
// config/agilerp.php
'models' => ['user' => App\Models\User::class],

// In package/module models
public function user(): BelongsTo {
    return $this->belongsTo(config('agilerp.models.user'));
}
```

---

## 8. Potential Bottlenecks

### Bottleneck 1: AI Tool Discovery from vendor/
- **Risk:** ToolManager needs to discover tools from packages in `vendor/`
- **Solution:** Service container tagging

**Status:** [x] Solved - packages register tools via service container tags in their ServiceProvider

### Bottleneck 2: Migration Ordering
- **Risk:** Package migrations reference `users` table
- **Mitigation:** Use timestamps strategically or `Schema::hasTable()` checks
- **Status:** Doable. Make sure to run base app migrations first

### Bottleneck 3: Filament Panel Auto-Registration
- **Risk:** Packages need to register panels with Filament
- **Mitigation:** Use Filament plugin pattern in ServiceProvider. Already done in AI package(example: external_packages/ai-module)
- **Status:** Done in AI package. See "Expanded: Package ServiceProvider" section for implementation details

---

## 9. Tool Discovery Strategy

### Service Container Tagging

Packages and modules register their tools via service container tags in their ServiceProvider:

```php
// In any package or module ServiceProvider
public function boot(): void
{
    // Register individual tools
    $this->app->tag([
        \Agilerp\CRM\AI\Tools\CreateLeadTool::class,
        \Agilerp\CRM\AI\Tools\SearchLeadsTool::class,
    ], 'agilerp.ai.tools');

    // Or register a tool provider
    $this->app->tag([
        \Agilerp\CRM\AI\CRMToolProvider::class,
    ], 'agilerp.ai.tool-providers');
}
```

### ToolManager Discovery

```php
// In agilerp/ai ToolManager
public function discoverTools(): Collection
{
    $tools = collect();

    // Tagged individual tools
    foreach (app()->tagged('agilerp.ai.tools') as $tool) {
        $tools->push($tool);
    }

    // Tool providers (return arrays of tools)
    foreach (app()->tagged('agilerp.ai.tool-providers') as $provider) {
        $tools = $tools->merge($provider->getTools());
    }

    return $tools->unique();
}
```


## 10. POC Implementation Plan

### Phase 1: Create arp-kickstart Base

**Goal:** Clean Laravel/Filament project with Core logic

Ask for confirmation after each line completed

- [x] Create fresh Laravel project
- [x] Manually add external_code/genumi-demo file to app(to gitignore as well) to see the context of the current code
- [x] Set up docker environment - Adjust docker-compose.yml, mainly just container names and volumes
    - run php commands as docker compose exec php php artisan ...
    - run node commands as docker compose exec node npm ...
- [x] Install Filament, Livewire, Shield, laravel-modules
- [x] Publish Livewire assets
    - php artisan livewire:publish --assets)
- [x] Laravel setup (env, app key, database)
- [x] Npm install, build assets
- [x] Set up Spatie Settings package
- [x] Set up User model with HasRoles
- [x] Create SharedPanelConfiguration trait
- [x] Create `config/agilerp.php`
- [x] Set up base admin panel
- [x] Create seeders for default roles/permissions

### Phase 2: Include agilerp/ai Package

**Goal:** Pull repo manually

- [x] Create packages/ folder in arp-kickstart
- [x] Clone agilerp/ai package into packages/ai
- [x] Adjust composer.json to include "repositories" entry for local package
    - "repositories": [
        {
            "type": "path",
            "url": "./packages/ai-module"
        },
        {
            "type": "path",
            "url": "./packages/cms-module"
        }
    ],
    "require": {
        "agilerp/ai-module": "@dev",
        "agilerp/cms-module": "@dev",
    },
- [x] Require agilerp/ai package via composer()
- [x] Check if panels load and function correctly
- [x] Show panels resources
- [x] Enable panel switching
- [x] Enable language switching
- [x] Merge/join ai-module Chat styles with base app styles (currently conflicting)
    - ai-module's custom chat doesnt have its styles loaded currently
    - Analyze how /Users/kristof/www/arp-kickstart/external_code/genumi-demo/Modules/AI resolves its tailwind styles. In module setup, those styles were registered in genumi-demo Core module. In current project, arp-kickstart, ai-module is a composer package. And its styles are not registered anywhere currently. Propose solutions.
    - [x] Create new Filament theme (`resources/css/filament/admin/theme.css`)
    - [x] Configure theme CSS with `@source` directive for AI module Blade files
    - [x] Update vite.config.js to include theme CSS in inputs
    - [x] Update SharedPanelConfiguration trait to apply viteTheme()
    - [x] Create artisan publish command in ai-module package that auto-inserts `@source` directive
        - Command: `php artisan agilerp:ai-module:publish-styles`
        - Appends `@source '../../../../vendor/agilerp/ai-module/resources/views/**/*.blade.php';` to theme.css
        - Created `PublishAIStylesCommand` in ai-module package
    - [x] Rebuild frontend assets (`npm run build`)
- [x] Move ai-module package persmission seeding into command. Move out of migration.
    - Currently ai-module package has permission seeding in its migration file. This is not ideal, as migrations should be idempotent and not have side effects like seeding data.
    - Propose to create an artisan command in ai-module package that seeds permissions when run explicitly.
    - Command: `php artisan agilerp:ai-module:seed-permissions`
    - Created `SeedAIPermissionsCommand` in ai-module package
- [x] Setup Laravel Horizon for queue management (ai-module uses queues for processing)
    - [x] Install horizon package via composer
    - [x] Publish Horizon assets
    - [x] Configure HorizonServiceProvider gate for local + super_admin access
    - [x] Update composer dev script to use Horizon instead of queue:listen
- [x] Test basic AI functionality (create agent, chat, use tools)
    - [x] Add API key
    - [x] Create agent
    - [x] Test chat with agent
- [x] Adapt Tool discovery in ai-module to use service container tagging
    - [x] Update ToolManager to discover tools via `agilerp.ai.tools` service container tag
    - [x] Packages register tools in their ServiceProvider using `$this->app->tag()`
    - [x] Test tool discovery from client-specific module and from other packages, eg. cms-module
    - [x] Fixed cms-module tools to use `Modules\AI\Neuron\*` namespace (was using `Agilerp\ArpAi\*`)
- [x] Verify that ai-module package works correctly as composer package in arp-kickstart project
    - [x] Test installation flow in fresh Laravel project
    - [x] Document installation steps in ai-module README

---

### Phase 3. Adapt agilerp modules from composer Package structure to laravel-module structure ✅
- Module first resides in packages/ai-module and packages/cms-module as composer packages
- Goal is to convert them to use nWidart/laravel-modules structure internally, so that when published, they can be extracted into Modules/AI and Modules/CMS directories
- [x] Convert ai-module package to use nWidart/laravel-modules structure internally
    - [x] Install nWidart/laravel-modules and joshbrw/laravel-module-installer in arp-kickstart composer.json
    - [x] Adjust or just check ai-module package structure to match laravel-modules conventions
    - [x] On package/module publish, module will be extracted into Modules/AI directory
        - Use docs https://laravelmodules.com/docs/12/advanced/publishing-modules#have-modules-be-installed-in-the-codemodulescode-folder
    - Module agilerp/ai-module can be dependent on arp-kickstart, as it uses its User model and SharedPanelConfiguration trait
    - [x] Review autoloading and correctness of namespaces
    - [x] Verified: Both packages have correct `"type": "laravel-module"`, module.json, and PSR-4 autoloading
    - [x] Make sure if current changes in packages/ai-module make change, when comparing to initial AI module in external_code/genumi-demo/Modules/AI - Purpose of ai-module, was to convert Module into reusable composer package. Now we are converting it back to laravel-module structure, but as a composer package. So the code should remain mostly the same as in external_code/genumi-demo/Modules/AI, so new changes are actually useful, or maybe break somehting? Do this analysis and propose steps to fix if needed.
        - [x] Analysis complete: Compared packages/ai-module vs external_code/genumi-demo/Modules/AI
        - [x] Added back `tests/Feature/ToolRenderingTest.php` (was missing in composer package)
        - [x] Added back `package.json` for Laravel Module pattern compliance
        - Kept intentional improvements: Console commands, config file, Livewire registration, README
        - Kept custom `modulePath()` helper (works for both vendor/ and Modules/ locations)
- [x] Check if there is a command to publish config from ai-module package to main app config
    - [x] Command exists: `php artisan vendor:publish --tag=agilerp-ai-config` (registered in AIServiceProvider)
    - [x] Documented in ai-module README.md (step 5)


### Phase 3.5: Publish *-module Modules as GitHub Repositories ✅
- [x] Create GitHub repositories for each module package
    - [x] agilerp/ai-module https://github.com/agilerp/ai-module
    - [x] agilerp/cms-module https://github.com/agilerp/cms-module
- [x] Private repos - prepare authentication via fine-grained PAT for agilerp organization
- [x] Update ai-module
    - [x] Update Readme with GitHub repo link and prerequisites for token setup
- [x] Update cms-module
    - [x] Update Readme with GitHub repo link and prerequisites for token setup
    - [x] Update composer.json dependencies to pull ai-module from GitHub repo (vcs)
- [x] Use dev-main branch for now (will create releases later)
- [x] Update composer.json in arp-kickstart to pull from GitHub repos instead of local packages/
    - [x] Add vcs repository entry for ai-module GitHub repo
    - [x] Update require to use agilerp/ai-module:dev-main
    - [x] Removed cms-module (optional install)
    - [x] Test installation flow from GitHub repos - WORKS

## Phase 3.6: Horizon Setup in arp-kickstart
- [ ] Provide supervisor configuration for Laravel Horizon
- [ ] Document Horizon setup in README
- [ ] Test Horizon in context of ai-module - Cache behavior on permission changes, etc.

## Phase 3.7: XDebug
- [x] Install XDebug in local php Dockerfile

### Phase 4: Add UserResource to main admin panel ✅
- Basically copy the functionality form genumi-demo Core module UserResource into main app admin panel - /Users/kristof/www/arp-kickstart/external_code/genumi-demo/Modules/Core/app/Filament/Resources/Users
- [x] Create UserResource in main app admin panel
    - Created `app/Filament/Resources/UserResource/` with UserResource.php, Schemas/, Tables/, Pages/
    - Includes form with name, email, password, email_verified_at, and roles assignment
    - Includes table with search, role filter, and sortable columns
    - Includes infolist for view page
- [x] Assign Shield permissions for UserResource
    - Generated policy via `php artisan shield:generate --resource=UserResource --panel=admin`
- [x] Add create user action to UserResource
- [x] Add edit user action to UserResource
- [x] Add delete user action to UserResource
- [x] Add ability to assign roles to users in UserResource
    - CheckboxList component with roles relationship
- [x] Test UserResource functionality (list, create, edit, delete users)
    - Created `tests/Feature/Filament/Resources/UserResourceTest.php` with 15 tests covering all CRUD operations



### Phase 4 Real world setup and test

- [ ] Prepare project to only have ai-module as dependency in composer.json
- [ ] Test installation flow of new kickstart project from scratch(with included ai-module as already added dependency)

### Phase 5 Setup instructions in README
- [ ] OpenAi API key setup instructions
- [ ] Shield permissions/roles setup instructions
- [ ] Instructions for agilerp package installation via composer
- [ ] Instructions to install additional agilerp packages via composer
- [ ] Brief instructions for client-specific module creation via laravel-modules

### Deployment phase
- [ ] Prepare deployment scripts for production server
- [ ] Prepare ssh keys or tokens for private repo access on server

---

## 11. Deployment via GitLab CI/CD
- [ ] Plan deployment process

## 12. Setup Commands Reference

### Shield Commands (Permissions & Roles)

```bash
# Generate permissions for all panels
docker-compose exec php php artisan shield:generate --all --panel=admin
docker-compose exec php php artisan shield:generate --all --panel=ai
docker-compose exec php php artisan shield:generate --all --panel=cms

# Create super admin (interactive - run in terminal)
docker-compose exec php php artisan shield:super-admin

# Assign super admin to specific user by ID
docker-compose exec php php artisan shield:super-admin --user=1

# Install Shield (first time setup)
docker-compose exec php php artisan shield:install

# Seed Shield roles/permissions
docker-compose exec php php artisan shield:seeder
```

### Database Commands

```bash
# Run all migrations
docker-compose exec php php artisan migrate

# Fresh migration with seeders
docker-compose exec php php artisan migrate:fresh --seed

# Run seeders
docker-compose exec php php artisan db:seed
```

### Cache Commands

```bash
# Clear all caches
docker-compose exec php php artisan optimize:clear

# Rebuild caches
docker-compose exec php php artisan optimize
```

### Filament Commands

```bash
# Create admin user
docker-compose exec php php artisan make:filament-user

# List registered panels
docker-compose exec php php artisan route:list --name=filament
```

---

### Phase 3: Test Client Module Pattern

**Goal:** Verify client modules work alongside packages

- [ ] Create test module: `php artisan module:make ClientDemo`
- [ ] Add model with User relationship
- [ ] Add AI tools in module
- [ ] Verify tools discovered by AI

### Phase 4: Extract One Add-on (CMS) via local composer package

**Goal:** Validate add-on package pattern - https://github.com/agilerp/cms-module

- [ ] Create packages/cms folder
- [ ] Move CMS module code from genumi-demo to packages/cms
- [ ] Adjust composer.json to include "repositories" entry for local package
- [ ] Test installation via composer require agilerp/cms
- [ ] Verify CMS panel loads and functions

---

## 13. Backlog

### Package Uninstall Commands

**Problem:** When running `composer remove agilerp/cms-module`, database tables remain and migration history in `migrations` table stays, which can cause issues on reinstall.

**Solution:** Create uninstall artisan command for each package that:
- Rolls back package migrations
- Cleans up published assets
- Removes `@source` directive from theme.css
- Removes Shield permissions for package resources (from `permissions`, `role_has_permissions`, `model_has_permissions` tables)
- Example: `php artisan ai:uninstall`, `php artisan cms:uninstall`

**Proper removal flow:**
```bash
# 1. Run package uninstall (while package still installed)
php artisan ai:uninstall

# 2. Then remove package
composer remove agilerp/ai-module
```

