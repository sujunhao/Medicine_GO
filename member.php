<?php

// include function files for this application
require_once('medicine_fns.php'); 
session_start();

//create short variable names
$thetype = $_POST['the_type'];
$username = $_POST['username'];
$passwd = $_POST['passwd'];

if ($username && $passwd && $thetype)
// they have just tried logging in
{
  try
  {
    login($thetype, $username, $passwd);
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $username;
    $_SESSION['valid_type'] = $thetype;
  }
  catch(Exception $e)
  {
    // unsuccessful login
    do_html_header('Problem:');
    echo 'You could not be logged in. 
          You must be logged in to view this page.';
    do_html_url('login.php', 'Login');
    do_html_footer();
    exit;
  }      
}

do_html_header('Home');
check_valid_user();


// get the medicine info
if ($md_array = get_md_info())
  display_md_info($md_array);

// give menu of options
display_user_menu();

do_html_footer();
?>
