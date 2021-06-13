<?php
include("./config.php");
include("./header.php");
include("./lang/$language.php");

$rand1 =rand(1,9);
$rand2 =rand(0,9);
$rand3 =rand(0,9);
$rand4 =rand(0,9);

$randcode = $rand1. $rand2. $rand3. $rand4;

$bans=file("./secure/bans.mfh");
foreach($bans as $line)
{
  if ($line==$_SERVER['REMOTE_ADDR']){
?>
<center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo "$lang[younallow]";?>
</td></tr></table>
<br />
<?
    echo "$lang[younallow]";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
    include("./footer.php");
    die();
  }
}

if(isset($_GET['file'])) {
  $filecrc = $_GET['file'];
} else {
?>

<?
?>
<center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo "$lang[inlink]";?>
</td></tr></table>
<br />
<?
  echo "$lang[inlink] <br />";
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
  include("./footer.php");
  die();
}

$foundfile=0;
if (file_exists("./files/".$filecrc.".mfh")) {
	$fh1=fopen("./files/".$filecrc.".mfh",r);
	$foundfile= explode('|', fgets($fh1));
	fclose($fh1);
}
{
  $thisline = explode('|', $line);
  if ($thisline[0]==$filecrc){
    $foundfile=$thisline;
  }
}

if(isset($_GET['del'])) {

$deleted=0;
$filecrc = $_GET['file'];
$filecrctxt = $filecrc . ".mfh";
$passcode = $_GET['del'];
if (file_exists("./files/".$filecrctxt)) {
	$fh2=fopen ("./files/".$filecrctxt,r);
	$thisline= explode('|', fgets($fh2));
	if($thisline[2] == $passcode){
$deleted=1;
fclose($fh2);
		unlink("./files/".$filecrctxt);
	}

}

if($deleted==1){
unlink("./storage/".$_GET['file']);
?>
<center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo "$lang[ufwd]";?>
</td></tr></table>
<br />
<?
echo "<center><b>$lang[ufwd]</b></center><br />";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?

echo "<center><b>$lang[uwbr] </center></b><br />";
} else {
?><center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo "$lang[indlink2]";?>
</td></tr></table>
<br />
<?
echo "<center><b>$lang[indlink2] </b></center><br />";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?

echo "<center><b>$lang[uwbr] </center></b><br />";
}
?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();

}

if($foundfile==0) {
?> <center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo "$lang[inlink]";?>
</td></tr></table>
<br />
<?
  echo "<center><b>$lang[inlink]</center></b><br />";
?> <META HTTP-EQUIV="Refresh"
      CONTENT="10; URL=index.php"> <?
include("./squareads.php");?><p><?

echo "<center><b>$lang[uwbr]</center></b><br />";
  ?></center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
  die();
}

if(isset($foundfile[7]) && $foundfile[7]!=md5("") && (!isset($_POST['pass']) || $foundfile[7] != md5($_POST['pass']))){
?>  <center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $lang[dl_a_file];?>
</td></tr></table>

 <p> <?
echo "<form action=\"download.php?file=".$foundfile[0]."\" method=\"post\"><center><b>$lang[pw2] : </center></b><p><center><input type=\"password\" name=\"pass\"><p><center><input value=\"Enter\" type=\"submit\" /></form>";
?>
<p><center>
<? echo $lang[petc];?>
</center>
<?
?>
<p><p>
</center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
die();
}
?>
<center>



<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[dl_a_file];?>
</td></tr></table>
<br />
<?

$filesize = filesize("./storage/".$foundfile[0]);
$filesize = $filesize / 1048576;

$userip=$_SERVER['REMOTE_ADDR'];
$time=time();

///////////////////////////////////////////TIMER////////////////////////////////////
if($filesize > $nodolimit) {
if(file_exists("./downloader/".$userip.".mfh"))
{

$downloaders = fopen("./downloader/".$userip.".mfh","r+");
flock($downloaders,2);

while (!feof($downloaders)) {
  $user[] = chop(fgets($downloaders,65536));
}

fseek($downloaders,0,SEEK_SET);
ftruncate($downloaders,0);

$youcantdownload = 0;
foreach ($user as $line) {
list($savedip,$savedtime) = explode('|',$line);
 if ($savedip == $userip) {
    if ($time < $savedtime + ($downloadtimelimit*60)) {
      $youcantdownload = 1;
	  $downtimer = $time - $savedtime ;
	  $counter = $downloadtimelimit*60 - $downtimer;
    }
  }

  if ($time < $savedtime + ($downloadtimelimit*60)) {
    fputs($downloaders,"$savedip|$savedtime\n");
  }
}


if($youcantdownload==1) {

echo "<center><img src='img/halt.png' border=0 width=17 height=18> <font size=4 color=#E10000><b>Download Time Limit</b></center></font>";?>
<br />

<script type="text/javascript">

var running = false
var endTime = null
var timerID = null
var totalMinutes = <?php echo $counter;?>;

function startTimer() {
    running = true
    now = new Date()
    now = now.getTime()
    endTime = now + (1000 * totalMinutes);
    showCountDown()
}

function showCountDown() {
    var now = new Date()
    now = now.getTime()
    if (endTime - now <= 0) {
       clearTimeout(timerID)
       window.location.reload()

    } else {
        var delta = new Date(endTime - now)
        var theMin = delta.getMinutes()
        var theSec = delta.getSeconds()
        var theTime = theMin
        theTime += ((theSec < 10) ? ":0" : ":") + theSec
        document.getElementById('SessionTimeCount').innerHTML = 'Please wait ( <font color="#FF0000">' + theTime + '</font> ) minutes to download again...'
        if (running) {
            timerID = setTimeout("showCountDown()",1000)
        }
    }
}

window.onload=startTimer
</script>
<center>
<span id="SessionTimeCount"></span></center><br />
<?

	    include("./bottomads.php");
?><td><tr><table><?
       include("./footer.php");
      die();

}

}
}
///////////////////////////////////////////TIMER///////////////////////



$fsize = 0;
$fsizetxt = "";
  if ($filesize < 1)
  {
     $fsize = round($filesize*1024,0);
     $fsizetxt = "".$fsize." KB";
    $check1 = "KB";
  }
  else
    {
     $fsize = round($filesize,2);
     $fsizetxt = "".$fsize." MB";
$check1 = "MB";
  }

?>
<p>
<?
$quantity= $foundfile[5] * $fsizetxt;
$d=$descriptionoption;
switch ($d)
{
case false:
 $test="";
  break;
case true:
  $test= "$lang[fd6]";
  break;
default:
  echo ""; }
$f=$foundfile[6];
if ($f=="")
  $test2= "None";
else
  $test2= "$foundfile[6]";
$e=$descriptionoption;
switch ($e)
{
case false:
 $test4="";
  break;
case true:
  $test4= "$test2";
  break;
default:
  echo ""; }

echo '<center>';
echo '<table  border="0" cellpadding="0" cellspacing="0" width="">';
echo '<tr>';
echo '<td width="16"><img src="img/top_lef.gif" width="16" height="16"></td>';
echo '<td height="16" background="img/top_mid.gif"><img src="img/top_mid.gif" width="16" height="16"></td>';
echo '<td width="24"><img src="img/top_rig.gif" width="24" height="16"></td>';
echo '</tr>';
echo '<tr>';
echo '<td width="16" background="img/cen_lef.gif"><img src="img/cen_lef.gif" width="16" height="11"></td>';
echo '<td align="center" valign="middle" bgcolor="#FFFFFF">';

echo "<img src=\"img/warning.gif\" border=0 width=12 height=12> <a href='report.php?file=$foundfile[0]' style=color:#FF0000>".$lang[rtf]."</a><br><br>";

echo "<table cellspacing=1 cellpadding=2 border=0 bgcolor=#C0C0C0>";
echo "<tr><td align=left bgcolor=#F4F4F4 background=\"img/button03.gif\">".$lang[fn6].":</td><td bgcolor=#EEF4FB background=\"img/button03.gif\"><font color=#000080>".$foundfile[1] ."</td></tr>";
echo "<tr><td align=left bgcolor=#F4F4F4 background=\"img/button03.gif\">".$lang[fbu].":</td><td bgcolor=#EEF4FB background=\"img/button03.gif\"><font color=#000080>".$quantity ." ". $check1."</td></tr>";
//echo "<tr><td align=left bgcolor=#F4F4F4 background=\"img/button03.gif\">".$lang[dl_ip].":</td><td bgcolor=#EEF4FB background=\"img/button03.gif\"><font color=#000080>".$foundfile[3]."</td></tr>";
echo "<tr><td align=left bgcolor=#F4F4F4 background=\"img/button03.gif\">".$lang[dl_filesize].":</td><td bgcolor=#EEF4FB background=\"img/button03.gif\"><font color=#000080>". $fsizetxt."</td></tr>";
echo "<tr><td align=left bgcolor=#F4F4F4 background=\"img/button03.gif\">".$lang[dl_file_dl].":</td><td bgcolor=#EEF4FB background=\"img/button03.gif\"><font color=#000080>". $foundfile[5]." ".$lang[dl_file_dl1]."</td></tr>";
echo "<tr><td align=left bgcolor=#F4F4F4 background=\"img/button03.gif\">".$lang[dl_last_dl].": </td><td bgcolor=#EEF4FB background=\"img/button03.gif\"><font color=#000080>".date('d.m.Y G:i', $foundfile[4])."</td></tr>\n";

if(isset($foundfile[6])){ echo "<tr><td align=left bgcolor=#F4F4F4 background=\"img/button03.gif\">$test</td><td bgcolor=#EEF4FB background=\"img/button03.gif\"><font color=#000080>$test4</td></tr>"; }
$randcounter = rand(100,999);
echo "</td></tr></table>";

?>
       </td>
      <td width="24" background="img/cen_rig.gif"><img src="img/cen_rig.gif" width="24" height="11"></td>
    </tr>
    <tr>
      <td width="16" height="16"><img src="img/bot_lef.gif" width="16" height="16"></td>
      <td height="16" background="img/bot_mid.gif"><img src="img/bot_mid.gif" width="16" height="16"></td>
      <td width="24" height="16"><img src="img/bot_rig.gif" width="24" height="16"></td>
    </tr>
  </table><br>
  <?

$randcounter = rand(100,999);
?>
   <form id="form">
  <script>
function refreshh() {
window.location='<?php echo $scripturl . "download.php?file=" .$foundfile[0]; ?>';
}

function checksubmit()
{
if (document.getElementById("form").scode.value == <?php echo $randcode; ?> )
{
window.location='<?php echo $scripturl. "download2.php?a=" . $filecrc . "&b=" . md5($foundfile[2].$_SERVER['REMOTE_ADDR']) ?>';
window.setTimeout("refreshh()", 3000);
return false;
}
else
{
alert("ERROR:\n Securitycode was wrong!\n Please input the right Securitycode to download the File!");
window.location='<?php echo $scripturl . "download.php?file=" .$foundfile[0]; ?>';
}

}
</script>


<table cellspacing=1 cellpadding=0 border=0 height= width="250">
<tr>
<td align=center background="img/captcha-b.png" colspan=2><font color="#C0C0C0" size="6"><b><font face=times new roman><?php echo $randcode;?></td></tr>
<tr><td align=top>Security Code:<font size=1></td><td align=top>&nbsp;<input type="text" name="scode" size="2" /></font>
</td></tr></table>
</form>
<br><div id="dl" align="center">

<?php

if($downloadtimer == 0) {
echo "<input type=submit value=\"".$lang[dl_file_now]."\" onClick=window.location=\"".$scripturl. "download2.php?a=" . $filecrc . "&b=" . md5($foundfile[2].$_SERVER['REMOTE_ADDR'])."\">";
} else { ?>
<? echo $lang[nenjava];?>

<?php } ?>
</div>
<script language="Javascript">
x<?php echo $randcounter; ?>=<?php echo $downloadtimer; ?>;
function countdown()
{
 if ((0 <= 100) || (0 > 0))
 {
  x<?php echo $randcounter; ?>--;
  if(x<?php echo $randcounter; ?> == 0)
  {
document.getElementById("dl").innerHTML = '<input type="submit" value="<? echo $lang[dl_file_now];?>" onClick="checksubmit()" onClick="window.location=\'<?php echo $scripturl . "download2.php?a=" . $filecrc . "&b=" . md5($foundfile[2].$_SERVER['REMOTE_ADDR']) ?>\'">';
  }
  if(x<?php echo $randcounter; ?> > 0)
  {
 document.getElementById("dl").innerHTML = '<? echo $lang[dl_ticket];?><br><? echo $lang[dl_file_now1];?> <font color=#FF0000><b> '+x<?php echo $randcounter; ?>+'</b></font> <? echo $lang[dl_file_now2];?>...';
   setTimeout('countdown()',1000);
  }
 }
}
countdown();
</script>
 </td></tr></table></center>
<?php
include("./footer.php");
?>
<?
        $foo = '';

        if (!empty($_GET))
        {
                $foo .= '?';
                foreach ($_GET as $key => $val)
               {
                          $foo .= $key . '=' . $val;
               }
        }
$zufall = rand(10000000,99999999);
$ip=$_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($ip);
$datum = date("d.m.Y",time());
$uhrzeit = date("H:i",time());
$link = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"] . $foo;
$filename =  $foundfile[1];
$refferer = $_SERVER["HTTP_REFERER"];


$newfile = "./dl/".$zufall.".db";
$f=fopen($newfile, "w");
fwrite ($f,$ip."|".$host."|".$datum."|".$uhrzeit."|".$link."|".$filename."|".$refferer);
fclose($f);
chmod($newfile,0777);

?>
