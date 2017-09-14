 
CREATE TYPE rating AS ENUM('1','2','3','4','5');
CREATE TYPE INVITATION AS ENUM('0','1');
CREATE TYPE owner AS ENUM('0','1');


CREATE TYPE Gender AS ENUM('M','F');
CREATE TABLE Users (
  idUsers SERIAL   NOT NULL ,
  username VARCHAR(20)   NOT NULL ,
  password VARCHAR(255)   NOT NULL ,
  mail VARCHAR(255)   NOT NULL ,
  Name VARCHAR   NOT NULL ,
  Surname VARCHAR   NOT NULL ,
  town VARCHAR(20)   NOT NULL ,
  gender Gender   NOT NULL ,
  country VARCHAR(255) NOT NULL,
PRIMARY KEY(idUsers));

INSERT INTO Users (username, password, mail, Name, Surname, town, gender, country, date) VALUES ('testuser', 'asadasfas3421f', 'aaa@hotmail.com', 'Alan', 'Walker', 'Washington','M', 'USA',clock_timestamp());
INSERT INTO Users (username, password, mail, Name, Surname, town, gender, country, date) VALUES ('tuser', 'asad123asfas3421f', 'aa2111a@hotmail.com', 'Alice', 'Lamar', 'New York','F', 'USA',clock_timestamp());
INSERT INTO Users (username, password, mail, Name, Surname, town, gender, country, date) VALUES ('ter', 'asadas1423fas3421f', 'abbbaa@hotmail.com', 'Ala', 'Switch', 'New Orlean','F', 'USA',clock_timestamp());
INSERT INTO Users (username, password, mail, Name, Surname, town, gender, country, date) VALUES ('tser', 'asa12d123asdasfas3421f', 'zasabaa@hotmail.com', 'Gary', 'Granger', 'Tokyo','M', 'Japan',clock_timestamp());
INSERT INTO Users (username, password, mail, Name, Surname, town, gender, country, date) VALUES ('fasfestuser', 'a5356sadasfas3421f', 'kaweaaa@hotmail.com', 'Oliver', 'Walker', 'Madrid','M', 'Spain',clock_timestamp());
INSERT INTO Users (username, password, mail, Name, Surname, town, gender, country, date) VALUES ('fuser', 'asadasf64as3421f', 'aagdsaa@hotmail.com', 'Jessica', 'Wajda', 'Prague','F', 'Czech Republic',clock_timestamp());
INSERT INTO Users (username, password, mail, Name, Surname, town, gender, country, date) VALUES ('uuuuser', 'asada6435sfas3421f', 'assdaa@hotmail.com', 'Monica', 'Bella', 'Washington','F', 'USA',clock_timestamp());






CREATE TABLE Photos (
  idPhotos SERIAL   NOT NULL ,
  owner VARCHAR(20)   NOT NULL ,
  filename VARCHAR(255)    ,
  dating timestamp,
  description VARCHAR(255)      ,
PRIMARY KEY(idPhotos));




CREATE TABLE Status (
  idStatus SERIAL   NOT NULL ,
  owner VARCHAR(20)  NOT NULL ,
  description VARCHAR   NOT NULL ,
  dating timestamp   NOT NULL   ,
PRIMARY KEY(idStatus));




CREATE TABLE Friends (
  idFriends SERIAL   NOT NULL ,
  user1 varchar(20)  NOT NULL ,
  user2 varchar (20) NOT NULL ,
  dating timestamp  NOT NULL ,
  isaccepted INVITATION DEFAULT '0' NOT NULL   ,
PRIMARY KEY(idFriends));


CREATE TABLE Blocked (
  idblock SERIAL   NOT NULL ,
  blocker varchar(20)  NOT NULL ,
  blocked varchar (20) NOT NULL ,
  dating timestamp   NOT NULL ,
PRIMARY KEY(idblock));


CREATE TABLE message (
	idconv SERIAL NOT NULL,
	subject varchar(30) NOT NULL,
	sent varchar(20) NOT NULL,
	recived varchar(20) NOT NULL,
	text varchar(255) NOT NULL,
	who owner DEFAULT '0',
	dating timestamp NOT NULL,
PRIMARY KEY (idconv));



CREATE TABLE ratings (
	idrating SERIAL NOT NULL,
	profile varchar(20) NOT NULL,
	rater varchar(20) NOT NULL,
	mark rating NOT NULL,
	dating timestamp NOT NULL,
PRIMARY KEY (idrating));








	