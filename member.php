<?php

// include function files for this application
require_once('medicine_fns.php'); 
session_start();

//create short variable names
$thetype = $_POST['the_type'];
$username = $_POST['username'];
$passwd = $_POST['passwd'];
if ($_SESSION['valid_user']==NULL)
{
  try
  {
    // check forms filled in
    if (!filled_out($_POST))
    {
      throw new Exception('You have not filled the form out correctly - please go back'
          .' and try again.');    
    }

    $id_array = login($thetype, $username, $passwd);


    if (is_array($id_array) && count($id_array)>0)
    {
      foreach ($id_array as $id)
      {
        $_SESSION['valid_user_id'] = $id[0];
      }
    }
    // echo "PPPP".$_SESSION['valid_user_id'];
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
