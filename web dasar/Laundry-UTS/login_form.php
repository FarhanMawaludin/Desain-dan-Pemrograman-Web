<?php
session_start();
$error = $_SESSION['error'] ?? ''; 
$errors = $_SESSION['errors'] ?? ''; 
$username = $_SESSION['username'] ?? ''; 
unset($_SESSION['errors']); 
unset($_SESSION['username']); 

if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('img/Londri1.jpg');
            background-size: cover;
            background-position: center;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .login-container p {
            font-size: 14px;
            margin-bottom: 20px;
            color: #6c757d;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
        }

        .text-danger {
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1 class="text-center">Login</h1>
        <p class="text-center">Selamat Datang di LondriKuy</p>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <small class="text-danger"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></small>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="text-danger"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></small>
            </div>
            <?php if (isset($errors['login'])): ?>
                <div class="alert alert-danger"><?php echo $errors['login']; ?></div>
            <?php endif; ?>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">Log in</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
