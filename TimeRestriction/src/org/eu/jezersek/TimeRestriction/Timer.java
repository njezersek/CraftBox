package org.eu.jezersek.TimeRestriction;

import org.bukkit.Bukkit;
import org.bukkit.configuration.file.FileConfiguration;
import org.bukkit.entity.Player;

public class Timer implements Runnable {
	FileConfiguration config;
	Timer(FileConfiguration config){
		this.config = config;
	}

    @Override
    public void run() {

        for(Player player : Bukkit.getOnlinePlayers()){

        	boolean enabled = config.getBoolean("enabled");
    		String start = config.getString("start");
    		String end = config.getString("end");
    		
    		
    		if(enabled){	
    			if(TimeCalc.isBetween(start, end)){
    				player.kickPlayer("You can only play between "+end+" and "+start+".");			
    			}
    		}

        }

    }

}
