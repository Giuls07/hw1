USE hw1;

DROP TABLE users;

CREATE TABLE IF NOT EXISTS users (
	id INT AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	nome VARCHAR(255),
	cognome VARCHAR(255),
	data_nascita DATE,
	genere CHAR(3),
	paese VARCHAR(2),
	citta VARCHAR(255),
	address VARCHAR(255),
	pfp VARCHAR(255),
	PRIMARY KEY (id)
);
