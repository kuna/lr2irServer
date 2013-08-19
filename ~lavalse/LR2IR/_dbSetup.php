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
  `clearcount` int(11) NOT NULL DEFAULT '0',
  `songcount` int(11) NOT NULL DEFAULT '0',
  `pa` int(11) NOT NULL DEFAULT '0',
  `fc` int(11) NOT NULL DEFAULT '0',
  `hard` int(11) NOT NULL DEFAULT '0',
  `groove` int(11) NOT NULL DEFAULT '0',
  `easy` int(11) NOT NULL DEFAULT '0',
  `failed` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;", $link);


mysql_query("CREATE TABLE IF NOT EXISTS `play` (
  `songmd5` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `playcount` int(11) NOT NULL DEFAULT '0',
  `clearcount` int(11) NOT NULL DEFAULT '0',
  `totalnote` int(11) NOT NULL DEFAULT '0',
  `exscore` int(11) NOT NULL DEFAULT '0',
  `str_clear` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `str_rank` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pg` int(11) NOT NULL DEFAULT '0',
  `gr` int(11) NOT NULL DEFAULT '0',
  `gd` int(11) NOT NULL DEFAULT '0',
  `bd` int(11) NOT NULL DEFAULT '0',
  `pr` int(11) NOT NULL DEFAULT '0',
  `maxcombo` int(11) NOT NULL DEFAULT '0',
  `minbp` int(11) NOT NULL DEFAULT '0',
  `ghost` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rseed` int(11) NOT NULL,
  `minbpm` int(11) NOT NULL DEFAULT '0',
  `maxbpm` int(11) NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  `opt_history` int(11) NOT NULL DEFAULT '0',
  `opt_this` int(11) NOT NULL DEFAULT '0',
  `clear` int(11) NOT NULL DEFAULT '0',
  `inputtype` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8_unicode_ci;", $link);

mysql_query("CREATE TABLE IF NOT EXISTS `song` (
  `songmd5` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bmsid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `genre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `artist` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `course` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `mode` int(11) NOT NULL,
  `favorite` int(11) NOT NULL,
  `exlevel` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `url_original` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `url_sabun` int(255) NOT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pa` int(11) NOT NULL DEFAULT '0',
  `fc` int(11) NOT NULL DEFAULT '0',
  `hd` int(11) NOT NULL DEFAULT '0',
  `gv` int(11) NOT NULL DEFAULT '0',
  `easy` int(11) NOT NULL DEFAULT '0',
  `fail` int(11) NOT NULL DEFAULT '0',
  `playcount` int(11) NOT NULL DEFAULT '0',
  `clearcount` int(11) NOT NULL DEFAULT '0',
  `playusercount` int(11) NOT NULL DEFAULT '0',
  `clearusercount` int(11) NOT NULL DEFAULT '0',
  `guage` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`bmsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8_unicode_ci AUTO_INCREMENT=1 ;", $link);



mysql_query("CREATE TABLE IF NOT EXISTS `comment` (
  `board` text COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `id` text COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;", $link);

print "command executed.";

?>