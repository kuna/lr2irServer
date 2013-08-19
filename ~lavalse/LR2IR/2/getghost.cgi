<?
$songmd5 = $_POST['songmd5'];
$mode = $_POST['mode'];
$id = $_POST['playerid'];
$targetid = $_POST['targetid'];	// real ghost

$play_query = "SELECT * FROM play where id=$targetid and songmd5=$songmd5 LIMIT 1";
$play = mysql_query($play_query);
$playdata = mysql_fetch_array($play);

$targetname = $playdata['name'];
$targetarg2 = '21';	// Option (21 Hardrandom 1 Hard)
$targetarg3 = $playdata['rseed'];
$targetghost = $playdata['ghost'];

print "#$targetname,$targetarg2,$targetarg3,$targetghost,";

?>