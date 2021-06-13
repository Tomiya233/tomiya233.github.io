
$config = {
config_file_name         => 'Uploads',
temp_dir                 => $ENV{'DOCUMENT_ROOT'} . '/mfh/temp/',
upload_dir               => $ENV{'DOCUMENT_ROOT'} . '/mfh/storage/',
create_files_by_rename   => 1,
max_upload               => 104860000,
overwrite_existing_files => 0,
redirect_after_upload    => 1,
redirect_using_html      => 0,
redirect_url             => 'http://' . $ENV{'SERVER_NAME'} . '/mfh/upload.php',
get_data_url             => 'http://' . $ENV{'SERVER_NAME'} . '/mfh/data.php',
get_data_speed           => 800,
disallow_extentions      => '(\.sh)|(\.php)|(\.php2)|(\.php3)|(\.php4)|(\.php5)|(\.php6)|(\.shtml)|(\.htaccess)|(\.cgi)|(\.pl)|(\.phtml)|(\.phtm)|(\.pif)|(\.xhtml)|(\.dhtml)|(\.html)|(\.htm)|(\.xhtm)|(\.py)',
normalize_file_names     => 1,
normalize_file_delimiter => '_',
normalize_file_length    => 100,
path_to_upload           => 'http://'. $ENV{'SERVER_NAME'} . '/mfh/storage/',
progress_template        => 'templates/progress.tmpl',
};

1;