<?php
  // include function files for this application
  require_once('medicine_fns.php');


  // start session which may be needed later
  // start it now because it must go before headers
  session_start();

  do_html_header('Add prescription');
  check_valid_user();
  

  $pname = $_POST['new_name'];
  $patient_id = $_POST['new_pat'];
  $doctor_id = $_SESSION['valid_user_id'];
  $description = $_POST['new_des'];
  $num=1;
  $m_id=$_POST["md_id_".$num];
  $amount=$_POST["md_am_".$num];
  try{
    
    if (!$pname || !$patient_id || !$m_id || !$amount)
      throw new Exception("please fill in the prescription table");

    $id_array = add_prescriptiopn($pname, $doctor_id, $patient_id, $description);
    if (is_array($id_array) && count($id_array)>0)
    {
      foreach ($id_array as $id)
      {
        $p_id = $id[0];
        // echo "+++++++".$p_id;
      }
    }

    while ($m_id && $amount)
    {
      echo ":----".$pid."asd".$m_id.$amount;
      add_p_m($p_id, $m_id, $amount);

      ++$num;
      $m_id=$_POST["md_id_".$num];
      $amount=$_POST["md_am_".$num];
    }
    do_html_heading("add prescription succeed");
    // provide link to members page
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
