<?php
#########################################################################
#	PHP-TextCounter von murb					#
#	php_txtcounter v. 2.4						#
#	All rights by murb (www.murb.com)				#
#-----------------------------------------------------------------------#
#	Info: webmaster@murb.com					#
#	I-Net: http://www.murb.com					#
#									#
#	Dieses Script ist Freeware					#
#	Dateien dürfen NUR auf murb.com zum Download angeboten werden.	#
#########################################################################
// Dieses Copyright darf NICHT entfernt werden!

$ipsperre = "yes";			// IP-Sperre
$ipstore = "40";			// IP-Adressen-Anzahl (Besucherzähler)
$iptime = "1800";			// IP-Adressen-Zeitbegrenzung
$onlineipstore = "50";			// IP-Adressen-Anzahl (Onlinezähler)
$onlinetime = "300";			// Online-Zeit für einen Besucher
$path = "counter/";			// Ordner in der sich der Counter befindet
$countdatat = "counts.inc";		// Totalcounter-Datei
$countdata = "today.inc";		// Heutecounter-Datei
$countdatay = "yesterday.inc";		// Vortagcouter-Datei
$recorddata = "record.inc";		// Rekordcounter-Datei
$onlinedata = "online.inc";		// IP-Adressen der "Online-Besucher"
$ipdata = "ips.inc";			// IP-Datei
$visiblet = "yes";			// (Un)Sichtbarkeit des Totalcounters
$visibled = "yes";			// (Un)Sichtbarkeit des Heutecounters
$visibley = "yes";			// (Un)Sichtbarkeit des Vortagcounters
$visibler = "yes";			// (Un)Sichtbarkeit des Rekordcounters
$visibleo = "yes";			// (Un)Sichtbarkeit des Onlinecounters
$instdate = "04.10.2007";		// Installationsdatum
$splitting = "<br>";			// Statistiktrennung
$txtonline = "Online: ";		// Text vor der aktiven Besucheranzahl
$txttoday = "Today: ";			// Text vor der Besucheranzahl des heutigen Tages
$txtyesterday = "Yesterday: ";		// Text vor der Besucheranzahl des Vortages
$txtrecord = "Record: ";		// Text vor dem Tagesrekord
$txttotal = "Total: ";			// Text vor der Gesamtbesucheranzahl
$boldnumbers = "no";			// Fette/Normale Schriftart der Zahlen
$zeitzone = "no";			// Zeitzone aktivieren
$zeitzonentyp = "MET-1METDST";		// Zeitzone

#########################################################################
// Editiere nur, wenn du weißt was du tust !!!


if ($_GET[action] != "show" || !isset($_GET[action]))
{
if ($ipsperre == "yes")
{
if (getenv('HTTP_X_FORWARDED_FOR'))
{
$varip = getenv('HTTP_X_FORWARDED_FOR');
}
else
{
$varip = getenv('REMOTE_ADDR');
}
if (!file_exists($path.$countdatat) || !file_exists($path.$countdata) || !file_exists($path.$countdatay) || !file_exists($path.$recorddata) || !file_exists($path.$onlinedata) || !file_exists($path.$ipdata))
{
echo "Fehler! Dateizugriff nicht möglich.";
exit;
}
$factorx = time();
$ipanzahl = count(file($path.$onlinedata));
$loadips = fopen($path.$onlinedata,"r");
$allips = fread($loadips, filesize($path.$onlinedata));
fclose($loadips);
$ips = explode("||", $allips);

$i = 0;
while ($i < $ipanzahl)
{
$sectors = explode("::", $ips[$i]);
if (preg_match ("/$varip/i", $sectors[0]))
{
if ($onlinetime > 0)
{
$strike = $factorx - $sectors[1];
if ($strike <= $onlinetime)
{
$rauswurf = "no";
}
}
}
$i += 1;
}
if ($rauswurf != "no")
{
if ($ipanzahl == 0)
{
$storeip = fopen($path.$onlinedata,"a+");
fwrite($storeip, "$varip::$factorx||");
fclose($storeip);
}
else
{
if ($ipanzahl >= $onlineipstore)
{
$readips = fopen($path.$onlinedata,"r");
$cacheips = fread($readips, filesize($path.$onlinedata));
fclose($readips);
$ipcached = explode("||", $cacheips);

for ($r = 1; $r < $onlineipstore; ++$r)
{
if ($r == 1)
{
$ipcached[$r] = str_replace("\n", "", $ipcached[$r]);
$ipcached[$r] = str_replace("\r", "", $ipcached[$r]);
$storeip = fopen($path.$onlinedata,"w");
fwrite($storeip, "$ipcached[$r]||");
fclose($storeip);
}
elseif ($r == $onlineipstore - 1)
{
$storeip = fopen($path.$onlinedata,"a+");
fwrite($storeip, "$ipcached[$r]||\r\n$varip::$factorx||");
fclose($storeip);
}
else
{
$storeip = fopen($path.$onlinedata,"a+");
fwrite($storeip, "$ipcached[$r]||");
fclose($storeip);
}
}
}
else
{
$storeip = fopen($path.$onlinedata,"a+");
fwrite($storeip, "\r\n$varip::$factorx||");
fclose($storeip);
}
}
}
$factorx = time();
$ipsgesamt = count(file($path.$onlinedata));
$w = 0;
$useronline = 0;
while ($w < $ipsgesamt)
{
$sectors = explode("::", $ips[$w]);
if (!isset($sectors[1]) || $sectors[1] == "")
{
$strike = 0;
}
else
{
$strike = $factorx - $sectors[1];
}
if ($strike <= $onlinetime)
{
$useronline += 1;
}
$w += 1;
}

if ($useronline < 1)
{
$useronline = 1;
}
$ipanzahl = count(file($path.$ipdata));

$loadips = fopen($path.$ipdata,"r");
$allips = fread($loadips, filesize($path.$ipdata));
fclose($loadips);
$ips = explode("||", $allips);
$goon = "yes";

$i = 0;
while ($i < $ipanzahl)
{
$sectors = explode("::", $ips[$i]);
if (preg_match ("/$varip/i", $sectors[0]))
{
if ($iptime > 0)
{
$strike = $factorx - $sectors[1];
if ($strike <= $iptime)
{
$countit = "no";
}
}
elseif ($iptime <= 0)
{
$countit = "no";
}
}
$i += 1;
}
if ($countit == "no")
{
$loadcount = fopen($path.$countdata,"r");
$counttoday = fread($loadcount, filesize($path.$countdata));
fclose($loadcount);

$todaydaten = explode("||", $counttoday);

$loadyesterday = fopen($path.$countdatay, "r");
$countyesterday = fread($loadyesterday, filesize($path.$countdatay));
fclose($loadyesterday);

$loadtotal = fopen($path.$countdatat, "r");
$counttotal = fread($loadtotal, filesize($path.$countdatat));
fclose($loadtotal);

$loadrecord = fopen($path.$recorddata, "r");
$record = fread($loadrecord, filesize($path.$recorddata));
fclose($loadrecord);

if ($todaydaten[0] > $record)
{
$storenewrecord = fopen($path.$recorddata, "w");
fwrite($storenewrecord, $todaydaten[0]);
fclose($storenewrecord);

$record = $todaydaten[0];
}
if ($todaydaten[0] == "0")
{
$nday = date("d");
$nmonth = date("m");
$nyear = date("Y");
$tanzahl = "1";

$storecount = fopen($path.$countdata, "w");
fwrite($storecount, "$tanzahl||$nday||$nmonth||$nyear");
fclose($storecount);
}

if ($countyesterday == "0" || $countyesterday == "")
{
$countyesterday = "-";
}

$bv = "<b>";
$bh = "</b>";

if ($visibleo == "yes")
{
if ($visibled == "yes" || $visibley == "yes" || $visibler == "yes" || $visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$useronline = $bv.$useronline.$bh;
}
$writeonlinecounter = $txtonline.$useronline.$splitting;
}
else
{
if ($boldnumbers == "yes")
{
$useronline = $bv.$useronline.$bh;
}
$writeonlinecounter = $txtonline.$useronline;
}
}
if ($visibled == "yes")
{
if ($visibley == "yes" || $visibler == "yes" || $visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$todaydaten = $bv.$todaydaten[0].$bh;
}
else
{
$todaydaten = $todaydaten[0];
}
$writetodaycounter = $txttoday.$todaydaten.$splitting;
}
else
{
if ($boldnumbers == "yes")
{
$todaydaten = $bv.$todaydaten[0].$bh;
}
else
{
$todaydaten = $todaydaten[0];
}
$writetodaycounter = $txttoday.$todaydaten;
}
}
if ($visibley == "yes")
{
if ($visibler == "yes" || $visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$countyesterday = $bv.$countyesterday.$bh;
}
$writeyesterdaycounter = $txtyesterday.$countyesterday.$splitting;
}
else
{
if ($boldnumbers == "yes")
{
$countyesterday = $bv.$countyesterday.$bh;
}
$writeyesterdaycounter = $txtyesterday.$countyesterday;
}
}
if ($visibler == "yes")
{
if ($visibler == "yes" || $visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$record = $bv.$record.$bh;
}
$writerecordcounter = $txtrecord.$record.$splitting;
}
else
{
if ($boldnumbers == "yes")
{
$record = $bv.$record.$bh;
}
$writerecordcounter = $txtrecord.$record;
}
}
if ($visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$counttotal = $bv.$counttotal.$bh;
}
$writetotalcounter = $txttotal.$counttotal;
}

echo "$writeonlinecounter$writetodaycounter$writeyesterdaycounter$writerecordcounter$writetotalcounter";
$goon = "no";

}
if ($ipanzahl == 0)
{
$storeip = fopen($path.$ipdata,"a+");
fwrite($storeip, "$varip::$factorx||");
fclose($storeip);
}
else
{
if ($ipanzahl >= $ipstore)
{
$readips = fopen($path.$ipdata,"r");
$cacheips = fread($readips, filesize($path.$ipdata));
fclose($readips);
$ipcached = explode("||", $cacheips);

for ($r = 1; $r < $ipstore; ++$r)
{
if ($r == 1)
{
$ipcached[$r] = str_replace("\n", "", $ipcached[$r]);
$ipcached[$r] = str_replace("\r", "", $ipcached[$r]);
$storeip = fopen($path.$ipdata,"w");
fwrite($storeip, "$ipcached[$r]||");
fclose($storeip);
}
elseif ($r == $ipstore - 1)
{
$storeip = fopen($path.$ipdata,"a+");
fwrite($storeip, "$ipcached[$r]||\r\n$varip::$factorx||");
fclose($storeip);
}
else
{
$storeip = fopen($path.$ipdata,"a+");
fwrite($storeip, "$ipcached[$r]||");
fclose($storeip);
}
}
}
else
{
$storeip = fopen($path.$ipdata,"a+");
fwrite($storeip, "\r\n$varip::$factorx||");
fclose($storeip);
}
}
}
if ($goon != "no")
{
$loadcount = fopen($path.$countdata,"r");
$counttoday = fread($loadcount, filesize($path.$countdata));
fclose($loadcount);

$todaydaten = explode("||", $counttoday);

$tanzahl = $todaydaten[0];
$tday = $todaydaten[1];
$tmonth = $todaydaten[2];
$tyear = $todaydaten[3];

if ($zeitzone == "yes")
{
@putenv("TZ=$zeitzonentyp");
}
$nday = date("d");
$nmonth = date("m");
$nyear = date("Y");

$newday = "no";
$schongez = "0";

if ($nyear > $tyear)
{
$newday = "yes";
$schongez = "1";
}
if ($nmonth > $tmonth && $schongez == "0")
{
$newday = "yes";
$schongez = "1";
}
if ($nday > $tday  && $schongez == "0")
{
$newday = "yes";
}

if ($newday == "yes")
{
$storeyesterday = fopen($path.$countdatay, "w");
fwrite($storeyesterday, $tanzahl);
fclose($storeyesterday);

$tanzahl = 0;
}

$tanzahl += 1;

$storecount = fopen($path.$countdata, "w");
fwrite($storecount, "$tanzahl||$nday||$nmonth||$nyear");
fclose($storecount);

$loadtotal = fopen($path.$countdatat, "r");
$counttotal = fread($loadtotal, filesize($path.$countdatat));
fclose($loadtotal);

$counttotal += 1;

$storecount = fopen($path.$countdatat, "w");
fwrite($storecount, $counttotal);
fclose($storecount);
}

$loadrecord = fopen($path.$recorddata, "r");
$record = fread($loadrecord, filesize($path.$recorddata));
fclose($loadrecord);

if ($tanzahl > $record)
{
$storenewrecord = fopen($path.$recorddata, "w");
fwrite($storenewrecord, $tanzahl);
fclose($storenewrecord);

$record = $tanzahl;
}

if ($goon != "no")
{
$loadyesterday = fopen($path.$countdatay, "r");
$countyesterday = fread($loadyesterday, filesize($path.$countdatay));
fclose($loadyesterday);

$loadcount = fopen($path.$countdata, "r");
$counttoday = fread($loadcount, filesize($path.$countdata));
fclose($loadcount);

$todaydaten = explode("||", $counttoday);

if ($countyesterday == "0" || $countyesterday == "")
{
$countyesterday = "-";
}

$bv = "<b>";
$bh = "</b>";

if ($visibleo == "yes")
{
if ($visibled == "yes" || $visibley == "yes" || $visibler == "yes" || $visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$useronline = $bv.$useronline.$bh;
}
$writeonlinecounter = $txtonline.$useronline.$splitting;
}
else
{
if ($boldnumbers == "yes")
{
$useronline = $bv.$useronline.$bh;
}
$writeonlinecounter = $txtonline.$useronline;
}
}
if ($visibled == "yes")
{
if ($visibley == "yes" || $visibler == "yes" || $visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$todaydaten = $bv.$todaydaten[0].$bh;
}
else
{
$todaydaten = $todaydaten[0];
}
$writetodaycounter = $txttoday.$todaydaten.$splitting;
}
else
{
if ($boldnumbers == "yes")
{
$todaydaten = $bv.$todaydaten[0].$bh;
}
else
{
$todaydaten = $todaydaten[0];
}
$writetodaycounter = $txttoday.$todaydaten;
}
}
if ($visibley == "yes")
{
if ($visibler == "yes" || $visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$countyesterday = $bv.$countyesterday.$bh;
}
$writeyesterdaycounter = $txtyesterday.$countyesterday.$splitting;
}
else
{
if ($boldnumbers == "yes")
{
$countyesterday = $bv.$countyesterday.$bh;
}
$writeyesterdaycounter = $txtyesterday.$countyesterday;
}
}
if ($visibler == "yes")
{
if ($visibler == "yes" || $visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$record = $bv.$record.$bh;
}
$writerecordcounter = $txtrecord.$record.$splitting;
}
else
{
if ($boldnumbers == "yes")
{
$record = $bv.$record.$bh;
}
$writerecordcounter = $txtrecord.$record;
}
}
if ($visiblet == "yes")
{
if ($boldnumbers == "yes")
{
$counttotal = $bv.$counttotal.$bh;
}
$writetotalcounter = $txttotal.$counttotal;
}

echo "$writeonlinecounter$writetodaycounter$writeyesterdaycounter$writerecordcounter$writetotalcounter";
}
}
elseif ($_GET[action] == "show")
{
$ipsize = filesize($ipdata);
if ($ipsize < 1)
{
$ipsize = "10000";
}

$loadips = fopen($ipdata, "r");
$allips = fread($loadips, $ipsize);
fclose($loadips);
$ipcombo = explode("||", $allips);
$ipanzahl = count(file($ipdata));

$loadtotalcounts = fopen($countdatat, "r");
$totalcounts = fread($loadtotalcounts, filesize($countdatat));
fclose($loadtotalcounts);
$totalcounts = trim($totalcounts);

$loadtodaycounts = fopen($countdata, "r");
$todaycounts = fread($loadtodaycounts, filesize($countdata));
fclose($loadtodaycounts);
$todaycounts = trim($todaycounts);

$today = explode("||", $todaycounts);

$loadyesterdaycounts = fopen($countdatay, "r");
$yesterdaycounts = fread($loadyesterdaycounts, filesize($countdatay));
fclose($loadyesterdaycounts);
$yesterdaycounts = trim($yesterdaycounts);

$loaddayrecord = fopen($recorddata, "r");
$dayrecordcounts = fread($loaddayrecord, filesize($recorddata));
fclose($loaddayrecord);
$dayrecordcounts = trim($dayrecordcounts);

echo ("<html><head><title>PHP-Textcounter - Informationen</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
</head>
<body style=\"font-family: arial; font-size: 12px\">
<center>
<p><b>PHP-TextCounter: Allgemeine Informationen</b></p>
<p>&nbsp;</p>
<table width=\"300\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"font-family: arial; font-size: 12px\">
<tr>
<td width=\"60%\" height=\"19\" align=\"left\" valign=\"top\">Heute:<br>
Gestern:<br>
Tagesrekord:<br>
Seit $instdate:</td>
<td width=\"40%\" align=\"left\" valign=\"top\">$today[0]<br>$yesterdaycounts<br>$dayrecordcounts<br>$totalcounts</td>
</tr>
</table>
<p>&nbsp;</p>
<table width=\"300\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"font-family: arial; font-size: 12px\">
<tr>
<td width=\"100%\" align=\"left\" valign=\"top\" style=\"padding-bottom: 5px\">Die letzten $ipstore gespeicherten IP-Adressen sind:</td>
</tr>
<tr>
<td width=\"100%\" align=\"left\" valign=\"top\">");
if ($allips == "")
{
echo "<br>Es sind keine IP-Adressen vorhanden.";
}
else
{
for ($w = 0; $w < $ipanzahl; ++$w)
{
$onlyip = explode("::", $ipcombo[$w]);
$onlyip[0] = str_replace("\n", "", $onlyip[0]);
$onlyip[0] = str_replace("\r", "", $onlyip[0]);
echo "<br>$onlyip[0]";
}
}
echo ("</td>
</tr>
</table>
</center>
</body>
</html>");
}
else
{
echo "Es ist ein Fehler aufgetreten!";
}
?>