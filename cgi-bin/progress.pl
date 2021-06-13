#!/usr/bin/perl -w

#******************************************************************************************************
#   ATTENTION: THIS FILE HEADER MUST REMAIN INTACT. DO NOT DELETE OR MODIFY THIS FILE HEADER.
#
#   Name: uber_uploader_progress.pl
#   Link: http://uber-uploader.sourceforge.net/
#   Revision: 1.3.1
#   Date: 2006/10/07
#   Author: Peter Schmandra
#   Description: Creates a progress bar
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
#************************************************************************************************************************************

# Makes %ENV Safer (Programming Perl By Oreilly pg.560)
$ENV{'PATH'} = '/bin:/usr/bin';
delete @ENV{'IFS', 'CDPATH', 'ENV', 'BASH_ENV'};

use CGI::Carp('fatalsToBrowser');                                   # Display fatal errors in browser

my $uber_version = "3.5.1";                                           # Version of Uber Uploader
my $driver_version = "1.3.1";                                         # Version of this driver

###########################################################################################
# The following possible query string formats are assumed
#
# 1. ?tmp_sid=some_sid_number&config_file=some_config_name&imbedded_progress_bar= 1 or 0
# 2. ?close_pop=1
# 3. ?cmd=version
###########################################################################################
my($get_1_key, $get_1_val, $get_2_key, $get_2_val, $get_3_key, $get_3_val) = split(/[&=]/, $ENV{'QUERY_STRING'});

# Check query string sent to script
if($get_1_key eq 'cmd' && $get_1_val eq 'version'){ &kak("<u><b>UBER UPLOADER AJAX PROGRESS PAGE</b></u><br> UBER UPLOADER VERSION = <b>" . $uber_version . "<\/b><br>AJAX PROGRESS DRIVER VERSION (PERL) = <b>" . $driver_version . "<b><br>\n", 1, 0, __LINE__); }
elsif($get_1_key eq 'tmp_sid' && length($get_1_val) != 32){ &kak("<font color='red'>ERROR<\/font>: Invalid session-id $get_1_val.<br>\n", 1, 0, __LINE__); }
elsif(length($ENV{'QUERY_STRING'}) == 0){ &kak("<font color='red'>ERROR<\/font>: Invalid parameters passed to uber_uploader_progress.pl.<br>\n", 1, 0, __LINE__); }

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
				if($@){
					&kak("<font color='red'>ERROR<\/font>: Could not load config file $module" . ".pm or default config file UberUploads.pm<br>\n$@", 1, 0, __LINE__);
				}
			}
		}
	}
}
elsif($get_2_key ne 'config_file'){
	unless(eval "require configs::UberUploads"){
		if($@){
			&kak("<font color='red'>ERROR<\/font>: Could not load default config file UberUploads.pm<br>\n$@", 1, 0, __LINE__);
		}
	}
}

my $tmp_sid = $get_1_val;                                       # Get the session-id for temp files
$tmp_sid =~ s/[^a-zA-Z0-9]//g;                                  # Sanitise session-id
my $temp_dir_sid = $config->{temp_dir} . $tmp_sid;              # temp_dir/session-id
my $flength_file = $temp_dir_sid . "/flength";                  # temp_dir/session-id/flength
my $flength_file_exists = 0;
my $total_upload_size = 0;
my $buffer = "";

# Keep trying to find the flength file for 10 secs
for(my $i = 0; $i < 10; $i++){
	if(-e $flength_file && -r $flength_file){
		# We found the flength file
		$flength_file_exists = 1;

		open(FLENGTH, $flength_file);
		$total_upload_size = <FLENGTH>;
		close(FLENGTH);

		last;
	}
	else{ sleep(1); }
}

#####################################################################################
# Ok, we couldn't find the flength file after 10 seconds. This means
#
# a. The upload was so fast the flength file was deleted before it could be read.
# b. The flength file does not exist because the script is not set up properly.
# c. The flength file does not exist due to some kind of server caching.
#
# More info can be found at http://uber-uploader.sourceforge.net/?section=flength
#
# So, issue "Failed to find flength file" and exit. Upload may succeed anyway.
#####################################################################################
if(!$flength_file_exists){ &kak("<b>Failed to find flength file</b><br>$flength_file<br><a href=\"http://uber-uploader.sourceforge.net/?section=flength\"><br>Click Here For Help</a><br>" , 1, 0, __LINE__); }

######################################################################
# Found the flength file but it contains the max file upload error.
# Clean up the temp directories, issue error and exit.
######################################################################
if($total_upload_size =~ m/ERROR/g){
	&deldir($temp_dir_sid);

	if($get_3_key eq 'imbedded_progress_bar' && $get_3_val == 0){ &kak($total_upload_size, 1, 1, __LINE__); }
	else{
		print "Content-type: text/html\n\n";
		print "<script language=\"javascript\" type=\"text/javascript\">\n";
		print "  parent.stop_upload(\"$total_upload_size\");\n";
		print "</script>\n";
		exit;
	}
}

# Open and read the progress template file
open(TEMPLATE, $config->{progress_template}) or &kak("<font color='red'>ERROR</font>: Can't open uber_uploader_progress.tmpl: $!", 1, 0, __LINE__);
my @template = <TEMPLATE>;
close(TEMPLATE);

# Total upload size in Kilobytes
my $total_kbytes = sprintf("%d", $total_upload_size / 1024);

# Formatted URL used for the AJAX call in uber_uploader_get_data.php
my $get_data_url = $config->{get_data_url} . '?temp_dir_sid=' . $temp_dir_sid . '&start_time=' . time() . '&total_upload_size=' . $total_upload_size;

# Perform a search and replace on the progress template ($line =~ s/search_text/replace_text/)
foreach my $line (@template){
	$line =~ s/<!-- cgi:get_data_speed -->/$config->{get_data_speed}/;
 	$line =~ s/<!-- cgi:get_data_url -->/$get_data_url/;
	$line =~ s/<!-- cgi:total_kbytes -->/$total_kbytes/;
	$buffer .= $line;
}

# Dump the contents of the template to screen
print "Content-type: text/html\n\n";
print $buffer;
exit;

##############################################################
# Output a message to the screen
##############################################################
sub kak{
	my $msg = shift;
	my $kak_exit = shift;
	my $stop_upload = shift;
	my $line = shift;

	print "Content-type: text/html\n\n";
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
	print "    <!-- uber_uploader_progress.pl:kak on line $line -->\n";
	print "    </div>\n";

	if($stop_upload){ print "<script language=\"javascript\" type=\"text/javascript\">opener.stop_upload();</script>\n"; }

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