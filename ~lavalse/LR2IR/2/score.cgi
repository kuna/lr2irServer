<?
include("./mysqllogin.php");

// 단위인정은?

if (!$_POST) {
	die("ERROR - NO POST");
}

$songmd5 = $_POST['songmd5'];
$passmd5 = $_POST['passmd5'];
$id = $_POST['id'];
$title = $_POST['title'];
$genre = $_POST['genre'];
$artist = $_POST['artist'];
$maxbpm = $_POST['maxbpm'];
$minbpm = $_POST['minbpm'];
$playlevel = $_POST['playlevel'];
$clear = $_POST['clear'];	// FAIL / EASY / GROOVE / 4: HARD / FC / PA
$exscore = $_POST['exscore'];
$pg = $_POST['pg'];
$gr = $_POST['gr'];
$gd = $_POST['gd'];
$bd = $_POST['bd'];
$pr = $_POST['pr'];
$maxcombo = $_POST['maxcombo'];
$playcount = $_POST['playcount'];
$clearcount = $_POST['clearcount'];
$rate = $_POST['rate'];
$bp = $_POST['minbp'];
$totalnotes = $_POST['totalnotes'];
$opt_history = $_POST['opt_history'];
$opt_this = $_POST['opt_this'];
$mode = $_POST['line'];
$difficulty = $_POST['judge'];
$inputtype = $_POST['inputtype'];
$ghost = $_POST['ghost'];			// I dont know...
$rseed = $_POST['rseed'];			// I dont know... rseed is need to be stored?
$clear_db = $_POST['clear_db'];
$clear_ex = $_POST['clear_ex'];
$clear_sd = $_POST['clear_sd'];
$scorehash = $_POST['scorehash'];	// I dont know...
$timestamp = mktime();


// -------------------------------
// check identification first
// -------------------------------

$user_query = "SELECT * FROM LR2IR_user where id='$id' and passmd5='$passmd5' LIMIT 1";
$user = mysql_query($user_query);
if (mysql_num_rows($user) == 0) {
	die("ERROR - NO USER");
} else {
	$userdata = mysql_fetch_array($user);
	$name = $userdata['name'];
}

// -------------------------------
// update score(play) information
// -------------------------------
$play_query = "SELECT * FROM play where songmd5='$songmd5' and id='$id' LIMIT 1";
$play = mysql_query($play_query);
if (mysql_num_rows($play) == 0) {
	// set previous value
	$p_playcount = 0;
	$p_clearcount = 0;
	$p_clear = -1;

	// insert
	
	$play_query = "INSERT INTO `lr2ir`.`play` 
	(`songmd5`, `title`, `id`, `name`, `playcount`, `clearcount`, `totalnote`, `exscore`, `str_clear`, `str_rank`, `pg`, `gr`, `gd`, `bd`, `pr`, `maxcombo`, `minbp`, `ghost`, `minbpm`, `maxbpm`, `rate`, `opt_history`, `opt_this`, `clear`, `inputtype`, `timestamp`) VALUES 
	('$songmd5', '$title', '$id', '$name', '$playcount', '$clearcount', '$totalnotes', '$exscore', '', '', '$pg', '$gr', '$gd', '$bd', '$pr', '$maxcombo', '$minbp', '$ghost', '$minbpm', '$maxbpm', '$rate', '$opt_history', '$opt_this', '$clear', '$inputtype', CURRENT_TIMESTAMP);";
	mysql_query($play_query);
} else {
	// set previous value
	$playdata = mysql_fetch_array($play);
	$p_playcount = $playdata['playcount'];
	$p_clearcount = $playdata['clearcount'];
	$p_clear = $playdata['clear'];

	// update
	$play_query = "UPDATE play SET playcount='$playcount', clearcount='$clearcount', exscore='$exscore', pg='$pg', gr='$gr', gd='$gd', bd='$bd', pr='$pr', maxcombo='$maxcombo', rate='$rate', minbp='$bp', opt_history='$opt_history', opt_this='$opt_this', clear='$clear', inputtype='$inputtype', ghost='$ghost' where id='$id'";
	mysql_query($play_query);
}

// -------------------------------
// score proc end, analyze start
// -------------------------------
//
//
//
//
//
//
// -------------------------------
// update user's info - playcount
// -------------------------------
// 부분갱신법: 기존수치만큼 스탯을 뺀 후에 (앞의 score 단계에서 기존수치 알수있다) 현재수치만큼 더하면 됨

// 이전에 플레이한 적이 있을 때에 한해서 스탯을 뺀다
if ($p_clear >= 0) {
	$user_query = "UPDATE LR2IR_user SET playcount=playcount-$p_playcount, songcount=songcount-1, clearcount=clearcount-$p_clearcount, ";
	
	switch ($p_clear) {
		case 0:
			break;
		case 1:
			$user_query .= " failed = failed-1 ";
			break;
		case 2:
			$user_query .= " easy = easy-1 ";
			break;
		case 3:
			$user_query .= " groove = groove-1 ";
			break;
		case 4:
			$user_query .= " hard = hard-1 ";
			break;
		case 5:
			$user_query .= " fc = fc-1 ";
			break;
		case 6:
			$user_query .= " pa = pa-1 ";
			break;
	}
	$user_query .= " where id='$id' and passmd5='$passmd5' LIMIT 1";
	mysql_query($user_query);
}

// add new value
$user_query = "UPDATE LR2IR_user SET playcount=playcount+$playcount, songcount=songcount+1, clearcount=clearcount+$clearcount, ";
switch ($clear) {
	case 0:
		break;
	case 1:
		$user_query .= " failed = failed+1 ";
		break;
	case 2:
		$user_query .= " easy = easy+1 ";
		break;
	case 3:
		$user_query .= " groove = groove+1 ";
		break;
	case 4:
		$user_query .= " hard = hard+1 ";
		break;
	case 5:
		$user_query .= " fc = fc+1 ";
		break;
	case 6:
		$user_query .= " pa = pa+1 ";
		break;
}
$user_query .= " where id='$id' and passmd5='$passmd5' LIMIT 1";
mysql_query($user_query);


// -------------------------------
// update song's info
// -------------------------------
$song_query = "SELECT * FROM song where songmd5='$songmd5'";
$song = mysql_query($song_query);
if ($song == NULL or mysql_num_rows($song) == 0) {
	$song_query = "INSERT INTO `lr2ir`.`song` (`songmd5`, `title`, `genre`, `artist`, `tag`, `course`, `level`, `mode`, `favorite`, `exlevel`, `difficulty`, `url_original`, `url_sabun`, `desc`, `pa`, `fc`, `hd`, `gv`, `easy`, `fail`, `playcount`, `clearcount`, `playusercount`, `clearusercount`, `guage`, `timestamp`) VALUES ('$songmd5', '$title', '$genre', '$artist', '', '', '$level', '$mode', '0', '0', '$difficulty', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', CURRENT_TIMESTAMP);";
	mysql_query($song_query);
} else {
	$song_query = "UPDATE song SET playcount=playcount-$p_playcount, clearcount=clearcount-$p_clearcount, ";
	switch ($p_clear) {
	case 0:
		break;
	case 1:
		$song_query .= " fail=fail-1 ";
		break;
	case 2:
		$song_query .= " easy=easy-1 ";
		break;
	case 3:
		$song_query .= " gv=gv-1 ";
		break;
	case 4:
		$song_query .= " hd=hd-1 ";
		break;
	case 5:
		$song_query .= " fc=fc-1 ";
		break;
	case 6:
		$song_query .= " pa=pa-1 ";
		break;
	}
	if ($p_clear > 1) {
		$song_query .= ", clearusercount=clearusercount-1 ";
	}
	$song_query .= ", playusercount=playusercount-1 where songmd5='$songmd5'";
	mysql_query($song_query);
}

$song_query = "UPDATE song SET playcount=playcount+$playcount, clearcount=clearcount+$clearcount, ";
switch ($clear) {
case 0:
	break;
case 1:
	$song_query .= " fail=fail+1 ";
	break;
case 2:
	$song_query .= " easy=easy+1 ";
	break;
case 3:
	$song_query .= " gv=gv+1 ";
	break;
case 4:
	$song_query .= " hd=hd+1 ";
	break;
case 5:
	$song_query .= " fc=fc+1 ";
	break;
case 6:
	$song_query .= " pa=pa+1 ";
	break;
}
	if ($clear > 1) {
	$song_query .= ", clearusercount=clearusercount+1 ";
}
$song_query .= ", playusercount=playusercount+1 where songmd5='$songmd5'";
mysql_query($song_query);


// -------------------------------
// print returning data
// RETURN VALUE: #Rank,totRank,ClearRate,FC(PA),FAILED,EASY,NORMAL,HARD,FC,
// -------------------------------

$song_query = "SELECT * FROM song where songmd5='$songmd5'";
$song = mysql_query($song_query);
$songdata = mysql_fetch_array($song);

$totrank = $songdata['playusercount'];
$clearrate = $songdata['clearcount'] / $songdata['playcount'] * 100.0;
$pa = $songdata['pa'];
$fail = $songdata['fail'];
$easy = $songdata['easy'];
$groove = $songdata['gv'];
$hard = $songdata['hd'];
$fc = $songdata['fc'];

$song_query = "SELECT COUNT(*)+1 FROM play where songmd5='$songmd5' and exscore>$exscore";
$song = mysql_query($song_query);
$data = mysql_fetch_array($song);
$rank = $data[0];

print "#$rank,$totrank,$clearrate,$pa,$fail,$easy,$groove,$hard,$fc,";

// update str_rank, str_clear
switch ($clear) {
case 0:
	break;
case 1:
	$str_clear = "FAILED";
	break;
case 2:
	$str_clear = "EASY CLEAR";
	break;
case 3:
	$str_clear = "GROOVE";
	break;
case 4:
	$str_clear = "HARD CLEAR";
	break;
case 5:
	$str_clear = "FULLCOMBO";
	break;
case 6:
	$str_clear = "FULL★COMBO";
	break;
}
$str_rank = $rank . "/" . $totrank;

$play_query = "UPDATE play SET str_rank='$str_rank', str_clear='$str_clear' where id='$id' and songmd5='$songmd5'";
mysql_query($play_query);



mysql_close($link);
?>