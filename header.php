<?php
ob_start();
include("./config.php");
include("./lang/$language.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><? echo $compname . " - " . $slogan ;?></title>
<meta name="description" content="MiniFileHost v2.0 Free File Hosting Script">
<meta name="author" content="Inekai/Elderwind">
<meta name="keywords" content="File, Hosting, Script, Free, MFH, MiniFileHost, PHP, GalaxyScripts, Galaxy, Scripts">
<meta name="expire" content="never">
<link rel="stylesheet" type="text/css" href="css/<? echo $style ?> ">
<meta name="author" content="Dieter">
</head><body>
<center><table style="margin-top:5px;width:786px;height:1;">
<tr><td style="padding-bottom:5px;" height="1">
<a class="headlink" href="index.php">
<p style="margin:0px;">
<span style="font-size:27px;color:#FFFFFF;">&nbsp;<b><font color="white"><? echo $compname ?></font></span></b></p></a></td>
<td align=right valign=bottom style="padding-bottom:10px;color:#ffffff" height="1">
<a class="toplinks" href="index.php"><? echo $lang[top_upload];?></a>
<? if ($search == true) echo "|&nbsp;<a class=\"toplinks\" href=\"search.php\">" . $lang[settings_search] ."</a>" ; ?>
<? if ($enable_filelist == true) echo "&nbsp;|&nbsp;<a class=\"toplinks\" href=\"files.php\">". $lang[top_files]."</a>" ; ?>
&nbsp;|&nbsp;<a class="toplinks" href="index.php?page=tos"><? echo $lang[tos];?></a>
|&nbsp;<a class="toplinks" href="index.php?page=faq"><? echo $lang[top_faq];?></a>
<? if ($enable_topten == true) echo "|&nbsp;<a class=\"toplinks\" href=\"top.php\">". $lang[top_top]."</a>" ; ?>
<? if ($admin == true) echo "&nbsp;|&nbsp;<a class=\"toplinks\" href=\"admin.php\">" . $lang[top_admin] ."</a>" ; ?>
</td></tr></table>