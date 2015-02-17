<?php
require_once('utilities.php');

require_once('auth.php');

$xml = @better_file_get_contents($dest_alerts_url);
$parsed = fromXml($xml);

?>
<SCRIPT>

var alerts_array_js = new Array();

<?php
if ($parsed != NULL) {
	foreach ($parsed as $alert) {
		print "alerts_array_js.push({title:'" . addslashes($alert->title) .
			"', message:'" . addslashes($alert->message) . "'});";
	}
}
?>

</SCRIPT>
