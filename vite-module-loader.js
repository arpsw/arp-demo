import fs from 'fs/promises';
import path from 'path';
import { pathToFileURL } from 'url';

async function collectModuleAssetsPaths(paths, modulesPaths) {
  if (!Array.isArray(modulesPaths)) {
    modulesPaths = [modulesPaths];
  }

  const moduleStatusesPath = path.join(__dirname, 'modules_statuses.json');

  try {
    const moduleStatusesContent = await fs.readFile(moduleStatusesPath, 'utf-8');
    const moduleStatuses = JSON.parse(moduleStatusesContent);

    for (const modulesPath of modulesPaths) {
      const absoluteModulesPath = path.join(__dirname, modulesPath);

      let moduleDirectories;
      try {
        moduleDirectories = await fs.readdir(absoluteModulesPath);
      } catch {
        continue;
      }

      for (const moduleDir of moduleDirectories) {
        if (moduleDir === '.DS_Store') {
          continue;
        }

        if (moduleStatuses[moduleDir] === true) {
          const viteConfigPath = path.join(absoluteModulesPath, moduleDir, 'vite.config.js');

          try {
            await fs.access(viteConfigPath);
            const moduleConfigURL = pathToFileURL(viteConfigPath);
            const moduleConfig = await import(moduleConfigURL.href);

            if (moduleConfig.paths && Array.isArray(moduleConfig.paths)) {
              paths.push(...moduleConfig.paths);
            }
          } catch {
            // vite.config.js does not exist, skip this module
          }
        }
      }
    }
  } catch (error) {
    console.error(`Error reading module statuses or module configurations: ${error}`);
  }

  return paths;
}

export default collectModuleAssetsPaths;
