<?php

function do_html_header($title)
{
  // print an HTML header
?>
  <html>
  <head>
    <title><?php echo $title;?></title>
    <script src="jquery-1.12.4.min.js"></script>
    <script>
    var num=1;
    $(document).ready(function(){

      $(".btn").click(function(){
        $(".new_md:last").after("<tr class='new_md'><td><input name='md_id_"+num+"' placeholder='medicint id'></td> <td><input name='md_am_"+num+"' placeholder='amount'></td></tr>");num=num+1;
      });


      $(".btn1").click(function(){
          $(this).parent().parent().nextUntil(".p_main").toggle();
      });

    });
    </script>
    <style>
      body { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      hr { color: #3333cc; width=300; text-align=left}
      a { color: #000000 }
    </style>
  </head>
  <body>
  <img src="medicine.gif" alt="Medicine GO logo" border=0
       align=left valign=bottom height = 55 width = 57 />
  <h1>&nbsp;Medicine GO</h1>
  <hr />
<?php
  if($title)
    do_html_heading($title);
}

function do_html_footer()
{
  // print an HTML footer
?>
  </body>
  </html>
<?php
}

function do_html_heading($heading)
{
  // print heading
?>
  <h2><?php echo $heading;?></h2>
<?php
}

function do_html_URL($url, $name)
{
  // output URL as link and br
?>
  <br /><a href="<?php echo $url;?>"><?php echo $name;?></a><br />
<?php
}


function display_site_info()
{
  // display some marketing info
?>
  <ul>
  <li>search and check medicine info!</li>
  <li>manage medicien amount!</li>
  <li>just have fun!</li>
  </ul>
<?php
}

function display_login_form()
{
?>
  <a href='register_form.php'>Not a member?</a>
  <form method='post' action='member.php'>
  <table bgcolor='#cccccc'>
   <tr>
     <td colspan=2>Members log in here:</td>
   <tr>
     <td>Username:</td>
     <td><input type='text' name='username'></td></tr>
   <tr>
     <td>Password:</td>
     <td><input type='password' name='passwd'></td></tr>
   <tr>
     <td>Type:</td>
     <td><select name="the_type">
      <option value="the_patient">patient</option>
      <option value="the_doctor" selected="selected">doctor</option>
      <option value="the_storage" >inventory manager</option>
      </select></td></tr>
   <tr>
     <td colspan=2 align='center'>
     <input type='submit' value='Log in'></td></tr>
   <tr>
     <td colspan=2><a href='forgot_form.php'>Forgot your password?</a></td>
   </tr>
 </table></form>
<?php
}

function display_registration_form()
{
?>
 <form method='post' action='register_new.php'>
 <table bgcolor='#cccccc'>
   <tr>
     <td>Type:</td>
     <td><select name="the_type">
      <option value="the_patient">patient</option>
      <option value="the_doctor" selected="selected">doctor</option>
      <option value="the_storage" >inventory manager</option>
      </select></td></tr>
   <tr>
     <td>Preferred username <br />(max 16 chars):</td>
     <td valign='top'><input type='text' name='username'
                     size=16 maxlength=16></td></tr>
   <tr>
     <td>Password <br />(between 6 and 16 chars):</td>
     <td valign='top'><input type='password' name='passwd'
                     size=16 maxlength=16></td></tr>
   <tr>
     <td>Confirm password:</td>
     <td><input type='password' name='passwd2' size=16 maxlength=16></td></tr>
   <tr>
     <td>Email address: <br /></td>
     <td><input type='text' name='email' size=16 maxlength=100></td></tr>
   <tr>
     <td colspan=2 align='center'>
     <input type='submit' value='Register'></td></tr>
 </table></form>
<?php 

}


function display_md_info($md_array)
{
  // display the table of medicines

  // set global variable, so we can test later if this is on the page
  global $md_table;
  $md_table = true;
?>
  <br />
  <form name='md_table' action='search.php' method='post'>
  <table width=600 cellpadding=2 cellspacing=0>
    <tr>
     <td><input type='text' name='search_text'></td>
     <td align='left'>
     <input type='submit' value='Search'></td>
   </tr>
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor='$color'><td><strong>ID</strong></td>";
  echo "<td><strong>Name</strong></td>";
  echo "<td><strong>Kind</strong></td>";
  echo "<td><strong>Dosage</strong></td>";
  echo "<td><strong>Indication</strong></td>";
  echo "<td><strong>Description</strong></td>";
  echo "<td><strong>Price</strong></td>";
  echo "<td><strong>Amount</strong></td></tr>";
  if (is_array($md_array) && count($md_array)>0)
  {
    foreach ($md_array as $md)
    {
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      // remember to call htmlspecialchars() when we are displaying user data
      echo "<tr color='$color'><td>".$md[0]."</td>";
      echo "<td>".$md[1]."</td>";
      echo "<td>".$md[2]."</td>";
      echo "<td>".$md[3]."</td>";
      echo "<td>".$md[4]."</td>";
      echo "<td>".$md[5]."</td>";
      echo "<td>".$md[6]."</td>";
      echo "<td>".$md[7]."</td>";
      echo "</tr>"; 
    }
  }
  else
    echo "<tr><td>No record</td></tr>";
?>
  </table> 
  </form>
<?php
}

function display_profile_my_patient($info)
{
?>
  <br />
  <form name='info_table' action='' method='post'>
  <table width=600 cellpadding=2 cellspacing=0>
<?php
  $color = "#cccccc";
  echo "<tr bgcolor='$color'><td><strong>ID</strong></td>";
  echo "<td><strong>Name</strong></td>";
  echo "<td><strong>email</strong></td>";
  echo "<td><strong>address</strong></td>";
  echo "<td><strong>sexual</strong></td>";
  echo "<td><strong>age</strong></td>";
  echo "<td><strong>case history</strong></td></tr>";
  if (is_array($info) && count($info)>0)
  {
    foreach ($info as $md)
    {
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      // remember to call htmlspecialchars() when we are displaying user data
      echo "<tr><td>".$md[0]."</td>";
      echo "<td>".$md[1]."</td>";
      echo "<td>".$md[3]."</td>";
      echo "<td>".$md[4]."</td>";
      echo "<td>".$md[5]."</td>";
      echo "<td>".$md[6]."</td>";
      echo "<td>".$md[7]."</td></tr>";
    }
  }
  else
    echo "<tr><td>No profile record</td></tr>";
?>
  </table> 
  </form>
<?php
}

function display_profile_patient($info)
{
?>
  <br />
  <form name='info_table' action='update_profile.php' method='post'>
  <table width=600 cellpadding=2 cellspacing=0>
<?php
  if (is_array($info) && count($info)>0)
  {
    foreach ($info as $md)
    {
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      // remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor='$color'><td><strong>Name</strong></td><td><input type='text' name='name' value=".$md[1]."></td></tr>";
      echo "<tr><td><strong>email</strong></td><td><input type='text' name='email' value=".$md[3]."></td></tr>";
      echo "<tr><td><strong>address</strong></td><td><input type='text' name='address' value=".$md[4]."></td></tr>";
      echo "<tr><td><strong>sexual</strong></td><td><input type='text' name='sexual' value=".$md[5]."></td></tr>";
      echo "<tr><td><strong>age</strong></td><td><input type='text' name='age' value=".$md[6]."></td></tr>";
      echo "<tr><td><strong>case history</strong></td><td><input type='text' name='case_history' value=".$md[7]."></td></tr>";
      echo "<tr><td><strong>primary doctor</strong></td><td><input type='text' name='primary_doctor' value=".$md[9]."></td></tr>";
    }
    echo "<tr> <td colspan=2 align='center'> <input type='submit' value='Update Profile'></td></tr>";
  }
  else
    echo "<tr><td>No profile record</td></tr>";
?>
  </table> 
  </form>
<?php
}

function display_profile_doctor($info)
{
  // display the table of patient
?>
  <br />
  <form name='info_table' action='update_profile.php' method='post'>
  <table width=600 cellpadding=2 cellspacing=0>
<?php
  if (is_array($info) && count($info)>0)
  {
    foreach ($info as $md)
    {
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      // remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor='$color'><td><strong>Name</strong></td><td><input type='text' name='name' value=".$md[1]."></td></tr>";
      echo "<tr><td><strong>email</strong></td><td><input type='text' name='email' value=".$md[3]."></td></tr>";
      echo "<tr><td><strong>address</strong></td><td><input type='text' name='address' value=".$md[4]."></td></tr>";
      echo "<tr><td><strong>sexual</strong></td><td><input type='text' name='sexual' value=".$md[5]."></td></tr>";
      echo "<tr><td><strong>age</strong></td><td><input type='text' name='age' value=".$md[6]."></td></tr>";
      echo "<tr><td><strong>specialty</strong></td><td><input type='text' name='specialty' value=".$md[7]."></td></tr>";
      echo "<tr><td><strong>clinic name</strong></td><td><input type='text' name='clinic_name' value=".$md[8]."></td></tr>";
      echo "<tr><td><strong>clinic location</strong></td><td><input type='text' name='clinic_location' value=".$md[9]."></td></tr>";
    }
    echo "<tr> <td colspan=2 align='center'> <input type='submit' value='Update Profile'></td></tr>";
  }
  else
    echo "<tr><td>No profile record</td></tr>";
?>
  </table> 
  </form>
<?php

}

function display_prescription_form($info, $md_info)
{
  // display the table of patient
?>
  <br />
  <form name='p_table' action='' method='post'>
  <table width=600 cellpadding=2 cellspacing=0>
<?php
  $color = "#cccccc";
  echo "<tr bgcolor='$color'><td><strong>Prescription Id</strong></td>";
  echo "<td><strong>Prescription name</strong></td>";
  echo "<td><strong>doctor</strong></td>";
  echo "<td><strong>patient</strong></td>";
  echo "<td><strong>description</strong></td>";
  echo "<td><strong>medicines info</strong></td></tr>";
  if (is_array($info) && count($info)>0)
  {
    reset($info);
    if (is_array($md_info) && count($md_info)>0)
    reset($md_info);
    while($md=current($info))
    {
      each($info);
      // $md=$md[1];
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      // remember to call htmlspecialchars() when we are displaying user data
      echo "<tr class='p_main' color='$color'><td>".$md[0]."</td>";
      echo "<td>".$md[1]."</td>";
      echo "<td>".$md[2]."</td>";
      echo "<td>".$md[3]."</td>";
      echo "<td>".$md[4]."</td>";
      echo "<td><button type='button' class='btn1'>Check</button></td>";
      echo "</tr>"; 
      
      $t_md_info=current($md_info);
      if ($t_md_info[0]==$md[0])
      {
        $color = "#cccccc";
        echo "<tr class ='t_p_m' bgcolor='$color'><td><strong>Medicine ID</strong></td>";
        echo "<td><strong>Medicine Name</strong></td>";
        echo "<td><strong>Amount</strong></td>";
        echo "</tr>";
        while ($t_md_info[0]==$md[0])
        {
          echo "<tr class ='t_p_m' color='$color'><td>".$t_md_info[0]."</td>";
          echo "<td>".$t_md_info[1]."</td>";
          echo "<td>".$t_md_info[2]."</td>";
          echo "</tr>"; 
          each($md_info);
          $t_md_info=current($md_info);  
        }
      }
      // echo "<tr><td><strong>medicines</strong></td>";
      // echo "<td><strong>amount</strong></td></tr>";
    }
  }
  else
    echo "<tr><td>No profile record</td></tr>";
?>
  <script type="text/javascript">
  $(".t_p_m").toggle();
  </script>
  </table> 
  </form>
<?php

}
function display_add_prescription_form()
{
  // display the form for inventory_manager to add new medicine
?>
<form name='np_table' action='add_prescription.php' method='post'>
<p>Add new prescription</p>
<table width=600 cellpadding=2 cellspacing=0 bgcolor='#cccccc'>
  <tr class="new_md">
  <td><input name='new_name' placeholder="new prescription name"></td>
  <td><input name='new_pat' placeholder="patient id"></td>
  <td><input name='new_des' placeholder="description"></td>
  </tr>
  
  <tr><td><button type="button" class="btn">Add medicine</button></td></tr>


  <tr>
  <td colspan=2 align='center'>
     <input type='submit' value='Add new Prescription'></td>
  </tr>
</table>
</form>

<?php
}

function display_my_patient_form($info)
{
  // display the table of medicines
?>
  <br />
  <form name='myp_table' action='add_patient.php' method='post'>
  <table width=600 cellpadding=2 cellspacing=0>
    <tr>
     <td><input type='text' name='my_patient_id' placeholder="new patient id"></td>
     <td align='left'>
     <input type='submit' value='Add Patient'></td>
   </tr>
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor='$color'><td><strong>ID</strong></td>";
  echo "<td><strong>Name</strong></td>";
  echo "<td><strong>email</strong></td>";
  echo "<td><strong>address</strong></td>";
  echo "<td><strong>sexual</strong></td>";
  echo "<td><strong>age</strong></td>";
  echo "<td><strong>case_history</strong></td></tr>";
  if (is_array($info) && count($info)>0)
  {
    foreach ($info as $md)
    {
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      // remember to call htmlspecialchars() when we are displaying user data
      echo "<tr color='$color'><td>".$md[0]."</td>";
      echo "<td>".$md[1]."</td>";
      echo "<td>".$md[3]."</td>";
      echo "<td>".$md[4]."</td>";
      echo "<td>".$md[5]."</td>";
      echo "<td>".$md[6]."</td>";
      echo "<td>".$md[7]."</td>";
      echo "</tr>"; 
    }
  }
  else
    echo "<tr><td>No profile record</td></tr>";
?>
  </table> 
  </form>
<?php

}
function display_new_md_form()
{
  // display the form for inventory_manager to add new medicine
?>
<form name='nmd_table' action='new_medicine.php' method='post'>
<p>Add new medicine</p>
<table width=600 cellpadding=2 cellspacing=0 bgcolor='#cccccc'>
  <tr>
  <td><input name='new_name' placeholder="new medicin name"></td>
  <td><input name='new_kin' placeholder="kind"></td>
  <td><input name='new_dos' placeholder="dosage"></td>
  <td><input name='new_ind' placeholder="indication"></td>
  <td><input name='new_des' placeholder="description"></td>
  <td><input name='new_pri' placeholder="price"></td>
  <td><input name='new_amo' placeholder="amount"></td>
  <td colspan=2 align='center'>
     <input type='submit' value='Add new Medicine'></td>
  </tr>
</table>
</form>

<?php
}

function display_add_md($md_array)
{
  // display the table of medicines
?>
  <br />
  <form name='amd_table' action='add_medicine.php' method='post'>
  <table width=600 cellpadding=2 cellspacing=0>
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor='$color' align='center'><td><strong>Name</strong></td>";
  echo "<td align='center'><strong>Amount</strong></td>";
  echo "<td align='center'><strong>Add amount</strong></td>";
  echo "</tr>";
  if (is_array($md_array) && count($md_array)>0)
  {
    foreach ($md_array as $md)
    {
      if ($color == "#cccccc")
        $color = "#ffffff";
      else
        $color = "#cccccc";
      echo "<tr color='$color' align='center'><td>".$md[1]."</td>";
      if ($md[7] != NULL)
          echo "<td align='center'>".$md[7]."</td>";
      else
          echo "<td align='center'>0</td>";
      echo "<td><input type='text' name=".$md[0]."amount"."></td>";
      echo "</tr>"; 
    }
    echo "<tr> <td colspan=2 align='center'>
     <input type='submit' value='Add new amount'></td> </tr>";
  }
  else
    echo "<tr><td>No record</td></tr>";
?>
  </table> 
  </form>
<?php
}


function display_password_form()
{
  // display html change password form
?>
   <br />
   <form action='change_passwd.php' method='post'>
   <table width=250 cellpadding=2 cellspacing=0 bgcolor='#cccccc'>
   <tr><td>Old password:</td>
       <td><input type='password' name='old_passwd' size=16 maxlength=16></td>
   </tr>
   <tr><td>New password:</td>
       <td><input type='password' name='new_passwd' size=16 maxlength=16></td>
   </tr>
   <tr><td>Repeat new password:</td>
       <td><input type='password' name='new_passwd2' size=16 maxlength=16></td>
   </tr>
   <tr><td colspan=2 align='center'><input type='submit' value='Change password'>
   </td></tr>
   </table>
   <br />
<?php
};

function display_forgot_form()
{
  // display HTML form to reset and email password
?>
   <br />
   <form action='forgot_passwd.php' method='post'>
   <table width=250 cellpadding=2 cellspacing=0 bgcolor='#cccccc'>
   <tr><td>Enter your username</td>
       <td><input type='text' name='username' size=16 maxlength=16></td>
   </tr>
   <tr><td colspan=2 align='center'><input type='submit' value='Change password'>
   </td></tr>
   </table>
   <br />
<?php
};

function display_user_menu()
{
  // display the menu options on this page
?>
<hr />|&nbsp;
<a href="member.php">Home</a> &nbsp;|&nbsp;
<?php
  // only offer the delete option if bookmark table is on this page
  $thetype=$_SESSION['valid_type'];
  switch($thetype)
  {
    case 'the_patient':
        echo "<a href='show_my_prescription.php'>Show Prescription</a>&nbsp;|&nbsp;"; 
        echo "<a href='show_profile.php'>Show Profile</a>&nbsp;|&nbsp;"; 
    break;
    case 'the_doctor':
        echo "<a href='show_my_patient.php'>Show Patient</a>&nbsp;|&nbsp;"; 
        echo "<a href='show_my_prescription.php'>Show Prescription</a>&nbsp;|&nbsp;"; 
        echo "<a href='show_profile.php'>Show Profile</a>&nbsp;|&nbsp;"; 
    break;
    case 'the_storage':
        echo "<a href='manage_md_form.php'>Manage Medicine</a>&nbsp;|&nbsp;"; 
    break;
    default:
      throw new Exception('Could not check type');
  }
  echo "<a href='change_passwd_form.php'>Change password</a>&nbsp;|&nbsp;"; 
  echo "<a href='logout.php'>Logout</a>&nbsp;|&nbsp;<hr />"; 
}
