<?php

/**
 * Формирует SQL-запрос для показа лота на странице lot.php
 * @param integer $id_lot id лота
 * @return string SQL-запрос
 */
function get_query_lot ($id_lot) {
    return "SELECT lots.id, lots.date_creation, lots.title, lots.description_lot, lots.image_lot, lots.starting_price, lots.bet_step, lots.date_completion, lots.author_id, categories.name_category FROM lots 
    JOIN categories ON lots.category_id = categories.id
    WHERE lots.id = $id_lot";
}
/**
 * Формирует SQL-запрос для создания нового лота
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function get_query_create_lot ($user_id) { 
    return "INSERT INTO lots (title, description_lot, starting_price, bet_step, date_completion, category_id, image_lot, author_id) VALUES (?, ?, ?, ?, ?, ?, ?, $user_id)";
}
/**
 * Возвращает массив категорий
 * @param $con Подключение к MySQL
 * @return [Array | String] $categories Ассоциативный массив с категориями лотов из базы данных
 * или описание последней ошибки подключения
 */
function get_categories ($con) {
    if (!$con) {
    $error = mysqli_connect_error();
    return $error;
    } else {
        $sql = "SELECT id, character_code, name_category FROM categories;";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $categories;
        }
        $error = mysqli_error($con);
        return $error;
    }
}


/**
 * Записывает в БД данные пользователя из формы
 * @param $link mysqli Ресурс соединения
 * @param array $data Данные пользователя, полученные из формы
 * @return bool $res Возвращает true в случае успешного выполнения
 */
function add_user_database($link, $data = []) {
    $sql = "INSERT INTO users (date_registration, email, user_name, user_password, contacts) VALUES (NOW(), ?, ?, ?, ?);";
    $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $res = mysqli_stmt_execute($stmt);
    return $res;
}
/**
 * Возвращает массив данных пользователя: id адресс электронной почты имя и хеш пароля
 * @param $con Подключение к MySQL
 * @param $email введенный адрес электронной почты
 * @return [Array | String] $users_data Массив с данными пользователя: id адресс электронной почты имя и хеш пароля
 * или описание последней ошибки подключения
 */
function get_login($con, $email) {
    if (!$con) {
    $error = mysqli_connect_error();
    return $error;
    }
    $sql = "SELECT id, email, user_name, user_password FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $users_data = mysqli_fetch_assoc($result);
        return $users_data;
    }
    $error = mysqli_error($con);
    return $error;
}

/**
 * Возвращает массив лотов соответствующих поисковым словам
 * @param $link mysqli Ресурс соединения
 * @param string $words ключевые слова введенные пользователем в форму поиска
 * @return [Array | String] $goods Двумерный массив лотов, в названии или описании которых есть такие слова
 * или описание последней ошибки подключения
 */
function get_found_lots($link, $words, $limit, $offset) {
    $sql = "SELECT lots.id, lots.title, lots.starting_price, lots.image_lot, lots.date_completion, categories.name_category FROM lots
    JOIN categories ON lots.category_id=categories.id
    WHERE MATCH(title, description_lot) AGAINST(?) ORDER BY date_creation DESC LIMIT $limit OFFSET $offset;";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 's', $words);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $goods = mysqli_fetch_all($res);
        return $goods;
    }
    $error = mysqli_error($link);
    return $error;
}
/**
 * Возвращает количество лотов соответствующих поисковым словам
 * @param $link mysqli Ресурс соединения
 * @param string $words ключевые слова введенные ползователем в форму поиска
 * @return [int | String] $count Количество лотов, в названии или описании которых есть такие слова
 * или описание последней ошибки подключения
 */
function get_count_lots($link, $words) {
    $sql = "SELECT COUNT(*) as cnt FROM lots
    WHERE MATCH(title, description_lot) AGAINST(?);";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 's', $words);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $count = mysqli_fetch_assoc($res)["cnt"];
        return $count;
    }
    $error = mysqli_error($link);
    return $error;
}

/**
 * Записывает в БД сделанную ставку
 * @param $link mysqli Ресурс соединения
 * @param int $sum Сумма ставки
 * @param int $user_id ID пользователя
 * @param int $lot_id ID лота
 * @return bool $res Возвращает true в случае успешной записи
 */
function add_bet_database($link, $sum, $user_id, $lot_id) {
    $sql = "INSERT INTO bets (date_bet, price_bet, user_id, lot_id) VALUE (NOW(), ?, $user_id, $lot_id);";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $sum);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        return $res;
    }
    $error = mysqli_error($con);
    return $error;
}

/**
 * Возвращает массив из десяти последних ставок на этот лот
 * @param $con Подключение к MySQL
 * @param int $id_lot Id лота
 * @return [Array | String] $list_bets Ассоциативный массив со списком ставок на этот лот из базы данных
 * или описание последней ошибки подключения
 */
function get_bets_history ($con, $id_lot) {
    if (!$con) {
    $error = mysqli_connect_error();
    return $error;
    } else {
        $sql = "SELECT users.user_name, bets.user_id, bets.price_bet, bets.date_bet
        FROM bets
        JOIN lots ON bets.lot_id=lots.id
        JOIN users ON bets.user_id=users.id
        WHERE lots.id=$id_lot
        ORDER BY bets.date_bet DESC LIMIT 10;";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $list_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $list_bets;
        }
        $error = mysqli_error($con);
        return $error;
    }
}
/**
 * Возвращает массив ставок пользователя
 * @param $con Подключение к MySQL
 * @param int $id Id пользователя
 * @return [Array | String] $list_bets Ассоциативный массив ставок
 *  пользователя из базы данных
 * или описание последней ошибки подключения
 */
function get_bets ($con, $id) {
    if (!$con) {
    $error = mysqli_connect_error();
    return $error;
    } else {
        $sql = "SELECT bets.date_bet, bets.price_bet, lots.title, lots.description_lot, lots.image_lot, lots.date_completion, lots.winner_id, lots.id, categories.name_category, users.contacts
        FROM bets
        JOIN lots ON bets.lot_id=lots.id
        JOIN users ON bets.user_id=users.id
        JOIN categories ON lots.category_id=categories.id
        WHERE bets.user_id = $id
        ORDER BY bets.date_bet DESC;";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $list_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $list_bets;
        }
        $error = mysqli_error($con);
        return $error;
    }
}

function get_finish_lots ($con){
    if (!$con) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT lots.id as id_lot, lots.title, lots.description_lot as description, users.id as winner_id, users.contacts, users.user_name as name, users.email, MAX(bets.price_bet) as price_bet
        FROM lots 
        JOIN bets ON bets.lot_id = lots.id
        JOIN users ON users.id = bets.user_id
        WHERE lots.date_completion < NOW() and lots.winner_id IS NULL
        GROUP BY lots.id, lots.title, lots.description_lot, users.user_name, users.email, users.contacts";

        $result = mysqli_query($con, $sql);

        if ($result) {
            $list_finish_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $list_finish_lots;
        }
        $error = mysqli_error($con);
        return $error;
    }
}

function add_winner ($con, $lot_id, $winner_id){
    if (!$con) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "UPDATE lots
        SET winner_id = $winner_id 
        WHERE lots.id = $lot_id;";

        $result = mysqli_query($con, $sql);

        if (!$result) {
            $error = mysqli_error($con);
            return $error;
        }
    }
}