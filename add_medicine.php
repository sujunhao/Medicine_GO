<?php
  // include function files for this application
  require_once('medicine_fns.php');


  // start session which may be needed later
  // start it now because it must go before headers
  session_start();
  try{
    // check forms filled in
    if (!filled_out($_POST))
    {
      throw new Exception('You have not filled the form out correctly - please go back'
          .' and try again.');    
    }

    if ($md_array = get_md_info())
    {
      foreach ($md_array as $md)
      {
        if ($amount=$_POST[$md[0]."amount"])
        {
          add_md($md[1], $amount);
        }
      }
    }

    // provide link to members page
    do_html_header('Added successful');
    display_new_md_form();
    display_add_md($md_array);
    // end page
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
