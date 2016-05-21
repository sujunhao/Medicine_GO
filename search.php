<?php
  require_once('medicine_fns.php');
  session_start();
 
  do_html_header('Search Medicine');
  check_valid_user();
  $key = $_POST['search_text'];

  echo "search for ".$key.'<br />';
  
  if ($md_array = search_md_info($key))
    display_md_info($md_array);

  display_user_menu(); 
  do_html_footer();
?>