<?php
// include function files for this application
require_once('medicine_fns.php');
session_start();

// start output html
do_html_header('manage Medicines');

check_valid_user();
display_new_md_form();

// get the medicine info
if ($md_array = get_md_info())
  display_add_md($md_array);


display_user_menu();
do_html_footer();

?>
