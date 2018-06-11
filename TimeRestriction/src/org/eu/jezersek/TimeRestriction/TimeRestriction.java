package org.eu.jezersek.TimeRestriction;

import org.bukkit.Bukkit;
import org.bukkit.configuration.file.FileConfiguration;
import org.bukkit.plugin.java.JavaPlugin;

public class TimeRestriction extends JavaPlugin{
	FileConfiguration config = this.getConfig();
	// Fired when plugin is first enabled
    @Override
    public void onEnable() {
    	getServer().getPluginManager().registerEvents(new LoginListener(config), this);
    	
    	
    	config.addDefault("enabled", false);
    	config.addDefault("start", "20:00");
    	config.addDefault("end", "9:00");
    	config.options().copyDefaults(true);
    	
    	saveConfig();
    	
    	
    	Bukkit.getScheduler().scheduleSyncRepeatingTask(this, new Timer(config), 20, 20);
    	
    	
    }
    // Fired when plugin is disabled
    @Override
    public void onDisable() {
    	
    }
}
