<?php

// include function files for this application
require_once('medicine_fns.php'); 
session_start();

do_html_header('Home');
check_valid_user();

$username = $_SESSION['valid_user'] ;
$thetype = $_SESSION['valid_type'];

try
{
	if ($username != NULL && $thetype != NULL)
	{
		if ($info = get_member_info($thetype,$username))
		{
			switch($thetype)
			{
			case 'the_patient':
				display_profile_patient($info);
			break;
			case 'the_doctor':
				display_profile_doctor($info);
			break;
			default:
			  throw new Exception('Could not check type');
			}
		}
	}
	else 
	{
		throw new Exception("something woring in your account");    
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
