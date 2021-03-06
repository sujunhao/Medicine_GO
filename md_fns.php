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

  // if ($result->num_rows<=0)
  //   throw new Exception('no medicine record'); 

  //create an array of the mds 
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

  //create an array of the mds 
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

function add_new_patient($doctor_id, $patient_id)
{
  //Add new patient to a doctor

  $conn = db_connect();
   // check if there is a patient exist
  $result = $conn->query("select id from patient
                         where id = $patient_id");
  if (!$result || !($result->num_rows>0))
    throw new Exception('Patient no exists.');

  // update the record
  if (!$conn->query( "update patient 
                      set primary_doctor_id = $doctor_id
                      where id = $patient_id"))
    throw new Exception("Can't update patient primary doctor"); 

  return true;
}



function get_member_info($thetype, $name)
{
  //extract from the database all the URLs this user has stored
  $conn = db_connect();
  switch($thetype)
  {
    case 'the_patient':
        $thetype='patient';
        $result = $conn->query( "select patient.*, doctor.name
                          from patient, doctor
                          where patient.name = '$name' && primary_doctor_id=doctor.id");
    break;
    case 'the_doctor':
        $thetype='doctor';
        $result = $conn->query( "select *
                          from $thetype
                          where name = '$name'");
    break;
    default:
      throw new Exception('Could not check type');
  }

  if (!$result)
    return false; 

  //create an array of the URLs 
  $member_array = array();
  for ($count = 1; $row = $result->fetch_row(); ++$count) 
  {
    $member_array[$count] = $row;
  }  
  return $member_array;
}
function get_all_patient()
{
  $conn = db_connect();

  $result = $conn->query( "select *
                          from patient");
  if (!$result)
    return false; 

  //create an array of the URLs 
  $member_array = array();
  for ($count = 1; $row = $result->fetch_row(); ++$count) 
  {
    $member_array[$count] = $row;
  }  
  return $member_array;
}

function get_my_patient($doctor_id)
{
  $conn = db_connect();

  $result = $conn->query( "select *
                          from patient
                          where primary_doctor_id = $doctor_id");
  if (!$result)
    return false; 

  //create an array of the URLs 
  $member_array = array();
  for ($count = 1; $row = $result->fetch_row(); ++$count) 
  {
    $member_array[$count] = $row;
  }  
  return $member_array;
}

//$id_array = add_prescriptiopn($pname, $doctor_id, $patient_id, $description);
function add_prescriptiopn($pname, $doctor_id, $patient_id, $description)
{
  $conn = db_connect();

  // check not a repeat medicine
  $result = $conn->query("select * from patient, doctor
                         where patient.id=$patient_id && primary_doctor_id=$doctor_id");
  if (!$result || ($result->num_rows==0))
    throw new Exception('You arre no the primary doctor of patient');


  // check not a repeat medicine
  $result = $conn->query("select * from prescription
                         where pname='$pname'");
  if ($result && ($result->num_rows>0))
    throw new Exception('prescription already exists.');


  // insert the new record
  if (!$conn->query( "insert into prescription (pname, doctor_id, patient_id, description) values
                          ('$pname', $doctor_id, $patient_id, '$description')"))
    throw new Exception('prescription could not be inserted.'); 

  $result = $conn->query( "select id
                          from prescription
                          where pname='$pname'");

  //create an array of the mds 
  $md_array = array();
  for ($count = 1; $row = $result->fetch_row(); ++$count) 
  {
    $md_array[$count] = $row;
  }  
  return $md_array;
}

function add_p_m($p_id, $m_id, $amount)
{

  $conn = db_connect();
   // check not a repeat medicine
  
  // insert the new record
  if (!$conn->query( "insert into p_m (p_id, m_id, amount) values
                          ($p_id, $m_id, $amount)"))
    throw new Exception('p_m could not be inserted.'); 

  return true;
}

function get_my_prescription($thetype, $id)
{
  $conn = db_connect();
  switch($thetype)
  {
    case 'the_patient':
        if (!$result = $conn->query( "select prescription.id, prescription.pname, doctor.name, patient.name, description
                          from prescription, doctor, patient
                          where patient_id = $id && doctor.id=prescription.doctor_id && patient.id=prescription.patient_id
                          order by prescription.id"))
          throw new Exception("can't get patient prescription info");
    break;
    case 'the_doctor':
        if (!$result = $conn->query( "select prescription.id, prescription.pname, doctor.name, patient.name, description
                          from prescription, doctor, patient
                          where doctor_id = $id && doctor.id=prescription.doctor_id && patient.id=prescription.patient_id
                          order by prescription.id"))
            throw new Exception("can't get patient prescription info");
    break;
    default:
      throw new Exception('type error');
  }
  if (!$result)
    return false; 

  //create an array of the URLs 
  $member_array = array();
  for ($count = 1; $row = $result->fetch_row(); ++$count) 
  {
    $member_array[$count] = $row;
  }  
  return $member_array;
}

function get_my_prescription_md($thetype, $theid)
{
  $conn = db_connect();
  switch($thetype)
  {
    case 'the_patient':
        if (!$result = $conn->query( "select p_m.p_id, medicines.drug_names, p_m.amount, prescription.id
                          from prescription, doctor, patient, p_m, medicines
                          where patient_id = $theid && doctor.id=prescription.doctor_id && patient.id=prescription.patient_id &&
                          prescription.id=p_m.p_id && medicines.id=p_m.m_id
                          order by prescription.id"))
          throw new Exception("can't get patient prescription md info");
    break;
    case 'the_doctor':
      if (!$result = $conn->query( "select p_m.p_id, drug_names, p_m.amount, prescription.id
                          from prescription, doctor, patient, p_m, medicines
                          where doctor_id = $theid && doctor.id=prescription.doctor_id && patient.id=prescription.patient_id && 
                          prescription.id=p_m.p_id && medicines.id=p_m.m_id
                          order by prescription.id"))
        throw new Exception("can't get patient prescription md info");
    break;
    default:
      throw new Exception("can't get p_m medicine info");
  }
  if (!$result)
    return false; 

  //create an array of the URLs 
  $member_array = array();
  for ($count = 1; $row = $result->fetch_row(); ++$count) 
  {
    $member_array[$count] = $row;
  }  
  return $member_array;
}

function update_profile_doctor($id, $name, $email, $address, $sexual, $age, $specialty, $clinic_name, $clinic_location)
{

  $conn = db_connect();
   // check if there is a patient exist
  $result = $conn->query("select id from doctor
                         where name = '$name' && id != $id");
  if ($result && ($result->num_rows>0))
    throw new Exception('Name exists.');

  // update the record
  if (!$conn->query( "update doctor
                      set name='$name', 
                      email='$email', 
                      address='$address', 
                      sexual=$sexual, 
                      specialty='$specialty',
                      age=$age, 
                      c_name='$clinic_name', 
                      c_location='$clinic_location'
                      where id = $id"))
    throw new Exception("Can't update  doctor profile"); 

  return true;
}

function update_profile_patient($id, $name, $email, $address, $sexual, $age, $case_history)
{
   $conn = db_connect();
   // check if there is a patient exist
  $result = $conn->query("select id from patient
                         where name = '$name' && id != $id");
  if ($result && ($result->num_rows>0))
    throw new Exception('Name exists.');

  // update the record
  if (!$conn->query( "update patient
                      set name='$name', 
                      email='$email', 
                      address='$address', 
                      sexual=$sexual, 
                      case_history='$case_history',
                      age=$age
                      where id = $id"))
    throw new Exception("Can't update  patient profile"); 

  return true;
}
