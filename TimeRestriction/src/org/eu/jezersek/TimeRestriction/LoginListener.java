package org.eu.jezersek.TimeRestriction;

import org.bukkit.configuration.file.FileConfiguration;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.player.PlayerJoinEvent;

public class LoginListener implements Listener {
	FileConfiguration config;
	LoginListener(FileConfiguration config){
		this.config = config;
	}
	
	@EventHandler
    public void onPlayerJoin(PlayerJoinEvent event){
		Player player = event.getPlayer();
		boolean enabled = config.getBoolean("enabled");
		String start = config.getString("start");
		String end = config.getString("end");
		
		
		if(enabled){	
			event.setJoinMessage("Welcome, " + player.getName() + "!"+" You can play between "+end+" and "+start+".");
			if(TimeCalc.isBetween(start, end)){
				player.kickPlayer("You can only play between "+end+" and "+start+".");			
			}
		}
		else{
			event.setJoinMessage("Welcome, " + player.getName() + "!");
		}
		
    }
}
