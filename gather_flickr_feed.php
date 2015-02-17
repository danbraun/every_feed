<?php
// $feed_url = "http://api.flickr.com/services/feeds/photoset.gne?set=72157603482891441&nsid=14571714@N08&lang=en-us";
$feed_url = "http://api.flickr.com/services/feeds/photoset.gne?set=72157603455421832&nsid=14571714@N08&lang=en-us";

$flickr_xml = simplexml_load_file($feed_url);
$entries = $flickr_xml->entry;
function returnImage($links) {
	$count = count($links);
	for ($i = 0; $i < $count; $i++) {
		if ($links[$i]['type'] == "image/jpeg") {
			return $links[$i]['href'];
		}
	}
}
?>
<SCRIPT>
var photo_array_js = new Array();
<?php
$i = 0;
foreach ($entries as $entry) {
	print "photo_array_js.push({image:'".returnImage($entry->link)."', caption:'".$entry->title."'});";
	print "Image".$i." = new Image();";
	print "Image".$i.".src = '".returnImage($entry->link)."';";
	$i++;
}
?>
</SCRIPT>