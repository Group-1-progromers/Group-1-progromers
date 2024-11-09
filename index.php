<?php
include 'db.php';
session_start();

// Initialize or fetch cart count
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Fetch featured products or just a sample set of products
$sql = "SELECT * FROM products LIMIT 6"; // Adjust as needed
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Agricultural Produce</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .hero-section {
            background-color: #f8f9fa;
            padding: 40px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Agricultural Produce</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="product.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php">Cart <span class="badge badge-pill badge-primary" id="cart-count"><?php echo $cart_count; ?></span></a>
            </li>
            <?php if (isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="hero-section">
    <h1>Welcome to Agricultural Produce</h1>
    <p>Explore a wide variety of fresh and organic produce directly from the farm.</p>
</div>

<div class="container">
    <h2 class="my-4">Featured Products</h2>
    <div class="row">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='col-lg-4 col-md-6 mb-4'>";
            echo "<div class='card h-100'>";
            echo "<img class='card-img-top' src='" . $row['image'] . "' alt='Product Image'>";
            echo "<div class='card-body'>";
            echo "<h4 class='card-title'>" . $row['name'] . "</h4>";
            echo "<p class='card-text'>" . $row['description'] . "</p>";
            echo "<h5>$" . $row['price'] . "</h5>";
            echo "<a href='product.php?id=" . $row['id'] . "' class='btn btn-info'>View Details</a>";
            echo "<button class='btn btn-primary add-to-cart' data-id='" . $row['id'] . "'>Add to Cart</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.add-to-cart').click(function() {
        var product_id = $(this).data('id');
        $.ajax({
            url: 'add_to_cart.php',
            type: 'POST',
            data: { id: product_id },
            success: function(response) {
                $('#cart-count').text(response);
            }
        });
    });
});
</script>
</body>
</html>
