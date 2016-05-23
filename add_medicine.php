<?php
  // include function files for this application
  require_once('medicine_fns.php');


  // start session which may be needed later
  // start it now because it must go before headers
  session_start();
  try{
    
    if ($md_array = get_md_info())
    {
      foreach ($md_array as $md)
      {
        if ($amount=$_POST[$md[0]."amount"])
        {
          // echo $md[1].$amount;
          add_md($md[1], $amount);
        }
      }
    }

    // provide link to members page
    do_html_header('Add amount successful');
    // echo "<a href='manage_md_form.php'>Manage Medicine</a>&nbsp;|&nbsp;"; 
    // end page
    display_user_menu();
    do_html_footer();
  }
  catch (Exception $e)
  {
     do_html_header('Problem:');
     echo $e->getMessage(); 
     display_user_menu();
     do_html_footer();
     exit;
  } 
?>
