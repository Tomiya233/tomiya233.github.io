<?php
$datum=date("d.m.Y:");
$zeit=date("H:i:s");
$ip=getenv("REMOTE_ADDR");
$site = $_SERVER['REQUEST_URI'];
$monate = array(1=>"January", 2=>"February", 3=>"March", 4=>"April", 5=>"May", 6=>"June", 7=>"July", 8=>"August", 9=>"September", 10=>"October", 11=>"November", 12=>"December");

$monat = date("n");
$jahr = date("y");
$dateiname="log/log_$monate[$monat]_$jahr.mfh";

$eintragen="$ip - - [$datum$zeit] \"GET /$site HTTP/1.1\"";

$datei=fopen($dateiname,"a");
fputs($datei,"$eintragen\n");
fclose($datei);
?>
<center><font color="white" face="Verdana" size="1">Copyright?<? echo date("Y")?> <font color="white" face="Verdana" size="1"><? echo $compname;?>. All Rights Reserved<br> 
Powered by <a href="http://www.galaxyscripts.com/" target="_blank"><font color="white" face="Verdana" size="1">MFH v2.0</a></font></b> <a href="http://www.btdisk.info">.</a><br />
</body></html>