package org.eu.jezersek.TimeRestriction;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.TimeZone;

public class TimeCalc {
	public static boolean isBetween(String startTime, String endTime){
		long today = todayMillis();
		//long current = toMillis("06:00")+today;
		long current = nowMillis();
		long start = toMillis(startTime)+today;
		long end = toMillis(endTime)+today;

		if ((start > end && current > start && current > end) || (start > end && current < start && current < end)) { // FFS - Too many compares, but hey, at least it's working :)
			return true;
		} else if (start < end && current > start && current < end) {
			return true;
		} else {
			return false;
		}
	}
	
	static long todayMillis(){ //to zdej kao dela
		Calendar c = Calendar.getInstance(); // today
		c.set(Calendar.HOUR_OF_DAY, 0);
		c.set(Calendar.MINUTE, 0);
		c.set(Calendar.SECOND, 0);
		c.set(Calendar.MILLISECOND, 0);

		return c.getTimeInMillis();
	}
	
	static long nowMillis(){
		Calendar c = Calendar.getInstance(); // today
		return c.getTimeInMillis();
	}
	
	static long toMillis(String time){		
		Calendar c = Calendar.getInstance();
		SimpleDateFormat sdf = new SimpleDateFormat("HH:mm");
		sdf.setTimeZone(TimeZone.getTimeZone("GMT"));
		try {
			c.setTime(sdf.parse(time));
		} catch (ParseException e) {
			
		}
		
		long millis = c.getTimeInMillis();
		return millis;
	} 
}
