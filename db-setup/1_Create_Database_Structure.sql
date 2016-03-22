/*
This script will drop and re-create the database with no dummy data in it. It does not create the views or stored procedures.
*/

DROP DATABASE IF EXISTS prism;
CREATE DATABASE prism;
USE prism;

CREATE TABLE organizations
(
	OrganizationId			INT				PRIMARY KEY 		AUTO_INCREMENT,
    OrganizationName		VARCHAR(100)	UNIQUE				NOT NULL,
    YearlyRevenue			INT				NULL,
    NumOfEmployees			INT				NULL,
	URL						VARCHAR(250)	NULL,
    StreetAddressLineOne	VARCHAR(250)	NULL,
    StreetAddressLineTwo	VARCHAR(250)	NULL,
    City					VARCHAR(250)	NULL,
    State					VARCHAR(250)	NULL,
    Statement				VARCHAR(250)	NULL,
	Description 			TEXT			NOT NULL
);


CREATE TABLE organization_contacts
(
	ContactId				INT				PRIMARY KEY			AUTO_INCREMENT,
    OrganizationId			INT				NOT NULL,
    ContactName				VARCHAR(100)	NOT NULL,
    OfficeNumber			VARCHAR(12),
    OfficeExtension			VARCHAR(10),
	CellNumber				VARCHAR(12),
    EmailAddress			VARCHAR(100),
    OfficeHours				VARCHAR(10), 
	CONSTRAINT Organization_Contact_fk_OrganizationId
		FOREIGN KEY (OrganizationId)
        REFERENCES organizations(OrganizationId)
);


CREATE TABLE internships
(
	InternshipId 			INT				PRIMARY KEY			AUTO_INCREMENT,
    PositionTitle			VARCHAR(100)	NOT NULL,
	Description				TEXT			NOT NULL,
    OrganizationId			INT				NOT NULL,
    LocationState			VARCHAR(250)	NOT NULL,
    LocationZip				VARCHAR(10)		NOT NULL,
    DatePosted				DATE			NOT NULL,
    AppStartDate			DATE			NOT NULL,
    AppEndDate				DATE			NOT NULL,
	StartDate				DATE			NOT NULL,
    EndDate					DATE,			
    SlotsAvailable			INT				NOT NULL,
    LastUpdated				DATETIME		NOT NULL,
	CONSTRAINT Internship_fk_OrganizationId
		FOREIGN KEY (OrganizationId)
        REFERENCES organizations(OrganizationId)
);

CREATE TABLE user_types
(
	TypeId					INT				PRIMARY KEY			AUTO_INCREMENT,
    TypeName				VARCHAR(12)		UNIQUE				NOT NULL
);


CREATE TABLE users
(
	UserId					INT				PRIMARY KEY			AUTO_INCREMENT,

    FirstName				VARCHAR(250)	NOT NULL,
    MiddleName				VARCHAR(250)	NULL,
    LastName				VARCHAR(250)	NULL,
    ContactInfo				TEXT			NULL,
    UserName				VARCHAR(250)	NOT NULL			UNIQUE,
    UserPassword			VARCHAR(500)	NOT NULL,
    TypeId					INT				NOT NULL,
	CONSTRAINT User_fk_TypeId
		FOREIGN KEY (TypeId)
        REFERENCES user_types(TypeId)
);


CREATE TABLE students
(
	StudentId				INT 			PRIMARY KEY, 
    ProgramStatus			VARCHAR(12)		NOT NULL,
	InternshipId 			INT				NULL,
	Cohort					INT				NOT NULL,
    UserId					INT				UNIQUE 				NOT NULL,
	StreetAddressLineOne	VARCHAR(250)	NULL,
    StreetAddressLineTwo	VARCHAR(250)	NULL,
    City					VARCHAR(250)	NULL,
    State					VARCHAR(250)	NULL,
	CONSTRAINT Student_fk_InternshipId
		FOREIGN KEY (InternshipId)
        REFERENCES internships(InternshipId),
	CONSTRAINT Student_fk_UserId
		FOREIGN KEY (UserId)
        REFERENCES users(UserId)
);

CREATE TABLE student_internships
(
	InternshipId 			INT				NOT NULL,
	StudentId				INT 			NOT NULL,
	CONSTRAINT Student_Internship_fk_InternshipId
		FOREIGN KEY (InternshipId)
        REFERENCES internships(InternshipId),
	CONSTRAINT Student_Internship_fk_StudentId
		FOREIGN KEY (StudentId)
        REFERENCES students(StudentId)
);

CREATE TABLE student_contact_log
(
	Student_Contact_LogId	INT 			PRIMARY KEY			AUTO_INCREMENT, 
    StudentId				INT 			NOT NULL,
    LogTime					TIMESTAMP		NOT NULL			
	DEFAULT CURRENT_TIMESTAMP  		ON UPDATE CURRENT_TIMESTAMP,
    Notes					TEXT			NOT NULL,
	UserId					INT				NOT NULL,
	CONSTRAINT Student_Contact_Log_fk_StudentId
		FOREIGN KEY (StudentId)
        REFERENCES students(StudentId),
	CONSTRAINT Student_Contact_Log_fk_UserId
		FOREIGN KEY (UserId)
        REFERENCES users(UserId)
);


CREATE TABLE change_log
(
	Change_LogId			INT 			PRIMARY KEY			AUTO_INCREMENT, 
    LogTime					TIMESTAMP		NOT NULL			
	DEFAULT CURRENT_TIMESTAMP  		ON UPDATE CURRENT_TIMESTAMP,
    UserId					INT				NOT NULL,
    Message					TEXT			NOT NULL,
	CONSTRAINT Change_Log_fk_UserId
		FOREIGN KEY (UserId)
        REFERENCES users(UserId)
);


CREATE TABLE user_notes
(
	User_NoteId				INT 			PRIMARY KEY			AUTO_INCREMENT, 
	UserId					INT				NOT NULL,
	Note_Type				VARCHAR(100)	NOT NULL,
    Note_Text				TEXT			NOT NULL,
	CONSTRAINT User_Note_Log_fk_UserId
		FOREIGN KEY (UserId)
        REFERENCES users(UserId)
);

SET NAMES 'utf8';

--
-- Inserting data into table organizations
--
INSERT INTO user_types
(TypeId, TypeName)
VALUES
(1, 'Student'),
(2, 'Admin'),
(3, 'Staff');
