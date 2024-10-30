<?php
// страница продукти
$products = [];

$search = $_GET['search'] ?? '';

//правим заявка към БД
$query = "SELECT * FROM products";
$stmt = ($pdo->query($query));
while ($row = $stmt->fetch()) {
    if (empty($search) || (!empty($search) && str_contains(mb_strtolower($row['title']), mb_strtolower($search)))) {
        $products[] = $row;
    }
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
    echo ' <div class="d-flex flex-wrap justify-content-between">.';
    foreach ($products as $product) {
        echo '
                <div class="card mb-4" style="width: 18rem;">
                    <img src="' . $product['image'] . '" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">' . $product['title'] . '</h5>
                        <p class="card-text">' . $product['price'] . '</p>
                    </div>
                </div>
            ';
    }
    echo '</div>';
}
?>