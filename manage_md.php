<?php
 require_once('medicine_fns.php');
 session_start();
 
  //create short variable name
  $new_url = $_POST['new_url'];
 
  do_html_header('Manage Medicine');
  display_add_new_md();
  display_add_md();
  
  display_user_menu(); 
  do_html_footer();
?>
