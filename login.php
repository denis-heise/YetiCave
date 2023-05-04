<?php
    require_once('helpers.php');
    require_once('init.php');
    require_once('functions.php');
    require_once('models.php');
    require_once('auth.php');
    
    if(isset($_SESSION['name'])){
        header("Location: /");                
        exit();
    }

    if(!$connect){
        $error = mysqli_connect_error();
    } else {
        $categories = get_categories($connect);
    };

    $page_content = include_template ('main-login.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ["email", "password"];
        $errors = [];

        $rules = [
            "email" => function($value) {
                return validate_email ($value);
            },
            "password" => function($value) {
                return validate_length ($value, 5, 12);
            }
        ];

        $data_form_login = filter_input_array(INPUT_POST,
        [
            "email"=>FILTER_DEFAULT,
            "password"=>FILTER_DEFAULT,
        ], true);

        foreach ($data_form_login as $field => $value) {
            if (isset($rules[$field])) {
                $rule = $rules[$field];
                $errors[$field] = $rule($value);
            }
            if (in_array($field, $required) && empty($value)) {
                switch($field){
                    case 'email':
                        $errors[$field] = "Введите e-mail";
                        break;
                    case 'password':
                        $errors[$field] = "Введите пароль";
                        break;
                }
            }
        };

        $errors = array_filter($errors);

        if(count($errors)){
            $page_content = include_template ('main-login.php', [
                "data_form_login" => $data_form_login,
                "errors" => $errors
            ]);
        } else{
            $result = get_login($connect, $data_form_login['email']);

            if($result){
                if(password_verify($data_form_login['password'], $result['user_password'])){
                    session_start();
                    $_SESSION['name'] = $result["user_name"];
                    $_SESSION['id'] = $result["id"];
    
                    header("Location: /");                
                } else {
                    $errors["password"] = "Вы ввели неверный пароль";
                }
            } else {
                $errors["email"] = "Пользователь с таким е-mail не зарегестрирован";
            }
        };
        if(count($errors)){
            $page_content = include_template ('main-login.php', [
                "data_form_login" => $data_form_login,
                "errors" => $errors
            ]);
        };
    };

    $layout_content = include_template ('layout.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => 'Вход',
        "is_auth" => $is_auth,
        "user_name" => $user_name
    ]);

    print($layout_content); 