<?php
if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}
session_start();
include("./config.php");
include("./header.php");
include("./lang/$language.php");
if($act=="login"){
if($_POST['passwordx']==$adminpass){
$_SESSION['logged_in'] = md5(md5($adminpass));
}
}
if($act=="logout"){
session_unset();
echo "";
}
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==md5(md5($adminpass))) {

$filecrctxt = $filecrc . ".db";
if (file_exists("./dl/" . $filecrctxt)) {
	$fh = fopen("./dl/" . $filecrctxt, r);
	$filedata= explode('|', fgets($fh));
         }
if(isset($_GET['delete'])) {
unlink("./dl/".$_GET['delete'].".db");
}
?>
<center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; Downloads
</td></tr></table>

<table width="100%" cellpadding="2" cellspacing="1" border="0" bgcolor="#F0F0F0">
<tr>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>#</td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>IP</b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>Remote</b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[dldate];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[dltime];?></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[fname];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>Referer</b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[adel];?></b></td>
</tr>
<tr><td colspan=8 height=1></td></tr>
<?php
$i = 0;
$entries = 10;
$bl_anzeige = $pps3;
$dirname = "./dl";
$dh = opendir( $dirname ) or die("couldn't open directory");
$start = isset($_GET['start']) ? (intval($_GET['start'])-1)*$bl_anzeige : 0;
while ( $file = readdir( $dh ) ) {
if ($file{0} != '.') {
  $xzal=$i++;
  if($xzal>= $start && $xzal<$start+$pps3) {
  $filecrc = str_replace(".db","",$file);
  $fh = fopen ("./dl/".$file, r);
  $filedata= explode('|', fgets($fh));
  echo "<tr><td align=center bgcolor=#F9F9F9>".$i."</td>";
  echo "<td align=left bgcolor=#F9F9F9>".$filedata[0]."</td>";
  echo "<td align=left bgcolor=#F9F9F9>".$filedata[1]."</td>";
  echo "<td align=center bgcolor=#F9F9F9>".$filedata[2]."</td>";
  echo "<td align=center bgcolor=#F9F9F9>".$filedata[3]."</td>";
  echo "<td align=left style=padding-left:5px bgcolor=#F9F9F9><a href=\"".$filedata[4]."\" target=\"_blank\">".$filedata[5]."</a></td>";
  echo "<td align=center style=padding-left:5px bgcolor=#F9F9F9><a href=\"".$filedata[6]."\" target=\"_blank\">Link</a></td>";
  echo "<td align=center style=padding-left:5px bgcolor=#F9F9F9><a href=\"admindls.php?delete=".$filecrc."\"><img src=\"img/del1.jpg\" border=0></a></td></tr>";
  fclose ($fh);
}
}
$gesamt++;
}
// Einbinden der Blätterklasse ; evtl. Pfad anpassen
// Include the pagination-class
include("paginadmindls.php");

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
echo "</table>";
// An der Stelle wo die Ausgabe erfolgen soll
echo $lang[pagination]." ".$nav_search ." ". $lang[dltotal] . $i++;
?>
 </td></tr></table></center>
<?
} else {
?>
<center>
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top><center>
<h1><center>Admin Login</center></h1><br />
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
<br /><br />
</form></center>
<?php }
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./adminfooter.php");
?>