<?php
include("./config.php");
include("./lang/$language.php");
$bans=file("./secure/bans.mfh");
foreach($bans as $line)
{
  if ($line==$_SERVER['REMOTE_ADDR']){
?> <center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top> <?
    echo "$lang[younallow]";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
  }
}

if(!isset($_GET['a']) || !isset($_GET['b']))
{
  echo "<script>window.location = '".$scripturl."';</script>";
}

$validdownload = 0;
$fileLocation = './storage/';




$filecrc = $_GET['a'];
$filecrctxt = $filecrc.".mfh";
if (file_exists("./files/".$filecrctxt)) {
	$fh = fopen ("./files/".$filecrctxt,r);
	$thisline= explode('|', fgets($fh));
	if ($thisline[0]==$_GET['a'] && md5($thisline[2].$_SERVER['REMOTE_ADDR'])==$_GET['b'])
		$validdownload=$thisline;
	fclose($fh);
}
if($validdownload==0) {
?> <center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>
<?
    echo "<center>$lang[inlink]</center>";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
}

$userip = $_SERVER['REMOTE_ADDR'];
$time = time();

$filesize = filesize("./storage/".$validdownload[0]);
$filesize = $filesize / 1048576;

if($filesize > $nolimitsize)
{
$newfile = "./downloader/".$userip.".mfh";
$f=fopen($newfile, "w");
fwrite ($f,$userip."|".$time."|");
fclose($f);
chmod($newfile,0777);
}


$validdownload[4] = time();

session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==md5(md5($adminpass))) {
}
else {

// begin separate file mod
$newfile = "./files/$filecrc" . ".mfh";
$f=fopen($newfile, "w");
fwrite ($f,$validdownload[0]."|". $validdownload[1]."|". $validdownload[2]."|". $validdownload[3]."|". $validdownload[4]."|".($validdownload[5]+1)."|".$validdownload[6]."|".$validdownload[7]."|".$validdownload[8]."|\n");
fclose($f);
// end separate file mod
}

$speed = $dlspeed; // in Kb
header("Cache-control: private");
header('Content-type: application/force-download');
header('Content-Length: ' . filesize("./storage/".$validdownload[0]));
header('Content-Disposition: attachment; filename="'.$validdownload[1].'"');

if (!$minfile = fopen($fileLocation. $validdownload[0], 'r')) {
    exit;
}
while (!feof($minfile)) {
    echo fread($minfile, $speed * 1024);
    flush();
    sleep(1);
}
fclose($f);

?>