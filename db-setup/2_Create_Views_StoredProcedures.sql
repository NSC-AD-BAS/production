USE prism;
-- 
-- View Creation
-- 

CREATE OR REPLACE VIEW internship_list AS
    (SELECT 
        i.InternshipId,
        o.organizationId,
        i.PositionTitle AS `Position Title`,
        o.OrganizationName AS `Organization`,
		i.SlotsAvailable AS `Slots Available`,
        i.DatePosted AS `Date Posted`,
        o.City,
        o.State,
        i.StartDate AS `Start Date`,
        i.EndDate AS `End Date`
    FROM
        internships i
            JOIN
        organizations o ON o.OrganizationId = i.OrganizationId);

-- View to be used with stored procedure for single record detail views. 
CREATE OR REPLACE VIEW internship_detail AS
    (SELECT 
        i.InternshipId,
        i.PositionTitle AS `Position Title`,
        o.OrganizationName AS `Organization`,
        i.DatePosted AS `Date Posted`,
        i.StartDate AS `Start Date`,
        i.EndDate AS `End Date`,
        o.StreetAddressLineOne AS `Address 1`,
        o.StreetAddressLineTwo AS `Address 2`,
        o.City,
        o.State,
        i.description AS `Job Description`,
        i.LastUpdated AS `Last Update`
    FROM
        internships i
            JOIN
        organizations o ON o.OrganizationId = i.OrganizationId);

CREATE OR REPLACE VIEW org_list AS
    (SELECT 
        o.OrganizationName AS `Organization Name`,
        o.City,
        o.State,
        COUNT(i.InternshipId) AS `Number of Positions`
    FROM
        organizations o
            JOIN
        internships i ON o.OrganizationId = i.OrganizationId
    GROUP BY o.OrganizationId);

CREATE OR REPLACE VIEW org_detail AS
    (SELECT 
        o.OrganizationId,
        o.OrganizationName AS `Organization`,
        o.URL,
        o.StreetAddressLineOne AS `Address 1`,
        o.StreetAddressLineTwo AS `Address 2`,
        o.City,
        o.State,
        o.NumOfEmployees AS `Number of Employees`,
        o.YearlyRevenue AS `Yearly Revenue`,
        o.Statement,
        o.Description
    FROM
        organizations o
            JOIN
        internships i ON o.OrganizationId = i.OrganizationId);

CREATE OR REPLACE VIEW student_list AS
    (SELECT 
        u.FirstName AS `Student First Name`,
        u.MiddleName AS `Student Middle Name`,
		u.LastName AS `Student Last Name`,
        s.StudentId AS `SID`,
        s.Cohort,
        s.ProgramStatus AS `Program Status`,
        i.positionTitle AS `Internship`,
        un.Note_Text AS `Notes`
    FROM
        students s
            JOIN
        users u ON u.userId = s.userId
            JOIN
        internships i ON i.InternshipId = s.InternshipId
            JOIN
        user_notes un ON un.userId = s.userId);

CREATE OR REPLACE VIEW student_detail AS
    (SELECT 
		u.FirstName AS `Student First Name`,
        u.MiddleName AS `Student Middle Name`,
		u.LastName AS `Student Last Name`,
        s.StudentId AS `SID`,
        s.Cohort,
        s.ProgramStatus AS `Program Status`,
        i.positionTitle AS `Internship`,
        u.contactInfo AS `Contact`,
        s.StreetAddressLineOne AS `Address 1`,
        s.StreetAddressLineTwo AS `Address 2`,
        s.City,
        s.State,
        un.Note_Text AS `Notes`
    FROM
        students s
            JOIN
        users u ON u.userId = s.userId
            JOIN
        internships i ON i.InternshipId = s.InternshipId
            JOIN
        user_notes un ON un.userId = s.userId);

CREATE OR REPLACE VIEW user_list AS
    (SELECT 
        u.UserId AS `User ID`,
		u.FirstName AS `Student First Name`,
        u.MiddleName AS `Student Middle Name`,
		u.LastName AS `Student Last Name`,
        u.ContactInfo AS `Contact`,
        t.TypeName AS `User Type`,
        n.Note_Text AS `Notes`
    FROM
        users u
            JOIN
        user_types t ON t.TypeId = u.TypeId
            AND t.TypeName != 'Student'
            JOIN
        user_notes n ON n.UserId = u.UserId);

CREATE OR REPLACE VIEW user_detail AS
    (SELECT 
        *
    FROM
        user_list);

CREATE OR REPLACE VIEW change_list AS
    (SELECT 
        c.Change_LogId,
        c.LogTime,
        c.UserId,
       	u.FirstName AS `Student First Name`,
        u.MiddleName AS `Student Middle Name`,
		u.LastName AS `Student Last Name`,
        c.Message
    FROM
        change_log c
            JOIN
        users u ON u.UserId = c.UserId);

CREATE OR REPLACE VIEW change_detail AS
    (SELECT 
        *
    FROM
        change_list);

DROP PROCEDURE IF EXISTS `internship_detail_single`;
DROP PROCEDURE IF EXISTS `org_detail_single`;
DROP PROCEDURE IF EXISTS `internship_list_by_org`;
DROP PROCEDURE IF EXISTS `student_detail_single`;
DROP PROCEDURE IF EXISTS `user_detail_single`;
DROP PROCEDURE IF EXISTS `change_detail_single`;

DELIMITER //
CREATE PROCEDURE `internship_detail_single` (IN internship_ID INT)
	BEGIN
		SELECT * FROM internship_detail i
		WHERE i.InternshipId = internship_id;
	END //
    
CREATE PROCEDURE `org_detail_single` (IN org_ID INT)
	BEGIN
		SELECT * FROM org_detail o
		WHERE o.organizationId = org_id;
	END //

CREATE PROCEDURE `internship_list_by_org` (IN org_ID INT)
	BEGIN
		SELECT * FROM internship_list i
		WHERE i.`organizationId` = org_ID;
	END //
    
CREATE PROCEDURE `student_detail_single` (IN sid INT)
	BEGIN
		SELECT * FROM student_detail s
		WHERE s.SID = sid;
	END //
    
CREATE PROCEDURE `user_detail_single` (IN user_id INT)
	BEGIN
		SELECT * FROM user_detail u
		WHERE u.`User Id` = user_id;
	END //
    
CREATE PROCEDURE `change_detail_single` (IN change_id INT)
	BEGIN
		SELECT * FROM change_detail c
		WHERE c.Change_LogId = change_id;
	END //
DELIMITER ; 

