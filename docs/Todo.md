# Todo

This todo list is sorted by priority (high, medium, low) and is mostly meant for us developers to keep track of stuff we have to fix. The todo list may be replaced by **Issues** in the future.

## High Priority (Mixed)

* Fix permissions (users should NOT have sudo permissions - alternative: add www-data to proper group)
* Disable SSH (When updates are ready)
* Fix security flaws in the code ([worlds.php](../var/www/html/worlds.php) should not have to set chmod 777!!!)
* Replace Pi user with Spigot user
* Fix naming (Minecraft -> Spigot, worlds -> saves)
* Explain security settings in [Security.md](Security.md)
* Force changing of password on first login into console (Web management and WiFi network passwords)

## Medium Priority (Easy)

* Custom plugin upload
* Installation script
* Code cleanup, server optimisations


## Low Priority (Medium)

* Generate custom structures using [WorldEdit](https://dev.bukkit.org/projects/worldedit "WorldEdit Website")
* Separate builds for Raspberry Pi 3 and older versions (built-in WiFi or external Wireless adapter)
* Manual updates (new releases will offer a script that, when run, will replace, add or edit updated files automatically)
* A section in the web management console for applying these updates (maybe include them in a zip that can be uploaded)
* Semi-automatic updates (A button in the web console that checks if an update is released, downloads it and installs it)
* Automatic updates (Server checks for updates every week or so and automatically installs them if they are available)
