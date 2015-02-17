<?php 
require("gather_noaa_data.php");
require("gather_alerts_data.php"); 
require("gather_flickr_feed.php");
require("gather_events_feed.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Information Feed</title>
	<meta name="author" content="Dan Braun">
	<!-- Date: 2012-09-07 -->
	<link href="css/kiosk_feed_style.css" rel="stylesheet" type="text/css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
	

	
	<script type="text/javascript">
	function compare(a,b) {
	  if (a.start_date_value < b.start_date_value)
	     return -1;
	  if (a.start_date_value > b.start_date_value)
	    return 1;
	  return 0;
	}
	function centerImage() {
		var slideshowDiv = document.getElementById('flickrSlideshow');
		var imagetags = slideshowDiv.getElementsByTagName('img');
		var img = imagetags[0];
		if (img.width > img.height) {
			if (img.height < 313) {
				img.style.minHeight = "313px";
				img.style.marginTop = -(img.height/2) + "px";
			}else{
				img.style.maxHeight = "313px";
				img.style.marginTop = -(img.height/2) + "px";
			}
		}else{
			if (img.width < 373)
			{
				img.style.minWidth = "373px";
				img.style.marginTop = -(img.height/2.5) + "px";
			}else{
				img.style.maxWidth = "373px";
				img.style.marginTop = -(img.height/2.5) + "px";
			}
		}
		img.style.marginLeft = -(img.width/2) + "px";
		
	}
	function centerBGImage() {
		var bgDiv = document.getElementById('imageBG');
		var imagetags = bgDiv.getElementsByTagName('img');
		var img = imagetags[0];
		if (img.width > img.height) {
			if (img.height < 1080) {
				img.style.minHeight = "1080px";
			}else{
				img.style.maxHeight = "1080px";
			}
		}else{
			if (img.width < 1920)
			{
				img.style.minWidth = "1920px";
			}else{
				img.style.maxWidth = "1920px";
			}
		}
		img.style.marginLeft = -(img.width/2) + "px";
		img.style.marginTop = -(img.height/2) + "px";
	}
	
	function initAlerts() {
		var title = $('#alertTitle');
		var message = $('#alertMessage');
		var header = $('#alertsHeader');
		alerts_array_js = alerts_array_js.concat(weather_alerts_js);
		var numberOfAlerts = alerts_array_js.length;
		var val1 = alerts_array_js[0].title;
		var val2 = alerts_array_js[0].message;
		title.text( val1 );
		message.text( val2 );
		header.text("VIEWING ALERT: 1 of " + numberOfAlerts); 
	}
	function initEvents() {
		// var html = "";
		// 		var total = events_array_js.length;
		// 		for (var i=0; i<events_array_js.length; i++) {
		// 			var val1 = events_array_js[i].title;
		// 			var val2 = events_array_js[i].summary;
		// 			var val3 = events_array_js[i].start_date;
		// 			html += "<li>";
		// 			html += "<div id='eventNumberBox'><p>" +(i+1)+" <span>of</span> "+total+ "</p></div>";
		// 			html += "<p class='eventDate'>"+val3+"</p>";
		// 			html += "<p class='eventTitle'>"+val1+"</p>";
		// 			html += "<p class='eventSummary'>"+val2+"</p>";
		// 			html += "<p>&nbsp;</p>";
		// 			html += "<hr>";
		// 			html += "</li>";
		// 		}
		// 		$('#scroller').html(html);
		
		//$('.simply-scroll-clip').css("height", "583");
		
		var title = $('#eventTitle p');
		var summary = $('#eventSummary p');
		var date = $('#eventDate p');
		var header = $('#eventsHeader');
		var numberOfEvents = events_array_js.length;
		var val1 = events_array_js[0].title;
		var val2 = events_array_js[0].summary;
		var val3 = events_array_js[0].start_date;
		title.text( val1 );
		summary.text( val2 ); 
		date.text( val3 );
		header.text("VIEWING EVENT: 1 of " + numberOfEvents);
	}
	function initFlickrSlideshow() {
		var imageDiv = $('#flickrSlideshow');
		imageDiv.html( '<img src="'+photo_array_js[0].image+'" onload="centerImage()">' );
		//imageDiv.html( '<div id="flickrCaption"><p>'+photo_array_js[0].caption+'</p></div><img src="'+photo_array_js[0].image+'" onload="centerImage()">' );
		
		// var bgDiv = $('#imageBG');
		// 		bgDiv.html( '<img src="'+photo_array_js[0].image+'">' );
	}
	function runAlerts() {
		var title = $('#alertTitle');
		var message = $('#alertMessage');
		var header = $('#alertsHeader');
		var numberOfAlerts = alerts_array_js.length;
		var i = 0; 
		var slideshow = setInterval(function() { 
			i = i<(alerts_array_js.length-1) ? i+1 : 0;
			var val1 = alerts_array_js[i].title;
			var val2 = alerts_array_js[i].message;
	    	title.fadeOut(function() { 
	        	$(this).text( val1 ).fadeIn(); 
	        }); 
			message.fadeOut(function() { 
	        	$(this).text( val2 ).fadeIn(); 
	        });
			header.fadeOut(function() { 
	        	$(this).text( "VIEWING ALERT: "+(i+1)+" of " + numberOfAlerts ).fadeIn(); 
	        });
	    },10000);
	}
	function runEvents() {
		var title = $('#eventTitle p');
		var summary = $('#eventSummary p');
		var date = $('#eventDate p');
		var header = $('#eventsHeader');
		var numberOfEvents = events_array_js.length;
		var i = 0; 
		var slideshow = setInterval(function() { 
			i = i<(events_array_js.length-1) ? i+1 : 0;
			var val1 = events_array_js[i].title;
			var val2 = events_array_js[i].summary;
			var val3 = events_array_js[i].start_date;
	    	title.fadeOut(function() { 
	        	$(this).text( val1 ).fadeIn(); 
	        }); 
			summary.fadeOut(function() { 
	        	$(this).text( val2 ).fadeIn(); 
	        });
			date.fadeOut(function() { 
	        	$(this).text( val3 ).fadeIn(); 
	        });
			header.fadeOut(function() { 
	        	$(this).text( "VIEWING EVENT: "+(i+1)+" of " + numberOfEvents ).fadeIn(); 
	        });
	    },10000);
	}
	function runflickrSlideshow() { 
		var imageDiv = $('#flickrSlideshow');
		
		var bgDiv = $('#imageBG');
		
		var i = 0; 
		var slideshow = setInterval(function() { 
			i = i<(photo_array_js.length-1) ? i+1 : 0;			 		
			imageDiv.fadeOut(function() { 				
				$(this).html( '<img src="'+photo_array_js[i].image+'" onload="centerImage()">' ).fadeIn();
				//$(this).html( '<div id="flickrCaption"><p>'+photo_array_js[i].caption+'</p></div><img src="'+photo_array_js[i].image+'" onload="centerImage()">' ).fadeIn();				
			});
			
			// bgDiv.fadeOut(function() { 				
			// 	$(this).html( '<img src="'+photo_array_js[i].image+'">' ).fadeIn(); 
			// }); 
					
		},10000); 
	}
	
	$(document).ready(function() {
		initFlickrSlideshow();
		if (alerts_array_js.length > 0 || weather_alerts_js.length > 0) {
			initAlerts();
			runAlerts();
			// $('#events').addClass("events_condensed");
			// $('#welcome_filler').hide();
		}else{
			// $('#alerts').hide();
			$('#alertTitle').text("No Alerts At This Time");
			$('#alertMessage').text("");
			$('#alertsHeader').text("");
		}
		if (events_array_js.length > 0) {
			events_array_js.sort(compare);
			initEvents();
			runEvents();
			// $('#welcome_filler').hide();
		}else{
			// $('#events').hide();
			$('#eventTitle p').text("No Events Scheduled At This Time");
			$('#eventSummary p').text("");
			$('#eventDate p').text("");
			$('#eventsHeader').text("");
		}
		
		runflickrSlideshow();
	});
	function timedRefresh(timeoutPeriod) {
		setTimeout("location.reload(true);",timeoutPeriod);
	}
	
	// Array of day names
	var dayNames = new Array("Sunday","Monday","Tuesday","Wednesday",
					"Thursday","Friday","Saturday");

	// Array of month Names
	var monthNames = new Array(
	  "January","February","March","April","May","June","July",
	  "August","September","October","November","December");
	
	function updateClock()
	{
	  var currentTime = new Date ( );

	  var currentHours = currentTime.getHours ( );
	  var currentMinutes = currentTime.getMinutes ( );
	  var currentSeconds = currentTime.getSeconds ( );
	  
	  // Pad the minutes and seconds with leading zeros, if required
	  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
	  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

	  // Choose either "AM" or "PM" as appropriate
	  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

	  // Convert the hours component to 12-hour format if needed
	  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

	  // Convert an hours component of "0" to "12"
	  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

	  // Compose the string for display
	  var currentTimeString = currentHours + ":" + currentMinutes + timeOfDay;

	  // Update the time display
	  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
	  document.getElementById("date").firstChild.nodeValue = monthNames[currentTime.getMonth()] + " " + 
	  currentTime.getDate() + ", " + currentTime.getFullYear();
	}
	
	// (function($) {
	// 		$(function() {
	// 			initEvents();
	// 			$("#scroller").simplyScroll({orientation:'vertical',customClass:'vert', pauseOnHover:false, pauseOnTouch:false,startOnLoad: false, speed:1, frameRate:10});
	// 		});
	// 	})(jQuery);
	
	</script>
</head>
<body onload="JavaScript:timedRefresh(300000);updateClock(); setInterval('updateClock()', 1000 )">

    <div class="container">
      <div class="content">
          <div id="weather_container">
            <img id="weather_container-banner" src="images/banner-current-weather.png" />
            <br class="clearfloat">
                <div id="current_obs_container">
                    <h1 class="txt-ctr-caps">Current Conditions</h1>
                    <img src="<?php echo $current_obs_icon_link[0]; ?>" width="50%" height="50%" class="centered">
                    <p class="txt-ctr-caps"><?php echo $current_obs_temp[0] . "&deg; F"; ?></p>
                    <p class="txt-ctr-caps"><?php echo $current_obs_summary[0]; ?></p>
                </div>
                <div id="forecast_container">
                    
                    <?php for ($i = 0; $i<5; $i++) { ?>
                    
                    <div class="forecast_box">
                        <p class="txt-ctr-caps forecast_header"><?php echo $all_periods[$i]; ?><br><br></p>
                        <p><img src="<?php echo $forecast_icon_links[$i]; ?>" width="80%"></p>
                        <p class="forecast_desc"><?php echo $weather_summary[$i]; ?></p>
                        <div class="temp_container"><?php echo $temps[$i]; ?></div>
                    </div>
                    
                    <?php } ?>
                </div>
            </div>
            
            <div id="radar">
                <div class="parkMarker douthat"></div>
                <img src="http://radar.weather.gov/lite/NCR/FCX_loop.gif">
            </div>
            
            <div id="flickr_container">
                <img id="flickrSlideshow-banner" src="images/banner-park-images.png" />
                <div id="flickr">
                	<div id="flickrSlideshow">
                    	<!--<div id="flickrCaption"></div>-->
                 	</div>
                </div>
			</div>
            
            <div id="timedate">
                <p><span id="date">&nbsp;</span> <br>
                <span id="clock">&nbsp;</span></p>
			</div>
            
            <div id="events">
            <img id="events-banner" src="images/banner-events.png" />
                <div id="eventsHeader">VIEWING EVENT:</div>
                <div id="eventDate"><p class="eventDate"></p></div>
                <div id="eventTitle"><p class="eventTitle"></p></div>
                <div id="eventSummary"><p class="eventSummary"></p></div>
            </div>
            
            <div id="alerts">
            <img id="alerts-banner" src="images/banner-alerts.png" />
                <div id="alertsHeader">VIEWING ALERT:</div>
                <div id="alertTitle"></div>
                <div id="alertMessage"></div>
            </div>
            
           
   
    <!-- end .content --></div>
  <!-- end .container --></div>
</body>
</html>