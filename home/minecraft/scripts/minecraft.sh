case "$1" in
	start)
		echo "Starting Minecraft server..."
		cd /home/minecraft
		screen -dmS "minecraft_server" sudo java -Xms512M -Xmx1008M -jar spigot.jar > /dev/null
		;;
	stop)
		echo "Stopping Minecraft server..."
		screen -S minecraft_server -p 0 -X stuff "`printf \"stop\r\"`"  > /dev/null
		;;
	restart)
		echo "Restarting Minecraft server..."
		screen -S minecraft_server -p 0 -X stuff "`printf \"stop\r\"`" > /dev/null
		cd /home/minecraft
		screen -dmS "minecraft_server" sudo java -Xms512M -Xmx1008M -jar spigot.jar > /dev/null
		;;
	*)
		echo "Usage: $0 {start|stop|restart}"

exit 1
esac
exit 0
