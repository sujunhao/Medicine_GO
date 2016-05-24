<?php

// include function files for this application
require_once('medicine_fns.php'); 
session_start();

do_html_header('Home');
check_valid_user();

$username = $_SESSION['valid_user'] ;
$thetype = $_SESSION['valid_type'];
$id = $_SESSION['valid_user_id'];
try
{
	switch($thetype)
	{
	case 'the_patient':
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$sexual = $_POST['sexual'];
		$age = $_POST['age'];
		$case_history = $_POST['case_history'];
		update_profile_patient($id, $name, $email, $address, $sexual, $age, $case_history);
		echo "<p>update secceed</p>";
	break;
	case 'the_doctor':
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$sexual = $_POST['sexual'];
		$age = $_POST['age'];
		$specialty = $_POST['specialty'];
		$clinic_name = $_POST['clinic_name'];
		$clinic_location = $_POST['clinic_location'];
		update_profile_doctor($id, $name, $email, $address, $sexual, $age, $specialty, $clinic_name, $clinic_location);
		echo "<p>update secceed</p>";
	break;
	default:
	  throw new Exception('Could not check type');
	}
}	
catch(Exception $e)
{
	echo "Can't get your Profile";
	echo $e->getMessage(); 
	display_user_menu();
	do_html_footer();
	exit;
}


// give menu of options
display_user_menu();

do_html_footer();
?>
