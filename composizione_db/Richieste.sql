USE hw1;

DROP TABLE if EXISTS richieste;

CREATE TABLE if NOT EXISTS richieste (
	id_richiesta INT AUTO_INCREMENT PRIMARY KEY,
	id_utente INT,
	data_richiesta DATETIME DEFAULT CURRENT_TIMESTAMP,
	status_richiesta VARCHAR(30) DEFAULT 'pending',
	richiesta VARCHAR(1000),
	FOREIGN KEY(id_utente) REFERENCES users(id)
);