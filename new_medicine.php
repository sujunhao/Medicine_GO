<?php
  // include function files for this application
  require_once('medicine_fns.php');

  //create short variable names
  $drug_names=$_POST['new_name'];
  $kind=$_POST['new_kin'];
  $dosage_and_admi=$_POST['new_dos'];
  $indication=$_POST['new_ind'];
  $description=$_POST['new_des'];
  $price=$_POST['new_pri'];
  $amount=$_POST['new_amo'];
  // start session which may be needed later
  // start it now because it must go before headers
  session_start();
  try
  {
    // check forms filled in
    if (!filled_out($_POST))
    {
      throw new Exception('You have not filled the form out correctly - please go back'
          .' and try again.');    
    }
   
    // attempt to add new medicine
    // this function can also throw an exception
    add_new_md($drug_names, $kind, $dosage_and_admi, $indication, $description, $price, $amount);
    
    // provide link to members page
    do_html_header('Added successful');
    display_new_md_form();
    // get the medicine info
    if ($md_array = get_md_info())
      display_add_md($md_array);


   
    display_user_menu();
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
