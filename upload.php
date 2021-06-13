<?
include("./header.php");
include("./config.php");
include("./lang/$language.php");
$bans=file("./secure/bans.mfh");
foreach($bans as $line)
{
$banline = explode('|', $line);
  if ($banline[0]==$_SERVER['REMOTE_ADDR']){

  if ($banline[1]=="")
{
$showbanground= "*************************";
}
else
{
$showbanground= $banline[1]."".$banline[2];
}
echo "</td></tr></table>";
 echo "<center><table style='margin-top:0px;width:790px;'><tr><td style='border:0px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:0px;text-align:left;' valign=top>";


?><script> alert ('\n\t You have been banned!!!!\n\n Banned: <? print $showbanground; ?> \n\n Questions? Send an email to <? print $sendmail; ?>')
this.location.href="index.php"</script>

<?
echo "</td></tr></table>";
echo "</td></tr></table></center>";
    include("./footer.php");
    die();
  }
}


$m=$shourturl;
if ($m=="true")
  $short= "";
else
  $short= "download.php?file=";



$uber_version = "3.5.1";
$driver_version = "2.7.3";

/////////////////////////////////////////////////////////////////
// The following possible query string formats are assumed
//
// 1. ?upload_dir=path_to_upload_dir&clode_pop=1
// 2. ?upload_dir=path_to_upload_dir
// 3. ?cmd=version
/////////////////////////////////////////////////////////////////
if(isset($_GET['cmd']) && $_GET['cmd'] == 'version'){ kak("<u><b>FILE UPLOADER FINISHED PAGE</b></u><br>FILE UPLOADER VERSION =  <b>" . $uber_version . "</b><br>FINISHED DRIVER VERSION = <b>" . $driver_version . "<b><br>\n"); }
elseif(!isset($_GET['tmp_sid']) || strlen($_GET['tmp_sid']) != 32){ kak("<font color='red'>WARNING</font>: Invalid session-id.<br>\n"); }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// If you do not want the path to the temp dir passed in the address bar simply hardcode it here.
// However, you will also need to adjust the redirect in uber_uploader.pl so it does not pass the upload_dir value.
//
// eg. $temp_dir = "/var/tmp/";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$temp_dir = $_GET['temp_dir'];

// Get all the posted values from the .param file
$_POST_DATA = getPostData($temp_dir, $_GET['tmp_sid']);

////////////////////////////////////////////////////////////////////////////////////////////
// You can now access all the post values from the .param file. eg. $_POST_DATA['email']; //
////////////////////////////////////////////////////////////////////////////////////////////

// We must force flush incase email hangs
if($_POST_DATA['send_email_on_upload']){ ob_implicit_flush(1); }

$i = 0;
$file_list = "";
$email_file_list = "";



# Loop over the post data looking for files and create table elements
foreach($_POST_DATA as $key => $value){
	if(preg_match("/^upfile_/i", $key)){
		$uploaded_file_name = $value;
		$uploaded_file_path = $_POST_DATA['upload_dir'] . $uploaded_file_name;

		$urlnum=rand(1, 9999999999999);
         $rand2=("$urlnum-$uploaded_file_name");

$filecrcx = md5_file("storage/".$uploaded_file_name);
$filename = $uploaded_file_name;
$userip2 = $_SERVER['REMOTE_ADDR'];
$filesize = filesize("storage/".$uploaded_file_name);
$passkey = rand(100000, 9999999999);
		if(is_file($uploaded_file_path)){
			$file_size = filesize($uploaded_file_path);
			$file_size = formatBytes($file_size);

			if($i%=2){ $bg_col = "cccccc"; }
			else{ $bg_col = "dddddd"; }

			if($_POST_DATA['link_to_upload']){
				$path_to_upload = $_POST_DATA['path_to_upload'];
				$file_list .= "<div align=center><center><a href=\"$path_to_upload$rand2\" target=\"_blank\">$uploaded_file_name</a><br><br>$file_size<br></div>\n";
			}
			else{ $file_list .= '<div align=center><hr noshade size=1 width=100% color=#6CB7B7><img src=img/ok.gif border=0 width=16 height=16> '.$lang[yupfile].'<br><font color="#FF0000">'.$uploaded_file_name.' ('.$file_size.')</font><hr noshade size=1 width=100% color=#6CB7B7><br>'."<a href=\"" . $scripturl . "$short" .$rand2. "\">"."Download Link:</a>".'<br><input type="text" name="textfield5" size="120" value='.'"'. $scripturl . "$short" .$rand2 .'"'.'readonly="1" onClick="this.select();" />'."<br><br>Forums URL<br>".'<input type="text" name="textfield5" size="120" value='.'"'."[URL=".$scripturl . "$short" .$rand2."]".$filename."[/URL]".'"'.'readonly="1" onClick="this.select();" />'."<br><br><center>Website URL:<br>".'<input type="text" name="textfield5" size="120" value='.'"'."<a href=".$scripturl . "$short" .$rand2.">".$filename."</a>".'"'.'readonly="1" onClick="this.select();" /><br>'."<br><a href=\"" . $scripturl . "$short" .$rand2 . "&del=" . $passkey . "\">"."Delete Link"."</a><br>".'<input type="text" name="textfield5" size="120" value='.'"'.$scripturl . "$short" .$rand2 ."&del=".$passkey.'"'.'readonly="1" onClick="this.select();" /></div><br /><br />';


$cat = "";
$filesize = $filesize / 1048576;
$userip = $_SERVER['REMOTE_ADDR'];
$time = time();

if($filesize > $nolimitsize) {

$uploaders = fopen("./secure/uploaders.mfh","r+");
flock($uploaders,2);
while (!feof($uploaders)) {
$user[] = chop(fgets($uploaders,65536));
}
fseek($uploaders,0,SEEK_SET);
ftruncate($uploaders,0);
foreach ($user as $line) {
@list($savedip,$savedtime) = explode("|",$line);
if ($savedip == $userip) {
if ($time < $savedtime + ($uploadtimelimit*60)) {

echo "You're trying to upload again too soon!";
echo "</td></tr></table></center>";
include("./footer.php");
die();
}
}

if ($time < $savedtime + ($uploadtimelimit*60)) {
  fputs($uploaders,"$savedip|$savedtime\n");
}
}
fputs($uploaders,"$userip|$time\n");

}

if($emailoption && isset($_POST_DATA['myemail']) && $_POST_DATA['myemail']!="") {
$uploadmsg = "$lang[ufile] (".$filename.") $lang[wup].\n  ". $lang[udownfile] . ":" . $scripturl . "$short" . $rand2 . "\n ". $lang[udeletefile] . ":" . $scripturl . "$short" . $rand2 . "&del=" . $passkey . "&ignore=" . "\n $lang[thank]";
mail($_POST_DATA['myemail'],"Ihre hochgeladene Datei ".$uploaded_file_name,$uploadmsg,"From: ". $email ."\n");
}

if($passwordoption && isset($_POST_DATA['pprotect'])) {
  $passwerd = md5($_POST_DATA['pprotect']);
  $pass2=$_POST_DATA['pprotect'];
} else {
$passwerd = md5("");
$pass2 = "";
}

if($descriptionoption && isset($_POST_DATA['descr'])) {
  $description = strip_tags($_POST_DATA['descr']);
} else { $description = ""; }


$filelist = fopen("./files/".$rand2.".mfh","w");
fwrite($filelist, $rand2 ."|". $uploaded_file_name ."|". $passkey ."|". $userip ."|". $time ."|0|". $description ."|". $passwerd ."|". $cat ."|". $pass2 ."|". $filecrcx ."|". $time ."|\n");

rename("./storage/".$uploaded_file_name, "./storage/".$rand2);

			}

			$email_file_list .= "File Name: $uploaded_file_name     File Size: $file_size\n";

			$i++;
		}
		else{
			if($i%=2){ $bg_col = "cccccc"; }
			else{ $bg_col = "dddddd"; }

			$email_file_list .= "File Name: $uploaded_file_name     File Size: Failed To Upload !\n";

			$file_list .= "<tr><td align=\"center\" bgcolor=\"$bg_col\">&nbsp;$uploaded_file_name&nbsp;</td><td align=\"center\" bgcolor=\"$bg_col\"><font color=\"red\">Failed To Upload</font></td></tr></table>\n";
			$i++;
		}
		clearstatcache();
	}
}

// Send upload results if email on upload is enabled
if($_POST_DATA['send_email_on_upload']){ email_upload_results($_POST_DATA['to_email_address'], $_POST_DATA['from_email_address'], $_POST_DATA['email_subject'], $email_file_list, $_GET['tmp_sid'], $_POST_DATA['start_time'], $_POST_DATA['html_email_support']); }

/////////////////////////////////////////////////////////
//  Get the post data from the param file (tmp_sid.param)
/////////////////////////////////////////////////////////
function getPostData($up_dir, $tmp_sid){
	$param_array = array();
	$buffer = "";
	$key = "";
	$value = "";
	$paramFileName = $up_dir . $tmp_sid . ".params";
	$fh = fopen($paramFileName, 'r') or kak("<font color='red'>ERROR</font>: Can't open $paramFileName");

	while(!feof($fh)){
		$buffer = fgets($fh, 4096);
		list($key, $value) = explode('=', trim($buffer));
		$value = str_replace("~EQLS~", "=", $value);
		$value = str_replace("~NWLN~", "\r\n", $value);

		if(isset($key) && isset($value) && strlen($key) > 0 && strlen($value) > 0){
			if(preg_match('/(.*)\[(.*)\]/i', $key, $match)){ $param_array[$match[1]][$match[2]] = $value; }
			else{ $param_array[$key] = $value; }
		}
	}

	fclose($fh);

	/////////////////////////////////////////////////////////////////////////////////
	// If you suspect there is something wrong with your .param file, simply comment
	// out this for loop. The .param file will be left in your temp directory.
	/////////////////////////////////////////////////////////////////////////////////
	for($i = 0; $i < 5; $i++){
		if(unlink($paramFileName)){ break; }
		else{ sleep(1); }
	}

	return $param_array;
}

//////////////////////////////////////////////////
//  formatBytes($file_size) mixed file sizes
//  formatBytes($file_size, 0) KB file sizes
//  formatBytes($file_size, 1) MB file sizes etc
//////////////////////////////////////////////////
function formatBytes($bytes, $format=99){
	$byte_size = 1024;
	$byte_type = array(" KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");

	$bytes /= $byte_size;
	$i = 0;

	if($format == 99 || $format > 7){
		while($bytes > $byte_size){
			$bytes /= $byte_size;
			$i++;
		}
	}
	else{
		while($i < $format){
			$bytes /= $byte_size;
			$i++;
		}
	}

	$bytes = sprintf("%1.2f", $bytes);
	$bytes .= $byte_type[$i];

	return $bytes;
}

/////////////////////////////////////////
// Output a message to screen and exit.
////////////////////////////////////////
function kak($msg){
	print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
	print "  <html>\n";
	print "    <head>\n";
	print "      <title>Webhosting</title>\n";
	print "      <META NAME=\"ROBOTS\" CONTENT=\"NOINDEX\">\n";
	print "      <meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
	print "      <meta http-equiv=\"CACHE-CONTROL\" content=\"no-cache\">\n";
	print "      <meta http-equiv=\"expires\" content=\"-1\">\n";
	print "    </head>\n";
	print "    <body style=\"background-color: #227B81; color: #000000; font-family: arial, helvetica, sans_serif;\">\n";
	print "	     <br>\n";
	print "      <div align='center'>\n";
	print        $msg . "\n";
	print "      <br>\n";
	print "      </div>\n";
         print "     </td></tr></table>";
	print "    </body>\n";
	print "  </html>\n";
	exit;
}

//////////////////////////////////////////
// Send an email with the upload results.
//////////////////////////////////////////
function email_upload_results($email_to, $email_from, $email_subject, $upload_result, $tmp_sid, $start_time, $html_email){
	$end_time = mktime();

	if($html_email){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	}

	$headers .= "To: " . $email_to . "\r\n";
	$headers .= "From: " . $email_from . "\r\n";

	$message = "\nStart Upload (epoch): " . $start_time . "\n";
	$message .= "End Upload (epoch): " . $end_time . "\n";
	$message .= "Start Upload: ". date("M j, Y, g:i:s", $start_time) . "\n";
	$message .= "End Upload: ". date("M j, Y, g:i:s", $end_time) . "\n";
	$message .= "SID: ". $tmp_sid . "\n";
	$message .= "Remote IP: " . $_SERVER['REMOTE_ADDR']  . "\n";
	$message .= "Browser: " . $_SERVER['HTTP_USER_AGENT'] . "\n\n";
	$message .= $upload_result;

	mail($email_to, $email_subject, $message, $headers);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Uploading File</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" >
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="-1">
  </head>

  <!-- Close the progress bar -->
  <? if(!$_POST_DATA['imbedded_progress_bar']){ ?>
  	<script language="JavaScript" type="text/JavaScript">
  	  popwin = window.open('','pop_win_<? print $_GET['tmp_sid']; ?>','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=10,height=10,left=10,top=10');
  	  popwin.focus();
  	  popwin.document.writeln('<html><body onload="javascript:self.close();"></body></html>');
    	  popwin.document.close();
  	</script>
  <? } ?>
  <body style="background-color: #227B81; color: #000000; font-family: arial, helvetica, sans_serif;">
<center><table style='margin-top:0px;width:790px;'><tr><td style='border:0px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:0px;text-align:left;' valign=top>

<div align="center">
<?php

$filelist = fopen("./secure/search.mfh","a");
fwrite($filelist, "[list];". $scripturl ."download.php?file=". $rand2 .";". $uploaded_file_name .";\r\n");

if($filesize==0) {
echo "<br><br><center>Damaged File - Please Try Again</center><br><br><center><strong>Please select a real file!</strong></center><br><br>";
echo "</td></tr></table>";
echo "</td></tr></table></center>";
include("./footer.php");
die();
}
echo "<center><table style='margin-top:0px;width:780px;height:400px;'><tr><td style='border:0px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>";

echo '';
echo "".'<font color="#FF0000" size="3">'.'<center><table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png"><font size=3 color=#FFFFFF><b>&nbsp;'.$compname.' &raquo; Download Links:</center>'.'</font></tr></table></font>';
echo $file_list;
echo "</td></tr></table>";
echo "</td></tr></table></center>";
include("./footer.php");
?>