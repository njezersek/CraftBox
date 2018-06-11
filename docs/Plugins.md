# Plugins

## General info

Plugins are additional files or even mods, that alter the gaming experience in some way. They may do so by adding new files or resources, or by adding new commands and permissions. One of the plugins we use, [NoSpawnChunks](https://dev.bukkit.org/projects/nospawnchunks), "prevents spawn chunks being loaded into memory for all worlds on the server". In practice this means your server should be able to run a lot faster, because it doesn't have to load all the chunks and then keep them loaded, even after they are not in use.

## Installation

Spigot plugins are saved in the **/home/minecraft/plugins** directory.

You can find a list of popular plugins on the [Spigot forums](https://www.spigotmc.org/resources/categories/bukkit.4/).

You can install new plugins by including their jar file (for example NoSpawnChunks.jar) in the plugins folder.
Example: /home/minecraft/plugins/NoSpawnChunks.jar

We recommend you don't install too many plugins or very resource-heavy plugins, as they may affect performance.
