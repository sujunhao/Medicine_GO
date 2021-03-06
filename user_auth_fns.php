<?php

require_once('db_fns.php');

function register($thetype, $username, $email, $password)
// register new person with db
// return true or error message
{
  // connect to db
  $conn = db_connect();
  
  // check if username is unique 
  switch($thetype)
  {
    case 'the_patient':
        $result = $conn->query("select * from patient where name='$username'"); 
        if (!$result)
          throw new Exception('Could not execute query');
        if ($result->num_rows>0) 
          throw new Exception('That username is taken - go back and choose another one.');

        // if ok, put in db
        $result = $conn->query("insert into patient (name, passwd, email) values 
                               ('$username', sha1('$password'), '$email')");
        if (!$result)
          throw new Exception('Could not register you in database - please try again later.');
    break;
    case 'the_doctor':
        $result = $conn->query("select * from doctor where name='$username'"); 
        if (!$result)
          throw new Exception('Could not execute query');
        if ($result->num_rows>0) 
          throw new Exception('That username is taken - go back and choose another one.');

        // if ok, put in db
        $result = $conn->query("insert into doctor (name, passwd, email) values 
                               ('$username', sha1('$password'), '$email')");
        if (!$result)
          throw new Exception('Could not register you in database - please try again later.');
    break;
    case 'the_storage':
        $result = $conn->query("select * from inventory_manager where name='$username'"); 
        if (!$result)
          throw new Exception('Could not execute query');
        if ($result->num_rows>0) 
          throw new Exception('That username is taken - go back and choose another one.');

        // if ok, put in db
        $result = $conn->query("insert into inventory_manager (name, passwd, email) values 
                               ('$username', sha1('$password'), '$email')");
        if (!$result)
          throw new Exception('Could not register you in database - please try again later.');
    break;
    default:
      throw new Exception('Could not check type');
  }
  

  return true;
}
 
function login($thetype, $username, $password)
// check username and password with db
// if yes, return true
// else throw exception
{
  // connect to db
  $conn = db_connect();

  switch($thetype)
  {
    case 'the_patient':
        $thetype='patient';
    break;
    case 'the_doctor':
        $thetype='doctor';
    break;
    case 'the_storage':
        $thetype='inventory_manager';
    break;
    default:
      throw new Exception('Could not check type');
  }
  // check if username is unique
  $result = $conn->query("select id from $thetype 
                         where name='$username'
                         and passwd = sha1('$password')");
  if (!$result)
     throw new Exception('Could not log you in.');
  
  if ($result->num_rows>0)
  {
    $id_array = array();
    for ($count = 1; $row = $result->fetch_row(); ++$count) 
    {
      $id_array[$count] = $row;
    }  
    return $id_array;
    
  }
  else throw new Exception('Could not log you in.');
}

function check_valid_user()
// see if somebody is logged in and notify them if not
{
  $thetype=$_SESSION['valid_type'];
  switch($thetype)
  {
    case 'the_patient':
        $thetype='patient';
    break;
    case 'the_doctor':
        $thetype='doctor';
    break;
    case 'the_storage':
        $thetype='inventory_manager';
    break;
    default:
      throw new Exception('Could not check type');
  }
  if (isset($_SESSION['valid_user']))
  {
      echo 'Logged in as '.$_SESSION['valid_user'].'.';
      echo '<br />';
      echo 'hello '.$thetype.'.';
      echo '<br />';
  }
  else
  {
     // they are not logged in 
     do_html_heading('Problem:');
     echo 'You are not logged in.<br />';
     do_html_url('login.php', 'Login');
     do_html_footer();
     exit;
  }  
}

function change_password($thetype, $username, $old_password, $new_password)
// change password for username/old_password to new_password
// return true or false
{
  // if the old password is right 
  // change their password to new_password and return true
  // else throw an exception
  login($thetype, $username, $old_password);
  switch($thetype)
  {
    case 'the_patient':
        $thetype='patient';
    break;
    case 'the_doctor':
        $thetype='doctor';
    break;
    case 'the_storage':
        $thetype='inventory_manager';
    break;
    default:
      throw new Exception('Could not check type');
  }
  $conn = db_connect();
  $result = $conn->query( "update $thetype
                            set passwd = sha1('$new_password')
                            where name = '$username'");
  if (!$result)
    throw new Exception('Password could not be changed.');
  else
    return true;  // changed successfully
}

function get_random_word($min_length, $max_length)
// grab a random word from dictionary between the two lengths
// and return it
{
   // generate a random word
  $word = '';
  // remember to change this path to suit your system
  $dictionary = '/usr/dict/words';  // the ispell dictionary
  $fp = @fopen($dictionary, 'r');
  if(!$fp)
    return false; 
  $size = filesize($dictionary);

  // go to a random location in dictionary
  srand ((double) microtime() * 1000000);
  $rand_location = rand(0, $size);
  fseek($fp, $rand_location);

  // get the next whole word of the right length in the file
  while (strlen($word)< $min_length || strlen($word)>$max_length || strstr($word, "'"))
  {  
     if (feof($fp))   
        fseek($fp, 0);        // if at end, go to start
     $word = fgets($fp, 80);  // skip first word as it could be partial
     $word = fgets($fp, 80);  // the potential password
  };
  $word=trim($word); // trim the trailing \n from fgets
  return $word;  
}

function reset_password($username)
// set password for username to a random value
// return the new password or false on failure
{ 
  // get a random dictionary word b/w 6 and 13 chars in length
  $new_password = get_random_word(6, 13);
  
  if($new_password==false)
    throw new Exception('Could not generate new password.');
  // add a number  between 0 and 999 to it
  // to make it a slightly better password
  srand ((double) microtime() * 1000000);
  $rand_number = rand(0, 999); 
  $new_password .= $rand_number;
 
  // set user's password to this in database or return false
  $conn = db_connect();
  $result = $conn->query( "update user
                          set passwd = sha1('$new_password')
                          where name = '$username'");
  if (!$result)
    throw new Exception('Could not change password.');  // not changed
  else
    return $new_password;  // changed successfully  
}

function notify_password($username, $password)
// notify the user that their password has been changed
{
    $conn = db_connect();
    $result = $conn->query("select email from user
                            where username='$username'");
    if (!$result)
    {
      throw new Exception('Could not find email address.');  
    }
    else if ($result->num_rows==0)
    {
      throw new Exception('Could not find email address.');   // username not in db
    }
    else
    {
      $row = $result->fetch_object();
      $email = $row->email;
      $from = "From: support@medicine \r\n";
      $mesg = "Your medicineGO password has been changed to $password \r\n"
              ."Please change it next time you log in. \r\n";
      
      
      if (mail($email, 'medicine login information', $mesg, $from))
        return true;      
      else
        throw new Exception('Could not send email.');
    }
} 

?>
