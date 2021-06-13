<?
include("./config.php");
include("./lang/$language.php");

if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}
session_start();
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

include("./header.php");

$passtemp = $_POST['setting16'];
if ($passtemp==null)
 $passnew = $content[16];
else
  $passnew = md5(md5($_POST['setting16']))  ;
If(isset($_POST['changesettings'])){
$fop =  fopen('secure/settings.mfh', 'w');
  $setting0 = $_POST['setting0'];
  $setting1 = $_POST['setting1'];
  $setting2 = $_POST['setting2'];
  $setting3 = $_POST['setting3'];
  $setting4 = $_POST['setting4'];
  $setting5 = $_POST['setting5'];
  $setting6 = $_POST['setting6'];
  $setting7 = $_POST['setting7'];
  $setting8 = $_POST['setting8'];
  $setting9 = $_POST['setting9'];
  $setting10 = $_POST['setting10'];
  $setting11 = $_POST['setting11'];
  $setting12 = $_POST['setting12'];
  $setting13 = $_POST['setting13'];
  $setting14 = $_POST['setting14'];
  $setting15 = $_POST['setting15'];
  $setting16 = $passnew;
  $setting17 = $_POST['setting17'];
  $setting18 = $_POST['setting18'];
  $setting19 = $_POST['setting19'];
  $setting20 = $_POST['setting20'];
  $setting21 = $_POST['setting21'];
  $setting22 = $_POST['setting22'];
  $setting23 = $_POST['setting23'];
  $setting24 = $_POST['setting24'];
  $setting25 = $_POST['setting25'];
  $setting26 = $_POST['setting26'];
  $setting27 = $_POST['setting27'];
  $setting28 = $_POST['setting28'];
  $setting29 = $_POST['setting29'];
  $setting30 = $_POST['setting30'];
  $setting31 = $_POST['setting31'];
  $setting32 = $_POST['setting32'];
  $setting33 = $_POST['setting33'];
  $setting34 = $_POST['setting34'];
  $setting35 = $_POST['setting35'];
  $setting36 = $_POST['setting36'];
  $setting37 = $_POST['setting37'];
  $setting38 = $_POST['setting38'];
  $setting39 = $_POST['setting39'];
  $setting40 = $_POST['setting40'];
  $setting41 = $_POST['setting41'];
  $setting42 = $_POST['setting42'];
  $setting43 = $_POST['setting43'];
  $setting44 = $_POST['setting44'];
  $setting45 = $_POST['setting45'];
  $setting46 = $_POST['setting46'];
  $setting47 = $_POST['setting47'];
  $setting48 = $_POST['setting48'];
  $setting49 = $_POST['setting49'];
  $setting50 = $_POST['setting50'];
  $setting51 = $_POST['setting51'];
  $setting52 = $_POST['setting52'];
  $setting53 = $_POST['setting53'];
  $setting54 = $_POST['setting54'];
  $setting55 = $_POST['setting55'];
  $setting56 = $_POST['setting56'];
  $setting57 = $_POST['setting57'];
  $setting58 = $_POST['setting58'];

$newcontent =  $setting0."|". $setting1."|". $setting2 ."|". $setting3 ."|". $setting4 ."|". $setting5 ."|". $setting6 ."|". $setting7 ."|". $setting8 ."|". $setting9 ."|". $setting10 ."|". $setting11 ."|". $setting12 ."|". $setting13 ."|". $setting14 ."|". $setting15 ."|". $setting16 ."|". $setting17 ."|". $setting18 ."|". $setting19 ."|". $setting20 ."|". $setting21 ."|". $setting22 ."|". $setting23 ."|". $setting24 ."|". $setting25 ."|". $setting26 ."|". $setting27 ."|". $setting28 ."|". $setting29 ."|". $setting30 ."|". $setting31 ."|". $setting32 ."|". $setting33 ."|". $setting34 ."|". $setting35 ."|". $setting36 ."|". $setting37 ."|". $setting38 ."|". $setting39 ."|". $setting40 ."|". $setting41 ."|". $setting42 ."|". $setting43 ."|". $setting44 ."|". $setting45 ."|". $setting46 ."|". $setting47 ."|". $setting48 ."|". $setting49 ."|". $setting50 ."|". $setting51 ."|". $setting52 ."|". $setting53 ."|". $setting54 ."|". $setting55 ."|". $setting56 ."|". $setting57 ."|". $setting58;

If(fwrite($fop,$newcontent)){
$set = "a";
 }else{
$set = "b";
}

fclose($fop);

  }
 $fop =  fopen('secure/settings.mfh', 'r');

 $content = fread($fop, '999');
 fclose($fop);
$content = explode("|", $content);

     ?>
<center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<? include("./adminmenu.php"); ?>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[settings];?>
</td></tr></table>
<br />

<?
if ($set=="a")
{
  echo '<center><font size="+1" color="Green">'.$lang[changed_success].'</font></center></br>';
?> <META HTTP-EQUIV="Refresh" CONTENT="0; URL=settings.php"> <?
}
elseif($d=="b")
{
  echo '<center><font size="+1" color="Red">'.$lang[changed_not_success].'</font></center></br>';
?> <META HTTP-EQUIV="Refresh" CONTENT="7; URL=settings.php"> <?
}
else
{
  echo "";
}
?>
<p>

      <form method="post" action="">
<table bgcolor="#DFDFDF" border="0" cellpadding="2" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
 <tr><td colspan=3 bgcolor=#F2F2F2 background="img/bg.png" align=center><b><? echo $lang[settings_main_config];?></b></td></tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_site_name];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting0" value="<?echo $content[0];?>" size="20" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_site_name1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_slogan];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting1" value="<?echo $content[1];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_slogan1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_script_url];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting2" value="<?echo $content[2];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_script_url1];?></td>
  </tr></table>
  <br />

<table bgcolor="#DFDFDF" border="0" cellpadding="2" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
 <tr><td colspan=3 bgcolor=#F2F2F2 background="img/bg.png" align=center><b><? echo $lang[settings_cgi_config];?></b></td></tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_uscript];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting55" value="<?echo $content[55];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_uscript1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_pscript];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting56" value="<?echo $content[56];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_pscript1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_configfile];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting57" value="<?echo $content[57];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_configfile1];?></td>
  </tr>
  </tr></table>
  <br />

<table bgcolor="#DFDFDF" border="0" cellpadding="2" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr><td colspan=3 bgcolor=#F2F2F2 background="img/bg.png" align=center><b><? echo $lang[settings_multiserver_config];?></b></td></tr>
<tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 1</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting44" value="<?echo $content[44];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 2</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting45" value="<?echo $content[45];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 3</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting46" value="<?echo $content[46];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 4</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting47" value="<?echo $content[47];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 5</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting48" value="<?echo $content[48];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 6</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting49" value="<?echo $content[49];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 7</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting50" value="<?echo $content[50];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 8</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting51" value="<?echo $content[51];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 9</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting52" value="<?echo $content[52];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiserver];?> 10</td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting53" value="<?echo $content[53];?>" size="30" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiserver1];?></td>
  </tr></table>
  <br />
<table bgcolor="#DFDFDF" border="0" cellpadding="2" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr><td colspan=3 bgcolor=#F2F2F2 background="img/bg.png" align=center><b><? echo $lang[settings_zusatz_config];?></b></td></tr>

  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_password];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="password" name="setting16" size="20" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_password1];?> <font color=#FF0000><b><? echo $lang[settings_password2];?></b></font></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_email];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting17" value="<?echo $content[17];?>" size="20" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_email1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_aemail];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting27" value="<?echo $content[27];?>" size="20" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_aemail1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_language];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting15" value="<?echo $content[15];?>" size="20" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_language1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_style];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting21" value="<?echo $content[21];?>" size="20" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_style1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_dlspeed];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting34" value="<?echo $content[34];?>" size="8" />&nbsp;KB/S
</td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_dlspeed1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_maxfilesize];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting3" value="<?echo $content[3];?>" size="8" />&nbsp;MB
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_maxfilesize1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_downloadtimelimit];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting4" value="<?echo $content[4];?>" size="8" />&nbsp;<? echo $lang[settings_minutes];?>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_downloadtimelimit1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_uploadtimelimit];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting5" value="<?echo $content[5];?>" size="8" />&nbsp;<? echo $lang[settings_minutes];?>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_uploadtimelimit1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_nolimitsize];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting6" value="<?echo $content[6];?>" size="8" />&nbsp;MB
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_nolimitsize1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_deleteafter];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting7" value="<?echo $content[7];?>" size="8" />&nbsp;<? echo $lang[settings_days];?>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_deleteafter1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_downloadtimer];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting8" value="<?echo $content[8];?>" size="8" />&nbsp;<? echo $lang[settings_seconds];?>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_downloadtimer1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_pps];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting18" value="<?echo $content[18];?>" size="8" />&nbsp;<? echo $lang[settings_pps2];?>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_pps1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_pps];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting19" value="<?echo $content[19];?>" size="8" />&nbsp;<? echo $lang[settings_pps2];?>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_pps3];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_pps];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting20" value="<?echo $content[20];?>" size="8" />&nbsp;<? echo $lang[settings_pps2];?>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_pps4];?></td>
  </tr>
<tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_pps];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="text" name="setting41" value="<?echo $content[41];?>" size="8" />&nbsp;<? echo $lang[settings_pps2];?>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_pps5];?></td>
  </tr>
   <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_securitycode];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting40" value="true" <?php if ($content[40] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting40" value="false" <?php if ($content[40] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_securitycode1];?></td>
  </tr>
<tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_filelist];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting9" value="true" <?php if ($content[9] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting9" value="false" <?php if ($content[9] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_filelist1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_multiupload];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting38" value="true" <?php if ($content[38] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting38" value="false" <?php if ($content[38] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_multiupload1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_shorturl];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting10" value="true" <?php if ($content[10] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting10" value="false" <?php if ($content[10] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_shorturl1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_email_option];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting11" value="true" <?php if ($content[11] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting11" value="false" <?php if ($content[11] == 'false') echo 'checked' ?>
    <font size="2">&nbsp;<b><? echo $lang[settings_off];?></b></font>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_email_option1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_password_feature];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting12" value="true" <?php if ($content[12] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting12" value="false" <?php if ($content[12] == 'false') echo 'checked' ?>
    <font size="2"><b>&nbsp;<? echo $lang[settings_off];?></b></font>
    </td><td bgcolor=#F2F2F2>
   <? echo $lang[settings_password_feature1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_file_description];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting13" value="true" <?php if ($content[13] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting13" value="false" <?php if ($content[13] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_file_description1];?></td>
  </tr>
 <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_toplist];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting14" value="true" <?php if ($content[14] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting14" value="false" <?php if ($content[14] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_toplist1];?></td>
  </tr>
   <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_admin];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting33" value="true" <?php if ($content[33] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting33" value="false" <?php if ($content[33] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_admin1];?></td>
  </tr>
<tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_search];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting39" value="true" <?php if ($content[39] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting39" value="false" <?php if ($content[39] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_search1];?></td>
  </tr>
<tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_enhanced];?></td>
    <td bgcolor=#F2F2F2>&nbsp;<input type="radio" name="setting58" value="true" <?php if ($content[58] == 'true') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_on];?></font></b>&nbsp;&nbsp;
<input type="radio" name="setting58" value="false" <?php if ($content[58] == 'false') echo 'checked' ?>
    <b><font size="2">&nbsp;<? echo $lang[settings_off];?></font></b>
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_enhanced1];?></td>
  </tr>
</table>
<br>
<table bgcolor="#DFDFDF" border="0" cellpadding="2" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr><td colspan=3 bgcolor=#F2F2F2 background="img/bg.png" align=center><b><? echo $lang[settings_personal_data];?></b> <? echo $lang[settings_personal_data1];?></td></tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_personal_name];?></td>
    <td bgcolor=#F2F2F2 width=280>&nbsp;<input type="text" name="setting26" value="<?echo $content[26];?>" size="40" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_personal_name1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_personal_street];?></td>
    <td bgcolor=#F2F2F2 width=280>&nbsp;<input type="text" name="setting22" value="<?echo $content[22];?>" size="40" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_personal_street1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_personal_city];?></td>
    <td bgcolor=#F2F2F2 width=280>&nbsp;<input type="text" name="setting23" value="<?echo $content[23];?>" size="40" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_personal_city1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_personal_url];?></td>
    <td bgcolor=#F2F2F2 width=280>&nbsp;<input type="text" name="setting24" value="<?echo $content[24];?>" size="40" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_personal_url1];?></td>
  </tr>
  <tr>
    <td width=120 bgcolor=#F2F2F2><? echo $lang[settings_personal_phone];?></td>
    <td bgcolor=#F2F2F2 width=280>&nbsp;<input type="text" name="setting25" value="<?echo $content[25];?>" size="40" />&nbsp;
    </td><td bgcolor=#F2F2F2>
    <? echo $lang[settings_personal_phone1];?></td>
  </tr>
</table>
      <p><center><input type="submit" value="<? echo $lang[settings_change];?>" name="changesettings"></center>

      </form>
 </center></td></tr></table><p style="margin:3px;text-align:center"><?
include("./adminfooter.php");} else {

header("Location: admin.php");

        }
?>