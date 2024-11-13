<?php

require_once('../functions.php');
require_once('../db.php');

//debug($_POST, true);

$error = '';
foreach ($_POST as $key => $value) {
    if (mb_strlen($value) == 0) {
        $error = "Моля, попълнете всички полета!";
        break;
    }
}

if (mb_strlen($error) > 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = $error;
    $_SESSION['flash']['data'] = $_POST;
    header('Location: ../index.php?page=register');
} else {
    $names = trim($_POST['names']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $repeat_password = trim($_POST['repeat_password']);

    //ще проверим дали съществува потребител с този имейл
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    //debug($user, true);

    if ($user) {
        //debug($user, true);
        $error = 'Възникна грешка!';
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = $error;
        $_SESSION['flash']['data'] = $_POST;
        header('Location: ../index.php?page=register');
        exit;
    }

    if ($password != $repeat_password) {
        $error = 'Паролите не съвпадат!';
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = $error;
        $_SESSION['flash']['data'] = $_POST;
        header('Location: ../index.php?page=register');
        exit;
    } else {
        $password = password_hash($password, PASSWORD_ARGON2I);
        $query = "INSERT INTO users (names, email, `password`) VALUES (:names, :email, :password)";
        $stmt = $pdo->prepare($query);
        $params = [
            'names' => $names,
            'email' => $email,
            'password' => $password
        ];
        if ($stmt->execute($params)) {
            $_SESSION['flash']['message']['type'] = 'success';
            $_SESSION['flash']['message']['text'] = "Успешна регистрация";
            header('Location: ../index.php?page=home');
            exit;
        } else {
            $error = 'Възникна грешка!';
            $_SESSION['flash']['message']['type'] = 'danger';
            $_SESSION['flash']['message']['text'] = $error;
            $_SESSION['flash']['data'] = $_POST;
            header('Location: ../index.php?page=register');
            exit;
        }
    }
}
