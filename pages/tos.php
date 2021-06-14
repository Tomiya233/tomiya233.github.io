<?php
include("./config.php");
include("./lang/$language.php");
?>
<center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <? echo $lang[tos_tos];?>
</td></tr></table>
<br />

<b><? echo $lang[tos_tos];?></b>
<hr noshade size=1 width=100% color=#008080>
<? echo $your_name ?><br>
<? echo $your_street ?><br>
<? echo $your_city ?><br>
<? echo $your_phone ?><br><br>
Internet: <? echo $your_url ?><br>
eMail: <? echo $email ?>

<hr noshade size=1 width=100% color=#008080>
- <? echo $lang[tos_point1];?>
<p>
- <? echo $lang[tos_point2];?>
<p>
- <? echo $lang[tos_point3];?>
<p>
- <? echo $lang[tos_point4];?>
<hr noshade size=1 width=100% color=#008080>
<? echo $lang[tos_send_abuse];?><? echo $your_aemail ?>

</center></td></tr></table><p style="margin:3px;text-align:center">