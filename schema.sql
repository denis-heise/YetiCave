CREATE DATABASE YetiCave;
USE YetiCave;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    date_registration DATETIME DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL UNIQUE,
    user_name VARCHAR(128),
    user_password CHAR(255),
    contacts TEXT
);
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name_category VARCHAR(128),
    character_code VARCHAR(128) UNIQUE
);
CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(255),
    description_lot TEXT,
    image_lot VARCHAR(255),
    starting_price INT,
    bet_step INT,
    date_completion DATE,
    author_id INT,
    winner_id INT,
    category_id INT,
    FOREIGN KEY (author_id) REFERENCES users(id),
    FOREIGN KEY (winner_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
CREATE TABLE bets (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    date_bet DATETIME DEFAULT CURRENT_TIMESTAMP,
    price_bet INT,
    user_id INT,
    lot_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (lot_id) REFERENCES lots(id)
);

-- Созд. полнотекст. поиск
-- Индекс для поиска
CREATE FULLTEXT INDEX lot_ft_search 
ON lots(title, description_lot);
-- Поиск
SELECT * FROM lots
WHERE MATCH(title,description_lot) AGAINST('слово');

SELECT lots.id, lots.title, lots.description_lot as description, users.contacts, users.user_name as winner, users.email, MAX(bets.price_bet) as price_bet
FROM lots 
JOIN bets ON bets.lot_id = lots.id
JOIN users ON users.id = bets.user_id
WHERE lots.date_completion < NOW() and lots.winner_id IS NULL
GROUP BY lots.id, lots.title, lots.description_lot, users.user_name, users.email, users.contacts;
