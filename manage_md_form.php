<?php
// include function files for this application
require_once('medicine_fns.php');
session_start();

// start output html
do_html_header('manage Medicines');

check_valid_user();
display_manage_md_form();

display_user_menu();
do_html_footer();

?>
