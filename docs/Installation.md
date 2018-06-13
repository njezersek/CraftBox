# Installation

Installing CraftBox is very easy, but it partially differs depending on your Operating System (OS) and preferences. At the time we only provide the instructions for Linux and Windows, as those are the OSes we are familliar with.

## Easiest: Flash the released image file

You can download the latest release of CraftBox from our [Releases page](https://gitlab.com/JustMeErazem/CraftBox/tags). The current release is v0.1 (Updated 11. June 2018).

Recommended tools:
* [Win32DiskImager](https://sourceforge.net/projects/win32diskimager/) - Windows (For flashing the image onto the SDCard)
* [SD Card Formatter](https://www.sdcard.org/downloads/formatter_4/) - Windows & Mac (For formatting the SD Card, since Windows doesn't recognise ext4 partitions)
* [GParted](https://gparted.org/) - Linux (For formatting the SD Card, Gnome Disks would also be a good alternative)
* dcfldd - Linux (A better alternative to dd, used for copying the image to the SD Card). It doesn't come preinstalled on linux, so use `sudo apt install dcfldd` to install it (or use a similar package manager, like dnf or pacman, on other Linux distros).

**Windows:**
1. Download and install Win32 Disk Imager.
2. Run it and choose the image (.img) file we provided.
3. Select your freshly formatted SDCard.
4. Press "Write" and wait until it finishes.
5. Insert the SDCard into your Raspberry Pi plug it in.

**Linux:**
1. Format your SDCard, we recommend you leave it unallocated (Best way is to create a new **msdos** partition table).
2. Open a terminal and move into the directory to which you downloaded the image (.img) file. You can use the `cd` command to move to the directory.
3. Type: `sudo fdisk -l`. Take note of your SDCard's last letter, it will probably be "b" or "c" ("a" is usually occupied by the internal hard drive). You can use the SD Card  size as a reference, for example, a 16 GB card should show about 14-16 GB of storage, a hard drive is more like 128-1024 GB.
4. Type: `sudo dd if=filename.img of=/dev/sd# bs=4M; sync` (# = your SDCard's last letter). **Replace dd with dcfldd if you installed dcfldd!**
5. Insert the SD Card into your Raspberry Pi and plug it in.

Example with dd: `sudo dd if=craftbox-v0.1-11062018.img of=/dev/sdc bs=4M; sync`<br>
Example with dcfldd: `sudo dcfldd if=craftbox-v0.1-11062018.img of=/dev/sdc bs=4M; sync`

The difference between **dd** and **dcfldd** is in the output (and some other not-so-visual fixes). dcfldd displays the amount of data transfered which is a lot better than guessing if dd still works or how long it will take.

## Still pretty easy: Manually copying files to your pi

This way of installing involves manually downloading the latest [Rasbian Stretch Lite](https://www.raspberrypi.org/downloads/raspbian/) image and flashing it onto an SD Card. Then you must move the contents of **minecraft** and **var** folders to their respective positions. You will probably be able to merge the files (automatically moving the files to their proper positions).

Hopefully everything will work, but since this project has just been released, you may need to set some permissions, mainly add the www-data user to the pi group (or whichever group owns the minecraft server files).

You will also need to install apache and php files, which hopefully you already know how to do. This way of installation is for users that have a little more knowledge of Linux and setting up webservers. As of now you don't need to install MySQL or such, but it may be needed in future versions.

**Setup instructions:**
1. Download and flash the latest Raspbian Stretch Lite image to your SDCard (Refer to previous method of installation).
2. Insert the SD Card into your Raspbery Pi, find the Pi's IP in your router settings to connect to it over SSH, or just use a monitor and keyboard to set it up.
3. Update and upgrade using `sudo apt update && sudo apt -y upgrade`.
4. Change settings in the raspi-config menu by typing `sudo raspi-config` (You should at least change the default password).
5. Install **apache2** and **php** files using `sudo apt install apache2 php` (this will install the "apache2" and "php" packages).
6. Install **screen** to be able to freely connect to the server's console and to run the startup/shutdown script.
7. If the Minecraft Server is the only thing on the Pi (if you're not running other stuff/servers/whatever...), you can actually put all the files into the Pi user's directory (/home/pi) or even rename the Pi user, or (best if you have multiple stuff on the pi) create a new "minecraft" user and put the server files in there
8. (maybe) Add the www-data (webserver/apache) user to "pi" group (or whichever group owns the files) by using `sudo adduser www-data pi`
9. You can setup a DNS server, so you can access the Pi's Control Panel using **craftbox.tk** instead of **192.168.4.1**.

Now move all the files to their respective directories and start the server by running the **minecraft.sh** script.
Firstly move to the root directory of the server (e.g. /home/minecraft), then use `./minecraft.sh start` to start the server.
It should show you how to connect to the console, since it uses a program called **[screen](https://www.rackaid.com/blog/linux-screen-tutorial-and-how-to/)**. You can do this by typing `screen -r minecraft_server`. A full explanation of **every single command** can be found in the [Commands](Commands.md) section.

This should pretty much be it. BTW you can stop the server by either running `./minecraft.sh stop` or by entering the console with the previously mentioned screen command and terminating it with CTRL+C or by typing *stop* and pressing Enter.

One last thing is automatically starting the server at reboot, which can be done by adding the startup script (minecraft.sh start) to **crontab**.
You can do this by using `sudo crontab -e`, which will show you a text dialog, where you can choose your favourite text editor. For beginners we recommend pressing Enter, to choose **nano**, a very simple but useful editor. Now it will show you a new window with some text. Ignore all that and use your arrow keys to move to the bottom of the page, where you can add (on a separate line) the text `@reboot /bin/bash /home/minecraft/minecraft.sh start`.

You might also want to automatically update other packages, which you can do by adding `* * * * 1 root (apt update && apt -y -d upgrade) > /dev/null` under your newly added startup command.

**DNS Configuration:**

Use your favourite text editor to edit _/etc/resolv.conf.head_. We use the _resolf.conf.head_ instead of _resolv.conf_, because _resolv.conf.head_ doesn't get rewritten at reboot, like _resolv.conf_ does.

The full command would be `sudo nano /etc/resolv.conf.head`. Here you can add **craftbox.tk 127.0.0.1** and save the file. By doing this we have redirected the _craftbox.tk_ domain to our localhost, 127.0.0.1 (our Raspberry Pi).
