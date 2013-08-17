<?
include("./2/mysqllogin.php");

mysql_query("CREATE TABLE IF NOT EXISTS `lr2ir_user` (
  `passmd5` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL DEFAULT '0',
  `name` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `grade_sp` tinytext COLLATE utf8_unicode_ci,
  `grade_dp` tinytext COLLATE utf8_unicode_ci,
  `desc` text COLLATE utf8_unicode_ci,
  `homepage` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rivals` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `playcount` int(11) NOT NULL DEFAULT '0',
  `songcount` int(11) NOT NULL DEFAULT '0',
  `pa` int(11) NOT NULL DEFAULT '0',
  `fc` int(11) NOT NULL DEFAULT '0',
  `hard` int(11) NOT NULL DEFAULT '0',
  `groove` int(11) NOT NULL DEFAULT '0',
  `easy` int(11) NOT NULL DEFAULT '0',
  `failed` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;", $link);


mysql_query("CREATE TABLE IF NOT EXISTS `play` (
  `songmd5` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `playcount` int(11) NOT NULL DEFAULT '0',
  `clearcount` int(11) NOT NULL DEFAULT '0',
  `totalnote` int(11) NOT NULL DEFAULT '0',
  `exscore` int(11) NOT NULL DEFAULT '0',
  `pg` int(11) NOT NULL DEFAULT '0',
  `gr` int(11) NOT NULL DEFAULT '0',
  `gd` int(11) NOT NULL DEFAULT '0',
  `bd` int(11) NOT NULL DEFAULT '0',
  `pr` int(11) NOT NULL DEFAULT '0',
  `maxcombo` int(11) NOT NULL DEFAULT '0',
  `ghost` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `minbp` int(11) NOT NULL DEFAULT '0',
  `maxbp` int(11) NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  `opt_history` int(11) NOT NULL DEFAULT '0',
  `opt_this` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8_unicode_ci;", $link);

mysql_query("CREATE TABLE IF NOT EXISTS `score` (
  `hash` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `clear` int(11) NOT NULL,
  `perfect` int(11) NOT NULL,
  `great` int(11) NOT NULL,
  `good` int(11) NOT NULL,
  `bad` int(11) NOT NULL,
  `poor` int(11) NOT NULL,
  `totalnotes` int(11) NOT NULL,
  `maxcombo` int(11) NOT NULL,
  `minbp` int(11) NOT NULL,
  `playcount` int(11) NOT NULL,
  `clearcount` int(11) NOT NULL,
  `failcount` int(11) NOT NULL,
  `op_history` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rank` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `clear_db` int(11) NOT NULL,
  `scorehash` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `clear_sd` int(11) NOT NULL,
  `clear_ex` int(11) NOT NULL,
  `op_best` int(11) NOT NULL,
  `rseed` int(11) NOT NULL,
  `complete` int(11) NOT NULL,
  `ghost` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8_unicode_ci;", $link);



mysql_query("CREATE TABLE IF NOT EXISTS `song` (
  `hash` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `genre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `artist` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subartist` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `mode` int(11) NOT NULL,
  `favorite` int(11) NOT NULL,
  `exlevel` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8_unicode_ci;", $link);

print "command executed.";

?>