USE hw1;

DROP TABLE if EXISTS ordini;

CREATE TABLE IF NOT EXISTS ordini (
    id_ordine INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT,
    cover VARCHAR(255),
    artista VARCHAR(255),
    data_evento CHAR(10),
    ora_evento TIME,
    data_ordine DATETIME DEFAULT CURRENT_TIMESTAMP,
    quantita INT DEFAULT 1,
    prezzo VARCHAR(100),
    FOREIGN KEY (id_utente) REFERENCES users(id)
);

-- INSERT INTO ordini (id_utente, cover, artista, data_evento, ora_evento, prezzo) VALUES
-- (1, 'imgs/Black_Eyed_Peas.jpg', 'Black Eyed Peas', '28/07/2022', '21:30:00', '€49.09'),
-- (1, 'imgs/Blanco.jpg', 'Blanco', '30/07/2022', '22:00:00', '€36.81'),
-- (1, 'imgs/Tananai.jpeg', 'Tananai', '11/08/2023', '20:00:00', '€49.09'),
-- (1, 'imgs/Mahmood.jpg', 'Mahmood', '20/08/2024', '21:30:00', '€73.63'),
-- (2, 'imgs/Briga.jpg', 'Briga', '06/11/2016', '21:30:00', '€49.09'),
-- (2, 'imgs/Nigiotti.jpg', 'Enrico Nigiotti', '10/08/2025', '21:30:00', '€49.09'),
-- (2, 'imgs/Irama.jpg', 'Irama', '03/08/2025', '21:30:00', '€49.09'),
-- (2, 'imgs/Nayt.jpg', 'Nayt', '18/11/2023', '21:30:00', '€49.09');