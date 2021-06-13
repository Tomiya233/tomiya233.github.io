<?php
include("./header.php");
include("./config.php");
include("./lang/$language.php");
?>
<center><table style='margin-top:0px;width:790px;height:400px;'><tr><td style='border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;' valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> <? echo $lang[search];?>
</td></tr></table>
<table align=center border=0 cellspacing=0 cellpadding=0 width=100%><tr><td bgcolor=white align=center>
<table align=center border=0 cellspacing=0 cellpadding=0 width=100% background=./img/bg.gif1><tr><td height=40 background=./img/bg16.png>
<CENTER>
<FORM action=search.php?action=dict_find  method=post>
<table border=0 cellspacing=0 cellpadding=0><tr>
<td align=center><B><font color=#FFFFFF><? echo $lang[search];?>:</B>&nbsp;</font></td>
<td align=center><INPUT name=keyword size=50><FONT class=f1></td>
<td valign=bottom align=center>&nbsp;<INPUT name="submit_dict" value="Search" type="submit">
</td></tr></table>
</form></CENTER>
</td></tr>
<tr><td height=2></td></tr>
<tr><td align=center>
<?
extract($HTTP_GET_VARS);
extract($HTTP_POST_VARS);
//$results_per_page - how many results you want to be displayed per page?
$results_per_page=$searchhits;
if($action == "dict_find") {
$user = file("./secure/search.mfh");
$lis = 0;
if(strlen($keyword) <= 2){
	print "<BR><img src=\"img/warning.gif\" border=0 width=12 height=12> Your search term must have more than <b><font color=#000080>3</font></b> characters!";
}
else{
	for($x=0;$x<sizeof($user);$x++) {
		$temp = explode(";",$user[$x]);
		$opp[$x] = "$temp[0];$temp[1];$temp[2]";
		$such = strchr($temp[2],$keyword);
			if($such) {
				$list[$lis] = $opp[$x];
				$lis++;
			}
	}
		function getmicrotime(){
		list($usec, $sec) = explode(" ",microtime());
	   return ((float)$usec + (float)$sec);
	}

	$time = microtime();
	$time = number_format($time,3);

if(sizeof($list) != "0") {

		echo "<table width=100% cellspacing=0 cellpadding=0 border=0 bgcolor=#F2F2F2><tr><td align=left background=img/b1.png><b><font color=#FF0000>",sizeof($list),"</font></b> " . $lang[searchhits] . " <font color=#FF0000> \"$keyword\"</font></td></tr></table><BR>";
		}else{

		echo "<table width=100% cellspacing=0 cellpadding=0 border=0 bgcolor=#F2F2F2><tr><td align=left background=img/b1.png> " . $lang[nosearchhits] . " <font color=#FF0000>&nbsp;<b>". $keyword ."</b></font></td></tr></table><BR>";
	}
$latest_max = sizeof($list);
$u = $a - $latest_max;
if (is_file("./secure/search.mfh"))
	{
	$s=sizeof($list);
if ($page=='' or !$page) { $page=1; }
$end=$results_per_page*$page;
$start=$end-$results_per_page;

if ($start<>'0') {
	$new_page=$page-1;
	$prev="<a href='?action=dict_find&keyword=$keyword&page=$new_page'><img src=./img/previous1.gif border=0></a>";
}
else {
	$prev="";
}

if ($end<$s) {
	$new_page1=$page+1;
	$next="<a href='?action=dict_find&keyword=$keyword&page=$new_page1'><img src=./img/next1.gif border=0></a>";
}
else {
	$next="";
}
$today = time();
for ($i=$start; $i<$end; $i++){
	if(substr($list[$i], 0, 6 )=="[list]")
	{
	sort($list);
    $p=explode(';', $list[$i]);

	echo "<div align=left><img src=./img/dot.gif><font face=arial>&nbsp;<a href=$p[1] target=_blank>$p[2]</a>&nbsp;<br></FONT></div>";
}
}
$pages=$s/$results_per_page;
$pages1=round($pages, 2);
$p= explode(".", $pages1);
$pcount=count($p);
$ext=$p[$pcount-2];
if ($ext!=0) {
	$num=$p[0]+1;
}

else {
	$num=$p[0];
}
echo "<table width='100%' border=0><tr><td align='left' width=33%>$prev</td><td align='center' width=33%>";
for ($i=1; $i<=$num; $i++) {
	if ($i==$page) {
echo "<B>&nbsp;$i&nbsp;</B> ";

	}
	else {
echo "&nbsp;<a href='?action=dict_find&keyword=$keyword&page=$i'>[$i]</a>&nbsp;";
}
}
echo "</td><td align='right' width=33%>$next</td></tr></table>";
}
}
}

?>
</center>
</td></tr></table>
<center><?
include("./bottomads.php");
?></center>
</td></tr></table>
</body>
</html></center>
</center>
</td></tr></table><p style="margin:3px;text-align:center"><?
include("./footer.php");
?>