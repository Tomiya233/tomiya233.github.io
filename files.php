<?php
include("./config.php");
if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}
session_start();
include("./header.php");
include("./lang/$language.php");

if($enable_filelist==false){
?>
<center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[filelist];?>
</td></tr></table>
<?
echo $lang[fldis];?>
</center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}
?>
<center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[filelist];?>
</td></tr></table>
<table width="100%" cellpadding="2" cellspacing="1" border="0" bgcolor="#F0F0F0">
<tr>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b>#</td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[fname];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[size10];?></b></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[dloads];?></td>
<td align=center bgcolor=#EBEBEB background="img/bg.png"><b><? echo $lang[ldload];?></b></td>
</tr>
<tr><td colspan=5 height=1></td></tr>
<?php
$me=$shourturl;
if ($me=="true")
  $short= "";
else
  $short= "download.php?file=";
$i = 0;
$bl_anzeige = $pps2;
$dirname = "./files";
$dh = opendir( $dirname ) or die("couldn't open directory");
$start = isset($_GET['start']) ? (intval($_GET['start'])-1)*$bl_anzeige : 0;
while ( $file = readdir( $dh ) ) {
if ($file{0} != '.') {
  $xzal=$i++;
  if($xzal>= $start && $xzal<$start+$pps2) {
  $filecrc = str_replace(".mfh","",$file);
  $filesize = filesize("./storage/". $filecrc);
  $filesize = ($filesize / 1048576);
  $fh = fopen ("./files/".$file, r);
  $filedata= explode('|', fgets($fh));
  echo "<tr><td align=center bgcolor=#F9F9F9>".$i."</td><td align=left bgcolor=#F9F9F9><a href=\"". $short .$filedata[0]."\" target=\"_blank\">".$filedata[1]."</a></td><td align=center bgcolor=#F9F9F9>".round($filesize,2)." MB</td>";
  echo "<td align=center bgcolor=#F9F9F9>".$filedata[5]."</td><td align=center style=padding-left:5px bgcolor=#F9F9F9>".date('Y-m-d G:i', $filedata[4])." </td></tr>";
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
include("paginfiles.php");

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
echo "</td></tr></table></center>";
// An der Stelle wo die Ausgabe erfolgen soll
echo $lang[pagination]." ".$nav_search . $lang[ftotal] . $i++;
?>
</center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
?>