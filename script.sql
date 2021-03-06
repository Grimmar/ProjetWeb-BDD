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
DROP SEQUENCE SEQUENCE_SURVEILLANCE;
DROP SEQUENCE SEQUENCE_EI_FR;
DROP SEQUENCE SEQUENCE_EI_OMS;
DROP SEQUENCE SEQUENCE_SYMPTOME;

DROP TABLE Surveillance;
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
DROP TABLE Effet_Indesirable_Classe_Chim;
DROP TABLE Effet_Indesirable_Classe_Phar;
DROP TABLE Effet_Indesirable_Subs_OMS;
DROP TABLE Medecins_Laboratoires;
DROP TABLE Patients_Caracteristiques;
DROP TABLE Patients_MaladieChronique;
DROP TABLE Caracteristiques;
DROP TABLE Maladies_Chroniques;
DROP TABLE Traitements;
DROP TABLE SubsActClasseChimique;
DROP TABLE SubsActClassePharmaco;
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
 
CREATE SEQUENCE SEQUENCE_EI_FR
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_EI_OMS
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

CREATE SEQUENCE SEQUENCE_SURVEILLANCE
	START WITH 1
	INCREMENT BY 1
	MAXVALUE 99999;

CREATE SEQUENCE SEQUENCE_SYMPTOME
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
    libelle VARCHAR2(100),
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
    substance    VARCHAR2(5),
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
    risque         VARCHAR2(250 BYTE), 
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

CREATE TABLE Effet_Indesirable_Classe_Chim (
    identifiant        NUMBER(6) PRIMARY KEY,
    classe             VARCHAR2(5),
    idEffetIndesirable NUMBER(8),
    FOREIGN KEY (classe) REFERENCES Classes_Chimiques(identifiant),
    FOREIGN KEY (idEffetIndesirable) REFERENCES Effets_Indesirables_OMS(identifiant)
);

CREATE TABLE Effet_Indesirable_Classe_Phar (
    identifiant        NUMBER(6) PRIMARY KEY,
    classe             VARCHAR2(5),
    idEffetIndesirable NUMBER(8),
    FOREIGN KEY (classe) REFERENCES Classes_Pharmacologiques(identifiant),
    FOREIGN KEY (idEffetIndesirable) REFERENCES Effets_Indesirables_OMS(identifiant)
);

CREATE TABLE Effet_Indesirable_Subs_OMS (
    identifiant        NUMBER(6) PRIMARY KEY,
    idSubstance        VARCHAR2(5),
    idEffetIndesirable NUMBER(4),
    FOREIGN KEY (idSubstance) REFERENCES Substances_Actives_OMS(identifiant),
    FOREIGN KEY (idEffetIndesirable) REFERENCES Effets_Indesirables_OMS(identifiant)
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
--  DDL for Trigger INSERT_ON_EI_FR 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_EI_FR
BEFORE INSERT ON EFFETS_INDESIRABLES_FR 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_EI_FR.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_EI_OMS 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_EI_OMS
BEFORE INSERT ON EFFETS_INDESIRABLES_OMS 
FOR EACH ROW 
BEGIN
  SELECT SEQUENCE_EI_OMS.NEXTVAL INTO :new.identifiant FROM DUAL;
END;
/

--------------------------------------------------------
--  DDL for Function AFFECTER_MALADIE_PATIENT
--------------------------------------------------------
CREATE OR REPLACE FUNCTION AFFECTER_MALADIE_PATIENT(pat Patients.matricule%TYPE,
  med Medecins.matricule%TYPE,
  idMaladie Maladies.idMaladie%TYPE) RETURN INTEGER IS

  idConsult  NUMBER(9);
BEGIN
  SELECT identifiant INTO idConsult FROM Consultations 
  WHERE matriculePatient = pat 
    AND matriculeMedecin = med
    AND dateConsultation = SYSDATE;

  INSERT INTO Consultation_Maladie VALUES (idConsult, idMaladie);
  RETURN 1;

EXCEPTION
  WHEN no_data_found then
    INSERT INTO Consultations VALUES (SEQUENCE_CONSULTATION.NEXTVAL, med,
    pat, SYSDATE);
    idConsult := SEQUENCE_CONSULTATION.CURRVAL;

    INSERT INTO Consultation_Maladie VALUES (idConsult, idMaladie);
    RETURN 0;
  WHEN Others then
    RETURN 0;
END;
/
--------------------------------------------------------
--  DDL for Function MEDICAMENTS_FROM_MALADIE
--------------------------------------------------------
CREATE OR REPLACE  FUNCTION MEDICAMENTS_FROM_MALADIE (
idMal Maladies.idMaladie%TYPE) RETURN SYS_REFCURSOR IS 
curseur SYS_REFCURSOR;
BEGIN
    OPEN curseur FOR
    SELECT mm.codeCis FROM Maladie_Medicament mm
    JOIN Maladies mal ON mal.idmaladie = mm.idmaladie
    WHERE mm.idMaladie = idMal
    CONNECT BY mal.idpere = PRIOR mal.idmaladie;
    RETURN curseur;
    
END MEDICAMENTS_FROM_MALADIE;
--------------------------------------------------------
--  DDL for Function PRESCRIRE_MEDICAMENT
--------------------------------------------------------
CREATE OR REPLACE FUNCTION PRESCRIRE_MEDICAMENT (
  idConsult traitements.idconsultation%TYPE, duration NUMBER,
  cis medicaments.codecis%TYPE) RETURN INTEGER IS
  
  idTrait  NUMBER(9);
BEGIN
  
  SELECT identifiant INTO idTrait FROM Traitements 
  WHERE idConsultation = idConsult;

  INSERT INTO traitement_medicaments(idTraitement, codeCIS) VALUES (idTrait, cis);
  RETURN 1;  
    
EXCEPTION
  WHEN no_data_found THEN
    INSERT INTO Traitements (idConsultation, duree) VALUES(idConsult, duration);
    idTrait := SEQUENCE_TRAITEMENT.CURRVAL;
    INSERT INTO traitement_medicaments(idTraitement, codeCIS) VALUES (idTrait, cis);
    RETURN 1; 
  WHEN Others then
    RETURN 0;
END;
/

--------------------------------------------------------
--  DDL for Function PRESCRIRE_RECOMMENDATION
--------------------------------------------------------
CREATE OR REPLACE FUNCTION PRESCRIRE_RECOMMENDATION (
  idConsult traitements.idconsultation%TYPE, duration NUMBER,
  rec Traitement_Recommendations.recommendation%TYPE) RETURN Integer IS
  
  idTrait  NUMBER(9);
BEGIN
  
  SELECT identifiant INTO idTrait FROM Traitements 
  WHERE idConsultation = idConsult;

  INSERT INTO Traitement_Recommendations(idTraitement, recommendation) VALUES (idTrait, rec);
  RETURN 1;
  
EXCEPTION
  WHEN no_data_found THEN
    INSERT INTO Traitements (idConsultation, duree) VALUES(idConsult, duration);
    idTrait := SEQUENCE_TRAITEMENT.CURRVAL;
    INSERT INTO Traitement_Recommendations(idTraitement, recommendation) VALUES (
        idTrait, rec);
    RETURN 1;
    
  WHEN Others then
    RETURN 0;
END;
/

--------------------------------------------------------
--  DDL for Function 4 DETERMINER_MEDICAMENT_EI
--------------------------------------------------------
CREATE OR REPLACE FUNCTION DETERMINER_MEDICAMENT_EI (
    codeCis Medicaments.codeCIS%TYPE) RETURN SYS_REFCURSOR IS 
curseur SYS_REFCURSOR;
BEGIN
    OPEN curseur FOR
    SELECT identifiant, libelle FROM Effets_Indesirables_OMS
    WHERE identifiant IN (
        SELECT e.idEffetIndesirable FROM Effet_Indesirable_Subs_OMS e
        JOIN Substances_Actives_OMS s ON e.idSubstance = s.identifiant
        JOIN SubsActClasseChimique cl ON s.identifiant = cl.substance
        JOIN Classes_Chimiques cc ON cc.identifiant = cl.classe
        CONNECT BY PRIOR cc.identifiant = cc.idPere
    )  OR identifiant IN (
        SELECT e.idEffetIndesirable FROM Effet_Indesirable_Subs_OMS e
        JOIN Substances_Actives_OMS s ON e.idSubstance = s.identifiant
        JOIN SubsActClassePharmaco cl ON s.identifiant = cl.substance
        JOIN Classes_Pharmacologiques cc ON cc.identifiant = cl.classe
        CONNECT BY cc.idPere = PRIOR cc.identifiant
    );
    RETURN CURSEUR;
END DETERMINER_MEDICAMENT_EI;
/

--------------------------------------------------------
--  DDL for Function 5 IS_DEVELOPPEUR_ONLY_PRESC
--------------------------------------------------------
CREATE OR REPLACE FUNCTION IS_DEVELOPPEUR_ONLY_PRESC(
    code Medicaments.codecis%TYPE) RETURN INTEGER IS
trait NUMBER(9);
consult NUMBER(9);
medecin_traitant  Medecins.matricule%TYPE;
medecin_medicament Medecins.matricule%TYPE;
--récuperer le traitement du médicament en question
CURSOR C1 IS
    SELECT idTraitement 
    FROM Traitement_Medicaments 
    WHERE codeCIS = code;

BEGIN
--récuperer la consultation du traitement en question
    OPEN C1;
    LOOP
        FETCH C1 INTO trait; 
        EXIT WHEN C1%NOTFOUND;
        SELECT idConsultation INTO consult
        FROM   Traitements
        WHERE  identifiant = trait; 
        --récuperer les medecins qui ont prescrit le medicament lors d'une consultation
        SELECT matriculeMedecin INTO medecin_traitant
        FROM   Consultations
        WHERE  identifiant = consult;
        --faire la comparaison entre le medecin traitant et chaque medecin du 
        SELECT matricule INTO medecin_medicament
        FROM Medecins_Medicaments
        WHERE codeCIS = code AND matricule = medecin_traitant;

        IF medecin_medicament == NULL THEN
            RETURN 0;
        END IF;
    END LOOP;
    CLOSE C1;
    RETURN 1;

EXCEPTION
WHEN no_data_found THEN
    RETURN 0;
END;
/

--------------------------------------------------------
--  DDL for Function 5 LISTE_MEDOC_PRESCR_DEVELOPPEUR
--------------------------------------------------------
CREATE OR REPLACE FUNCTION LISTE_MEDOC_PRESCR_DEVELOPPEUR RETURN SYS_REFCURSOR IS 
curseur SYS_REFCURSOR;
BEGIN

    OPEN curseur FOR
    SELECT * FROM Medicaments m
    WHERE IS_DEVELOPPEUR_ONLY_PRESC(m.codeCis) = 1;
    
    RETURN curseur;
END LISTE_MEDOC_PRESCR_DEVELOPPEUR;
/

--------------------------------------------------------
--  DDL for Function 6 IS_DEVELOPPEUR_LAB_PRESC
--------------------------------------------------------
create or replace 
FUNCTION IS_DEVELOPPEUR_LAB_PRESC(
    code Medicaments.codecis%TYPE) RETURN INTEGER IS
trait              NUMBER(9);
consult            NUMBER(9);
medecin_traitant   Medecins.matricule%TYPE;
medecin_medicament Medecins.matricule%TYPE;
lab                Laboratoires.identifiant%TYPE;
--récuperer le traitement du médicament en question
CURSOR C1 IS
    SELECT idTraitement 
    FROM Traitement_Medicaments 
    WHERE codeCIS = code;

BEGIN
    OPEN C1;
    LOOP
        FETCH C1 INTO trait; 
        EXIT WHEN C1%NOTFOUND;

        --récuperer la consultation du traitement en question
        SELECT idConsultation INTO consult
        FROM   Traitements
        WHERE  identifiant = trait;
        
        --récuperer le medecin qui a prescrit le medicament lors d'une consultation
        SELECT matriculeMedecin INTO medecin_traitant
        FROM   Consultations
        WHERE  identifiant = consult;
        
        --récupérer le laboratoire 
        SELECT idLab INTO lab
        FROM Laboratoires_Medicaments
        WHERE codeCIS = code;
        
        --Comparer le medecin avec ceux travaillant dans le laboratoire 
        SELECT matricule INTO medecin_medicament
        FROM Medecins_Laboratoires
        WHERE matricule = medecin_traitant AND dateSortie IS NULL
        AND idLab = lab;

        IF medecin_medicament != NULL THEN
            RETURN 1;
        END IF;
    END LOOP;
    CLOSE C1;
    RETURN 0;

EXCEPTION
WHEN no_data_found THEN
    RETURN 0;
END;
/

--------------------------------------------------------
--  DDL for Function 6 LISTE_MEDOC_PRESCR_LAB
--------------------------------------------------------
CREATE OR REPLACE FUNCTION LISTE_MEDOC_PRESCR_LAB 
    RETURN SYS_REFCURSOR IS 
curseur SYS_REFCURSOR;
BEGIN
    OPEN curseur FOR
    SELECT * FROM Medicaments m
    WHERE IS_DEVELOPPEUR_LAB_PRESC(m.codeCis) != 0;
    
    RETURN curseur;
END LISTE_MEDOC_PRESCR_LAB;
/

--------------------------------------------------------
--  DDL for Function 7 PROPOSER_TRAITEMENTS
--------------------------------------------------------
CREATE OR REPLACE FUNCTION PROPOSER_TRAITEMENTS (
  mat Patients.matricule%TYPE) RETURN SYS_REFCURSOR IS
maladie  Maladies.idMaladie%TYPE;

curseur SYS_REFCURSOR;
BEGIN
    
    OPEN curseur FOR 
    SELECT DISTINCT * FROM Medicaments m
    JOIN Maladie_Medicament mm ON mm.codeCIS = m.codeCIS
    WHERE mm.idMaladie IN (
        SELECT sm.idMaladie FROM Symptomes_Maladies sm
        JOIN Symptomes_Consultation sc ON sm.codeSymptome = sc.codeSymptome
        JOIN Consultations cc ON cc.identifiant = sc.idConsultation
        WHERE cc.matriculePatient = mat
    );
    RETURN curseur;
END PROPOSER_TRAITEMENTS;
/

--------------------------------------------------------
--  DDL for 8 Surveillance
--------------------------------------------------------
CREATE TABLE SURVEILLANCE (
    identifiant               NUMBER(9),
    medecin                   NUMBER(9),  
    nombreMedicamentDeveloppe NUMBER(5),
    nombreLabTravaille        NUMBER(5),
    nombreMedicamentPrescrit  NUMBER(5),
    rapport                   NUMBER(5),
    CONSTRAINT PKSurveillance PRIMARY KEY(identifiant),
    FOREIGN KEY (medecin) REFERENCES Medecins(matricule)
);

--------------------------------------------------------
--  DDL for Trigger INSERTUPDATE_ON_SURVEILLANCE 
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_SURVEILLANCE 
BEFORE INSERT OR UPDATE ON SURVEILLANCE 
FOR EACH ROW 
BEGIN
  IF :new.nombreMedicamentDeveloppe + :new.nombreLabTravaille = 0 THEN
    SELECT 0 INTO :new.rapport FROM DUAL;
   ELSE 
  SELECT (:new.nombreMedicamentPrescrit + :new.nombreMedicamentDeveloppe 
    + :new.nombreLabTravaille) / :new.nombreMedicamentDeveloppe 
    + :new.nombreLabTravaille INTO :new.rapport FROM DUAL;
    END IF;
END;
/

--------------------------------------------------------
--  DDL for Trigger INSERT_ON_TRAITEMENT_Medicaments
--------------------------------------------------------
CREATE OR REPLACE TRIGGER INSERT_ON_TRAIT_MEDIC
BEFORE INSERT ON Traitement_Medicaments
FOR EACH ROW
DECLARE
  matricule  NUMBER(9);
  count_surveillance  NUMBER(9);
  val NUMBER(9);
BEGIN
    SELECT SEQUENCE_TRAITEMENT_MEDICAMENT.NEXTVAL INTO :new.identifiant FROM DUAL;
    SELECT matriculeMedecin INTO matricule FROM Consultations c
    JOIN Traitements t ON idConsult = c.identifiant
    WHERE t.identifiant = :new.idTraitement;
    
    SELECT COUNT(*) INTO count_surveillance FROM SURVEILLANCE WHERE medecin = matricule;
    IF count_surveillance = 0 THEN
        IF IS_DEVELOPPEUR_ONLY_PRESC(:new.codeCis) = 1 THEN
            INSERT INTO Surveillance VALUES (SEQUENCE_SURVEILLANCE.NEXTVAL, matricule, 1, 0, 0, 0);
        ELSIF IS_DEVELOPPEUR_LAB_PRESC(:new.codeCis) = 1 THEN
            INSERT INTO Surveillance VALUES (SEQUENCE_SURVEILLANCE.NEXTVAL, matricule, 0, 1, 0, 0);
        ELSE
            INSERT INTO Surveillance VALUES (SEQUENCE_SURVEILLANCE.NEXTVAL, matricule, 0, 0, 1, 0);
        END IF;
    ELSE 
        IF IS_DEVELOPPEUR_ONLY_PRESC(:new.codeCis) = 1 THEN
            SELECT nombreMedicamentDeveloppe INTO val
            FROM Surveillance  WHERE medecin = matricule;
            
            UPDATE Surveillance SET nombreMedicamentDeveloppe = val + 1
            WHERE medecin = matricule;
            
        ELSIF IS_DEVELOPPEUR_LAB_PRESC(:new.codeCis) = 1 THEN
            SELECT nombreLabTravaille INTO val
            FROM Surveillance  WHERE medecin = matricule;
            
            UPDATE Surveillance SET nombreLabTravaille = val + 1
            WHERE medecin = matricule;
        ELSE
            SELECT nombreMedicamentPrescrit INTO val
            FROM Surveillance  WHERE medecin = matricule;
            
            UPDATE Surveillance SET nombreMedicamentPrescrit = val + 1
            WHERE medecin = matricule;
        END IF;
    END IF;
END;
/

--------------------------------------------------------
--  DDL for 9
--------------------------------------------------------
CREATE OR REPLACE FUNCTION SUBSTANCES_INTERACTION(
    sub1 Substances_Actives_OMS.identifiant%TYPE,
    sub2 Substances_Actives_OMS.identifiant%TYPE) RETURN INTEGER IS
interactions NUMBER(5);
BEGIN
    SELECT COUNT(*) INTO interactions
    FROM Interactions_Substances
    WHERE idSubstance1 = sub1
    AND idSubstance2 = sub2;

    RETURN interactions;

EXCEPTION
WHEN no_data_found THEN
    RETURN 0;
END;
/

CREATE OR REPLACE FUNCTION GET_SUBSTANCES_MEDICAMENT (
    cis Medicaments.codeCIS%TYPE) RETURN SYS_REFCURSOR IS 
curseur SYS_REFCURSOR;
BEGIN
    OPEN curseur FOR
    SELECT codeSubstanceOMS FROM Medicaments_Substances_OMS
    WHERE codeCis = cis;
    RETURN CURSEUR;
END GET_SUBSTANCES_MEDICAMENT;
/

CREATE OR REPLACE FUNCTION MEDICAMENT_INTERACTION(
    med1 Medicaments.codeCis%TYPE,
    med2 Medicaments.codeCis%TYPE) RETURN INTEGER IS
interactions NUMBER(5);

substancesMed1 SYS_REFCURSOR;
substancesMed2 SYS_REFCURSOR;
subMed1 Substances_Actives_OMS.identifiant%TYPE;
subMed2 Substances_Actives_OMS.identifiant%TYPE;
BEGIN
    interactions := 0;
    substancesMed1 := GET_SUBSTANCES_MEDICAMENT(med1);
    LOOP
        EXIT WHEN substancesMed1%NOTFOUND;
        FETCH substancesMed1 INTO subMed1;
        substancesMed2 := GET_SUBSTANCES_MEDICAMENT(med2);
            LOOP
            EXIT WHEN substancesMed2%NOTFOUND;
            FETCH substancesMed2 INTO subMed2;
                interactions := interactions + MEDICAMENT_INTERACTION(subMed1, subMed2);
            END LOOP;
        CLOSE substancesMed2;
    END LOOP;
    CLOSE substancesMed1;
    RETURN interactions;

EXCEPTION
WHEN no_data_found THEN
    RETURN 0;
END;
/


CREATE OR REPLACE FUNCTION MEDICAMENTS_INTERACTION(
    med Medicaments.codeCis%TYPE,
    trait Traitements.identifiant%TYPE) RETURN INTEGER IS
CURSOR cur IS
    SELECT codeCis FROM Traitement_Medicaments
    WHERE idTraitement = trait;
cis Medicaments.codeCis%TYPE;
interactions NUMBER(5);
BEGIN
    interactions := 0;
    OPEN cur;
    LOOP
        EXIT WHEN cur%NOTFOUND;
        FETCH cur INTO cis;
        interactions := interactions + MEDICAMENT_INTERACTION(med, cis);
    END LOOP;
    CLOSE cur;

    RETURN interactions;

EXCEPTION
WHEN no_data_found THEN
    RETURN 0;
END;
/

CREATE OR REPLACE FUNCTION GET_TRAITEMENTS_EN_COURS (
  mat Patients.matricule%TYPE) RETURN SYS_REFCURSOR IS
traitements SYS_REFCURSOR;
BEGIN
    
    OPEN traitements FOR 
    SELECT t.identifiant FROM Traitements t
    JOIN Consultations c ON t.idConsultation = c.identifiant
    WHERE matriculePatient = mat
        AND SYSDATE BETWEEN dateConsultation AND dateConsultation + t.duree;
    RETURN traitements;
END GET_TRAITEMENTS_EN_COURS;
/

CREATE or replace TYPE medicaments_trait IS TABLE OF VARCHAR(50);
CREATE OR REPLACE FUNCTION IS_TRAITEMENT_INTERACTION(
    mat Patients.matricule%TYPE, meds medicaments_trait) RETURN INTEGER IS
curVal NUMBER(5);
traitements SYS_REFCURSOR;
interactions NUMBER(9);
i NUMBER(3);
BEGIN
    interactions := 0;
    traitements := GET_TRAITEMENTS_EN_COURS(mat);
    LOOP
    EXIT WHEN traitements%NOTFOUND;
    FETCH traitements INTO curVal;
        FOR i in 1..meds.COUNT LOOP
            interactions := interactions + MEDICAMENTS_INTERACTION(meds(i), curVal);
        END LOOP;
    END LOOP;
    CLOSE traitements;
    RETURN interactions;

EXCEPTION
WHEN no_data_found THEN
    RETURN 0;
END;
/


/*10. une fonction qui recherche s’il existe des traitements communs à deux maladies ;*/
CREATE OR REPLACE FUNCTION GET_TRAITEMENTS_COMMUNS (
    idM1 Maladies.idMaladie%TYPE,
    idM2 Maladies.idMaladie%TYPE
    ) RETURN medicaments_trait IS 
meds1 SYS_REFCURSOR;
meds2 SYS_REFCURSOR;
med1 Medicaments.codeCis%TYPE;
med2 Medicaments.codeCis%TYPE;
medsCommuns medicaments_trait;
i NUMBER(2);
BEGIN
    i := 1;
    medsCommuns := medicaments_trait();
    meds1 := MEDICAMENTS_FROM_MALADIE(idM1);
    LOOP
      EXIT WHEN meds1%NOTFOUND;
      FETCH meds1 INTO med1;
     meds2 := MEDICAMENTS_FROM_MALADIE(idM2);
      LOOP
        EXIT WHEN meds2%NOTFOUND;
        FETCH meds2 INTO med2;
            IF med1 = med2 THEN
                medsCommuns.EXTEND;
                medsCommuns(i) := med1;
                i := i + 1;
            END IF;
        END LOOP;
        CLOSE meds2;
    END LOOP;
    CLOSE meds1;
    RETURN medsCommuns;
END GET_TRAITEMENTS_COMMUNS;
/

/*11. un patient peut consulter un médecin pour lui déclarer des eﬀets secondaires dus à son traitement. Une fonction
vériﬁera si ces eﬀets indésirables sont connus ou pas (grâce aux hiérarchies des classes chimiques et pharmaco-
logiques des substances actives, mais également des eﬀets indésirables eux-mêmes). Dans ce cas l’ajout de ces
eﬀets indésirables déclenchera une forme d’alerte dans laquelle seront regroupés tous les patients traités avec ces médicaments*/
CREATE OR REPLACE FUNCTION IS_EFFET_CONNU(
med Medicaments.codeCis%TYPE, effet Effets_Indesirables_OMS.libelle%TYPE) RETURN INTEGER IS 
cur SYS_REFCURSOR;
identifiant NUMBER(9);
libelle Effets_Indesirables_OMS.libelle%TYPE;
BEGIN
    cur := DETERMINER_MEDICAMENT_EI(med);
    LOOP
        EXIT WHEN cur%NOTFOUND;
        FETCH cur INTO identifiant, libelle;
            IF libelle = effet THEN
                RETURN 1;
            END IF;
    END LOOP;
    CLOSE cur;
    RETURN 0;
END;
/

CREATE OR REPLACE FUNCTION GET_PATIENTS_FROM_MED(med Medicaments.codeCis%TYPE) 
    RETURN SYS_REFCURSOR IS 
    cur SYS_REFCURSOR;
    CURSOR cur2 IS 
    SELECT matricule FROM Patients;

BEGIN
    OPEN cur FOR 
    SELECT c.matriculePatient FROM Traitements t
    JOIN Consultations c ON t.idConsultation = c.identifiant
        AND SYSDATE BETWEEN dateConsultation AND dateConsultation + t.duree
        AND med IN(
            SELECT codeCis FROM Traitement_Medicaments tm
            JOIN Traitements t2 ON t2.identifiant = tm.idTraitement
            JOIN Consultations c2 ON t2.idConsultation = c2.identifiant
            WHERE c2.matriculePatient = c.matriculePatient
        );
    RETURN cur;
END;
/

CREATE OR REPLACE FUNCTION INSERER_NOUVEL_EI(med Medicaments.codeCis%TYPE, 
    effet Effets_Indesirables_OMS.libelle%TYPE) RETURN SYS_REFCURSOR IS
    patients SYS_REFCURSOR;
    val INTEGER;
    BEGIN
    patients := NULL;
    val := IS_EFFET_CONNU(med, effet);
    IF val = 0 THEN 
        INSERT INTO EFFETS_INDESIRABLES_OMS VALUES(SEQUENCE_EI_OMS.NEXTVAL, effet, NULL);
       patients := GET_PATIENTS_FROM_MED(med);
    END IF;
    RETURN patients;
END;
/
