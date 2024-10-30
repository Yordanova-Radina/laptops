<?php
require_once('../functions.php');

$users = [
    [
        'email' => 'john@gmail.com',
        'password' => '123456',
        'name' => 'John Jones',
        'hash' => '$argon2i$v=19$m=65536,t=4,p=1$TnVKWXZzZk54clRkNkNBMA$DsqJv8l+eP6K4fk+ytdpPm4phzMdm0aM3cFD5o9nj70',
    ],
    [
        'email' => 'ana@gmail.com',
        'password' => 'qwerty',
        'name' => 'Ana Smith',
        'hash' => '$argon2i$v=19$m=65536,t=4,p=1$czd0NEVoL3VRQkxNRGxsTg$Rq0DBaI6aSSFhzf3DH53/vfrIXK5DvQcPf5j8eANDYE',
    ],
    [
        'email' => 'ivan@gmail.com',
        'password' => 'asd123',
        'name' => 'Ivan Ivanov',
        'hash' => '$argon2i$v=19$m=65536,t=4,p=1$UmtaRFhlUVBaZ00zU1ExRA$ik4M6hwM4zXvld1QE7YwPl5cHfErCEG6p8JUN9/BUF0',
    ],
];


foreach ($users as $user) {
    if ($user['email'] == $_POST['email'] && password_verify($_POST['password'], $user['hash'])) {
        session_start();
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        //сетваме бисквитка
        setcookie('user_email', $user['email'], time() + 3600, '/', 'localhost', false, true);
    } else {
        //debug('fail');
    }
}

header('Location: ../index.php');
exit;
