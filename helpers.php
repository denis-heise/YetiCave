<?php

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $key => $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }
        $values = array_merge([$stmt, $types], $stmt_data);
        mysqli_stmt_bind_param(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}


/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function get_dt_range($date){
    date_default_timezone_set('Europe\Moscow');
    $current_date = date_create();
    $final_date = date_create($date);

    $difference_date = date_diff($final_date, $current_date);
    $format_diff = date_interval_format($difference_date, '%d %H %I');
    $array_date = explode(' ', $format_diff);

    $hours = $array_date[0] * 24 + $array_date[1];
    $minutes = intval($array_date[2]);

    $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

    $result_date[] = $hours;
    $result_date[] = $minutes;

    return $result_date;
}

/**
 * Валидирует поле категории, если такой категории нет в списке
 * возвращает сообщение об этом
 * @param int $id категория, которую ввел пользователь в форму
 * @param array $allowed_list Список существующих категорий
 * @return string Текст сообщения об ошибке
 */
function validate_category ($id, $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
}
/**
 * Проверяет что содержимое поля является числом больше нуля
 * @param string $num число которое ввел пользователь в форму
 * @return string Текст сообщения об ошибке
 */
function validate_number ($num) {
    if (!empty($num)) {
        $num *= 1;
        if (is_int($num) && $num > 0) {
            return NULL;
        }
        return "Содержимое поля должно быть целым числом больше ноля";
    }
};

/**
 * Проверяет что дата окончания торгов не меньше одного дня
 * @param string $date дата которую ввел пользователь в форму
 * @return string Текст сообщения об ошибке
 */
function validate_date ($date) {
    if (is_date_valid($date)) {
        $now = date_create("now");
        $d = date_create($date);
        $diff = date_diff($d, $now);
        $interval = date_interval_format($diff, "%d");

        if ($interval < 1) {
            return "Дата должна быть больше текущей не менее чем на один день";
        };
    } else {
        return "Содержимое поля «Дата окончания торгов» должно быть датой в формате «ГГГГ-ММ-ДД»";
    }
};

function check_date ($date) {
    $now_date = strtotime(date('Y-m-d H:i:s'));
    $check_date = strtotime($date);
    return $check_date < $now_date;
};

function get_time_bet ($date) {
    $now = date_create("now");
    $d = date_create($date);
    $diff = date_diff($d, $now);
    $interval = explode(' ', date_interval_format($diff, "%y %m %d %h %i"));

    if($interval[0]){
        if ($interval[0] === 1){
            $result = 'Один год назад';
        } else if ($interval[0] <= 4 && $interval[0] > 1){
            $result = "$interval[0] года назад";
        } else if ($interval[0] >= 5){
            $result = "$interval[0] лет назад";
        }
    } else if($interval[1]){
        if ($interval[1] === 1){
            $result = 'Один месяц назад';
        } else if ($interval[1] <= 4 && $interval[1] > 1){
            $result = "$interval[1] месяца назад";
        } else if ($interval[1] >= 5){
            $result = "$interval[1] месяцев назад";
        }
    } else if($interval[2]){
        if ($interval[2] === 1){
            $result = 'Один день назад';
        } else if ($interval[2] <= 4 && $interval[2] > 1){
            $result = "$interval[2] дня назад";
        } else if ($interval[2] >= 5){
            $result = "$interval[2] дней назад";
        }
    } else if($interval[3]){
        if ($interval[3] === 1){
            $result = 'Один час назад';
        } else if ($interval[3] <= 4 && $interval[3] > 1){
            $result = "$interval[3] часа назад";
        } else if ($interval[3] >= 5 && $interval[3] < 21){
            $result = "$interval[3] часов назад";
        } else if ($interval[3] == 21){
            $result = "$interval[3] час назад";
        } else if ($interval[3] > 21){
            $result = "$interval[3] часа назад";
        }
    } else if($interval[4]){
        if ($interval[4] === 1){
            $result = 'Одну минуту назад';
        } else if ($interval[4] <= 4 && $interval[4] > 1){
            $result = "$interval[4] минуты назад";
        } else if ($interval[4] >= 5){
            $result = "$interval[4] минут назад";
        }
    } else {
        $result = 'Только что';
    }

    return $result;
};

function get_time_mybet ($date){
    $now = date_create("now");
    $d = date_create($date);
    $diff = date_diff($d, $now);
    $interval = explode(' ', date_interval_format($diff, "%y %m %d %h %i"));

    if($interval[0] || $interval[1]){
        $result = date('d.m.y в h:i', strtotime($date));
    } else if($interval[2]){
        if ($interval[2] === 1){
            $result = "Вчера, в $interval[3]:$interval[4]";
        } else {
            $result = date('d.m.y в h:i', strtotime($date));
        }
    } else if($interval[3]){
        if ($interval[3] === 1){
            $result = 'Один час назад';
        } else if ($interval[3] <= 4 && $interval[3] > 1){
            $result = "$interval[3] часа назад";
        } else if ($interval[3] >= 5 && $interval[3] < 21){
            $result = "$interval[3] часов назад";
        } else if ($interval[3] == 21){
            $result = "$interval[3] час назад";
        } else if ($interval[3] > 21){
            $result = "$interval[3] часа назад";
        }
    } else if($interval[4]){
        if ($interval[4] === 1){
            $result = 'Одну минуту назад';
        } else if ($interval[4] <= 4 && $interval[4] > 1){
            $result = "$interval[4] минуты назад";
        } else if ($interval[4] >= 5){
            $result = "$interval[4] минут назад";
        }
    } else {
        $result = 'Только что';
    } 

    return $result;
}

//New
/**
 * Проверяет что содержимое поля является корректным адресом электронной почты
 * @param string $email адрес электронной почты
 * @return string Текст сообщения об ошибке
 */
function validate_email ($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "E-mail должен быть корректным";
    }
}

/**
 * Проверяет что содержимое поля укладывается в допустимый диапазон
 * @param string $value содержимое поля
 * @param int $min минимальное количество символов
 * @param int $max максимальное количество символов
 * @return string Текст сообщения об ошибке
 */
function validate_length ($value, $min, $max) {
    if ($value) {
        $len = strlen($value);
        if ($len < $min or $len > $max) {
            return "Значение должно быть от $min до $max символов";
        }
    }
}
