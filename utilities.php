<?php
function better_file_get_contents($url) {
    if ((function_exists("file_get_contents")) && (ini_get('allow_url_fopen') == TRUE)) {
            return file_get_contents($url);
    } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
            curl_setopt($ch, CURLOPT_URL, $url);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
    }
}
function fromXml($xml) { 
    $xmlstr = _clean_cdata($xml);
	$str = simplexml_load_string($xmlstr, 'SimpleXMLElement', LIBXML_NOCDATA);
    return($str);
}
function _clean_cdata($xml) {
    $stripopen = str_replace("&lt;![CDATA[","", $xml); 
    $stripclose = str_replace("]]&gt;", "", $stripopen);
    return $stripclose;
}

function removeLineBreaks($input) {
	$output = str_replace(array("\r\n", "\r"), "\n", $input);
	$lines = explode("\n", $output);
	$new_lines = array();

	foreach ($lines as $i => $line) {
	    if(!empty($line))
	        $new_lines[] = trim($line);
	}
	return implode(" ", $new_lines);
}
?>