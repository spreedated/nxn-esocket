<?PHP
// set the header to make sure cache is forced
header('Content-Type: text/xml; charset=utf-8');
//echo '<?xml version="1.0" encoding="utf-8"\><res>';

//Main
$data = array('response' => 'XML not yet implemented sorry');

$xml = new SimpleXMLElement('<rootTag/>');
array_walk_recursive($data, array ($xml, 'addChild'));
echo $xml->asXML();
?>