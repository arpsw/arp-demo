# Docker Environment

All PHP and Node commands must run inside Docker containers.

## PHP Commands
```bash
docker-compose exec php php artisan <command>
docker-compose exec php php <script>
docker-compose exec php composer <command>
docker-compose exec php ./vendor/bin/pint
```

## Node Commands
```bash
docker-compose exec node npm <command>
docker-compose exec node npm run build
docker-compose exec node npm run dev
```

## Host Commands (no docker prefix)
- Git commands: `git status`, `git commit`, etc.
- Docker control: `docker-compose up`, `docker-compose down`
