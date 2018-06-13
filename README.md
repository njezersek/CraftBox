<img src="docs/images/logo-title.png" width="350">

CraftBox is a RaspberryPi powered Local Area Network Minecraft Server intended for parents who don't want their kids playing on public servers until they are old enough. The reasons might vary, but we believe parents want to allow their children to play Minecraft, it's just that public servers could be full of [Griefers](https://minecraft.gamepedia.com/Tutorials/Griefing) or people who swear or insult. This isn't the environment that [Notch](https://en.wikipedia.org/wiki/Markus_Persson) envisioned.

## **CraftBox's features include:**
* Optimised Spigot server
* Some included plugins ([NoSpawnChunks](https://dev.bukkit.org/projects/nospawnchunks) and [Time Restriction](https://github.com/JustMeErazem/CraftBox/tree/master/TimeRestriction) - We've built this one ourselves, courtesy of Nejc Jezeršek)
* Material web management console
* Creating new worlds
* Uploading or backing up worlds
* World configuration (at creation)
* Server configuration
* CraftBox configuration (WiFi SSID, console login credentials)
* Setting time restrictions
* RCON access to server
* Easy server restarting process

### **Current release:** v0.1

CraftBox is based on [Spigot](https://www.spigotmc.org/), so it offers very good performance on the Pi's hardware. Currently the project only officially supports the Raspberry Pi 3 and newer models, because of the built-in wireless module, but you can easily make it work with any other Raspberry Pi by including a Wireless adapter and changing a bit of code, although we discourage the usage of older Raspberry Pis, since their performance may be significantly worse. We have optimised the server settings to increase performance, although you may edit the configuration yourself, to increase performance even further (Info about such configuration can be found in the [Optimisation](docs/Optimisation.md) section.

It works by creating its own WiFi network, called **CraftBox** - default password is **craftbox**. The web management console is available on **192.168.4.1** or at **craftbox.tk** (if you set up a DNS server), while connected to it through its WiFi network. You can of course access it from outside its network, which will also have the benefit of you still having access to the internet, but you will have to find the external IP yourself first (You can also see it on the "Server info" page in the web management console). 

**While connected to CraftBox's network, you will not have internet access, as that is the whole point of it (check the first paragraph if you forgot what it's all about).**

### **Default access info:**
**Network name:** CraftBox  
**Network password:** craftbox  
**Web console IP:** 192.168.4.1 (or craftbox.tk)  
**Web console username:** admin  
**Web console password:** admin  

We recommend you change these settings after the first login.

Users can connect to CraftBox's network and start playing on its Minecraft Server (192.168.4.1 or craftbox.tk) almost immediately after powering it on, as the server is automatically started with every reboot.

**You can find all the instructions on setting up, installing plugins, configuring files and more in the [docs](docs) folder.**

## **Todo list:**
* Custom plugin upload
* Generate custom structures using [WorldEdit](https://dev.bukkit.org/projects/worldedit "WorldEdit Website")
* Separate builds for Raspberry Pi 3 and older versions (built-in WiFi or external Wireless adapter)
* Edit permissions (some files are owned by root - a quick fix for www-data access) --> This one has a priority
* Delete Pi user, replace with craftbox user (and fix permissions)
* Manual updates (new releases will offer a script that, when run, will replace, add or edit updated files automatically)
* A section in the web management console for applying these updates (maybe include them in a zip that can be uploaded)
* Semi-automatic updates (A button in the web console that checks if an update is released, downloads it and installs it)
* Automatic updates (Server checks for updates every week or so and automatically installs them if they are available)
* A bit of code cleanup, some server optimisations, ...

For info on installation see the [Installation](docs/Installation.md) section.

## **Contributors:**
* Erazem Kokot ([JustMeErazem](https://github.com/JustMeErazem)) - Main developer
* Nejc Jezeršek ([njezersek](https://github.com/njezersek) - [Website](https://jezersek.eu.org))  - Main developer
* Domen Klinc ([@domen_klinc](https://www.instagram.com/domen_klinc)) - Graphical design

## **How you can help the project:**
* Contribute to the Wiki with examples, configurations, tutorials
* Test for bugs and report issues
* Fix, add or update stuff from the todo list
