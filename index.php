<?php
// boilerplate index
require_once('./functions.php');
require_once('./db.php');

debug($pdo);

$page = $_GET['page'] ?? 'home';
//debug($_COOKIE);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лаптопи</title>
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">Лаптопи</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == 'home' ? 'active' : ''); ?>" aria-current="page" href="?page=home">Начало</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == 'products' ? 'active' : ''); ?>" href="?page=products">Продукти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == 'contacts' ? 'active' : ''); ?>" href="?page=contacts">Контакти</a>
                        </li>
                    </ul>
                    <div class="d-flex flex-row gap-3">
                        <?php
                        if (isset($_SESSION['user_name'])) {
                            echo '<span class="text-white"> Здравейте, ' . $_SESSION['user_name'] . '</span>';
                            echo '
                            <form method="POST" action="./handlers/handel_logout.php" class="m-0">
                                <button type="submit" class="btn-outline-light">Изход</button>

                            </form>

                            ';
                        } else {
                            echo '<a href="?page=login" class= "btn btn-outline-light">Вход</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container py-4" style="min-height:80vh;">
        <?php
        if (file_exists('pages/' . $page . '.php')) {
            require_once('pages/' . $page . '.php');
        } else {
            require_once('pages/not_found.php');
        }
        ?>
    </main>
    <footer class="bg-dark text-center py-5 mt-auto">
        <div class="container">
            <span class="text-light">© 2024 All rights reserved</span>
        </div>
    </footer>
</body>

</html>