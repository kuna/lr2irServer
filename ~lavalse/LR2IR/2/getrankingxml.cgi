<?
include ("./mysqllogin.php");

$songmd5 = $_POST['songmd5'];

print "#<?xml version='1.0'?>";
print "<ranking>";
$rank_query = "SELECT * FROM play where songmd5='$songmd5' ORDER BY exscore DESC";
$rank = mysql_query($rank_query);
while ($rankdata = mysql_fetch_array($rank)) {
	$name = $rankdata['name'];
	$name = $rankdata['name'];
	$clear = $rankdata['clear'];
	$notes = $rankdata['totnote'];
	$combo = $rankdata['maxcombo'];
	$minbp = $rankdata['minbp'];
	$pg = $rankdata['pg'];
	$gr = $rankdata['gr'];

	print "<score>";
	print "<name>$name</name>";
	print "<id>$id</id>";
	print "<clear>$clear</clear>";
	print "<notes>$notes</notes>";
	print "<combo>$combo</combo>";
	print "<pg>$pg</pg>";
	print "<gr>$gr</gr>";
	print "<minbp>$minbp</minbp>";
	print "</score>";
}
print "</ranking>";

$song_query = "SELECT timestamp FROM song where songmd5='$songmd5'";
$song = mysql_query($song_query);
$songdata = mysql_fetch_array($song);
$timestamp = $songdata['timestamp'];
$date = date("Y-m-d H:m:s", $timestamp);
print "<lastupdate>$date</lastupdate>";

mysql_close($link);
?>