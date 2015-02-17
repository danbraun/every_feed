<?php
require_once('utilities.php');

$xml = @better_file_get_contents($dest_events_url);
$parsed = fromXml($xml);

//print_r($parsed);

?>
<SCRIPT>

events_array_js = new Array();

<?php
function _returnDate($date) {
	$date = date_create($date);
	return date_format($date, 'g:ia \o\n l jS F Y');
}

if ($parsed != NULL) {
	foreach ($parsed as $event) {
		print "events_array_js.push({title:'" . addslashes($event->title) .
			"', summary:'" . removeLineBreaks(addslashes($event->summary)) . 
			"', start_date_value:'" . ($event->date_start) . 
			"', start_date:'". _returnDate($event->date_start) .
			"', end_date:'". $event->date_end .
			"', location:'". addslashes($event->located_within_park) .
			"', children:'". $event->children_allowed .
			"', fee:'". $event->fee_other_than_parking .
			"'});";
	}
}
?>

</SCRIPT>