<?
$uber_version = "3.5.1";
$driver_version = "1.8";

if(isset($_GET['cmd']) && $_GET['cmd'] == 'version'){ kak("<u><b>FILE UPLOADER GET DATA PAGE</b></u><br>FILE UPLOADER VERSION =  <b>" . $uber_version . "</b><br>GET DATA DRIVER VERSION = <b>" . $driver_version . "<b><br>\n"); }
elseif(!isset($_GET['temp_dir_sid']) || !isset($_GET['start_time']) || !isset($_GET['total_upload_size'])){ kak("<font color='red'>ERROR</font>: Invalid parameters passed<br>"); }

$bRead = GetBytesRead($_GET['temp_dir_sid']);
$flength_file = $_GET['temp_dir_sid'] . "/flength";
$lapsed = time() - $_GET['start_time'];
$bSpeed = 0;
$remaining = 0;

if($lapsed > 0){ $bSpeed = $bRead / $lapsed; }
if($bSpeed > 0){ $remaining = round(($_GET['total_upload_size'] - $bRead) / $bSpeed); }

$remaining_sec = ($remaining % 60);
$remaining_min = ((($remaining - $remaining_sec) % 3600) / 60);
$remaining_hours = (((($remaining - $remaining_sec) - ($remaining_min * 60)) % 86400) / 3600);

if($remaining_sec < 10){ $remaining_sec = "0$remaining_sec"; }
if($remaining_min < 10){ $remaining_min = "0$remaining_min"; }
if($remaining_hours < 10){ $remaining_hours = "0$remaining_hours"; }

$remainingf = "$remaining_hours:$remaining_min:$remaining_sec";
$percent = round(100 * $bRead / $_GET['total_upload_size'],1);

if(is_dir($_GET['temp_dir_sid']) && is_file($flength_file) && $bRead < $_GET['total_upload_size']){
	$speed = $lapsed ? round($bRead / $lapsed) : 0;
	$speed = round($speed / 1024,1);
	$bRead = round($bRead /= 1024);
}
else{
	print "stopGetProgressData();";
	exit;
}

///////////////////////////////////////////////////////////////////////////////
// Return the current size of the $_GET['temp_dir_sid'] - flength file size. //
///////////////////////////////////////////////////////////////////////////////
function GetBytesRead($tmp_dir){
	$bytesRead = 0;

	if(is_dir($tmp_dir)){
		if($handle = opendir($tmp_dir)){
			while(false !== ($file = readdir($handle))){
				if($file != '.' && $file != '..' && $file != 'flength'){
					$bytesRead += filesize($tmp_dir . '/' . $file);
				}
			}
			closedir($handle);
		}
	}

	return $bytesRead;
}

//////////////////////////////////////////
// Output a message to screen and exit. //
//////////////////////////////////////////
function kak($msg){
	print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
	print "  <html>\n";
	print "    <head>\n";
	print "      <title>UBER UPLOADER</title>\n";
	print "      <META NAME=\"ROBOTS\" CONTENT=\"NOINDEX\">\n";
	print "      <meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
	print "      <meta http-equiv=\"CACHE-CONTROL\" content=\"no-cache\">\n";
	print "      <meta http-equiv=\"expires\" content=\"-1\">\n";
	print "    </head>\n";
	print "    <body style=\"background-color: #227B81; color: #000000; font-family: arial, helvetica, sans_serif; font size:10px;\">\n";
	print "	     <br>\n";
	print "      <div align='center'>\n";
	print        $msg . "\n";
	print "      <br>\n";
	print "      </div>\n";
	print "    </body>\n";
	print "  </html>\n";
	exit;
}

?>

document.getElementById('upload_status').style.width = <? print $percent; ?>+'%';
document.getElementById('percent').innerHTML = <? print $percent; ?>+'%';
document.getElementById('current').innerHTML = <? print $bRead; ?>;
document.getElementById('remain').innerHTML = "<? print $remainingf; ?>";
document.getElementById('speed').innerHTML = <? print $speed; ?>;