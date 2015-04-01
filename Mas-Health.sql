/* Create Database */ 

/* CREATE DATABASE MasHealth; */

CREATE TABLE Admin(

	Username VARCHAR(15) NOT NULL,
	FirstName VARCHAR(20) NOT NULL,
	LastName VARCHAR(20) NOT NULL,
	Password VARCHAR(65) NOT NULL,
	PRIMARY KEY(Username)
);

CREATE TABLE Doctor(
	
	DoctorID INT(6) UNSIGNED AUTO_INCREMENT,
	FirstName VARCHAR(20) NOT NULL,
	LastName VARCHAR(20) NOT NULL,
	Password VARCHAR(65) NOT NULL,
	PasswordCheck CHAR(1) NOT NULL DEFAULT 'N',
	AddressLine1 VARCHAR(50) NOT NULL,
	AddressLine2 VARCHAR(50),
	City VARCHAR(30) NOT NULL,
	ContactNumber VARCHAR(30) NOT NULL,
	Email VARCHAR(250) NOT NULL UNIQUE,
	DOB DATE NOT NULL,
	PRIMARY KEY(DoctorID)
	
);

CREATE TABLE Patient(

	PatientID INT(6) UNSIGNED AUTO_INCREMENT,
	FirstName VARCHAR(20) NOT NULL,
	LastName VARCHAR(20) NOT NULL,
	Password VARCHAR(65) NOT NULL,
	PasswordCheck CHAR(1) NOT NULL DEFAULT 'N',
	DOB DATE NOT NULL,
	ContactNumber VARCHAR(30) NOT NULL,
	EmergencyContactName VARCHAR(30),
	EmergencyContactNumber VARCHAR(30),
	AddressLine1 VARCHAR(50) NOT NULL,
	AddressLine2 VARCHAR(50),
	City VARCHAR(30) NOT NULL,
	Email VARCHAR(250) NOT NULL UNIQUE,
	SharedHealthFlag CHAR(1) NOT NULL DEFAULT 'N',
	EventFlag CHAR(1) NOT NULL DEFAULT 'N',
	PRIMARY KEY(PatientID)
	
);


CREATE TABLE Event(
	EventID INT(6) UNSIGNED AUTO_INCREMENT,
	PatientID INT(6) UNSIGNED NOT NULL,
	DoctorID INT(6) UNSIGNED NOT NULL,
	EventDate DATE NOT NULL,
	Synopsis  VARCHAR(2048) NOT NULL,
	FOREIGN KEY (PatientID) REFERENCES Patient(PatientID),
	FOREIGN KEY (DoctorID) REFERENCES Doctor(DoctorID),
	PRIMARY KEY(EventID)
);

CREATE TABLE AdverseReaction(
                AdverseReactionID INT(6) UNSIGNED AUTO_INCREMENT,
                Substance VARCHAR(50) NOT NULL,
                Manifestation VARCHAR(50) NOT NULL,
                PatientID INT(6) UNSIGNED NOT NULL,
                FOREIGN KEY(PatientID) REFERENCES Patient(PatientID),
                PRIMARY KEY(AdverseReactionID)
                );

CREATE TABLE Medication
            (
	            MedicationID INT(6) UNSIGNED AUTO_INCREMENT,
                Medicine VARCHAR(50) NOT NULL,
                Dosage VARCHAR(50) NOT NULL,
                Indication VARCHAR(50) NOT NULL,
                Comments VARCHAR(50),
                DatePrescribed DATE NOT NULL,
                PatientID INT(6) UNSIGNED NOT NULL,
                FOREIGN KEY(PatientID) REFERENCES Patient(PatientID),
                PRIMARY KEY(MedicationID)
            );

CREATE TABLE Diagnosis(
                    DiagnosisID INT(6) UNSIGNED AUTO_INCREMENT,
                    Diagnosis VARCHAR(50) NOT NULL,
                    DateOfOnset DATE NOT NULL,
                    Comments VARCHAR(100),
                    PatientID INT(6) UNSIGNED NOT NULL,
                    FOREIGN KEY(PatientID) REFERENCES Patient(PatientID),
                    PRIMARY KEY(DiagnosisID)
             );
             
             
CREATE TABLE Immunization(
                    ImmunizationID INT(6) UNSIGNED AUTO_INCREMENT,
                    Disease VARCHAR(50) NOT NULL,
	                Vaccine VARCHAR(50) NOT NULL,
                    DateImmunized DATE NOT NULL,
                    PatientID INT(6) UNSIGNED NOT NULL,
                    FOREIGN KEY(PatientID) REFERENCES Patient(PatientID),
                    PRIMARY KEY(ImmunizationID)
                    );
