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

    $page_content = include_template ('main-registration.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ["email", "password", "name", "message"];
        $errors = [];

        $rules = [
            "email" => function($value) {
                return validate_email ($value);
            },
            "password" => function($value) {
                return validate_length ($value, 5, 12);
            },
            "name" => function($value) {
                return validate_length ($value, 2, 15);
            },
            "message" => function($value) {
                return validate_length ($value, 11, 50);
            }
            
        ];

        $data_form_registration = filter_input_array(INPUT_POST,
        [
            "email"=>FILTER_DEFAULT,
            "name"=>FILTER_DEFAULT,
            "password"=>FILTER_DEFAULT,
            "message"=>FILTER_DEFAULT,
        ], true);

        foreach ($data_form_registration as $field => $value) {
            if (isset($rules[$field])) {
                $rule = $rules[$field];
                $errors[$field] = $rule($value);
            }
            if (in_array($field, $required) && empty($value)) {
                switch($field){
                    case 'name':
                        $errors[$field] = "Введите имя";
                        break;
                    case 'message':
                        $errors[$field] = "Напишите как с вами связаться";
                        break;
                    case 'email':
                        $errors[$field] = "Введите e-mail";
                        break;
                    case 'password':
                        $errors[$field] = "Введите пароль";
                        break;
                }
            }
        };

        $user_data = get_login($connect, $_POST['email']);
        if(!empty($user_data['id'])){
            $errors['email'] = "E-mail уже используется другим пользователем.";
        }

        $errors = array_filter($errors);

        if(count($errors)){
            $page_content = include_template ('main-registration.php', [
                "data_form_registration" => $data_form_registration,
                "errors" => $errors
            ]);
        } else{
            $result = add_user_database($connect, $data_form_registration);

            if($result){
                header("Location: /" );
                exit();
            } else {
                $error = mysqli_error($connect);
            }
        };
    };

    if(isset($_SESSION['name'])){ 
        $page_content = include_template ('403.php', []);
    };
     
    $layout_content = include_template ('layout.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => 'Регистрация',
        "is_auth" => $is_auth,
        "user_name" => $user_name
    ]);

    print($layout_content);