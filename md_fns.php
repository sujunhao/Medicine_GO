<?php
require_once('db_fns.php');

function get_md_info()
{
  //extract from the database all the URLs this user has stored
  $conn = db_connect();
  $result = $conn->query( "select id, medicines.drug_names, kind, dosage_and_admi, indication, description, price,
                           SUM(amount)
                           from medicines left join storages
                           using(drug_names)
                           group by id;
                           " );
  if (!$result)
    return false; 

  //create an array of the URLs 
  $md_array = array();
  for ($count = 1; $row = $result->fetch_row(); ++$count) 
  {
    $md_array[$count] = $row;
  }  
  return $md_array;
}
  
function search_md_info($key)
{
  //extract from the database all the URLs this user has stored
  $conn = db_connect();
  $result = $conn->query( "select *
                          from medicines
                          where drug_names like \"%$key%\"");
  if (!$result)
    return false; 

  //create an array of the URLs 
  $md_array = array();
  for ($count = 1; $row = $result->fetch_row(); ++$count) 
  {
    $md_array[$count] = $row;
  }  
  return $md_array;
}

function add_md($drug_names, $amount)
{
  // Add new amount to the database
  $conn = db_connect();

  // insert the new amount
  if (!$conn->query( "insert into storages values
                          ('$drug_names', now(), '$amount')"))
    throw new Exception('amount could not be added.'); 

  return true;
} 


function add_new_md($drug_names, $kind, $dosage_and_admi, $indication, $description, $price, $amount)
{
  //Add new medicine to the database
  // echo "Attempting to add ".$drug_names.'<br />';

  $conn = db_connect();
   // check not a repeat medicine
  $result = $conn->query("select * from medicines
                         where name='$drug_name'");
  if ($result && ($result->num_rows>0))
    throw new Exception('Medicine already exists.');

  // insert the new record
  if (!$conn->query( "insert into medicines (drug_names, kind, dosage_and_admi, indication, description, price) values
                          ('$drug_names', '$kind', '$dosage_and_admi', '$indication', '$description', $price)"))
    throw new Exception('Medicine could not be inserted.'); 

  // insert the new amount
  if (!$conn->query( "insert into storages (drug_names, expired_date, amount) values
                          ('$drug_names',  now(), $amount)"))
    throw new Exception('Medicine info added but update amount fail.'); 

  return true;
}
