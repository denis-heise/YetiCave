<?php
    require_once('helpers.php');
    require_once('init.php');
    require_once('models.php');
    require_once('auth.php');

    $limit = 9;
    $page = 1;
    $word_search = $_GET['search'];
    $count_lots = get_count_lots($connect, $word_search);
    $pages = floor($count_lots / $limit);
    $offset = ($page - 1) * $limit;

    if(!$connect){
        $error = mysqli_connect_error();
    } else {
        $categories = get_categories($connect);
    };
    
    $page_content = include_template ('main-search.php', [
        'categories' => $categories
    ]);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $goods = get_found_lots($connect, $word_search, $limit, $offset);

        if(!empty(trim($word_search)) && $goods){
            $page_content = include_template ('main-search.php', [
                'categories' => $categories,
                'goods' => $goods,
                'word_search' => $word_search,
                'pages' => $pages
            ]);
        } else {
            $page_content = include_template ('main-search.php', [
                'categories' => $categories,
                'word_search' => $word_search,
                'word_error' => 'Ничего не найдено по вашему запросу'
            ]);
        }
    };

    $layout_content = include_template ('layout.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => 'Поиск',
        "is_auth" => $is_auth,
        "user_name" => $user_name
    ]);

    print($layout_content);