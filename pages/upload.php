<?php
include("./config.php");
include("./lang/$language.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<META NAME="revisit-after" CONTENT="2 days">
<link rel="SHORTCUT ICON" href="favicon.ico">
<script type="text/javascript">
function turnOff(dname) {
document.getElementById(dname).style.display = 'none';
}
function turnOn(dname) {
document.getElementById(dname).style.display = 'block';
}
</script>
<SCRIPT language="JavaScript">
var checkobj
function agreesubmit(el){
checkobj=el
if (document.all||document.getElementById){
for (i=0;i<checkobj.form.length;i++){  //hunt down submit button
var tempobj=checkobj.form.elements[i]
if(tempobj.type.toLowerCase()=="submit")
tempobj.disabled=!checkobj.checked
}
}
}

function defaultagree(el){
if (!document.all&&!document.getElementById){
if (window.checkobj&&checkobj.checked)
return true
else{
alert("Please read and accept terms to submit form")
return false
}
}
}
</script>
<script type="text/javascript"><!--
function agreeTerms()
{
document.getElementById("upload").disabled=false
document.getElementById("checkBox").checked=true
}
function denyTerms()
{
document.getElementById("upload").disabled=true
document.getElementById("checkBox").checked=false
}

var W3CDOM = (document.createElement && document.getElementsByTagName);

function initFileUploads() {
	if (!W3CDOM) return;
	var fakeFileUpload = document.createElement('div');
	fakeFileUpload.className = 'fakefile';
	fakeFileUpload.appendChild(document.createElement('input'));
	var image = document.createElement('img');
	image.src='button_select.gif';
	fakeFileUpload.appendChild(image);
	var x = document.getElementsByTagName('input');
	for (var i=0;i<x.length;i++) {
		if (x[i].type != 'file') continue;
		if (x[i].parentNode.className != 'fileinputs') continue;
		x[i].className = 'file hidden';
		var clone = fakeFileUpload.cloneNode(true);
		x[i].parentNode.appendChild(clone);
		x[i].relatedElement = clone.getElementsByTagName('input')[0];
		x[i].onchange = x[i].onmouseout = function () {
			this.relatedElement.value = this.value;
		}
	}
}

//--></script>

<!-- flooble Expandable Content header start -->
<script language="javascript">
// Expandable content script from flooble.com.
// For more information please visit:
//   http://www.flooble.com/scripts/expand.php
// Copyright 2002 Animus Pactum Consulting Inc.
//----------------------------------------------
var ie4 = false; if(document.all) { ie4 = true; }
function getObject(id) { if (ie4) { return document.all[id]; } else { return document.getElementById(id); } }
function toggle(link, divId) { var lText = link.innerHTML; var d = getObject(divId);
 if (lText == '+') { link.innerHTML = '-'; d.style.display = 'block'; }
 else { link.innerHTML = '+'; d.style.display = 'none'; } }
</script>
<!-- flooble Expandable Content header end   -->
</head>
<body onload="denyTerms()">
<table style="margin-top:0px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:10px;text-align:left;" valign=top>
<center>

<br />
<table cellspacing=0 cellpadding=0 border=0>
<tr><td align=absmiddle><img src="img/folder-neu.png" border=0 width=33 height=29></td>
<td><font color=#FFFFFF>...</font></td>
<td align=absmiddle><font size=5 color=#808080><b><? echo $compname ?> <? echo $lang[file_upload];?></td>
<td><font color=#FFFFFF>...</font></td>
<td align=absmiddle><img src="img/pfeil-neu.png" border=0 width=39 height=33></td>
</tr></table>
</center><br>
	<center>
         <?
set_time_limit(0);                        // No time limit
$tmp_sid = md5(uniqid(mt_rand(), true));  // Generate session-id used by Uploader and Progress Bar

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$path_to_upload_script   = $uscript;             // Path to the cgi-bin upload script                             //
$path_to_progress_script = $pscript;    // Path to the cgi-bin progress bar script                       //
$config_file             = $configfile;  // Name of the cgi-bin Config-File. You must change this file manually   //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$rand1 =rand(1,9);
$rand2 =rand(0,9);
$rand3 =rand(0,9);
$rand4 =rand(0,9);
$secrandcode = $rand1.$rand2.$rand3

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Uploading File</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" >
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="-1">
  <!-- Please do not remove this tag: Uber-Uploader Ver 3.5.1 http://uber-uploader.sourceforge.net -->
</head>
<script language="javascript" type="text/javascript">
var check_file_extensions = true;                         // Change to false to skip file extension check
var check_null_file_count = true;                         // Change to false to skip null file upload
var check_duplicate_file_count = true;                    // Change to false to skip duplicate file upload check
var check_file_name_format = false;                        // Change to false to skip file name format check
var imbedded_progress_bar = true;                         // Change to false to use pop-up progress bar.
var upload_range = 1;                                    // Initialize the number of upload slots to 1 (Do Not Change)


//////////////////////////////////////////////////////////
// Make sure file names do not contain illegal characters.
//
// You may choose to skip this check and let the
// uploader simply 'normalize' the file name.
//////////////////////////////////////////////////////////
function checkFileNameFormat(){
	if(check_file_name_format == false){ return false; }

	for(var i = 0; i < upload_range; i++){
  		if(document.form_upload.elements['upfile_' + i].value != ""){
  			var string = document.form_upload.elements['upfile_' + i].value;
			var num_of_last_slash = string.lastIndexOf("\\");

			if(num_of_last_slash < 1){ num_of_last_slash = string.lastIndexOf("/"); }

			var file_name = string.slice(num_of_last_slash + 1, string.length);
			var re = /^[\w][\w\.\-]{1,100}$/i;

			if(!re.test(file_name)){
  				alert("Sorry, uploading files in this format is not allowed. Please ensure your file names follow this format. \n\n1. Entire file cannot exceed 100 characters\n2. Format should be filename.extention or filename\n3. Legal characters are 1-9, a-z, A-Z, '_', '-'\n");
  				return true;
  			}
  		}
  	}
	return false;
}

//////////////////////////////////////////////////////////////////////
// Disallow uploading files by extention (DO NOT REMOVE .sh OR .php)
//
// If you want prevent users from uploading a file based on extention
// simply modify the regular exression eg.
// var re = /(\.php)|(\.sh)|(\.gif)|(\.jpg)$/i;
// would prevent anyone from uploading .php, .sh, .gif, .jpg files.
//////////////////////////////////////////////////////////////////////
function checkFileExtentions(){
	if(check_file_extensions == false){ return false; }

  	var re = <? print $notalloweddfiletypes; ?>i;

  	for(var i = 0; i < upload_range; i++){
  		if(document.form_upload.elements['upfile_' + i].value != ""){
  			if(document.form_upload.elements['upfile_' + i].value.match(re)){
  				var string = document.form_upload.elements['upfile_' + i].value;
				var num_of_last_slash = string.lastIndexOf("\\");

				if(num_of_last_slash < 1){ num_of_last_slash = string.lastIndexOf("/"); }

				var file_name = string.slice(num_of_last_slash + 1, string.length);
				var file_extention = file_name.slice(file_name.indexOf(".")).toLowerCase();

  				alert('Sorry, uploading a file with the extention "' + file_extention + '" is not allowed.');
  				return true;
  			}
  		}
  	}
	return false;
}

///////////////////////////////////////////////////////
// Make sure user selected at least one file to upload
///////////////////////////////////////////////////////
function checkNullFileCount(){
  	if(check_null_file_count == false){ return false; }

  	var null_file_count = 0;

  	for(var i = 0; i < upload_range; i++){
  		if(document.form_upload.elements['upfile_' + i].value == ""){ null_file_count++; }
  	}

  	if(null_file_count == upload_range){
		this.location.href="index.php"
		return true;
  	}
  	else{ return false; }
}

////////////////////////////////////////////////////////
// Make sure user did not select duplicate file uploads
////////////////////////////////////////////////////////
function checkDuplicateFileCount(){
	if(check_duplicate_file_count == false){ return false; }

	var duplicate_flag = false;
	var file_count = 0;
	var duplicate_msg = "Duplicate Upload Files Detected.\n\n";
	var file_name_array = new Array();

	for(var i = 0; i < upload_range; i++){
		if(document.form_upload.elements['upfile_' + i].value != ""){
  			var string = document.form_upload.elements['upfile_' + i].value;
			var num_of_last_slash = string.lastIndexOf("\\");

			if(num_of_last_slash < 1){ num_of_last_slash = string.lastIndexOf("/"); }

			var file_name = string.slice(num_of_last_slash + 1, string.length);

			file_name_array[i] = file_name;
  		}
  	}

	for(var i = 0; i < file_name_array.length; i++){
		for(var j = 0; j < file_name_array.length; j++){
			if(file_name_array[i] == file_name_array[j] && file_name_array[i] != null){ file_count++; }
		}
		if(file_count > 1){
			duplicate_msg += 'Duplicate file "' + file_name_array[i] + '" detected in slot ' + (i + 1) + ".\n";
			duplicate_flag = true;
		}
		file_count = 0;
	}

	if(duplicate_flag){
		alert(duplicate_msg);
		return true;
	}
	else{ return false; }
}

//////////////////////////////////////////////////////
// Check files, submit upload and pop up progress bar
//////////////////////////////////////////////////////
function uploadFiles(){
	if(checkFileExtentions()){ return false; }
	if(checkNullFileCount()){ return false; }
	if(checkDuplicateFileCount()){ return false; }
	if(checkFileNameFormat()){ return false; }

	// If opera browser force pop-up mode
	if(window.opera){ imbedded_progress_bar = false; }

	if(imbedded_progress_bar){ document.form_upload.imbedded_progress_bar.value = 1; }
	else{ document.form_upload.imbedded_progress_bar.value = 0; }

	document.form_upload.upload_range.value = upload_range;
	document.form_upload.submit();
	document.progress_bar.upload_button.disabled = true;

	for(var i = 0; i < upload_range; i++){ document.form_upload.elements['upfile_' + i].disabled = true; }

	if(imbedded_progress_bar){
		var progress_link = "<? print $path_to_progress_script; ?>?tmp_sid=<? print $tmp_sid; ?>&config_file=<? print $config_file; ?>&imbedded_progress_bar=1";

		document.getElementById('progress_div').innerHTML = "<iframe name='progress_iframe' background-color='#EEEEEE' src='" + progress_link + "'frameborder='0' scrolling='no' width='600' height='110'></iframe>";

		//We've opened the progress bar in an iframe so we return false to prevent the progress form from posting
		return false;
	}
	else{
		var upWin = window.open('','pop_win_<? print "$tmp_sid"; ?>','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=550,height=170,left=360,top=250');

		if(window.focus){ upWin.focus(); }

		return true;
	}
}

//////////////////////////////
// Reset the form_upload form
//////////////////////////////
function resetForm(){

	for(var i = 0; i < upload_range; i++){
		document.form_upload.elements['upfile_' + i].disabled = false;
		document.form_upload.elements['upfile_' + i].value = "";
	}

	document.progress_bar.upload_button.disabled = false;
	document.getElementById('progress_div').innerHTML = "";
	document.form_upload.reset();
	stop_upload("");

}


function checksubmit()
{
if (document.getElementById("form").scode.value == <?php echo $secrandcode; ?> )
{
return false;
}
else
{

alert("You have entered the incorrect security code! Please try again.");

resetForm()
}

}


////////////////////////////
// Stop the current upload
////////////////////////////
function stop_upload(msg){
	if(imbedded_progress_bar){ document.getElementById('progress_div').innerHTML = msg; }

	try{ document.execCommand('Stop'); }
	catch(e){ window.stop(); }
}

////////////////////////////
// Add another upload slot
////////////////////////////
function addUploadSlot(num){
	if(num == upload_range){
		var up = document.getElementById('upload_slots');
		var dv = document.createElement("div");
		dv.innerHTML = '<img src="img/back.png" border=0 width=16 height=16> <input type="file" name="upfile_' + upload_range + '" size="60" onchange="addUploadSlot('+(upload_range + 1)+')">';
		up.appendChild(dv);
		upload_range++;
	}
}

</script>
<body style="background-color: #969696; color: #000000; font-family: arial, helvetica, sans_serif;" onLoad="resetForm()">
  <? print "<!-- TMP_SID: $tmp_sid -->\n"; ?>

  <div align="center">
    <form name="form_upload" method="post" id="form" enctype="multipart/form-data"  action="<? print $path_to_upload_script; ?>?tmp_sid=<? print $tmp_sid; ?>&config_file=<? print $config_file; ?>" style="margin: 0px; padding: 0px;">
      <input type="hidden" name="imbedded_progress_bar" value="0">
      <input type="hidden" name="upload_range" value="1">
      <!-- Include extra values you want passed to the upload script here. -->
      <!-- eg. <input type="text" name="email" value="5"> -->
      <!-- Access the value in the cgi with $query->param('email'); -->
      <!-- Access the value in the php finished page with $_POST_DATA['email']; -->
      <!-- DO NOT USE "upfile_" for any of your values. -->
      <div id="upload_slots">
      <img src="img/back.png" border=0 width=16 height=16> <input type="file" name="upfile_0" size="60" <? if($multi_upload_slots){ ?>onChange="addUploadSlot(1)"<? } ?> value="">
      </div><br>
      <input type="checkBox" onclick="if (this.checked) {agreeTerms()} else {denyTerms()}"> <? echo $lang[sinfo];?> <a href="?page=tos"><? echo $lang[tos];?></a>.<br /><br />
      <img src="img/dll.png" border=0 width=16 height=16> <a href="javascript:turnOn('layer1');"><? echo $lang[moreoptions];?></a><br>
      <div id="layer1" style="display:none;">
      <table border=0 cellspacing=2 cellpadding=2>
      <?php if($emailoption) { ?>
      <tr><td align=left>
      <? echo $lang[emailopt];?>:
      </td><td>
      <input type="text"  name="myemail" size="40" />
      </td><td>
      <i>(Optional)</i>
      </td></tr>
      <?php } ?>
      <?php if($descriptionoption) { ?>
      <tr><td align=left>
      <? echo $lang[desopt];?>:
      </td><td>
      <input type="text" name="descr" size="40" />
      </td><td>
      <i>(Optional)
      </td></tr>
      </td></tr>
      <?php } ?>
      <?php if($passwordoption) { ?>
      <tr><td align=left>
      <? echo $lang[passopt];?>:
      </td><td>
      <input type="password" name="pprotect" size="40" />
      </td><td>
      <i>(Optional)</i>
      </td></tr></table>
      <?php } ?>
      </div>
      <table border=0 cellspacing=2 cellpadding=2><tr><td align=left>
      <?php if($uploadsecuritycode) { ?><? echo 'Security Code:</td><td align=left> <font face="times new roman" color="#808080" size="5"><strong>'.$secrandcode."<strong></font></center>";?></td><td></td>
      <td align=left>
      Enter Code:
      </td><td align=left>
      <input type="text"  name="scode" size="2"  />
      </td><td>
      </td></tr></table>
      </center>
      <?php } ?>
      <div id="progress_div" align=center></div>
      <noscript><input type="submit" name="submit" value="Upload!" id="upload" /></noscript>
    </form><br />
    <form name="progress_bar" id="form" target="pop_win_<? print "$tmp_sid"; ?>" method="post" action="<? print $path_to_progress_script; ?>?tmp_sid=<? print $tmp_sid; ?>&config_file=<? print $config_file; ?>&imbedded_progress_bar=0" onSubmit="return uploadFiles();" style="margin: 0px; padding: 0px;">

      <center><script language="javascript" type="text/javascript">
      <!--
        document.writeln('<input type="submit" name="upload_button" value="Upload" id="upload" onclick="checksubmit()"> <input type="button" name="reset_button" value="Reset" onClick="resetForm();">');
      //-->
      </script>
    </form>
</div>
</td></tr></table>
</center></td></tr></table><p style="margin:3px;text-align:center">