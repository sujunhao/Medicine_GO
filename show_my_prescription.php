<?php

// include function files for this application
require_once('medicine_fns.php'); 
session_start();

do_html_header('Home');
check_valid_user();

$username = $_SESSION['valid_user'] ;
$thetype = $_SESSION['valid_type'];
$theid = $_SESSION['valid_user_id'];

try
{
	switch($thetype)
	{
		case 'the_patient':
			if ($info = get_my_prescription($thetype, $theid))
		    {
		    	display_prescription_form($info);
		    }
		    else
		    {
		      throw new Exception("can't get pre info");
		    }
		break;
		case 'the_doctor':
			display_add_prescription_form();
		    if ($info = get_my_prescription($thetype, $theid))
		    {
		    	display_prescription_form($info);
		    }
		    else
		    {
		      throw new Exception("can't get pre info");
		    }
		break;
		default:
		  throw new Exception('type error');
	}
	
}	
catch(Exception $e)
{
	echo "Can't get your Profile";
	display_user_menu();
	do_html_footer();
	exit;
}


// give menu of options
display_user_menu();

do_html_footer();
?>
