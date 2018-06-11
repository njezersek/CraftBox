# Commands

This file lists all the commands needed for normal operation and their short descriptions.
The command explanations all apply to Linux, since the Raspberry Pi is running [Raspbian](https://www.raspbian.org/), a modified version of [Debian](https://www.debian.org/).

You can see full descriptions of every command by running `man commandname`, for example `man fdisk`.

The only two commands not used on the Pi are `fdisk` and `dd`. The `sudo` command that is sometimes used just means that you're running that command as the **root** user. This user is basically the equivalent of Administrator on Windows and he has access to every file on the system.

### fdisk -l

This command was used to list all the drives that are connected to our PC. More info on it can be found [here](https://www.lifewire.com/linux-command-fdisk-4091540).

The <b>-l</b> option specified that we want to **list** all the drives.

Example output:

```
Disk /dev/sdb: 28,9 GiB, 31009800192 bytes, 60566016 sectors
Units: sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disklabel type: dos
Disk identifier: 0xfe46e46b
```

This is not the full output of the command, only my 32 GB USB's listing.

### [dcfl]dd

This command makes a copy of the input file with the specified conditions. We used it to transfer the contents of the image (.img) file to the SD Card. More info on it can be found [here](https://www.lifewire.com/dd-linux-command-4095971).

The **if=** option specified the **input** path/file.<br>
The **of=** option specified the **output** path/file.<br>
The **bs=** option specified the **block size**.<br>
We then used the <b>;</b> character to specify a new command (sync).
The `sync` command is not part of dd or dcfldd and is used to verify that all the files were fully transferred.

The dd command doesn't output anything until the process of transfering is finished. It then outputs the number of transferred blocks and the size of files.

## **Booting up and initial installation**

After flashing the image file onto the Raspberry Pi we have to update it and set it up. We can do so with these commands.

### apt update && apt -y upgrade

apt is a Linux package manager mostly used in Ubuntu and Debian.

The `update` command checks for any updates in its repositories.<br>
The `upgrade` command downloads and installs those updates.<br>
We used the **&&** operator, which just executes commands one after another.<br>
The <b>-y</b> option used with the `upgrade` command. It means that there won't be a confirmation dialog (sometimes you have to press Enter to confirm you want to download and install the files).

### raspi-config

The command is used to open the Raspbian configuration menu, where you can change most Raspberry Pi-related settings, like its hostname or password (and of course a lot more).

### apt install apache2 php screen

The `install` command is used with the `apt` program. It is used to download and install new programs. Its opposite would be `remove` which is used to uninstall programs.<br>
After the install command we specify programs we want to install, in our case **apache2**, **php** and **screen**. We can download mupltiple packages at the same time by putting a space (" ") in-between them.

### cp, mv

The `cp` command is used for **copying** files from one location to another.<br>
THe `mv` command is used for **moving** files from one location to another.<br>

## Server installation and startup

Once we have updated the Pi, we can start working on the server settings. By this time we have already moved the **minecraft** and **var** folders and their contents to their respective positions.

### ./minecraft.sh {start|stop|restart}

The `minecraft.sh` script was written to start, stop or restart the Minecraft Server. It uses the `screen` program, which is very configurable and is great for commands you want running in the background.
The **start** option starts the server. I'm sure you can figure the other two out yourself.

### screen

The `screen` program is used for better remote management of programs and windows. We use it for managing the Server. There are two main commands we use, `screen -list` and `screen -r minecraft_server`.<br>

The `screen -list` command displays all the running windows/screens.

Example output:

```
There is a screen on:
        404.minecraft_server    (06/11/18 10:48:26)     (Detached)
1 Socket in /run/screen/S-pi.
```

You can see that there is one screen (our server) and that we are currently **detached**. This means that the server is running inside its screen, but that we currently aren't seeing its output. We can do just that by using the next command.

The `screen -r minecraft_server` command **reattaches** us to the running server. <i>minecraft_server</i> is the name we chose for the screen, but it can be anything you want.

Example output:

```
[09:28:05 INFO]: Nerfing mobs spawned from spawners: false                                                                   
[09:28:05 INFO]: -------- World Settings For [saves/World_the_end] --------                                                  
[09:28:05 INFO]: Cactus Growth Modifier: 100%                                                                                
[09:28:05 INFO]: Cane Growth Modifier: 100%                                                                                  
[09:28:05 INFO]: Melon Growth Modifier: 100%                                                                                 
[09:28:05 INFO]: Mushroom Growth Modifier: 100%                                                                              
[09:28:05 INFO]: Pumpkin Growth Modifier: 100%                                                                               
[09:28:05 INFO]: Sapling Growth Modifier: 100%                                                                               
[09:28:05 INFO]: Wheat Growth Modifier: 100%                                                                                 
[09:28:05 INFO]: NetherWart Growth Modifier: 100%                                                                            
[09:28:05 INFO]: Vine Growth Modifier: 100%                                                                                  
[09:28:05 INFO]: Cocoa Growth Modifier: 100%                                                                                 
[09:28:05 INFO]: Entity Activation Range: An 32 / Mo 32 / Mi 16 / Tiv true                                                   
[09:28:05 INFO]: Entity Tracking Range: Pl 48 / An 48 / Mo 48 / Mi 32 / Other 64                                             
[09:28:05 INFO]: Hopper Transfer: 8 Hopper Check: 1 Hopper Amount: 1                                                         
[09:28:05 INFO]: Random Lighting Updates: false                                                                              
[09:28:05 INFO]: Structure Info Saving: true                                                                                 
[09:28:05 INFO]: Mob Spawn Range: 4                                                                                          
[09:28:05 INFO]: Custom Map Seeds:  Village: 10387312 Feature: 14357617 Monument: 10387313 Slime: 987234911                  
[09:28:05 INFO]: Max TNT Explosions: 100                                                                                     
[09:28:05 INFO]: Tile Max Tick Time: 50ms Entity max Tick Time: 50ms                                                         
[09:28:05 INFO]: Arrow Despawn Rate: 200                                                                                     
[09:28:05 INFO]: Allow Zombie Pigmen to spawn from portal blocks: true                                                       
[09:28:05 INFO]: Experience Merge Radius: 3.0                                                                                
[09:28:05 INFO]: Zombie Aggressive Towards Villager: true                                                                    
[09:28:05 INFO]: View Distance: 4                                                                                            
[09:28:05 INFO]: Item Despawn Rate: 1000                                                                                     
[09:28:05 INFO]: Item Merge Radius: 2.5                                                                                      
[09:28:05 INFO]: Nerfing mobs spawned from spawners: false                                                                   
[09:28:05 INFO]: Preparing start region for level 0 (Seed: -7492801512473941435)                                             
[09:28:05 INFO]: Preparing start region for level 1 (Seed: -7492801512473941435)                                             
[09:28:05 INFO]: Preparing start region for level 2 (Seed: -7492801512473941435)                                             
[09:28:05 INFO]: Server permissions file permissions.yml is empty, ignoring it                                               
[09:28:06 INFO]: Done (3.359s)! For help, type "help" or "?"                                                                 
[09:28:06 INFO]: Starting remote control listener                                                                            
[09:28:06 INFO]: RCON running on 0.0.0.0:25575                                                                               
>
```

This is the actual console of the server, which BTW is accessible over RCON as well. The `./minecraft.sh stop` command sends the word _stop_ to the server and presses Enter. This signals the server to stop and shut down.

By pressing CTRL+A+D we can **detach** again and leave the server running in the background.


**This should be all the commands, if you want more info on what's actually happening inside the script(s) add an issue and I'll explain everything.**
