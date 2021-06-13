<?php
include("./config.php");
include("./header.php");
include("./lang/$language.php");
if(isset($_GET['file'])){
$thisfile=$_GET['file'];
}else{
?>
<center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <?php echo $lang[treport]; ?>
</td></tr></table>
<br />
<?
echo "<center>$lang[treport]</center>";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}



$foundfile=0;
if (file_exists("./files/".$thisfile.".mfh")) {
	$fh1=fopen("./files/".$thisfile.".mfh",r);
	$foundfile= explode('|', fgets($fh1));
	fclose($fh1);
}


if($foundfile==0){
?><center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <?php echo $lang[treport]; ?>
</td></tr></table>
<br />
<?
echo "<center>$lang[treport]</center>";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}

$bans=file("./secure/bans.mfh");
foreach($bans as $line)
{
  if ($line==$_SERVER['REMOTE_ADDR']."\n"){
?><center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <?php echo $lang[uall]; ?>
</td></tr></table>
<br />
<?
    echo "<center>$lang[uall]</center>";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
  }
}

$reported = 0;
$fc=file("./secure/reports.mfh");
foreach($fc as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0] == $thisfile)
    $reported = 1;
}

if($reported == 1) {
?> <center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <?php echo $lang[rthanks]; ?>
</td></tr></table>
<br />
<?
echo "<center><b>$lang[rthanks]<p></b></center>";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?

echo "<center><b>$lang[redir]</center></b><br />";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}

$filelist = fopen("./secure/reports.mfh","a+");
fwrite($filelist, $thisfile ."|". $_SERVER['REMOTE_ADDR'] ."\n");
?> <center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <?php echo $lang[rthanks]; ?>
</td></tr></table>
<br />
<?
echo "<center><b>$lang[rthanks]</b><p>";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?
echo "<center><b>$lang[redir]</center></b><br />";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");

?>