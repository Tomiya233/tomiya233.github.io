<?php

$version = '2.0';
$sname = 'MFH v2.0';

$enhancedupload = "$content[58]";
// Set this to true to enable the progress bar (needs Perl)

$fop =  fopen('secure/settings.mfh', 'r');
$content = fread($fop, '999');
fclose($fop);
$content = explode("|", $content);

$compname = "$content[0]";
//// Your Company Name

$slogan = "$content[1]";
//// Your Company Slogan

$scripturl = "$content[2]";
//// the URL to this script with a trailing slash

$uscript = "$content[55]";
//// the URL to the cgi-bin upload-script (upload.pl)

$pscript = "$content[56]";
//// the URL to the cgi-bin progress-script (progress.pl)

$configfile = "$content[57]";
//// the Name of the cgi-bin Config-File (e.G. "Uploads" without an Endings)

$domains[1] = "$content[44]";
$domains[2] = "$content[45]";
$domains[3] = "$content[46]";
$domains[4] = "$content[47]";
$domains[5] = "$content[48]";
$domains[6] = "$content[49]";
$domains[7] = "$content[50]";
$domains[8] = "$content[51]";
$domains[9] = "$content[52]";
$domains[10] = "$content[53]";
$rand = rand(1,10);
$multiserverx =  $domains[$rand];
////Multiserver Configuration

$adminpass = $content[16];
//// set this password to something other than default
//// it will be used to access the admin panel

$email = $content[17];
//// your eMail-Adress for abuse/support and user registration page

$maxfilesize = $content[3];
//// the maximum file size allowed to be uploaded (in megabytes)

$downloadtimelimit = $content[4];
//// time users must wait before downloading another file (in minutes)

$uploadtimelimit = $content[5];
//// time users must wait before uploading another file (in minutes)

$nolimitsize = $content[6];
//// if a file is under this many megabytes, there is no time limit

$deleteafter = $content[7];
//// delete files if not downloaded after this many days

$downloadtimer = $content[8];
//// length of the timer on the download page (in seconds)

$language = $content[15];

if ($content[9]=="false")
  $result9 = false;
else
  $result9 = true;

$enable_filelist = $result9;
//// allows users to see a list of uploaded files. set to false to disable

if ($content[10]=="false")
  $result10 = false;
else
  $result10 = true;

$shourturl = $result10;
//// Short url Eg yourdomain.com/13232 needs mod_rewrite enabled. For More Info See Our Froum

if ($content[11]=="false")
  $result11 = false;
else
  $result11 = true;

$emailoption = $result11;
//// set this to true to allow users to email themselves the download links

if ($content[12]=="false")
  $result12 = false;
else
  $result12 = true;

$passwordoption = $result12;
//// set this to true to allow users to password protect their uploads

if ($content[13]=="false")
  $result13 = false;
else
  $result13 = true;

$descriptionoption = $result13;
//// set this to true to disable the description field

if ($content[14]=="false")
  $result14 = false;
else
  $result14 = true;

$enable_topten =  $result14;
//// Make It true if you want to enable Top ten files

if ($content[33]=="false")
  $result33 = false;
else
  $result33 = true;

$admin =  $result33;
//// Make it true if you want to enable Admin-Link

if ($content[39]=="false")
  $result39 = false;
else
  $result39 = true;

$search =  $result39;
//// Make it true if you want to enable Search-Link

//$categories = array("Documents","Applications","Audio","Misc");
//// remove the //'s from the above line to enable categories
//// Users will be able to choose from this list of categories

//$allowedtypes = array("txt","gif","jpg","jpeg");
//// remove the //'s from the above line to enable file extention blocking
//// only file extentions that are noted in the above array will be allowed

$dlspeed = $content[34];
//// the maximum download-speed for free-users (in kb - kilobytes)

$pps1 = $content[18];
//// the hits shows on admin's filelist

$pps2 = $content[19];
//// the hits shows on filelist

$pps3 = $content[20];
//// the hits shows on admin's downloadslist

$pps4 = $content[43];
//// the hits shows on admin's downloadslist

$pps5 = $content[43];
//// the hits shows on admin's downloadslist

$style = $content[21];
//// The Style of your MiniFileHost

$your_name = $content[26];
//// Your Name

$your_street = $content[22];
//// Your Street

$your_city = $content[23];
//// Your Name

$your_url = $content[24];
//// Your Internet-Adress

$your_phone = $content[25];
//// Your Phone-Number

$your_aemail = $content[27];
//// Your Abuse-EMail

$sendmail="admin@filehost.com";
////Link SendMail and AbuseMail Adresse

if ($content[38]=="false")
  $result38 = false;
else
  $result38 = true;

$multi_upload_slots = $result38;
////Enable/Disable multiple upload slots = true or false

$searchhits = $content[41];
//// The Number of Search-Hits per Page

$notalloweddfiletypes = "/(\.sh)|(\.php)|(\.php2)|(\.php3)|(\.php4)|(\.php5)|(\.php6)|(\.shtml)|(\.htaccess)|(\.cgi)|(\.pl)|(\.phtml)|(\.phtm)|(\.pif)|(\.xhtml)|(\.dhtml)|(\.html)|(\.htm)|(\.xhtm)|(\.py)$/";
////Show Not Allowed Files in Startpage and in Upload.php

if ($content[40]=="false")
  $result40 = false;
else
  $result40 = true;

$uploadsecuritycode = $result40;
//// set this to true to UPLOAD Seuritycode

if ($content[42]=="false")
  $result42 = false;
else
  $result42 = true;

$pfolder = $result42;
//// set this to true to UPLOAD Seuritycode

?>