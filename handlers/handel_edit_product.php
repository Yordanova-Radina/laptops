<?php

require_once('../functions.php');
require_once('../db.php');

$title = trim($_POST['title'] ?? '');
$price = trim($_POST['price'] ?? '');
$product_id = intval($_POST['id'] ?? 0);

if (mb_strlen($title) == 0 || mb_strlen($price) == 0 || $product_id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Моля попълнете всички полета!';

    header('Location: ../index.php?page=edit_product&id=' . $product_id);
    exit;
}

$query = "UPDATE products SET title=:title, price=:price WHERE id=:id";
$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':id' => $product_id
];

if($stmt->execute($params)){
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = 'Продуктът е редактиран успешно!';
}else{
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = 'Възникна грешка при редакцията на продукта!';
}

header('Location: ../index.php?page=products');
exit;