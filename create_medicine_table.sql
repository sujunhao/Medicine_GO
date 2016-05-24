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
id int unsigned not null auto_increment,
pname varchar(50),
doctor_id int unsigned not null,
patient_id int unsigned not null,
description text,
foreign key(patient_id) references patient(id),
foreign key(doctor_id) references doctor(id),
primary key(id)
);

create table p_m
(
p_id int unsigned not null,
m_id int unsigned not null,
amount int,
foreign key(p_id) references prescription(id),
foreign key(m_id) references medicines(id)
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

INSERT INTO `medicines` VALUES (1,'Albuterol Inhalation','muscles','Applies to the following strength(s): 2 mg ; 4 mg ; 2 mg/5 mL ; 90 mcg/inh ; 5 mg/mL ; 2.5 mg/3 mL (0.083%) ; CFC free 90 mcg/inh ; 200 mcg ; 8 mg ; 0.63 mg/3 mL (0.021%) ; 1.25 mg/3 mL (0.042%)','Get emergency medical help if you have signs of an allergic reaction to albuterol: hives; difficult breathing; swelling of your face, lips, tongue, or throat.','Albuterol is a bronchodilator that relaxes muscles in the airways and increases air flow to the lungs.\n\nAlbuterol inhalation is used to treat or prevent bronchospasm in people with reversible obstructive airway disease. It is also used to prevent exercise-induced bronchospasm.\n\nAlbuterol inhalation is for use in adults and children who are at least 4 years old.\n\n',36.00),(2,'amitriptyline','depression','Usual dose: 75 mg orally per day in divided doses; this may be increased to a total of 150 mg per day if needed\nAlternate dose: 40 to 100 mg orally as a single dose at bedtime; this may be increased by 25 or 50 mg as needed at bedtime to a total of 150 mg per day\nMaximum dose: 150 mg orally per day','Get emergency medical help if you have signs of an allergic reaction to amitriptyline: hives; difficulty breathing; swelling of your face, lips, tongue, or throat.\n\nReport any new or worsening symptoms to your doctor, such as: mood or behavior changes, anxiety, panic attacks, trouble sleeping, or if you feel impulsive, irritable, agitated, hostile, aggressive, restless, hyperactive (mentally or physically), more depressed, or have thoughts about suicide or hurting yourself.','Amitriptyline is a tricyclic antidepressant. Amitriptyline affects chemicals in the brain that may be unbalanced in people with depression.\n\nAmitriptyline is used to treat symptoms of depression.\n\nAmitriptyline may also be used for purposes not listed in this medication guide.',24.00),(3,'Zostavax','prevent herpes zoster virus','0.65 mL subcutaneously in the deltoid once\n\nComments: Do not give IV or intramuscularly.\n\nUse: Prevention of herpes zoster (shingles) in individuals 50 years of age and older.','You should not receive a second Zostavax if you had a life-threatening allergic reaction after the first shot.\n\nKeep track of any and all side effects you have after receiving this vaccine. If you ever need to receive a booster dose, you will need to tell the doctor if the previous shots caused any side effects.','Zostavax (zoster vaccine live) is used to prevent herpes zoster virus (shingles) in people age 50 and older.\n\nHerpes zoster is caused by the same virus (varicella) that causes chickenpox in children. When this virus becomes active again in an adult, it can cause herpes zoster, or shingles. Zoster vaccine is a live vaccine that helps prevent shingles.',NULL),(4,'azithromycin','antibiotic','Applies to the following strength(s): 500 mg ; 250 mg ; 1 g ; 600 mg ; 100 mg/5 mL ; 200 mg/5 mL ; 2 g ; 2.5 g','Get emergency medical help if you have signs of an allergic reaction to Zithromax: hives; difficulty breathing; swelling of your face, lips, tongue, or throat.','Zithromax (azithromycin) is an antibiotic that fights bacteria.\n\nZithromax is used to treat many different types of infections caused by bacteria, such as respiratory infections, skin infections, ear infections, and sexually transmitted diseases.\n\nZithromax may also be used for purposes not listed in this medication guide.',NULL),(5,'Forteo','hormone','The recommended dose is 20 mcg subcutaneously once a day.\n\n','Get emergency medical help if you have any of these signs of an allergic reaction: hives; difficulty breathing; swelling of your face, lips, tongue, or throat. Stop using Forteo and call your doctor at once if you have any of these serious side effects:','Forteo is a man-made form of a hormone called parathyroid that exists naturally in the body. Forteo increases bone density and increases bone strength to help prevent fractures.\n\nForteo is used to treat osteoporosis in men and women who have a high risk of bone fracture.\n\nForteo may also be used for other purposes not listed in this medication guide.',NULL),(6,'Flonase','nasal spray containing fluticasone','The usual dose of Flonase is 1 to 2 sprays into each nostril once per day. Your dose may change after your symptoms improve. Follow all dosing instructions very carefully.\n\n','Get emergency medical help if you have signs of an allergic reaction to Flonase: hives; difficult breathing; swelling of your face, lips, tongue, or throat.','Flonase is a nasal spray containing fluticasone. Fluticasone is corticosteroid that prevents the release of substances in the body that cause inflammation.\n\nFlonase nasal spray is used to treat nasal congestion, sneezing, runny nose, and itchy or watery eyes caused by seasonal or year-round allergies.\n\nFlonase nasal spray is for use in adults and children who are at least 4 years old. Flonase is available without a prescription.',NULL),(7,'Brintellix','antidepressant','nitial dose: 10 mg orally once a day\nMaintenance dose: 20 mg orally once a day\nMaximum dose: 20 mg orally once a day','Get emergency medical help if you have any of these signs of an allergic reaction to Brintellix: hives; difficult breathing; swelling of your face, lips, tongue, or throat.\n\nReport any new or worsening symptoms to your doctor, such as: mood or behavior changes, anxiety, panic attacks, trouble sleeping, or if you feel impulsive, irritable, agitated, hostile, aggressive, restless, hyperactive (mentally or physically), more depressed, or have thoughts about suicide or hurting yourself.','Brintellix (vortioxetine) is an antidepressant that affects chemicals in the brain that may become unbalanced.\n\nBrintellix is used to treat major depressive disorder in adults.',NULL),(8,'Biaxin','antibiotic','Take Biaxin exactly as prescribed by your doctor. Follow all directions on your prescription label. Do not take this medicine in larger or smaller amounts or for longer than recommended.\n\nYou may take Biaxin tablets and oral suspension (liquid) with or without food.\n\nClarithromycin extended-release tablets (Biaxin XL) should be taken with food.\n\nDo not crush, chew, or break an extended-release tablet. Swallow it whole.','Get emergency medical help if you have signs of an allergic reaction to Biaxin: hives; difficult breathing; swelling of your face, lips, tongue, or throat.','Biaxin (clarithromycin) is a macrolide antibiotic. Clarithromycin fights bacteria in your body.\n\nBiaxin is used to treat many different types of bacterial infections affecting the skin and respiratory system. It is also used together with other medicines to treat stomach ulcers caused by Helicobacter pylori.',NULL),(9,'Baclofen','muscle relaxer','10 mg ; 20 mg ; 0.05 mg/mL ; 0.5 mg/mL ; 1 mg/mL ; 2 mg/mL',' Get emergency medical help if you have any of these signs of an allergic reaction to baclofen: hives; difficult breathing; swelling of your face, lips, tongue, or throat.','Baclofen is a muscle relaxer and an antispastic agent.\n\nBaclofen is used to treat muscle symptoms caused by multiple sclerosis, including spasm, pain, and stiffness.\n\nBaclofen may also be used for purposes not listed in this medication guide.\n\n',NULL);