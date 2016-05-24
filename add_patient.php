<?php
  // include function files for this application
  require_once('medicine_fns.php');

  // start session which may be needed later
  // start it now because it must go before headers
  session_start();
  do_html_header('Add patient');
  check_valid_user();

  $patient_id = $_POST['my_patient_id'];
  $doctor_id = $_SESSION['valid_user_id'];

  // echo "asdasd|".$patient_id."||".$doctor_id."asdasdasd";

  try{
    add_new_patient($doctor_id, $patient_id);


    $mypatient = get_my_patient($doctor_id);
    display_my_patient_form($mypatient);
    if ($info = get_all_patient())
    {
      display_profile_my_patient($info);
    }
    else
    {
      throw new Exception("can't get pre info");
    }
    display_user_menu();
    do_html_footer();
  }
  catch (Exception $e)
  {
     // do_html_header('Problem:');
     echo $e->getMessage(); 
     display_user_menu();
     do_html_footer();
     exit;
  } 
?>
