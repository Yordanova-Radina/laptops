<?php
// страница продукти
$products = [];

$search = $_GET['search'] ?? '';

//правим заявка към БД
$query = "SELECT * FROM products WHERE title LIKE :search";
$stmt = ($pdo->prepare($query));
$stmt->execute([':search' => "%$search%"]);
while ($row = $stmt->fetch()) {
    $products[] = $row;
}

//debug($products);

if (!empty($search)) {
    setcookie('last_search', $search, time() + 3600, '/', 'localhost', false, false);
}
?>

<div class="row">
    <form class="mb-4" method="GET">
        <div class="input-group">
            <input type="hidden" name="page" value="products">
            <input type="text" class="form-control" placeholder="Търси продукт" name="search" value="<?php echo $search ?>">
            <button class="btn btn-primary" type="submit">Търсене</button>
        </div>
    </form>
    <?php
    if (isset($_COOKIE['last_search'])) {
        echo '
                <div class="alert alert-info" role="alert">
                Последно търсене: ' . $_COOKIE['last_search'] . '
                </div>
            ';
    }
    ?>
</div>
<?php
if (count($products) == 0) {
    echo '
            <div class="alert alert-warning" role="alert">
                Няма намерени продукти
            </div>
        ';
} else {
    echo ' <div class="d-flex flex-wrap justify-content-between">';
    foreach ($products as $product) {
        $fav_btn = '';
        if (isset($_SESSION['user_name'])) {
            $fav_btn = '
            <div class="card-footer text-center">
                            <button class="btn btn-primary btn-sm add-favorite"  data-product="' . $product['id'] . '">Добави в любими</button>
                        </div>
            ';
        }
        echo '
                <div class="card mb-4" style="width: 18rem;">
                    <img src="' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($product['title']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($product['price']) . '</p>
                    </div>
                        ' . $fav_btn . '
                </div>
            ';
    }
    echo '</div>';
}
?>