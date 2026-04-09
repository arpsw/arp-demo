# ARP Kickstart

Modular Laravel/Filament starter project for AgilERP.

## Getting Started

After cloning this repository, rename the project folder and remove the existing git history to start fresh:

```bash
# Clone the repository
git clone git@github.com:agilerp/arp-kickstart.git myproject

# Enter the project folder
cd myproject

# Remove existing git history
rm -rf .git

# Initialize a new git repository (optional)
git init
git add .
git commit -m "Initial commit from ARP Kickstart"
```

## Prerequisites

### Docker & Docker Compose

Ensure Docker and Docker Compose are installed on your system.

### GitHub Token for Private Packages

The `agilerp/{module-name}-module` packages are hosted in private GitHub repositories. To install them via Composer, you need to configure access using a GitHub Personal Access Token.

```bash
composer config --global github-oauth.github.com "your_github_token_here"
```

Create a fine-grained token at: https://github.com/settings/personal-access-tokens/new
- Repository access: Selected set of repositories or all AgilERP repos as needed
- Permissions: Contents → Read-only

## Setup

```bash
# 1. Copy environment file(if not already done)
cp .env.example .env

# 2. (Optional) Customize project name - edit .env and change:
#    COMPOSE_PROJECT_NAME=myproject # eg. myapp, projectx
#    This prefixes all Docker resources (containers, networks, volumes)

# 3. Start containers
docker-compose up -d --build

# 4. Install PHP dependencies
docker-compose exec php composer install

# 5. Install Node dependencies & build assets
docker-compose exec node npm install
docker-compose exec node npm run build

# 6. Setup Laravel
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan migrate
docker-compose exec php php artisan db:seed

# 7. Generate Shield permissions for all panels
docker-compose exec php php artisan shield:generate --all --panel=admin
docker-compose exec php php artisan shield:generate --all --panel=ai

# 8. Create super admin user (interactive)
docker-compose exec php php artisan shield:super-admin

# 9. Publish Livewire assets
docker-compose exec php php artisan livewire:publish --assets

# 10. Rebuild assets
docker-compose exec node npm run build
```

## Running Commands

```bash
# PHP/Artisan (Ran via PHP Docker container)
docker-compose exec php php artisan <command>

# Composer (Ran via PHP Docker container)
docker-compose exec php composer <command>

# Node/NPM (Ran via Node Docker container)
docker-compose exec node npm <command>
```

## Access

- **Admin Panel:** http://localhost/admin
- **AI Panel:** http://localhost/ai
- **Login:** `admin@arp.local` / `password`
- **phpMyAdmin:** http://localhost:8080
- **Mailpit:** http://localhost:8025

## Optional: Install Additional Modules

To install additional AgilERP modules (e.g., `cms-module`, `hr-module`, etc.):

```bash
# Add module repository (replace MODULE_NAME with actual module name)
composer config repositories.MODULE_NAME vcs git@github.com:agilerp/MODULE_NAME.git

# Install the module
docker-compose exec php composer require agilerp/MODULE_NAME:dev-main

# Run migrations and generate permissions
docker-compose exec php php artisan migrate
docker-compose exec php php artisan shield:generate --all --panel=MODULE_PANEL
```

Available modules: `cms-module`, more coming soon.

## Changing Project Name After Setup

If you need to change `COMPOSE_PROJECT_NAME` after initial setup, be aware that new volumes will be created and your database will be empty.

```bash
# Stop and remove old containers
docker-compose down

# Edit .env and change COMPOSE_PROJECT_NAME

# Start with new prefix (creates new empty volumes)
docker-compose up -d --build

# Re-run full setup: migrations, seeding, etc. (see Setup section)
```

To clean up orphaned old volumes:
```bash
docker volume rm oldprefix_mysql_data oldprefix_redis_data
```
