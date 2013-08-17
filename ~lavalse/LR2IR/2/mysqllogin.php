<?
include("mysqlinfo.php");
$link = mysql_connect($mysql_host, $mysql_id, $mysql_passwd)
	or die("#ERROR,UnableToConnectMySQL,".mysql_error());
mysql_select_db("LR2IR") or die("#ERROR,UnableToConnectMySQL");
?>