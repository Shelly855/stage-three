BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "users" (
	"user_id"	INTEGER,
	"username"	TEXT NOT NULL,
	"password"	TEXT NOT NULL,
	"role"	TEXT NOT NULL,
	"first_name"	TEXT NOT NULL,
	"surname"	TEXT NOT NULL,
	PRIMARY KEY("user_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "patients" (
	"patient_id"	INTEGER,
	"user_id"	INTEGER NOT NULL,
	"email"	TEXT,
	"mobile_number"	INTEGER,
	"date_of_birth"	TEXT,
	"medical_conditions"	TEXT,
	"previous_medical_conditions"	TEXT,
	FOREIGN KEY("user_id") REFERENCES "users"("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY("patient_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "surgery" (
	"surgery_id"	INTEGER,
	"surgery_name"	TEXT NOT NULL,
	"patient_id"	INTEGER NOT NULL,
	"eligible"	INTEGER CHECK("eligible" IN (0, 1)),
	FOREIGN KEY("patient_id") REFERENCES "patients"("patient_id") ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY("surgery_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "POA_questionnaire" (
	"poa_form_id"	INTEGER,
	"surgery_id"	INTEGER NOT NULL,
	"assigned"	INTEGER CHECK("assigned" IN (1, 0)),
	"percentage_completed"	FLOAT,
	"completed"	INTEGER CHECK("completed" IN (1, 0)),
	"date_of_poa"	TEXT,
	"surname"	TEXT,
	"first_name"	TEXT,
	"address"	TEXT,
	"date_of_birth"	TEXT,
	"sex"	TEXT,
	"age"	INTEGER,
	"telephone_number"	INTEGER,
	"occupation"	TEXT,
	"religion"	TEXT,
	"emergency_contact_number"	INTEGER,
	"heart_disease"	INTEGER CHECK("heart_disease" IN (0, 1)),
	"MI"	INTEGER CHECK("MI" IN (0, 1)),
	"hypertension"	INTEGER CHECK("hypertension" IN (0, 1)),
	"angina"	INTEGER CHECK("angina" IN (0, 1)),
	"DVT/PE"	INTEGER CHECK("DVT/PE" IN (0, 1)),
	"stroke"	INTEGER CHECK("stroke" IN (0, 1)),
	"diabetes"	INTEGER CHECK("diabetes" IN (0, 1)),
	"epilepsy"	INTEGER CHECK("epilepsy" IN (0, 1)),
	"jaundice"	INTEGER CHECK("jaundice" IN (0, 1)),
	"sickle_cell_status"	INTEGER CHECK("sickle_cell_status" IN (0, 1)),
	"kidney_disease"	INTEGER CHECK("kidney_disease" IN (0, 1)),
	"arthritis"	INTEGER CHECK("arthritis" IN (0, 1)),
	"asthma"	INTEGER CHECK("asthma" IN (0, 1)),
	"pregnant"	INTEGER CHECK("pregnant" IN (0, 1)),
	"other_health_conditions"	TEXT,
	"previous_medication"	TEXT,
	FOREIGN KEY("surgery_id") REFERENCES "surgery"("surgery_id") ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY("poa_form_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "appointments" (
	"appointment_id"	INTEGER,
	"date"	TEXT NOT NULL,
	"time"	TEXT NOT NULL,
	"clinical_notes"	TEXT,
	"patient_id"	INTEGER NOT NULL,
	FOREIGN KEY("patient_id") REFERENCES "patients"("patient_id") ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY("appointment_id" AUTOINCREMENT)
);
INSERT INTO "users" VALUES (1,'Will23','password1','doctor','Will','Smith');
INSERT INTO "users" VALUES (2,'Mary33','password2','patient','Mary','Johnson');
INSERT INTO "users" VALUES (3,'Sarah12','password3','admin','Sarah','Thorn');
INSERT INTO "users" VALUES (4,'Alex1','ashgjw63','patient','Alex','Smith');
INSERT INTO "users" VALUES (5,'Beth11','4rghs8A','patient','Beth','Jones');
INSERT INTO "users" VALUES (6,'Zara43','rghf93gG','patient','Zara','Khan');
INSERT INTO "users" VALUES (7,'Sam98','28fjsYi','patient','Sam','Saxton');
INSERT INTO "users" VALUES (8,'Max56','sgrh37G','patient','Max','Buckley');
INSERT INTO "patients" VALUES (1,4,'alex@gmail.com',74087613875,'1998-02-12','asthma','hypertension');
INSERT INTO "patients" VALUES (2,5,'BethJones@gmail.com',7409642755,'2002-12-18','diabetes',NULL);
INSERT INTO "patients" VALUES (3,6,'Zara@gmail.com',7408712345,'2003-07-07','Bronchitis',NULL);
INSERT INTO "patients" VALUES (4,7,'sam@hotmail.com',79764283875,'2004-01-10','asthma','kidney disease');
INSERT INTO "patients" VALUES (5,8,'Max@hotmail.com',7034812344,'2001-10-28','arthritis','heart disease');
INSERT INTO "patients" VALUES (6,2,'mary@gmail.com',74086613875,'1998-02-24','asthma','lyme disease');
INSERT INTO "surgery" VALUES (1,'Arm Surgery',2,NULL);
INSERT INTO "surgery" VALUES (2,'Leg Surgery',1,NULL);
INSERT INTO "surgery" VALUES (3,'Brain Surgery',3,1);
INSERT INTO "surgery" VALUES (4,'Knee Surgery',4,NULL);
INSERT INTO "POA_questionnaire" VALUES (1,1,1,20.0,0,'20/03/24','Jones','Beth','12 Green Street','18/12/02','female',21,7409642755,'engineer','Christianity',74035692333,0,0,0,1,0,0,0,0,0,0,0,0,1,0,'n/a','n/a');
INSERT INTO "POA_questionnaire" VALUES (2,2,1,0.0,0,'22/04/24','Smith','Alex','18 Chancer Lane','12/02/98','male',26,74087613875,'nurse','n/a',7407893433,0,0,1,0,0,0,0,0,0,0,0,0,0,0,'n/a','n/a');
INSERT INTO "POA_questionnaire" VALUES (3,3,1,100.0,1,'10/10/24','Zara','Khan','101 Park Lane','07/07/03','female',20,7408712345,'teacher','Islam',74035692343,1,0,0,0,0,0,0,0,0,0,0,1,0,0,'n/a','antibiotics');
INSERT INTO "POA_questionnaire" VALUES (4,4,1,100.0,1,'08/03/24','Sam','Saxton','22 Green Street','10/01/04','male',19,79764283875,'unemployed','n/a',74035182333,0,0,0,1,0,1,0,0,0,0,0,0,0,0,'n/a','n/a');
INSERT INTO "appointments" VALUES (1,'2024-04-13','11:00','n/a',3);
INSERT INTO "appointments" VALUES (2,'2024-05-24','10:00','n/a',5);
INSERT INTO "appointments" VALUES (3,'2024-12-06','01:00','n/a',2);
INSERT INTO "appointments" VALUES (4,'2024-08-25','10:30','n/a',4);
COMMIT;
