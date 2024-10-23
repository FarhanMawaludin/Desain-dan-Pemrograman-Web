<?php
session_start();
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? ''; 
    $password = $_POST['password'] ?? '';

    // Validasi username
    if (empty($username)) {
        $errors['username'] = 'Harus terisi';
    }

    // Validasi password
    if (empty($password)) {
        $errors['password'] = 'Harus terisi';
    } elseif (strlen($password) > 6) {
        $errors['password'] = 'Password maksimal 6 karakter';
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
        $errors['password'] = 'Password harus terdiri dari huruf besar dan kecil';
    }

    
    if (empty($errors)) {
        $correct_username = "admin"; 
        $correct_password = "Pas123"; 

      
        if ($username === $correct_username && $password === $correct_password) {
            $_SESSION['username'] = $username;
            header("Location: home.php"); 
            exit;
        } else {
            $errors['login'] = 'Username atau password salah'; 
        }
    }

    
    $_SESSION['errors'] = $errors; 
    $_SESSION['username'] = $username; 
    header("Location: login_form.php");
    exit;
}
?>
