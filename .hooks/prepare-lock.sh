#!/bin/bash

# Regenerates a clean composer.lock with GitHub refs instead of local path refs.
# Parses composer.local.json to dynamically determine packages and module symlinks.

set -e

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"
cd "$PROJECT_DIR"

LOCAL_JSON="composer.local.json"
LOCAL_JSON_BAK="composer.local.json.bak"

if [ ! -f "$LOCAL_JSON" ]; then
    echo "No $LOCAL_JSON found — composer.lock should already be clean."
    exit 0
fi

# Derive package names and symlink info from composer.local.json
PACKAGES=$(python3 - "$LOCAL_JSON" <<'PYEOF'
import json, os, sys

with open(sys.argv[1]) as f:
    data = json.load(f)

names = []
for repo in data.get('repositories', {}).values():
    if repo.get('type') == 'path':
        pkg_json = os.path.join(repo['url'], 'composer.json')
        if os.path.exists(pkg_json):
            with open(pkg_json) as pf:
                names.append(json.load(pf)['name'])

print(' '.join(names))
PYEOF
)

echo "==> Found local packages: $PACKAGES"
echo "==> Temporarily disabling $LOCAL_JSON..."
mv "$LOCAL_JSON" "$LOCAL_JSON_BAK"

echo "==> Updating lock file with GitHub refs..."
composer update $PACKAGES 2>&1

if grep -q '"type": "path"' composer.lock; then
    echo "ERROR: composer.lock still contains path references."
    mv "$LOCAL_JSON_BAK" "$LOCAL_JSON"
    exit 1
fi

echo "==> Saving clean composer.lock..."
cp composer.lock composer.lock.clean

echo "==> Restoring $LOCAL_JSON and local symlinks..."
mv "$LOCAL_JSON_BAK" "$LOCAL_JSON"
composer update $PACKAGES 2>&1

echo "==> Staging clean composer.lock..."
cp composer.lock.clean composer.lock
rm composer.lock.clean
git add composer.lock

echo "==> Restoring module symlinks..."
python3 - "$LOCAL_JSON" <<'PYEOF'
import json, os, subprocess, sys

with open(sys.argv[1]) as f:
    data = json.load(f)

for repo in data.get('repositories', {}).values():
    if repo.get('type') != 'path':
        continue
    url = repo['url']
    pkg_json = os.path.join(url, 'composer.json')
    if not os.path.exists(pkg_json):
        continue
    with open(pkg_json) as pf:
        pkg = json.load(pf)
    if pkg.get('type') != 'laravel-module':
        continue
    # arpsw/core-module -> Modules/Remote/Core
    slug = pkg['name'].split('/')[-1].replace('-module', '')
    target = f'Modules/Remote/{slug.title()}'
    # Compute relative path from symlink's parent dir to the package dir
    abs_url = os.path.abspath(url)
    symlink_dir = os.path.dirname(os.path.abspath(target))
    rel_path = os.path.relpath(abs_url, symlink_dir)

    if os.path.islink(target):
        current = os.readlink(target).rstrip('/')
        if current == rel_path:
            print(f'  OK (symlink): {target}')
        else:
            os.remove(target)
            os.symlink(rel_path, target)
            print(f'  Fixed: {target} -> {rel_path}')
    else:
        if os.path.exists(target):
            subprocess.run(['rm', '-rf', target], check=True)
        os.symlink(rel_path, target)
        print(f'  Recreated: {target} -> {rel_path}')
PYEOF

echo ""
echo "Done! composer.lock is staged with clean GitHub refs."
echo "Your local symlinks are restored. You can now commit."
