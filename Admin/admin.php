<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminName = $_POST['admin'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($adminName === 'Admin' && $password === 'Admin1234') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: adminLogin.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background-image: url("../assets/background.jpg");
        }
        .container {
            max-width: 400px;
            background: white;
            padding: 20px;
            margin-top: 50px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        .btn-custom {
            background-color: green;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2 class="text-center text-light mt-5 "><b>Poultry Farm Management</b></h2>
    <div class="container">
        <div class="text-center">
            <h4>Administration Login</h4>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center"> <?php echo $error; ?> </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="admin" class="form-label">Admin Name</label> 
                <input type="text" id="admin" name="admin" class="form-control" placeholder="Enter your name" required> 
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Sign In</button>
        </form>
    </div>

    <footer class="footer mt-auto">
        <div class="text-center">
            <p>&copy; 2025 Poultry Farm Management. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>