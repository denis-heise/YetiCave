INSERT INTO categories (character_code, name_category)
VALUES
    ("boards", "Доски и лыжи"),
    ("attachment", "Крепления"),
    ("boots", "Ботинки"),
    ("clothing", "Одежда"),
    ("tools", "Инструменты"),
    ("other", "Разное");

INSERT INTO users (email, user_name, user_password, contacts)
VALUES
    ('qwerty@mail.ru', 'Иван', 'secretpass1', '89200000000'),
    ('poiuytrty@mail.ru', 'Вася', 'secretpass8', '892075232000'),
    ('qwertyqaz@mail.ru', 'Пётр', 'secretpass2', '89211111111');

INSERT INTO lots (title, description_lot, image_lot, starting_price, bet_step, date_completion, author_id, category_id)
VALUES
    ('Title lot 1', 'Description lot 1', 'img/lot-1.jpg', 12345, 43, '2023-05-03', 2, 4),
    ('Title lot 2', 'Description lot 2', 'img/lot-2.jpg', 6548, 43, '2023-05-03', 3, 6),
    ('Title lot 3', 'Description lot 3', 'img/lot-3.jpg', 876435, 43, '2023-05-03', 2, 3),
    ('Title lot 4', 'Description lot 4', 'img/lot-4.jpg', 9876, 43, '2023-05-03', 1, 2),
    ('Title lot 5', 'Description lot 5', 'img/lot-5.jpg', 543456, 43, '2023-05-03', 2, 5),
    ('Title lot 6', 'Description lot 6', 'img/lot-6.jpg', 876532, 43, '2023-05-03', 3, 1);

INSERT INTO bets (price_bet, user_id, lot_id)
VALUES
    (7654, 1, 4),
    (7987654, 2, 1),
    (123765, 1, 6),
    (91234, 2, 3);

-- Поучить все категории
SELECT name_categoty AS 'Категории' FROM categories;

-- Получить открытые лоты (в каждом название, старт. цену, ссылку на изображене, название категории)
SELECT lots.title, lots.starting_price, lots.image_lot, categories.name_categoty FROM lots
JOIN categories ON lots.category_id = categories.id;

-- Получить лот по id, получить название категории, к которой принадлежит лот
SELECT lots.title, lots.description_lot, lots.image_lot, lots.starting_price, lots.bet_step, lots.date_completion, categories.name_categoty
FROM lots JOIN categories ON lots.category_id = categories.id
WHERE lots.id = 4;

-- Обновить лот по его id
UPDATE lots
SET title = 'New title' 
WHERE lots.id = 4;

-- Получить список ставок для лота по id лота с сортировкой по дате, начиная с последней
SELECT bets.date_bet, bets.price_bet, lots.title, users.user_name
FROM bets 
JOIN lots ON bets.lot_id = lots.id
JOIN users ON bets.user_id = users.id
WHERE lots.id = 4
ORDER BY bets.date_bet DESC;