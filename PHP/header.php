<!-- بسم الله الرحمن الرحيم -->


<header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="nav">
        <a href="index.php" class="navbar-brand">
            <h3 class="px-2" id="shopping">
                <i class="fas fa-shopping-basket"></i> Shopping Cart
            </h3>
        </a>
        <button class="navbar-toggler" type="button" data-toggl="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-lable="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="mr-auto"></div>
            <div class="navbar-nav">
                <a href="cart.php" class="nav-link active">
                    <h5 class="px-5 cart" id="cart">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <?php
                        // calculate how many items the user choose 
                        if (isset($_SESSION['cart'])) {
                            $count = count($_SESSION['cart']);
                            echo "<span id=\"cart-count\" class=\"text-success bg-light\">$count</span>";
                        } else {
                            echo "<span id=\"cart-count\" class=\"text-danger bg-light\">0</span>";
                        }

                        ?>
                    </h5>
                </a>
                <a href="auth/logout.php" style="text-decoration: none;">
                    <h5 class="logout">
                        logout
                        <i class="fas fa-forward text-danger mt-2 mr-3 ml-1"></i>
                    </h5>
                </a>
            </div>
        </div>
    </nav>
</header>

<!-- الحمد لله -->