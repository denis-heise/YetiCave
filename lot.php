<?php
    require_once('helpers.php');
    require_once('init.php');
    require_once('models.php');
    require_once('auth.php');
    
    $id = intval($_GET['id']);

    if(!$connect){
        $error = mysqli_connect_error();
    } else {
        $result_lots = mysqli_query($connect, get_query_lot($id));
        
        if($result_lots) {
            $lot = mysqli_fetch_assoc($result_lots); 
            $bets = get_bets_history($connect, $lot['id']);
        } else {
            $error = mysqli_error($connect);
        }
        $categories = get_categories($connect);
    };

    if(mysqli_num_rows($result_lots) === 0){
        $page_content = include_template ('404.php', []);
    } else {
        $page_content = include_template ('main-lot.php', [
            'lot' => $lot,
            'bets' => $bets,
            'user_id' => $user_id
        ]);
    };

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bet = $_POST['cost'];
        $min_bet = $lot['starting_price'] + $lot['bet_step'];

        if ($bet < $min_bet) {
            $error = "Ставка не может быть меньше $min_bet";
        }
        if (empty($bet)) {
            $error = "Ставка должна быть целым числом, больше ноля";
        }
        print($error);
        if($error){
            $page_content = include_template ('main-lot.php', [
                'lot' => $lot,
                'bets' => $bets,
                'user_id' => $user_id,
                'error' => $error
            ]);
        } else {
            add_bet_database($connect, $bet, $user_id, $lot['id']);
            header("Location: /lot.php?id=" . $id);
        }
    };

    $layout_content = include_template ('layout.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => $lot['title'],
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

    print($layout_content);
    