<?
include ("./2/mysqllogin.php");

// PREPROCESSOR - LOGIN
$mode = $_REQUEST['mode'];
$exec = $_REQUEST['exec'];

$login = $_COOKIE['login'];
if ($login) {
	$login_arr = split("/", $login);
	$login_id = $login_arr[0];
	$login_passmd5 = $login_arr[1];
	$login_name = $login_arr[2];
}

if ($mode == "login") {
	$login_id = $id = $_POST["id"];
	$pass = $_POST["pass"];
	$login_passmd5 = $passmd5 = md5($pass);
	
	$user_query = "SELECT * FROM LR2IR_User where id=".$id." AND passmd5='".$passmd5."' LIMIT 1";
	$user = mysql_query($user_query) or die ("#ERROR");
	
	if (mysql_num_rows($user) >= 1) {
		$row = mysql_fetch_array($user);
		$login_name = $name = $row["name"];
		$login = "$id/$passmd5/$name/";
		setrawcookie("login", $login, time()+3600);
	} else {
		$error = "cannot find user";
	}
}
if ($mode == "logout") {
	setcookie("login", "", time()-3600);
	$login = NULL;
}
if ($exec == "playerdelete") {
	// first, remove login cookie
	setcookie("login", "", time()-3600);
	$login = NULL;
	
	// remove logged user
	$sql = "DELETE FROM `lr2ir`.`lr2ir_user` WHERE id='$login_id' LIMIT 1";
	mysql_query($sql);
}
if ($exec == "scoredelete") {
	$songmd5 = $_REQUEST['songmd5'];
	if (!$songmd5)  {
		$bmsid = $_REQUEST['bmsid'];
		$sql = "DELETE FROM play WHERE id='$login_id' AND songmd5='$bmsid' LIMIT 1";
	} else {
		$sql = "DELETE FROM play WHERE id='$login_id' AND songmd5='$songmd5' LIMIT 1";
	}
	mysql_query($sql);
}
if ($exec == "coursescoredelete") {
	$courseid = $_REQUEST['courseid'];
	$sql = "DELETE FROM courseplay WHERE id='$login_id' AND courseid='$courseid' LIMIT 1";
	mysql_query($sql);
}
if ($exec == "mypage_update") {
	$name = $_POST['name'];
	$profile = $_POST['profile'];
	$homepage = $_POST['homepage'];
	$sql = "UPDATE LR2IR_user SET name='$name', desc='$profile', homepage='$homepage' WHERE id='$login_id' LIMIT 1";
}
if ($exec == "comment") {
	$board = $_POST["board"];
	$comment = $_POST["comment"];
	$sql = "INSERT INTO `lr2ir`.`comment` (`board`, `name`, `id`, `comment`, `timestamp`) VALUES ('$board', '$login_name', '$login_id', '$comment', CURRENT_TIMESTAMP);";
	mysql_query($sql);
}

?>

<html>

<head>
	<meta http-equiv="CONTENT-TYPE" content="text/html; CHARSET=utf-8">
    <meta name="Author" content="kuna">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>LR2IR Webpage</title>
    <script type="text/javascript" src="./search.js"></script>
</head>

<body>
	<?
	if ($error) {
		print "<div id='msg'>$error</div>";
	}
	?>

    <!-- Login -->
    <div id="login">
    <?
	if ($login) {
		print "Welcome, $login_name ($login_id)";
		print " | <a href='search.php?mode=logout'>Logout</a> | <a href='search.php?mode=playerdelete'>Account Delete</a>";
	} else {
        print '<form method="post" action="search.php">';
        print 'ID: <input type="text" name="id" /> / ';
        print 'PASS: <input type="password" name="pass" />';
        print '<input type="submit" name="mode" value="login" />';
        print "</form>";
	}
	?>
    </div>
    <!-- Login End -->

	<hr />
	<center><h1><a href="search.php">LR2IR Webpage</a></h1></center>
    <hr />
    
    <?
	// CREATE MENU
	print "<div id='menu'>";
	if ($login) {
		print "<a href='search.php?mode=mypage&playerid=$login_id'>MYPAGE</a> | ";
	}
	print "<a href='search.php?mode=search&type=insane'>INSANE BMS</a> | ";
	print "<a href='search.php?mode=ranking_all'>ALL RANKING</a> | ";
	print "<a href='search.php?keyword=&mode=search&type=course'>ALL COURSE</a>";
	print "</div>";
	?>
    
    <!-- Search -->
    <div id="search">
        <form method="get" action="search.php">
        	<input type="text" name="keyword" />
            <input type="submit" name="mode" value="search" /><br />
            <input type="radio" name="type" value="keyword" checked/>by Keyword
            <input type="radio" name="type" value="tag" />by Tag
            <input type="radio" name="type" value="player" />by Player
            <input type="radio" name="type" value="course" />by Course
        </form>
    </div>
    <!-- Search End -->
    
    <?
	if ($mode == "mypage") {
		$id = $_GET['playerid'];
		
		// load informations for mypage
		$bms_query = "SELECT * FROM LR2IR_User where id='$id' LIMIT 1";
		$bms_q = mysql_query($bms_query, $link);
		$data = mysql_fetch_array($bms_q);
		$name = $data['name'];
		$profile = $data['desc'];
		$homepage = $data['homepage'];
		$grade_sp = $data['grade_sp'];
		$grade_dp = $data['grade_dp'];
		$playcount = $data['playcount'];
		$songcount = $data['songcount'];
		$pa = $data['pa'];
		$fc = $data['fc'];
		$hd = $data['hard'];
		$gv = $data['groove'];
		$easy = $data['easy'];
		$fail = $data['failed'];
		$display = $data['display'];
		// end
		
		print "<h2>$name's MyPage</h2><hr>";
		
		if ($login) {
			print "<form action='search.php' method='post'>";
		}
		print "<table>";
		print "<tr><th width=15%>name</th><th width=85%>";
		if ($login) {
			print "<input type='text' name='name' value='$name'>";
		} else {
			print "$name";
		}
		print "</th></tr>";
		
		print "<tr><th>LR2ID</th><th>$id</th></tr>";
		print "<tr><th>grade</th><th>$grade_sp / $grade_dp</th></tr>";
		print "<tr><th>Profile</th><th>";
		if ($login) {
			print "<textarea name='profile' cols='79' rows='10'>$profile</textarea>";
		} else {
			print "$profile";
		}
		print "</th></tr>";
		print "<tr><th>Homepage</th><th>";
		if ($login) {
			print "<input type='text' name='homepage' value='$homepage'>";
		} else {
			print "$homepage";
		}
		print "</th></tr>";
		print "<tr><th>Playcount</th><th>$playcount</th></tr>";
		print "<tr><th>Songcount</th><th>$songcount</th></tr>";
		print "</table>";
		if ($login) {
			print "<input type='submit' name='exec' value='mypage_update'>";
			print "</form>";
		}
		print "<br><br><br><br>";
		
		
		print "<h2>Clear Status</h2><hr>";
		print "<table><tr><th width=20%>FULLCOMBO</th><th width=20%>HARD</th><th width=20%>GROOVE</th><th width=20%>EASY</th><th width=20%>FAILED</th></tr>";
		$fcpa = $fc+$pa;
		print "<tr><th>$fcpa(★$pa)</th><th>$hd</th><th>$gv</th><th>$easy</th><th>$fail</th></tr></table>";
		print "<br><br><br>";
		
		// view recent songs
		print "<a href='./search.php?mode=mylist&playerid=$id&sort=playcount'>See Most Played Songs</a><br>";
		print "<a href='./search.php?mode=mylist&playerid=$id&sort=recent'>See Recent Played Songs</a><br>";
		print "<a href='./search.php?mode=mylist_course&playerid=$id&sort=playcount'>See Most Played Courses</a><br>";
		print "<a href='./search.php?mode=mylist_course&playerid=$id&sort=recent'>See Recent Played Courses</a><br>";
		print "<br><br><br>";
		
		// comments
		$comment_query = "SELECT * FROM comment WHERE board='player$id'";
		$comment = mysql_query($comment_query);
		while ($cdata = mysql_fetch_array($comment)) {
			print("{$cdata['name']} - {$cdata['comment']} - {$cdata['timestamp']}<br>");
		}
		
		if ($login) {
			print "<form action='#' method='post'>";
			print "<input type='text' name='comment'>";
			print "<input type='submit' name='exec' value='comment'>";
			print "<input type='hidden' name='board' value='player$id'><br>";
			print "</form>";
		}
	} else if ($mode == "mylist") {
		// list user's song
		$sort = $_GET['sort'];		// playcount, recent, clear
		$id = $_GET['playerid'];
		$filter = $_GET['filter'];	// 0, 7, 5, 14, 10, 9
		if (!$filter) $filter = 0;
		
		$mode = '';
		switch ($filter) {
			case 0:
			break;
			case 1:
			$mode = ' and mode=7';
			break;
			case 2:
			$mode = ' and mode=5';
			break;
			case 3:
			$mode = ' and mode=14';
			break;
			case 4:
			$mode = ' and mode=10';
			break;
			case 5:
			$mode = ' and mode=9';
			break;
		}
		switch ($sort) {
			case 'playcount':
			$srtquery = ' ORDER BY playcount desc';
			break;
			case 'clear':
			$srtquery = ' ORDER BY rate desc';
			break;
			case 'recent':
			$srtquery = ' ORDER BY timestamp desc';
			default:
			break;
		}
		
		$play_query = "SELECT * FROM play WHERE id='$id' and length(songmd5)=32 " . $mode . $srtquery;
		$play = mysql_query($play_query);
		while ($pdata = mysql_fetch_array($play)) {
			print "<a href='./search.php?mode=ranking&songmd5={$pdata['songmd5']}'>";
			print "{$pdata['title']} - {$pdata['str_clear']} - {$pdata['str_rank']}";
			print "</a><br>";
		}
	} else if ($mode == "mylist_course") {
		// list user's song
		$sort = $_GET['sort'];		// playcount, recent, clear
		$id = $_GET['playerid'];
		$filter = $_GET['filter'];	// 0, 7, 5, 14, 10, 9
		if (!$filter) $filter = 0;
		
		$mode = '';
		switch ($filter) {
			case 0:
			break;
			case 1:
			$mode = ' and mode=7';
			break;
			case 2:
			$mode = ' and mode=5';
			break;
			case 3:
			$mode = ' and mode=14';
			break;
			case 4:
			$mode = ' and mode=10';
			break;
			case 5:
			$mode = ' and mode=9';
			break;
		}
		switch ($sort) {
			case 'playcount':
			$srtquery = ' ORDER BY playcount desc';
			break;
			case 'clear':
			$srtquery = ' ORDER BY rate desc';
			break;
			case 'recent':
			$srtquery = ' ORDER BY timestamp desc';
			default:
			break;
		}
		
		$play_query = "SELECT * FROM play WHERE id='$id' and length(songmd5)>32 " . $mode . $srtquery;
		$play = mysql_query($play_query);
		while ($pdata = mysql_fetch_array($play)) {
			print "<a href='./search.php?mode=ranking&songmd5={$pdata['songmd5']}'>";
			print "{$pdata['title']} - {$pdata['str_clear']} - {$pdata['str_rank']}";
			print "</a><br>";
		}
	} else if ($mode == "search") {
		// 
		$keyword = $_GET['keyword'];
		$type = $_GET['type'];
		$sort = $_GET['sort'];			// playcount, playercnt
		$page = $_GET['page'];
		if (!$page) $page=1;
		if (!$type) $type='keyword';
		
		switch ($type) {
			case 'keyword':
			default:
			$song_query = "SELECT * FROM song WHERE title like '%$keyword%' and length(songmd5)=32 ";
			break;
			case 'tag':
			$song_query = "SELECT * FROM song WHERE tag like '%$keyword%' ";
			case 'player':
			$song_query = "SELECT * FROM LR2IR_user WHERE name like '%$keyword%' ";
			break;
			case 'course':
			$song_query = "SELECT * FROM song WHERE title like '%$keyword%' and length(songmd5)>32 ";
			break;
		}
		
		switch ($sort) {
			case 'playcount_desc':
			default:
			$srtquery = ' ORDER BY playcount desc';
			break;
			case 'playcount_asc':
			$srtquery = ' ORDER BY playcount asc';
			break;
			case 'playercnt_desc':
			$srtquery = ' ORDER BY playercount desc';
			break;
			case 'playercnt_asc':
			$srtquery = ' ORDER BY playcount asc';
			break;
		}
		
		$start = ($page-1)*100;
		$end = $start+100;
		$song_query .= $srtquery . " LIMIT $start, $end";
		$qr = mysql_query($song_query);
		if ($qr) {
			$count = mysql_num_rows($qr);
		} else {
			$count = 0;
		}
		
		$args = "mode=search&sort=$sort&keyword=$keyword";
		print "<form name='searchform' action='#'>";
		print "<select name='sort' style='width:200px;' onchange='jump()'>";
		print "<option value='./search.cgi?$args&sort=playcount_desc'>By many Playcount</option>";
		print "<option value='./search.cgi?$args&sort=playcount_asc'>By few Playcount</option>";
		print "<option value='./search.cgi?$args&sort=playercnt_desc'>By many Player</option>";
		print "<option value='./search.cgi?$args&sort=playercnt_asc'>By few Player</option>";
		print "</select>";
		print "</form>";
		
		while ($data = mysql_fetch_array($qr)) {
			switch ($type) {
				case 'keyword':
				case 'tag':
				default:
				print "<a href='./search.php?mode=ranking&bmsid={$data['bmsid']}'>";
				print "{$data['title']} - {$data['artist']}";
				print "</a><br>";
				break;
				case 'player':
				print "<a href='./search.php?mode=mypage&playerid={$data['id']}>";
				print "{$data['name']} - {$data['grade_sp']}/{$data['grade_dp']}";
				print "</a><br>";
				break;
				case 'course':
				print "<a href='./search.php?mode=ranking&courseid={$data['bmsid']}'>";
				print "{$data['title']} - {$data['artist']}";
				print "</a><br>";
				break;
			}
		}
		$args .= "&sort=" . $sort;
		if ($page > 1) print "<a href='./search.php?page=$page-1&$args'> ← </a> / ";
		if ($count >= 100) print "<a href='./search.php?page=$page+1&$args'> → </a>";
	} else if ($mode == "ranking_all") {
		// show songs LIMIT 100 desc playcount
		$page = $_GET['page'];
		if (!$page) $page=1;
		$start = ($page-1)*100;
		$end = $page*100;
		
		$song_query = "SELECT * FROM song WHERE length(songmd5)=32 ORDER BY playcount DESC LIMIT $start, $end";
		$song = mysql_query($song_query);
		$count = mysql_num_rows($song);
		while ($songdata = mysql_fetch_array($song)) {
			$start += 1;
			print "<a href='./search.php?mode=ranking&bmsid={$songdata['bmsid']}'>";
			print "$start - {$songdata['title']} - {$songdata['artist']} - {$songdata['playcount']}";
			print "</a><br>";
		}
		
		$args = "mode=search";
		if ($page > 1) print "<a href='./search.php?page=$page-1&$args'> ← </a> / ";
		if ($count >= 100) print "<a href='./search.php?page=$page+1&$args'> → </a>";
	} else if ($mode == "ranking") {
		// show song information
		$courseid = $_GET['courseid'];
		$bmsid = $_GET['bmsid'];
		$page = $_GET['page'];
		
		if ($courseid) {
			$song_query = "SELECT * FROM song where length(songmd5)>32 and bmsid='$courseid'";
		} else {
			if ($bmsid) {
				$song_query = "SELECT * FROM song where bmsid='$bmsid' and length(songmd5)=32";
			} else {
				$songmd5 = $_GET['songmd5'];
				$song_query = "SELECT * FROM song where songmd5='$songmd5'";
			}
		}
		$song = mysql_query($song_query);
		$songdata = mysql_fetch_array($song);
		if ($songdata) {
			$songmd5 = $songdata['songmd5'];
			$bmsid = $songdata['bmsid'];
			
			if (strlen($songmd5) == 32) {
				print "{$songdata['title']} <br>";
				print "{$songdata['artist']} <br>";
				print "{$songdata['genre']} <br><br>";
			} else {
				print "{$songdata['title']} <br><br>";
				
				// print info of the sub songs
				$cnt = strlen($songmd5)/32;
				for ($i=0; $i<$cnt; $i++) {
					$hash = substr($songmd5, $i*32, 32);
					$q = "SELECT * FROM song WHERE songmd5='$hash' LIMIT 1";
					$qr = mysql_query($q);
					$qd = mysql_fetch_array($qr);
					$num = $i+1;
					
					print "<a href='search.php?mode=ranking&songmd5=$hash'>";
					print "[$num]: {$qd['title']}";
					print "</a><br>";
				}
			}
			
			print "P-A:{$songdata['pa']} / ";
			print "FULLCOMBO:{$songdata['fc']} / ";
			print "GROOVE:{$songdata['gv']} / ";
			print "EASY:{$songdata['easy']} / ";
			print "FAILED:{$songdata['fail']}<br>";
			print "PLAYCOUNT:{$songdata['playcount']} / ";
			print "CLEARCOUNT:{$songdata['clearcount']}<br>";
			print "PLAYUSERCOUNT:{$songdata['playusercount']} / ";
			print "CLEARUSERCOUNT:{$songdata['clearusercount']}<br>";
			print "<br><br>";
			
			// if own score submitted then show score & score removal
			if ($login) {
				$play_query = "SELECT * FROM play where songmd5='$songmd5' and id='$login_id'";
				$play = mysql_query($play_query);
				if ($playdata = mysql_fetch_array($play)) {
					$query_str = getenv("QUERY_STRING");
					print "$login_name's playdata : {$playdata['exscore']} - ";
					print "<a href='./search.php?$query_str&exec=scoredelete&songmd5=$songmd5'>Remove Score</a><br>";
					print "<br><br>";
				}
			}
			
			// scores of the song
			// show scores LIMIT 100 desc exscore
			if (!$page) $page=1;
			$start = ($page-1)*100;
			$end = $page*100;
			
			$play_query = "SELECT * FROM play where songmd5='$songmd5' ORDER BY exscore DESC LIMIT $start, $end";
			$play = mysql_query($play_query);
			print "[Ranking]<br>";
			while ($playdata = mysql_fetch_array($play)) {
				print "{$playdata['name']} - {$playdata['pg']}/{$playdata['gr']}/{$playdata['gd']}/{$playdata['bd']}/{$playdata['pr']}<br>";
			}
			print "<br><br><br><br>";
			
			// comments
			$comment_query = "SELECT * FROM comment WHERE board='score$bmsid'";
			$comment = mysql_query($comment_query);
			while ($cdata = mysql_fetch_array($comment)) {
				print("{$cdata['name']} - {$cdata['comment']} - {$cdata['timestamp']}<br>");
				print "<br>";
			}
			// comment write
			if ($login) {
				print "<form action='#' method='post'>";
				print "<input type='text' name='comment'>";
				print "<input type='submit' name='exec' value='comment'>";
				print "<input type='hidden' name='board' value='score$bmsid'><br>";
				print "</form>";
			}
		} else {
			print "Cannot find song.";
		}		
	} else {
		// show stat
		print "<h2>Status</h2>";
		$bms_query = "SELECT COUNT(*) FROM song";
		$bms_q = mysql_query($bms_query, $link);
		$data = mysql_fetch_array($bms_q);
		print "$data[0] of Songs are Registered<br>";
		$bms_query = "SELECT COUNT(*) FROM LR2IR_user";
		$bms_q = mysql_query($bms_query, $link);
		$data = mysql_fetch_array($bms_q);
		print "$data[0] of Players are Registered<br>";
	}
	
	?>

</body>

</html>

<?
mysql_close($link);
?>
