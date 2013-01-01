DROP SEQUENCE SEQUENCE_CONSULTATION;
DROP SEQUENCE SEQUENCE_TRAITEMENT;
DROP SEQUENCE SEQUENCE_TRAITEMENT_MEDICAMENT;
DROP SEQUENCE SEQUENCE_RECOMMENDATION;
DROP SEQUENCE SEQUENCE_LAB_MEDICAMENT;
DROP SEQUENCE SEQUENCE_MEDECIN_MEDICAMENT;
DROP SEQUENCE SEQUENCE_MEDECIN_LABORATOIRE;
DROP SEQUENCE SEQUENCE_PATIENT;
DROP SEQUENCE SEQUENCE_MEDECIN;
DROP SEQUENCE SEQUENCE_SUBS_ACT_CLASSE_CH;
DROP SEQUENCE SEQUENCE_SUBS_ACT_CLASSE_PH;

DROP TABLE Laboratoires_Medicaments;
DROP TABLE Medecins_Medicaments;
DROP TABLE Traitement_Recommendations;
DROP TABLE Traitement_Medicaments;
DROP TABLE Maladie_Medicament;
DROP TABLE Medicaments_Substances_OMS; 
DROP TABLE Consultation_Maladie;
DROP TABLE Symptomes_Consultation;
DROP TABLE Symptomes_Maladies;
DROP TABLE Correspondance_Substances;
DROP TABLE Interactions_Substances;
DROP TABLE Correspondance_EI_OMS_FR;
DROP TABLE Effet_Indesirable_Substance_FR;
DROP TABLE Medecins_Laboratoires;
DROP TABLE Patients_Caracteristiques;
DROP TABLE Patients_MaladieChronique;
DROP TABLE Caracteristiques;
DROP TABLE Maladies_Chroniques;
DROP TABLE Traitements;
DROP TABLE Consultations;
DROP TABLE Symptomes;
DROP TABLE Patients;
DROP TABLE Medecins;
DROP TABLE Laboratoires;
DROP TABLE Effets_Indesirables_FR;
DROP TABLE Effets_Indesirables_OMS;
DROP TABLE Classes_Pharmacologiques;
DROP TABLE Classes_Chimiques;
DROP TABLE Maladies;
DROP TABLE Medicaments;
DROP TABLE Substances_Actives_FR;
DROP TABLE Substances_Actives_OMS;
DROP TYPE Substance;
DROP TYPE Classe_T;
DROP TYPE CodeLibelle;
DROP TYPE Medecin;
DROP TYPE Personne;
DROP TYPE Adresse_Type;
DROP TYPE Classe;

CREATE SEQUENCE SEQUENCE_CONSULTATION
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_TRAITEMENT
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_TRAITEMENT_MEDICAMENT
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;
  
CREATE SEQUENCE SEQUENCE_RECOMMENDATION
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;	

CREATE SEQUENCE SEQUENCE_LAB_MEDICAMENT
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_MEDECIN_MEDICAMENT
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_MEDECIN_LABORATOIRE
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_MEDECIN
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_PATIENT
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_SUBS_ACT_CLASSE_CH
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_SUBS_ACT_CLASSE_PH
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE TABLE Maladies (
    idMaladie        VARCHAR2(50),	
	codeArborescence VARCHAR2(50),
	idPere           VARCHAR2(50),
    libelle          VARCHAR2(100),
    CONSTRAINT pkMaladies PRIMARY KEY (idMaladie)
);

CREATE TABLE Medicaments (
    codeCIS VARCHAR2(10),
    libelleMedicament VARCHAR2(100),
    CONSTRAINT PKMedicaments PRIMARY KEY (codeCIS)
);

CREATE TABLE Maladie_Medicament (
    idMaladie VARCHAR2(50),
    codeCIS VARCHAR2(10),
    CONSTRAINT pkMaladieMedicament PRIMARY KEY (idMaladie, codeCIS),
    CONSTRAINT FKMaladieMedicament FOREIGN KEY(idMaladie) REFERENCES Maladies(idMaladie),
    CONSTRAINT FKMaladieMedicamentCodeCIS FOREIGN KEY(codeCIS) REFERENCES Medicaments(codeCIS)
);

CREATE TABLE Medicaments_Substances_OMS (
    codeCIS varchar2(10),
    codeSubstanceOMS varchar2(5),
    CONSTRAINT pkMedicamentSubstance PRIMARY KEY(codeCIS, codeSubstanceOMS),
    CONSTRAINT FKCodeCIS FOREIGN KEY(codeCIS) REFERENCES Medicaments(codeCIS),
    CONSTRAINT FKCodeSubsOMS FOREIGN KEY(codeSubstanceOMS) REFERENCES Maladies(idMaladie)
);

CREATE TYPE Classe AS OBJECT(
	identifiant  VARCHAR2(5),
	libelle      VARCHAR2(60), 
	idPere       VARCHAR2(5)
);
/
CREATE TABLE Classes_Pharmacologiques OF Classe (
    CONSTRAINT PKClasses_Pharmacologiques PRIMARY KEY(identifiant)
);

CREATE TABLE Classes_Chimiques OF Classe (
    CONSTRAINT PKClasses_Chimiques PRIMARY KEY(identifiant)
);

CREATE TYPE Substance AS OBJECT (
    identifiant VARCHAR2(5),
    libelle     VARCHAR2(60)
);
/


CREATE TABLE Substances_Actives_FR OF Substance (
    CONSTRAINT PKSubstances_Actives_FR PRIMARY KEY(identifiant)
);

CREATE TABLE Substances_Actives_OMS OF Substance (
    CONSTRAINT PKSubstances_Actives_OMS PRIMARY KEY(identifiant)
);

CREATE TABLE SubsActClasseChimique (
    identifiant  NUMBER(9),
    substance    VARCHAR2 (5),
    classe       VARCHAR2(5),
    CONSTRAINT PKSubsActClasseChimique PRIMARY KEY(identifiant),
    FOREIGN KEY (substance) REFERENCES Substances_Actives_OMS(identifiant),
    FOREIGN KEY (classe) REFERENCES Classes_Chimiques(identifiant)
);

CREATE TABLE SubsActClassePharmaco (
    identifiant  NUMBER(9),
    substance    VARCHAR2 (5),
    classe       VARCHAR2(5),
    CONSTRAINT PKSubsActClassePharmaco PRIMARY KEY(identifiant),
    FOREIGN KEY (substance) REFERENCES Substances_Actives_OMS(identifiant),
    FOREIGN KEY (classe) REFERENCES Classes_Pharmacologiques(identifiant)
);

CREATE TABLE Correspondance_Substances (
    identifiantOMS  VARCHAR2(5),
    identifiantFR   VARCHAR2(5),
    CONSTRAINT PKCorrespondance_Substances PRIMARY KEY(identifiantOMS, identifiantFR)
);

CREATE TABLE Interactions_Substances (
    idSubstance1   VARCHAR2(5),
    idSubstance2   VARCHAR2(5),
    CONSTRAINT PKInteraction_Substances PRIMARY KEY(idSubstance1, idSubstance2)
);

CREATE TABLE Effets_Indesirables_OMS (
    identifiant    NUMBER(8),
    libelle   	   VARCHAR2(60),
    idPere   	   VARCHAR2(8),
    CONSTRAINT PKEffets_Indesirables_OMS primary key(identifiant)
);

CREATE TABLE Effets_Indesirables_FR (
    identifiant    VARCHAR2(4),
    libelle   	   VARCHAR2(60),
    idPere   	   VARCHAR2(8),
    CONSTRAINT PKEffets_Indesirables_FR primary key(identifiant)
);

CREATE TABLE Correspondance_EI_OMS_FR (
    EI_OMS    NUMBER(8) PRIMARY KEY,
    EI_FR     VARCHAR2(4),
    FOREIGN KEY (EI_FR) REFERENCES Effets_Indesirables_FR(identifiant),
    FOREIGN KEY (EI_OMS) REFERENCES Effets_Indesirables_OMS(identifiant)
);

CREATE TABLE Effet_Indesirable_Substance_FR (
    identifiant        NUMBER(6) PRIMARY KEY,
    idSubstance        VARCHAR2(5),
    idEffetIndesirable VARCHAR2(4),
    FOREIGN KEY (idSubstance) REFERENCES Substances_Actives_FR(identifiant),
    FOREIGN KEY (idEffetIndesirable) REFERENCES Effets_Indesirables_FR(identifiant)
);

CREATE TYPE CodeLibelle AS OBJECT (
    code    VARCHAR2(10),
    libelle VARCHAR2(60)
);
/

CREATE TABLE Caracteristiques OF CodeLibelle (
     CONSTRAINT PKCaracteristiques PRIMARY KEY(code)
);

CREATE TABLE Maladies_Chroniques OF CodeLibelle (
     CONSTRAINT Maladies_Chroniques PRIMARY KEY(code)
);

CREATE TABLE Symptomes OF CodeLibelle (
     CONSTRAINT PKSymptomes PRIMARY KEY(code)
);

CREATE TYPE Adresse_Type AS OBJECT (
    numero     NUMBER(3),
    adresse    VARCHAR2(50),
    ville      VARCHAR2(50), 
    codePostal NUMBER(5)
);
/

CREATE TYPE Personne AS OBJECT (
    matricule     NUMBER(9),
    nom           VARCHAR2(40),
    prenom        VARCHAR2(40),
    telephone     NUMBER(10),
    numeroSecu    NUMBER(15),
    dateNaissance DATE,
    adresse       Adresse_Type
)NOT FINAL;
/

CREATE or replace TYPE Medecin UNDER Personne (
    login       VARCHAR2(40),
    motDePasse  VARCHAR2(100),
    role       VARCHAR2(15)
);
/

CREATE TABLE Patients OF Personne (
    CONSTRAINT PKPatients PRIMARY KEY(matricule)
);

CREATE TABLE Patients_Caracteristiques (
	 code          VARCHAR2(10),
	 matricule     NUMBER(9),
	 CONSTRAINT PKPatients_Caracteristiques PRIMARY KEY(code, matricule),
	 FOREIGN KEY (code) REFERENCES Caracteristiques(code),
	 FOREIGN KEY (matricule) REFERENCES Patients(matricule)
);

CREATE TABLE Patients_MaladieChronique (
	 code        VARCHAR2(10),
	 matricule   NUMBER(9),
	 CONSTRAINT PKPatients_MaladiesChroniques PRIMARY KEY(code, matricule),
	 FOREIGN KEY (code) REFERENCES Maladies_Chroniques(code),
	 FOREIGN KEY (matricule) REFERENCES Patients(matricule)
);

CREATE TABLE Medecins OF Medecin (  
    CONSTRAINT PKMedecins PRIMARY KEY(matricule)
);

CREATE TABLE Laboratoires (
    identifiant   NUMBER(9),
    nom           VARCHAR2(50),
    CONSTRAINT PKLaboratoires PRIMARY KEY(identifiant)
);

CREATE TABLE Consultations (
    identifiant         NUMBER(9),
    matriculeMedecin    NUMBER(9),
    matriculePatient    NUMBER(9),
    dateConsultation    DATE,
    CONSTRAINT PKConsultation PRIMARY KEY(identifiant),
    FOREIGN KEY (matriculeMedecin) REFERENCES Medecins(matricule),
    FOREIGN KEY (matriculePatient) REFERENCES Patients(matricule)
);

CREATE TABLE Consultation_Maladie (
    idConsultation      NUMBER(9),
    idMaladie           VARCHAR2(50),
    CONSTRAINT PKConsultationMaladie PRIMARY KEY(idConsultation, idMaladie),
    FOREIGN KEY (idConsultation) REFERENCES Consultations(identifiant),
    FOREIGN KEY (idMaladie) REFERENCES Maladies(idMaladie)
);

CREATE TABLE Symptomes_Consultation (
    identifiant       NUMBER(9),
    idConsultation    NUMBER(9),
    codeSymptome      VARCHAR2(10),
    CONSTRAINT PKSymptomes_Consultation PRIMARY KEY(identifiant),
    FOREIGN KEY (idConsultation) REFERENCES Consultations(identifiant),
    FOREIGN KEY (codeSymptome) REFERENCES Symptomes(code)
);

CREATE TABLE Symptomes_Maladies (
    identifiant       NUMBER(9),
    idMaladie         VARCHAR2(50),
    codeSymptome      VARCHAR2(10),
    CONSTRAINT PKSymptomes_Maladies PRIMARY KEY(identifiant),
    FOREIGN KEY (idMaladie) REFERENCES Maladies(idMaladie),
    FOREIGN KEY (codeSymptome) REFERENCES Symptomes(code)
);

CREATE TABLE Traitements (
    identifiant       NUMBER(9),
    idConsultation    NUMBER(9),
    duree	      NUMBER(3),
    CONSTRAINT PKTraitement PRIMARY KEY(identifiant),
    FOREIGN KEY (idConsultation) REFERENCES Consultations(identifiant)
);

CREATE TABLE Traitement_Recommendations (
    identifiant       NUMBER(9),
    idTraitement      NUMBER(9),
    recommendation    VARCHAR2(150),
    CONSTRAINT PKRecommendations PRIMARY KEY(identifiant),
    FOREIGN KEY (idTraitement) REFERENCES Traitements(identifiant)
);

CREATE TABLE Traitement_Medicaments (
    identifiant  NUMBER(9),
    idTraitement NUMBER(9),
    codeCIS VARCHAR2(10),
    CONSTRAINT PKTraitement_Medicaments PRIMARY KEY(identifiant),
    FOREIGN KEY (idTraitement) REFERENCES Traitements(identifiant),
    FOREIGN KEY (codeCIS) REFERENCES Medicaments(codeCIS)
);

CREATE TABLE Medecins_Laboratoires (
    identifiant   NUMBER(9),
    matricule     NUMBER(9),
    idLab         NUMBER(9),
    dateEntree    DATE,
    dateSortie    DATE,
    CONSTRAINT PKMedecins_Laboratoires PRIMARY KEY(identifiant),
    FOREIGN KEY (matricule) REFERENCES Medecins(matricule),
    FOREIGN KEY (idLab) REFERENCES Laboratoires(identifiant)
);

CREATE TABLE Laboratoires_Medicaments (
    identifiant  NUMBER(9),
    codeCIS VARCHAR2(10),
    idLab         NUMBER(9),
    CONSTRAINT PKLaboratoires_Medicaments PRIMARY KEY(identifiant),
    FOREIGN KEY (codeCIS) REFERENCES Medicaments(codeCIS),
    FOREIGN KEY (idLab) REFERENCES Laboratoires(identifiant)
);

CREATE TABLE Medecins_Medicaments (
    identifiant  NUMBER(9),
    codeCIS VARCHAR2(10),
    matricule     NUMBER(9),
    CONSTRAINT PKMedecins_Medicaments PRIMARY KEY(identifiant),
    FOREIGN KEY (matricule) REFERENCES Medecins(matricule),
    FOREIGN KEY (codeCIS) REFERENCES Medicaments(codeCIS)
);

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_MEDECINS
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_MEDECINS
BEFORE INSERT ON MEDECINS 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_MEDECIN.NEXTVAL INTO :new.matricule FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_PATIENTS
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_PATIENTS 
BEFORE INSERT ON PATIENTS 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_PATIENT.NEXTVAL INTO :new.matricule FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_CONSULTATIONS
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_CONSULTATIONS 
BEFORE INSERT ON CONSULTATIONS 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_CONSULTATION.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_TRAITEMENTS 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_TRAITEMENTS 
BEFORE INSERT ON TRAITEMENTS 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_TRAITEMENT.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_RECOMMENDATIONS 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_RECOMMENDATIONS 
BEFORE INSERT ON TRAITEMENT_RECOMMENDATIONS 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_RECOMMENDATION.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_TRAITEMENT_MEDICAMENTS 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_TRAIT_MEDIC
BEFORE INSERT ON TRAITEMENT_MEDICAMENTS 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_TRAITEMENT_MEDICAMENT.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_LABORATOIRES_MEDICAMENTS 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_LAB_MEDIC 
BEFORE INSERT ON LABORATOIRES_MEDICAMENTS
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_LAB_MEDICAMENT.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_MEDECINS_MEDICAMENTS 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_MEDECINS_MEDICAMENTS 
BEFORE INSERT ON MEDECINS_MEDICAMENTS 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_MEDECIN_MEDICAMENT.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_MEDECINS_LABORATOIRES 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_MEDECINS_LAB 
BEFORE INSERT ON MEDECINS_LABORATOIRES 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_MEDECIN_LABORATOIRE.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_SubsClasseChimique 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_SubsClasseChimique 
BEFORE INSERT ON SubsActClasseChimique 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_SUBS_ACT_CLASSE_CH.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_SubsClassePharmaco 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_SubsClassePharmaco 
BEFORE INSERT ON SubsActClassePharmaco 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_SUBS_ACT_CLASSE_PH.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Function AFFECTER_MALADIE_PATIENT
--------------------------------------------------------
CREATE OR REPLACE FUNCTION AFFECTER_MALADIE_PATIENT (idPatient Consultations.matriculePatient%TYPE,
  idMedecin Consultations.matriculeMedecin%TYPE,
  idMaladie Maladies.idMaladie%TYPE) RETURN BOOLEAN IS

  idConsult  NUMBER(9);
BEGIN
  SELECT identifiant INTO idConsult FROM Consultations 
  WHERE matriculePatient = idPatient 
    AND matriculeMedecin = idMedecin
    AND dateConsultation = SYSDATE;
  
  IF idConsult = NULL THEN 
    INSERT INTO Consultations VALUES (SEQUENCE_CONSULTATION.NEXTVAL, idMedecin,
    idPatient, SYSDATE);
    idConsult := SEQUENCE_CONSULTATION.CURRVAL;
  END IF;
  
  INSERT INTO Consultation_Maladie VALUES (idConsult, idMaladie);
  RETURN TRUE;

EXCEPTION
  WHEN Others then
    RETURN FALSE;
END;
/
--------------------------------------------------------
--  DDL for Function IDENTIFIER_MALADIES
--------------------------------------------------------
CREATE OR REPLACE FUNCTION IDENTIFIER_MALADIES (
  idPatient Patients.matricule%TYPE) RETURN SYS_REFCURSOR IS
curseur SYS_REFCURSOR;
BEGIN


    RETURN curseur;
END IDENTIFIER_MALADIES;
/
--------------------------------------------------------
--  DDL for Function MEDICAMENTS_FROM_MALADIE
--------------------------------------------------------
CREATE OR REPLACE FUNCTION MEDICAMENTS_FROM_MALADIE (
idMal Maladies.idMaladie%TYPE) RETURN SYS_REFCURSOR IS 
curseur SYS_REFCURSOR;
BEGIN
--A ESSAYER
    OPEN curseur FOR
    SELECT mm.codeCis FROM Maladie_Medicament mm
    JOIN Maladies ON maladies.idmaladie = mm.idmaladie
    WHERE mm.idMaladie = idMal
    CONNECT BY idpere = PRIOR maladies.idmaladie;
    RETURN curseur;
    
END MEDICAMENTS_FROM_MALADIE;
/
--------------------------------------------------------
--  DDL for Function PRESCRIRE_MEDICAMENT
--------------------------------------------------------
CREATE OR REPLACE FUNCTION PRESCRIRE_MEDICAMENT (
  idConsult traitements.idconsultation%TYPE, duration NUMBER,
  cis medicaments.codecis%TYPE) RETURN BOOLEAN IS
  
  idTrait  NUMBER(9);
BEGIN
  
  SELECT identifiant INTO idTrait FROM Traitements 
  WHERE idConsultation = idConsult;

  INSERT INTO traitement_medicaments(idTraitement, codeCIS) VALUES (idTrait, cis);
  RETURN TRUE;  
    
EXCEPTION
  WHEN no_data_found THEN
    INSERT INTO Traitements (idConsultation, duree) VALUES(idConsult, duration);
    idTrait := SEQUENCE_TRAITEMENT.CURRVAL;
    INSERT INTO traitement_medicaments(idTraitement, codeCIS) VALUES (idTrait, cis);
      
  WHEN Others then
    RETURN FALSE;
END;
/

--------------------------------------------------------
--  DDL for Function PRESCRIRE_RECOMMENDATION
--------------------------------------------------------
CREATE OR REPLACE FUNCTION PRESCRIRE_RECOMMENDATION (
  idConsult traitements.idconsultation%TYPE, duration NUMBER,
  rec Traitement_Recommendations.recommendation%TYPE) RETURN BOOLEAN IS
  
  idTrait  NUMBER(9);
BEGIN
  
  SELECT identifiant INTO idTrait FROM Traitements 
  WHERE idConsultation = idConsult;

  INSERT INTO Traitement_Recommendations(idTraitement, recommendation) VALUES (idTrait, rec);
  RETURN TRUE;
  
EXCEPTION
  WHEN no_data_found THEN
    INSERT INTO Traitements (idConsultation, duree) VALUES(idConsult, duration);
    idTrait := SEQUENCE_TRAITEMENT.CURRVAL;
    INSERT INTO Traitement_Recommendations(idTraitement, recommendation) VALUES (
        idTrait, rec);
    RETURN TRUE;
    
  WHEN Others then
    RETURN FALSE;
END;
/
