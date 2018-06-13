case "$1" in
	start)
		cd /home/spigot
		screen -dmS "spigot" sudo java -Xms512M -Xmx1008M -jar spigot.jar > /dev/null
		;;
	stop)
		screen -S spigot -p 0 -X stuff "`printf \"stop\r\"`"  > /dev/null
		;;
	restart)
		screen -S spigot -p 0 -X stuff "`printf \"stop\r\"`" > /dev/null
		cd /home/spigot
		screen -dmS "spigot" sudo java -Xms512M -Xmx1008M -jar spigot.jar > /dev/null
		;;
	*)
		echo "Usage: $0 {start|stop|restart}"

exit 1
esac
exit 0
