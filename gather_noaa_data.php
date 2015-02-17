<?php
	require_once('utilities.php');
	// alaska weather alert url
	//$weather_alerts_url = "http://alerts.weather.gov/cap/wwaatmget.php?x=AKZ101&y=0";
	
	// spotsylvania weather alert url
	$weather_alerts_url = "http://alerts.weather.gov/cap/wwaatmget.php?x=VAC017&y=1";
	
	//$weather_alerts_xml = @simplexml_load_file($weather_alerts_url);
	//$weather_alerts = $weather_alerts_xml->entry;
	
	$weather_alerts_xmlstring = @better_file_get_contents($weather_alerts_url);
	$weather_alerts_xml = fromXml($weather_alerts_xmlstring);	
	$weather_alerts = $weather_alerts_xml->entry;
	//print_r($weather_alerts_xmlstring);
?>

<SCRIPT>
var weather_alerts_js = new Array();
<?php
if ($weather_alerts != NULL) {
	foreach ($weather_alerts as $weather_alert) {
		$namespaces = $weather_alert->getNameSpaces(true);
		$cap = $weather_alert->children($namespaces['cap']);
		if ($cap->status == "Actual") {
			
			print "weather_alerts_js.push({title:'".addslashes($weather_alert->title).
			"', message:'".addslashes($cap->areaDesc)."'});";
		}
	}
}
?>
</SCRIPT>
<?php
	$feed_url = "http://forecast.weather.gov/MapClick.php?lat=37.82350&lon=-79.8255&unit=0&lg=english&FcstType=dwml";
	//$xml = simplexml_load_file($feed_url);
	$xmlstring = @better_file_get_contents($feed_url);
	$xml = fromXml($xmlstring);
	
	$locationDescs = $xml->xpath("/dwml/data/location/description");
	$location = $locationDescs[0];

	$all_periods = $xml->xpath("/dwml/data[@type = 'forecast']/time-layout/start-valid-time/@period-name");
	$forecast_icon_links = $xml->xpath("/dwml/data[@type = 'forecast']/parameters/conditions-icon/icon-link");
	$weather_summary = $xml->xpath("/dwml/data[@type = 'forecast']/parameters/weather/weather-conditions/@weather-summary");
	
	$type1 = $xml->xpath("/dwml/data[@type = 'forecast']/parameters/temperature[1]/@type");
	$type2 = $xml->xpath("/dwml/data[@type = 'forecast']/parameters/temperature[2]/@type");
		
	$temps1 = $xml->xpath("/dwml/data[@type = 'forecast']/parameters/temperature[1]/value");
	$temps2 = $xml->xpath("/dwml/data[@type = 'forecast']/parameters/temperature[2]/value");
	
	for ($i=0; $i<count($temps1); $i++) {
		if ($type1[0] == "minimum") {
			$temps1[$i] = "<p class='temp_low'>Low: ".$temps1[$i]."&deg; F</p>";
		}else{
			$temps1[$i] = "<p class='temp_high'>High: ".$temps1[$i]."&deg; F</p>";
		}
		
	}
	for ($i=0; $i<count($temps2); $i++) {
		if ($type2[0] == "minimum") {
			$temps2[$i] = "<p class='temp_low'>Low: ".$temps2[$i]."&deg; F</p>";
		}else{
			$temps2[$i] = "<p class='temp_high'>High: ".$temps2[$i]."&deg; F</p>";
		}
		
	}
	
	$total_temps = count($temps1) + count($temps2);
	$temps = array();
	$temp1counter = 0;
	$temp2counter = 0;
	for ($i = 0; $i<$total_temps; $i++) {
		if ($i % 2 == 0)
		{
			$temps[] = $temps1[$temp1counter];
			$temp1counter++;
		}else{
			$temps[] = $temps2[$temp2counter];
			$temp2counter++;
		}
	}
		
	$total = count($temps);
	
	$current_obs_icon_link = $xml->xpath("/dwml/data[@type = 'current observations']/parameters/conditions-icon/icon-link");
	$current_obs_temp = $xml->xpath("/dwml/data[@type = 'current observations']/parameters/temperature/value");
	$current_obs_summary = $xml->xpath("/dwml/data[@type = 'current observations']/parameters/weather/weather-conditions/@weather-summary");
	//echo 'current: ' . $current_obs_icon_link[0];
?>