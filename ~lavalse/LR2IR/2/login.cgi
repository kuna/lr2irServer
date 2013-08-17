<?
	
// get list of the rival

// check args
if ( !$_POST ) {
	echo "#ERROR,NOPOST";
} else {
	if ( !$_POST['passmd5'] or
		!$_POST['id'] or
		!$_POST['name'] or
		!$_POST['version']) {
		echo "#ERROR,NOPOST";
	} else {
		print LoginDB($_POST['id'], $_POST['passmd5'], $_POST['name']);
	}
}

/*
 * 유저에게 필요한 Data:
 * passmd5
 * id
 * name
 * ┌단위인정(SP)
 * └단위인정(DP)
 * 자기소개
 * 홈페이지
 * ┌Playcount(total)
 * └Playcount (songs)
 * Rivals
 * ┌FCClear (PATTACK)
 * │FCClear
 * │HDClear
 * │GrooveClear
 * │EasyClear
 * └Fail
 * PlayedSongs
 * Courses
 * 덧글
 * 정보공개여부
 * -> 총 13개의 Column
 */
function LoginDB($id, $passmd5, $name) {
	include "mysqllogin.php";
	// if id exists, then fetch Rival lists
	// if no id, then INSERT USER
	
	$user_query = "SELECT * FROM LR2IR_User where id=".$id." AND passmd5='".$passmd5."' LIMIT 1";
	$user = mysql_query($user_query) or die("#ERROR,MySQLQueryFailed");

	$res = "#OK,";
	if (mysql_num_rows($user) >= 1) {
		// get rival lists
		$row = mysql_fetch_array($user);
		$res .= $row["rivals"];
	} else {
		// insert new user
		echo "NEW USER<br>";
		
		$user_query = "INSERT INTO `lr2ir`.`lr2ir_user` (`passmd5`, `id`, `name`, `grade_sp`, `grade_dp`, `desc`, `homepage`, `rivals`, `visible_grade`, `visible_desc`, `visible_homepage`, `visible_song`, `visible_rivals`) VALUES ('$passmd5', '$id', '$name', NULL, NULL, NULL, NULL, NULL, '1', '1', '1', '1', '1');";
		//print $user_query."<br>";
		mysql_query($user_query);
	}
	
	mysql_close($link);

	return $res;
}


?>