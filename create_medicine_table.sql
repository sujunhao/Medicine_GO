create table user  (
  username varchar(16) primary key,
  passwd char(40) not null,
  email varchar(100) not null
);

create table doctor
(
id int unsigned not null auto_increment,
name varchar(50) not null,
passwd varchar(50) not null,
email varchar(50),
address varchar(100),
sexual char(1),
age int unsigned,
specialty varchar(255),
c_name varchar(50) not null,
c_location varchar(100),
primary key(id)
);


create table patient
(
id int unsigned not null auto_increment,
name varchar(50) not null,
passwd varchar(50) not null,
email varchar(50),
address varchar(100),
sexual char(1),
age int unsigned,
case_history text,
primary_doctor_id int unsigned,
foreign key(primary_doctor_id) references doctor(id),
primary key(id)
);

CREATE TABLE inventory_manager
(
id int unsigned not null auto_increment,
name varchar(50) not null,
email varchar(50),
passwd varchar(50) not null,
primary key(id)
);

CREATE TABLE system_manager
(
id int unsigned not null auto_increment,
name varchar(50) not null,
passwd varchar(50) not null,
primary key(id)
);

CREATE TABLE medicines
(
id int unsigned not null auto_increment,
drug_names varchar(50),
kind varchar(50),
dosage_and_admi varchar(255),
indication text,
description text,
price float(10,2),
primary key(id)
);

CREATE TABLE storages
(
drug_names varchar(50),
expired_date TIMESTAMP,
amount int
);



create table prescription
(
pid int unsigned not null auto_increment,
pname varchar(50),
doctor_id int unsigned not null,
patient_id int unsigned not null,
medicions_id int unsigned not null,
description text,
amount_to_take int unsigned,
foreign key(patient_id) references patient(id),
foreign key(doctor_id) references doctor(id),
foreign key(medicions_id) references medicions(id),
primary key(pid)
);


create table p_m_number
(
patient_id int unsigned not null,
medicines_id int unsigned not null,
number_of_medicine int,
primary key(patient_id,medicines_id),
foreign key(patient_id) references patient(id),
foreign key(medicines_id) references medicines(id)
);
