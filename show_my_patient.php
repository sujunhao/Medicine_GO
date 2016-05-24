<?php

// include function files for this application
require_once('medicine_fns.php'); 
session_start();

do_html_header('Home');
check_valid_user();

$username = $_SESSION['valid_user'] ;
$thetype = $_SESSION['valid_type'];
$doctor_id = $_SESSION['valid_user_id'];

try
{
	$mypatient = get_my_patient($doctor_id);
	display_my_patient_form($mypatient);
	if ($info = get_all_patient())
	{
		display_profile_my_patient($info);
	}
	else 
	{
		throw new Exception("something woring in your account");    
	}
}	
catch(Exception $e)
{
	echo "Can't diaplay pateirn info";
	display_user_menu();
	do_html_footer();
	exit;
}


// give menu of options
display_user_menu();

do_html_footer();
?>
