<?php
include("./config.php");
include("./lang/$language.php");

?>

<center><table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<table width=100% cellpadding=1 cellspacing=0 border=0><tr><td align=left background="img/bg14.png">
<font size=3 color=#FFFFFF><b>&nbsp;<? echo $compname ?> &raquo; <?php echo $lang[faq]; ?>
</td></tr></table>
<br />

<b><?php echo $lang[faq1]; ?></b>
<hr noshade size=1 width=100% color=#008080>
<?php echo $lang[faq1a]; ?> <?php echo $maxfilesize; ?> MB.

<br /><br />

<b><?php echo $lang[faq2]; ?></b>
<hr noshade size=1 width=100% color=#008080>
<?php echo $lang[faq2a]; ?> <?php echo $deleteafter; ?> <?php echo $lang[faq2b]; ?>

<br /><br />

<b><?php echo $lang[faq3]; ?></b>
<hr noshade size=1 width=100% color=#008080>
<?php echo $lang[faq3a]; ?> <?php echo $uploadtimelimit; ?> <?php echo $lang[faq3b]; ?> <?php echo $lang[faq3c]; ?> <?php echo $downloadtimelimit; ?> <?php echo $lang[faq3d]; ?>

<br /><br />

<b><?php echo $lang[faq4]; ?></b>
<hr noshade size=1 width=100% color=#008080>
<?php echo $lang[faq4a]; ?> <?php echo $nolimitsize; ?> <?php echo $lang[faq4b]; ?>

</center></td></tr></table><p style="margin:3px;text-align:center">