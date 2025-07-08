<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminLogin.php"); // Redirect to login page if not authenticated
    exit();
}

$servername = "localhost";
$username = "root"; // Change as per your database credentials
$password = "mysql8";
$database = "dk_poultry";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Poultry Farm</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #343a40 !important;
        }
        .navbar-brand, .nav-link, .btn-dark {
            color: white !important;
        }
        .table-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        table {
            width: 100%;
        }
        th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        td {
            text-align: center;
        }
        .product-img {
            width: 70px;
            height: 70px;
            border-radius: 5px;
            object-fit: cover;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <img src="../assets/download.jpg" alt="Logo" width="40" height="34" class="d-inline-block align-text-top">
                Poultry Farm Management Admin
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <a href="../logout.php" class="btn btn-danger fw-bold">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        
        <!-- User Details -->
        <div class="table-container">
            <h3 class="mb-3 text-primary">User Details</h3>
            <table class="table table-bordered table-hover">
                <tr><th>Name</th><th>Email</th></tr>
                <?php
                $result = $conn->query("SELECT name, email FROM users");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Farmer Details -->
        <div class="table-container">
            <h3 class="mb-3 text-success">Farmer Details</h3>
            <table class="table table-bordered table-hover">
                <tr><th>Farmer Name</th><th>Farm Name</th><th>Email</th></tr>
                <?php
                $result = $conn->query("SELECT f_name, f_farmname, f_email FROM farmers");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['f_name']}</td><td>{$row['f_farmname']}</td><td>{$row['f_email']}</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Order Details -->
        <div class="table-container">
            <h3 class="mb-3 text-warning">Order Details</h3>
            <table class="table table-bordered table-hover">
                <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total Price</th><th>Farm Name</th><th>Delivery Address</th></tr>
                <?php
                $result = $conn->query("SELECT product, price, quantity, total_price, farm_name, address FROM orders");
                $totalRevenue = 0;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['product']}</td>
                            <td>₹{$row['price']}</td>
                            <td>{$row['quantity']}</td>
                            <td>₹{$row['total_price']}</td>
                            <td>{$row['farm_name']}</td>
                            <td>{$row['address']}</td>
                          </tr>";
                    $totalRevenue += $row['total_price'];
                }
                ?>
                <tr><th colspan="3">Total Sales Amount</th><th>₹<?php echo number_format($totalRevenue, 2); ?></th><td colspan="2"></td></tr>
            </table>
        </div>

        <!-- Available Products Details -->
        <div class="table-container">
            <h3 class="mb-3 text-danger">Available Products</h3>
            <table class="table table-bordered table-hover">
                <tr><th>Farmer Name</th><th>Product Name</th><th>Price</th><th>Image</th></tr>
                <?php
                $result = $conn->query("SELECT farmer_name, product_name, product_price, product_image FROM products");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['farmer_name']}</td>
                            <td>{$row['product_name']}</td>
                            <td>₹{$row['product_price']}</td>
                            <td><img src='../assets/{$row['product_image']}' class='product-img' alt='Product'></td>
                          </tr>";
                }
                ?>
            </table>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; <?php echo date("Y"); ?> Poultry Farm Management. All rights reserved.
    </div>

</body>
</html>

<?php
$conn->close();
?>
