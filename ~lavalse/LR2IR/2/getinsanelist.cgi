<?

print "#";

$fp = fopen("insanelist.xml", "r");
$size = filesize("insanelist.xml");

print fread($fp, $size);

fclose($fp);

?>