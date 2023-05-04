<?php
    require_once('helpers.php');
    require_once('init.php');
    require_once('models.php');
    require_once('functions.php');
    require_once('auth.php');

    if(!$connect){
        $error = mysqli_connect_error();
    } else {
        $sql_lots = "SELECT lots.id, lots.date_creation, lots.title, lots.description_lot, lots.image_lot, lots.starting_price, lots.bet_step, lots.date_completion, categories.name_category FROM lots
        JOIN categories ON lots.category_id = categories.id
        ORDER BY date_creation DESC
        LIMIT 9";
        $result_lots = mysqli_query($connect, $sql_lots);

        if($result_lots) {
            $goods = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
        } else {
            $error = mysqli_error($connect);
        }
        $categories = get_categories($connect);
    };

    $winners = get_finish_lots($connect);

    foreach($winners as $winner){
        add_winner($connect, $winner['id_lot'], $winner['winner_id']);
        send_message_winner($winner);
    }

    $page_content = include_template ('main.php', [
        'categories' => $categories,
        'goods' => $goods
    ]);

    $layout_content = include_template ('layout.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => 'Главная',
        "is_auth" => $is_auth,
        "user_name" => $user_name
    ]);

    print($layout_content);
