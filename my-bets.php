<?php
    require_once('helpers.php');
    require_once('init.php');
    require_once('models.php');
    require_once('auth.php');

    if(!$connect){
        $error = mysqli_connect_error();
    } else {
        $categories = get_categories($connect);
    };
    
    $page_content = include_template ('main-my-bets.php', [
        'categories' => $categories
    ]);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['name'])) {
        $bets = get_bets($connect, $user_id);

        $page_content = include_template ('main-my-bets.php', [
            'categories' => $categories,
            'bets' => $bets,
            'user_id' => $user_id
        ]);
    };

    if(!isset($_SESSION['name'])){ 
        $page_content = include_template ('403.php', []);
    }; 

    $layout_content = include_template ('layout.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => 'Ставки',
        "is_auth" => $is_auth,
        "user_name" => $user_name
    ]);

    print($layout_content);