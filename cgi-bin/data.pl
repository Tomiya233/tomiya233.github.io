#!/usr/bin/perl -w

#**********************************************************************************************************************************
#   ATTENTION: THIS FILE HEADER MUST REMAIN INTACT. DO NOT DELETE OR MODIFY THIS FILE HEADER.
#
#   Name: uber_uploader.pl
#   Link: http://uber-uploader.sourceforge.net/
#   Revision: 3.7.1
#   Date: 2006/10/07
#   Author: Peter Schmandra  www.webdice.org
#   Description: Upload files to a temp dir based on Session-id, transfer files to upload dir and output results or redirect.
#
#   Credits:
#   I would like to thank the following people who helped create
#   and improve Uber-Uploader by providing code, ideas, insperation,
#   bug fixes and valuable feedback. If you feel you should be included
#   in this list, please post a message in the 'Open Discussion'
#   forum of the Uber-Uploader project page requesting a contributor credit.
#
#   Art Bogdanov             www.sibsoft.net/xupload.html
#   Bill                     www.rebootconcepts.com
#   Detlev Richter
#   Erik Guilfoyle
#   Feyyaz Oezdemir
#   Jeroen Soeters
#   Kim Steinhaug
#   Nico Hawley-Weld
#   Raditha Dissanyake       www.raditha.com/megaupload/
#   Tolriq
#   Tore B. Krudtaa
#
#   Licence:
#   The contents of this file are subject to the Mozilla Public
#   License Version 1.1 (the "License"); you may not use this file
#   except in compliance with the License. You may obtain a copy of
#   the License at http://www.mozilla.org/MPL/
#
#   Software distributed under the License is distributed on an "AS
#   IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or
#   implied. See the License for the specific language governing
#   rights and limitations under the License.
#
#**********************************************************************************************************************************

my $start_time = time();                                                     # Timestamp of the start of the upload

# Makes %ENV Safer (Programming Perl By Oreilly pg.560)
$ENV{'PATH'} = '/bin:/usr/bin';
delete @ENV{'IFS', 'CDPATH', 'ENV', 'BASH_ENV'};

use CGI qw(:cgi);                                                            # Load the CGI.pm module
use CGI::Carp('fatalsToBrowser');                                            # Display fatal errors in browser

my $uber_version = "3.5.1";                                                  # Version of Uber Uploader
my $driver_version = "3.7.1";                                                # Version of this driver
my $debug_cgi = 0; # ATTENTION: SET THIS BACK TO 0 WHEN YOU GO LIVE          # Set to 1 to debug and call ( eg. www.yoursite.com/cgi-bin/uber_uploader.pl?cmd=debug&config_file=UberUpload)

###############################################################
# The following possible query string formats are assumed
#
# 1. ?tmp_sid=some_sid_number&config_file=some_config_file_name
# 2. ?cmd=debug&config_file=some_config_file_name
# 3. ?cmd=version
###############################################################
my($get_1_key, $get_1_val, $get_2_key, $get_2_val) = split(/[&=]/, $ENV{'QUERY_STRING'});

#################################################################
# Attempt to load the config file that was passed to the script.
# If the config file cannot be found, load the default config
# file 'UberUploads.pm'. If no config file name was passed to the
# script at all, load the default config file 'UberUploads.pm'
#################################################################
if($get_2_key eq 'config_file'){
	my $module = $get_2_val;
	unless(eval "require configs::$module"){
		if($@){
			unless(eval "require configs::UberUploads"){
				if($@){ &kak("<font color='red'>ERROR<\/font>: Could not load config file $module" . ".pm or default config file UberUploads.pm<br>$@\n", 1, __LINE__); }
			}
		}
	}
}
elsif($get_2_key ne 'config_file'){
	unless(eval "require configs::UberUploads"){
		if($@){ &kak("<font color='red'>ERROR<\/font>: Could not load default config file UberUploads.pm<br>$@\n", 1, __LINE__); }
	}
}

# Check query string for commands sent to script
if($get_1_key eq 'cmd' && $get_1_val eq 'debug' && $debug_cgi){ &debug(); }
elsif($get_1_key eq 'cmd' && $get_1_val eq 'debug' && !$debug_cgi){ &kak("<u><b>UBER UPLOADER CGI SETTINGS<\/b><\/u><br> DEBUG_CGI = <b>disabled<\/b><br>\n", 1, __LINE__); }
elsif($get_1_key eq 'cmd' && $get_1_val eq 'version'){ &kak("<u><b>UBER UPLOADER VERSION</b><\/u><br> UBER UPLOADER VERSION = <b>" . $uber_version . "<\/b><br> CGI DRIVER VERSION = <b>" . $driver_version . "<\/b><br>\n", 1, __LINE__); }
elsif($get_1_key eq 'tmp_sid' && length($get_1_val) != 32){ &kak("<font color='red'>ERROR<\/font>: Invalid session-id $get_1_val.<br>\n", 1, __LINE__); }
elsif(length($ENV{'QUERY_STRING'}) == 0){ &kak("<font color='red'>ERROR<\/font>: Invalid parameters passed to uber_uploader.pl.<br>\n", 1, __LINE__); }

my $tmp_sid = $get_1_val;                                                           # Get the session-id for temp files
$tmp_sid =~ s/[^a-zA-Z0-9]//g;                                                      # Sanitise session-id

my $sleep_time = 1;                                                                 # Seconds to wait before upload proceeds (for small file uploads)
my $print_issued = 0;                                                               # Tracks print content type command
my %uploaded_files = ();                                                            # Hash with all the uploaded file names
my $temp_dir_sid = $config->{temp_dir} . $tmp_sid;                                  # Append Session-id to upload temp directory
my $flength_file = $temp_dir_sid . '/flength';                                      # Flength file is used to store the size of the upload in bytes

umask(0);
$|++;                                                                               # Force auto flush of output buffer
$SIG{HUP} = 'IGNORE';                                                               # Ignore sig hup
local $SIG{__DIE__} = \&cleanup;                                                    # User has pressed stop during upload so deal with it
$CGI::POST_MAX = $config->{max_upload};                                             # Set the max post value

# Create temp directory if it does not exist
if(!-d $config->{temp_dir}){ mkdir($config->{temp_dir}, 0777) or &kak("<font color='red'>ERROR</font>: Can't mkdir $config->{temp_dir}: $!", 1, __LINE__); }

# Create a temp directory based on Session-id
if(!-d $temp_dir_sid){ mkdir($temp_dir_sid, 0777) or &kak("<font color='red'>ERROR</font>: Can't mkdir $temp_dir_sid: $!", 1, __LINE__); }
else{
	&deldir($temp_dir_sid);
	mkdir($temp_dir_sid, 0777) or &kak("<font color='red'>ERROR</font>: Can't mkdir $temp_dir_sid: $!", 1, __LINE__);
}

# Prepare the flength file for writing
open FLENGTH, ">$flength_file" or &kak("<font color='red'>ERROR</font>: Can't open $temp_dir_sid/flength: $!", 1, __LINE__);

if($ENV{'CONTENT_LENGTH'} > $config->{max_upload}){
	# If file size exceeds maximum write error to flength file and exit
	my $max_size = &format_bytes($config->{max_upload}, 99);

	print FLENGTH "<font color='red'>ERROR</font>: Maximum upload size of $max_size exceeded.<br><br>Your upload has failed.<br><br>";
	close(FLENGTH);
	chmod 0666, $flength_file;

	&kak("<font color='red'>ERROR</font>: Maximum upload size of $max_size exceeded.<br><br>Your upload has failed.<br>", 1, __LINE__);
}
else{
	# Write total upload size in bytes to flength file
	print FLENGTH $ENV{'CONTENT_LENGTH'};
	close(FLENGTH);
	chmod 0666, $flength_file;
}

# Let progress bar get some info (for small file uploads)
sleep($sleep_time);

# Tell CGI.pm to use our directory based on Session-id
if($TempFile::TMPDIRECTORY){ $TempFile::TMPDIRECTORY = $temp_dir_sid; }
elsif($CGITempFile::TMPDIRECTORY){ $CGITempFile::TMPDIRECTORY = $temp_dir_sid; }
else{ &kak("<font color='red'>ERROR</font>: Cannot assign CGI temp directory", 1, __LINE__); }

my $query = new CGI;

###################################################################################################################
# The upload is complete at this point, so you can now access any post value by $query->param("some_post_value");
###################################################################################################################

###################################################################################################################
# IF you are modifying the upload directory with a post value, DO IT HERE!!!
#
# You must override the $config->{upload_dir} value
# If you are linking to the file you must also override the $config->{path_to_upload} value
#
# eg. $config->{upload_dir} = $ENV{'DOCUMENT_ROOT'} .  '/' . $query->param("employee_num") . '/';
# eg. $config->{path_to_upload} = 'http://'. $ENV{'SERVER_NAME'} . '/' . $query->param("employee_num") . '/';
###################################################################################################################

$query->param('myemail');
$query->param('pprotect');
$query->param('descr');

# Create upload directory if it does not exist
if(!-d $config->{upload_dir}){ mkdir($config->{upload_dir}, 0777) or &kak("<font color='red'>ERROR</font>: Can't mkdir $config->{upload_dir}: $!", 1, __LINE__); }

# If we are using rename, make sure it's the same disk
if($config->{create_files_by_rename}){
	my $dev_temp_dir = (stat($config->{temp_dir}))[0];
	my $dev_upload_dir = (stat($config->{upload_dir}))[0];

	# We have have two disks so use copy instead (can't rename across disks/mounts)
	if($dev_temp_dir != $dev_upload_dir){ $config->{create_files_by_rename} = 0; }
}

# Upload is finished, start creating files in the upload directory
for(my $i = 0; $i < $query->param('upload_range'); $i++){
	my ($upload_filehandle, $tmp_filename);
	my $file_name = $query->param('upfile_' . $i);

	# Remove all the path info from the file name (IE)
	$file_name =~ s/.*[\/\\](.*)/$1/;
	my($f_name, $file_extention) = ($file_name =~ /(.+)\.(.+)/);

	# If slot is not empty, construct a file handle and get the temp name of the file
	if($file_name ne ""){
		$upload_filehandle = $query->param("upfile_" . $i);
		$tmp_filename = $query->tmpFileName($upload_filehandle);
	}

	# Do not process blank upload slots, zero length files or executable files
	if(($file_name ne "") && (-s $tmp_filename) && ($file_extention !~ m/$config->{disallow_extentions}$/i)){
		# Normalize file name if enabled in config
		if($config->{normalize_file_names}){ $file_name = &normalize_filename($file_name, $config->{normalize_file_delimiter}, $config->{normalize_file_length}); }

		# Check for an existing file and rename if it already exists
		if(!$config->{overwrite_existing_files}){ $file_name = &rename_filename($file_name, 1); }

		########################################################################
		# IF you are modifying the file name with a post value, DO IT HERE!!!
		# eg. $file_name = $file_name . "_" . $query->param("employee_num");
		########################################################################

		my $upload_file_path = $config->{upload_dir} . $file_name;

		if($config->{create_files_by_rename}){
			# Create uploaded files by rename (fast)
			close($upload_filehandle);
			rename($tmp_filename, $upload_file_path) or warn("Cannot rename from $tmp_filename to $upload_file_path: $!");
		}
		else{
			# Create uploaded files by copy (slow but works across disks and mounts)
			open(UPLOADFILE, ">$upload_file_path");
			binmode UPLOADFILE;

			while(<$upload_filehandle>){ print UPLOADFILE; }

			close(UPLOADFILE);
		}

		chmod 0666, $upload_file_path;
	}

	if($file_name ne ""){ $uploaded_files{$file_name}{'upfile_' . $i} = 0; }
}

# Delete the temp directory based on session-id and everything in it
&deldir($temp_dir_sid);

# Redirect to php page if redirect enabled else display results
if($config->{redirect_after_upload}){
	my $param_file_path = $config->{temp_dir} . $tmp_sid . ".params";
	my @names = $query->param;
	my $redirect_url = $config->{redirect_url};

	# We are re-directing so write a session-id.param file with all the post values
	open PARAMS, ">$param_file_path" or &display_results_through_cgi();
	binmode PARAMS;

	# Write post values to param file (we do not write the files names at this point)
	foreach my $key (@names){
		my $post_value = $query->param($key);
		$post_value =~ s/(\r\n|\n|\r)/~NWLN~/g;
		$post_value =~ s/=/~EQLS~/g;

		if($post_value ne "" && $key !~ m/^upfile_/){ print PARAMS "$key=$post_value\n"; }
	}

	# Pass the path to the upload directory and start time
	print PARAMS "upload_dir=$config->{upload_dir}\n";
	print PARAMS "start_time=$start_time\n";

	# If link to upload is set, pass the path_to_upload url
	if($config->{link_to_upload}){
		print PARAMS "link_to_upload=1\n";
		print PARAMS "path_to_upload=$config->{path_to_upload}\n";
	}
	else{ print PARAMS "link_to_upload=0\n"; }

	# Pass the imbedded_progress_bar state
	if($query->param('imbedded_progress_bar')){ print PARAMS "imbedded_progress_bar=1\n"; }
	else{ print PARAMS "imbedded_progress_bar=0\n"; }

	# If email on upload, pass all the email info
	if($config->{send_email_on_upload}){
		print PARAMS "send_email_on_upload=1\n";
		print PARAMS "email_subject=$config->{email_subject}\n";
		print PARAMS "html_email_support=$config->{html_email_support}\n";
		print PARAMS "to_email_address=$config->{to_email_address}\n";
		print PARAMS "from_email_address=$config->{from_email_address}\n";
	}
	else{ print PARAMS "send_email_on_upload=0\n"; }

	# Write upload file names to param file
	for my $file_name (keys %uploaded_files){
		for my $upload_slot ( keys %{ $uploaded_files{$file_name} } ){
			print PARAMS "$upload_slot=$file_name\n";
		}
	}

	close(PARAMS);

	chmod 0666, $param_file_path;

	##############################################################################################################
	# If you do not want the path to the temp dir passed in the address bar simply remove it from the redirect.
	# However, you will also need to hardcode the $temp_dir value in uber_uploader_finished.php.
	#
	# eg. $redirect_url .= "?tmp_sid=$tmp_sid";
	###############################################################################################################

	# Append the session-id and path to the temp dir to the redirect url.
	$redirect_url .= "?tmp_sid=$tmp_sid&temp_dir=$config->{temp_dir}";

	if($config->{redirect_using_html}){
		print "Content-type: text/html\n\n";
		print "<meta http-equiv=\"refresh\" content=\"0; url='$redirect_url'\">\n";
	}
	else{
		# Uncomment next line if using Webstar V
		# print "HTTP/1.1 302 Redirection\n";
		print "Location: $redirect_url\n\n";
	}
}
else{ &display_results_through_cgi(); }

exit;


######################################################### START SUBROUTINES ###################################################

########################################
# Delete the temp dir based on tmp_sid
########################################
sub cleanup{ deldir($temp_dir_sid); }

#####################################
# Display upload results through cgi
#####################################
sub display_results_through_cgi{
	&confirm_upload();
	&display_results();
}

#####################################################
# Confirm uploaded file exist and get size file size
#####################################################
sub confirm_upload{
	for my $file_name (keys %uploaded_files){
		for my $upload_slot ( keys %{ $uploaded_files{$file_name} } ){
			my $path_to_file = $config->{upload_dir} . $file_name;

			if(-e $path_to_file && -f $path_to_file){ $uploaded_files{$file_name}{$upload_slot} = -s $path_to_file; }
		}
	}
}

####################################
# Format the upload result and exit
####################################
sub display_results{
	my ($upload_result, $email_file_list, $bg_col, $buffer, $js_code) = ();
	my $i = 0;

	# Loop over the file names creating table elements
	for my $file_name (keys %uploaded_files){
		if($i%2){ $bg_col = 'cccccc'; }
    		else{ $bg_col = 'dddddd'; }

		for my $upload_slot ( keys %{ $uploaded_files{$file_name} } ){
			if($uploaded_files{$file_name}{$upload_slot} > 0){
				my $file_size = &format_bytes($uploaded_files{$file_name}{$upload_slot}, 99);

				if($config->{link_to_upload}){
					$upload_result .= "<tr><td align='center' bgcolor='$bg_col'><a href=\"$config->{path_to_upload}$file_name\" TARGET=\"_blank\">$file_name</a><\/td><td align='center' bgcolor='$bg_col'>$file_size<\/td><\/tr>\n";
				}
				else{
					$upload_result .= "<tr><td align='center' bgcolor='$bg_col'>&nbsp;$file_name&nbsp;<\/td><td align='center' bgcolor='$bg_col'>$file_size<\/td><\/tr>\n";
				}

				$email_file_list .= "File Name: $file_name     File Size: $file_size\n";
			}
			else{
				$upload_result .= "<tr><td align='center' bgcolor='$bg_col'>&nbsp;$file_name&nbsp;<\/td><td align='center' bgcolor='$bg_col'><font color='red'>Failed To Upload<\/font><\/td><\/tr>\n";
				$email_file_list .= "File Name: $file_name     File Size: Failed To Upload !\n";
			}
		}

		$i++;
	}

	# If we are using a pop-up progress bar, add code to close it
	if(!$query->param('imbedded_progress_bar')){
		$js_code =  "popwin = window.open('','pop_win_$tmp_sid','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=10,height=10,left=10,top=10');\n";
  	  	$js_code .= "popwin.focus();\n";
  	  	$js_code .= "popwin.document.writeln('<html><body onload=\"javascript:self.close();\"></body></html>');\n";
    	  	$js_code .= "popwin.document.close();\n";
	}
	else{ $js_code = ""; }

	# Open and read the upload finished template file
	open(TEMPLATE, $config->{finished_template}) or &kak("<font color='red'>ERROR</font>: Can't open $config->{finished_template}: $!", 1, __LINE__);
	my @template = <TEMPLATE>;
	close(TEMPLATE);

	# Perform a search and replace on the template
	foreach my $line (@template){
 		$line =~ s/<!-- cgi:js_code -->/$js_code/i;
		$line =~ s/<!-- cgi:upload_result -->/$upload_result/i;
		$buffer .= $line;
	}

	if(!$print_issued){ print "Content-type: text/html\n\n"; }
	print $buffer;

	if($config->{send_email_on_upload}){ &email_upload_results($email_file_list); }
}

##########################################
#  Send an email with the upload results.
##########################################
sub email_upload_results{
	my $file_list = shift;
	my $path_to_sendmail = "/usr/sbin/sendmail -t";
	my $message;
	my ($ssec, $smin, $shour, $smday, $smon, $syear, $swday, $syday, $sisdst) = localtime($start_time);
	my $end_time = time();
	my ($esec, $emin, $ehour, $emday, $emon, $eyear, $ewday, $eyday, $eisdst) = localtime($end_time);
	my @abbr = ('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

	$eyear += 1900;
	$syear += 1900;

	if(open(SENDMAIL, "|$path_to_sendmail")){
		print SENDMAIL "From:" . $config->{from_email_address} . "\n";
		print SENDMAIL "To:" . $config->{to_email_address} . "\n";
		print SENDMAIL "Subject:" . $config->{email_subject} . "\n";

		if($config->{html_email_support}){
			print SENDMAIL 'MIME-Version: 1.0' . "\r\n";
			print SENDMAIL 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		}
		else{ print SENDMAIL "Content-type: text/plain\n\n"; }

		$message = "\nStart Upload (epoch): " . $start_time . "\n";
		$message .= "End Upload (epoch): " . $end_time . "\n";
		$message .= "Start Upload: " . $abbr[$smon] . " " . $smday . ", " . $syear . ", " .  $shour . ":" . $smin . ":" . $ssec . "\n";
		$message .= "End Upload: " . $abbr[$emon] . " " . $emday . ", " . $eyear . ", " .  $ehour . ":" . $emin . ":" . $esec . "\n";
		$message .= "SID: ". $tmp_sid . "\n";
		$message .= "Remote IP: " . $ENV{'REMOTE_ADDR'}  . "\n";
		$message .= "Browser: " . $ENV{'HTTP_USER_AGENT'} . "\n\n";
		$message .= $file_list;

		print SENDMAIL $message;
		close(SENDMAIL);
	}
	else{ warn("Failed to open sendmail $!"); }
}

####################################################
#  formatBytes($file_size, 99) mixed file sizes
#  formatBytes($file_size, 0) KB file sizes
#  formatBytes($file_size, 1) MB file sizes etc
####################################################
sub format_bytes{
	my $bytes = shift;
	my $byte_format = shift;
	my $byte_size = 1024;
	my $i = 0;
	my @byte_type = (" KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");

	$bytes /= $byte_size;

	if($byte_format == 99 || $byte_format > 7){
		while($bytes > $byte_size){
			$bytes /= $byte_size;
			$i++;
		}
	}
	else{
		while($i < $byte_format){
			$bytes /= $byte_size;
			$i++;
		}
	}

	$bytes = sprintf("%1.2f", $bytes);
	$bytes .= $byte_type[$i];

	return $bytes;
}

#####################################################################
# Print config, driver settings and 'Environment Variables' to screen
#####################################################################
sub debug{
	my ($msg, $temp_dir_state, $upload_dir_state) = ();

	if(!-d $config->{temp_dir}){ $temp_dir_state = "<font color='red'>$config->{temp_dir}<\/font>"; }
	else{ $temp_dir_state = "<font color='green'>$config->{temp_dir}<\/font>"; }

	if(!-d $config->{upload_dir}){ $upload_dir_state = "<font color='red'>$config->{upload_dir}<\/font>"; }
	else{ $upload_dir_state = "<font color='green'>$config->{upload_dir}<\/font>"; }

	$msg .= "<u><b>UBER UPLOADER CGI SETTINGS<\/b><\/u><br>\n";
	$msg .= "UBER UPLOADER VERSION = <b>$uber_version<\/b><br>\n";
	$msg .= "CGI DRIVER VERSION = <b>$driver_version<\/b><br>\n";
	$msg .= "CONFIG_FILE = <b>$config->{config_file_name}<\/b><br>\n";
	$msg .= "TEMP_DIR = <b>$temp_dir_state<\/b><br>\n";
	$msg .= "UPLOAD_DIR = <b>$upload_dir_state<\/b><br>\n";
	$msg .= "MAX_UPLOAD = <b>" . format_bytes($config->{max_upload}, 99) . "<\/b><br>\n";
	$msg .= "GET_DATA_SPEED = <b>$config->{get_data_speed}<\/b><br>\n";

	if($config->{create_files_by_rename}){ $msg .= "CREATE_FILES_BY_RENAME = <b><font color='green'>enabled</font><\/b><br>\n"; }
	else{ $msg .= "CREATE_FILES_BY_RENAME = <b><font color='red'>disabled</font><\/b><br>\n"; }

	if($config->{overwrite_existing_files}){ $msg .= "OVERWRITE_EXISTING_FILES = <b><font color='green'>enabled</font><\/b><br>\n"; }
	else{ $msg .= "OVERWRITE_EXISTING_FILES = <b><font color='red'>disabled</font><\/b><br>\n"; }

	if($config->{normalize_file_names}){ $msg .= "NORMALIZE_FILE_NAMES = <b><font color='green'>enabled</font><\/b><br>\n"; }
	else{ $msg .= "NORMALIZE_FILE_NAMES = <b><font color='red'>disabled</font><\/b><br>\n"; }

	if($config->{normalize_file_names}){ $msg .= "NORMALIZE_FILE_LENGTH = <b>$config->{normalize_file_length} chars<\/b><br>\n"; }

	if($config->{normalize_file_names}){ $msg .= "NORMALIZE_FILE_DELIMITER = <b>$config->{normalize_file_delimiter}<\/b><br>\n"; }

	if($config->{link_to_upload}){
		$msg .= "LINK_TO_UPLOAD = <b><font color='green'>enabled</font><\/b><br>\n";
		$msg .= "PATH_TO_UPLOAD = <a href=\"$config->{path_to_upload}\">$config->{path_to_upload}</a><br>\n";
	}
	else{ $msg .= "LINK_TO_UPLOAD = <b><font color='red'>disabled</font><\/b><br>\n"; }

	if($config->{send_email_on_upload}){
		$msg .= "SEND_EMAIL_ON_UPLOAD = <b><font color='green'><a href=\"mailto:$config->{to_email_address}?subject=Uber Uploader Email Test\">enabled</a></font><\/b><br>\n";
		$msg .= "EMAIL_SUBJECT = <b>$config->{email_subject}<\/b><br>\n";

		if($config->{html_email_support}){ $msg .= "HTML_EMAIL_SUPPORT = <b><font color='green'>enabled</font><\/b><br>\n"; }
		else{ $msg .= "HTML_EMAIL_SUPPORT = <b><font color='red'>disabled</font><\/b><br>\n"; }
	}
	else{ $msg .= "SEND_EMAIL_ON_UPLOAD = <b><font color='red'>disabled</font><\/b><br>\n"; }

	if($config->{redirect_after_upload}){
		$msg .= "REDIRECT_AFTER_UPLOAD = <b><font color='green'>enabled</font><\/b><br>\n";

		if($config->{redirect_using_html}){ $msg .= "REDIRECT_USING_HTML = <b><font color='green'>enabled</font><\/b><br>\n"; }
		else{ $msg .= "REDIRECT_USING_HTML = <b><font color='red'>disabled</font><\/b><br>\n"; }

		$msg .= "REDIRECT_URL = <a href=\"$config->{redirect_url}?cmd=version\">$config->{redirect_url}<\/a><br>\n";
	}
	else{ $msg .= "REDIRECT_AFTER_UPLOAD = <b><font color='red'>disabled</font><\/b><br>\n"; }

	$msg .= "GET_DATA_URL = <a href=\"$config->{get_data_url}?cmd=version\">$config->{get_data_url}<\/a><br><br>\n";
	$msg .= "<u><b>ENVIRONMENT VARIABLES<\/b><\/u><br>\n";

	foreach my $key (sort keys(%ENV)){ $msg .= "$key = <b>$ENV{$key}<\/b><br>\n"; }

	&kak($msg, 1, __LINE__);
}

########################################################################
# Output a message to the screen
#
# You can use this function to debug your script.
#
# eg. &kak("The value of blarg is: " . $blarg . "<br>", 1, __LINE__);
# This will print the value of blarg and exit the script.
#
# eg. &kak("The value of blarg is: " . $blarg . "<br>", 0, __LINE__);
# This will print the value of blarg and continue the script.
########################################################################
sub kak{
	my $msg = shift;
	my $kak_exit = shift;
	my $line  = shift;

	if(!$print_issued){
		print "Content-type: text/html\n\n";
		$print_issued = 1;
	}

	print "<!DOCTYPE HTML PUBLIC \"-\/\/W3C\/\/DTD HTML 4.01 Transitional\/\/EN\">\n";
	print "<html>\n";
	print "  <head>\n";
	print "    <title>UBER UPLOADER<\/title>\n";
	print "      <META NAME=\"ROBOTS\" CONTENT=\"NOINDEX\">\n";
	print "      <meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
	print "      <meta http-equiv=\"CACHE-CONTROL\" content=\"no-cache\">\n";
	print "      <meta http-equiv=\"expires\" content=\"-1\">\n";
	print "  <\/head>\n";
	print "  <body style=\"background-color: #227B81; color: #000000; font-family: arial, helvetica, sans_serif; font-size:10px;\">\n";
	print "    <br>\n";
	print "    <div align='center'>\n";
	print "    $msg\n";
	print "    <br>\n";
	print "    <!-- uber_uploader.pl:kak on line $line -->\n";
	print "    </div>\n";
	print "  </body>\n";
	print "</html>\n";

	if($kak_exit){ exit; }
}

#########################################
# Delete a directory and everthing in it
#########################################
sub deldir{
	my $del_dir = shift;

	if(-d $del_dir){
		if(opendir(DIRHANDLE, $del_dir)){
			my @file_list = readdir(DIRHANDLE);

			closedir(DIRHANDLE);

			foreach my $file (@file_list){
				unless( ($file eq ".") || ($file eq "..") ){ unlink($del_dir . "/" . $file); }
			}

			for(my $i = 0; $i < 5; $i++){
				if(rmdir($del_dir)){ last; }
				else{ sleep(1); }
			}
		}
		else{ warn("Cannont open $del_dir: $!"); }
	}
}

############################################
# Rename uploaded file if it already exists
############################################
sub rename_filename{
	my $file_name = shift;
	my $count = shift;
	my $path_to_file = $config->{upload_dir} . $file_name;

	if(-e $path_to_file && -f $path_to_file){
		if($file_name =~ /(.*)_(\d*)\.(.*)/){
			# Already renamed so count on
			$count = $2 + 1 ;
			$file_name =~ s/(.*)_(\d*)\.(.*)/$1_$count\.$3/;
		}
		else{
			# not renamed so start counting
			$file_name =~ s/(.*)\.(.*)/$1_$count\.$2/;
		}
		&rename_filename($file_name, $count);
	}
	else{ return $file_name; }
}

#######################
# Normalize file name
######################
sub normalize_filename{
	my $file_name = shift;
	my $delimiter = shift;
	my $max_file_length = shift;

	if(length($file_name) > $max_file_length){ $file_name = substr($file_name, length($file_name) - $max_file_length); }

	$file_name =~ s/[^a-zA-Z0-9\_\.\-]/$delimiter/g;

	return $file_name;
}