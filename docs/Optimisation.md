# Optimisation

Since CraftBox is meant to run on a Raspberry Pi, we have optimised some settings, although Spigot itself is very well optimised.

The main optimisation files are: **bukkit.yml**, **spigot.yml** and **server.properties**. Let's go through each one and see what we changed. Included are also links to the official explanations of every setting, in case you want to change or optimise the server even further.

## bukkit.yml

Explanation of every setting can be found [here](https://bukkit.gamepedia.com/Bukkit.yml).

In the file we changed:

* monsters: 40 (from 70)
* animals: 10 (from 15)

Even though this will means less animals/monsters will spawn, the gameplay should not be different that much. You can of course revert these changes if you want.

## spigot.yml

Explanation of every setting can be found [here](https://www.spigotmc.org/wiki/spigot-configuration/).

In the file we changed:

* restart-script: ./scripts/minecraft.sh restart (from ./start.sh)
* item-despawn-rate: 1000 (from 6000)
* arrow-despawn-rate: 200 (from 1200)

We changed the _restart-script_ option, because we wrote more scripts and included them all in the **scripts** folder.

## server.properties

Explanation of every setting can be found [here](https://www.spigotmc.org/wiki/spigot-configuration-server-properties/).

In the file we changed:

* spawn-protection: 0 (from 16)
* broadcast-console-to-ops=true (from false)
* broadcast-rcon-to-ops=true (from false)
* snooper-enabled=false (from true)
* enable-command-block=true (from false)
* max-players=5 (from 20)
* enable-rcon=true (from false)
* rcon.port=25575 (we manually added the option)
* rcon.password=craftbox (we manually added the option)
* level-name=saves/World (from just World for example)
* online-mode=false (from true)
* motd=\u00A71C\u00A72r\u00A73a\u00A74f\u00A75t\u00A76B\u00A79o\u00A7ax'\u00A7bs \u00A7cMinecraft \u00A7dServer (from Minecraft Server)

The _spawn-protection_ setting is NOT included in the Vanilla Minecraft Server config, but is added by Spigot.
The _broadcast-console-to-ops_ setting is NOT included in the Vanilla Minecraft Server config, but is added by Spigot.
The _broadcast-rcon-to-ops_ setting is NOT included in the Vanilla Minecraft Server config, but is added by Spigot.
_rcon.port_ and _rcon.password_ are required to be able to remotely connect to the console (which is what we do using our web management console).
The _level-name_ option is changed to saves/worldname, because we have moved all the worlds to the **saves** directory, to make the root folder less flodded and to make world management easier.
You might be wandering what the MOTD mess is. The _\u00A7#_ option is actually a command for different colors of the text that are displayed underneath the chosen server name in the Minecraft multiplayer menu. You can learn more about colorful MOTDs (Messages Of The Day) [here](https://www.minecraftforum.net/forums/support/server-support-and/1940468-how-to-add-colour-to-your-server-motd).


There are some other config files, but these are the important ones. Be aware that plugins might have their own configuration files, but we won't go into those.
