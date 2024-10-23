<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cek Harga - Laundry</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: white; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }
        
        .result {
            margin-top: 20px;
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 5px;
        }

        .nav-link:hover {
            border-width: 1px 0px 1px 0px; 
            border-style: solid;
            border-color: black;
        }

        footer {
            background-color: #007bff; 
            padding: 20px 0; 
            color: white;
        }
        

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light mb-5 fixed-top">
        <div class="container">
            <a class="navbar-brand fs-3 fw-bold" href="home.php">LondriKuy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold " aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="cek_harga.php">Cek Harga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center" style="margin-top: 150px;">
    <h1 class="mb-5">Cek Harga Laundry</h1>
    <form method="POST" action="">
    <div class="mb-3 row">
        <label for="weight" class="col-sm-3 col-form-label">Berat (kg)</label>
        <div class="col-sm-9">
            <input type="number" id="weight" name="weight" class="form-control" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="service" class="col-sm-3 col-form-label">Jenis Layanan</label>
        <div class="col-sm-9">
            <select id="service" name="service" class="form-select" required>
                <option value="dry">Cuci Kering (5,000/kg)</option>
                <option value="washIron">Cuci Setrika (8,000/kg)</option>
                <option value="iron">Setrika (6,000/kg)</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="speed" class="col-sm-3 col-form-label">Kecepatan</label>
        <div class="col-sm-9">
            <select id="speed" name="speed" class="form-select" required>
                <option value="regular">Reguler</option>
                <option value="express">Ekspress (+2,000/kg)</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="membership" class="col-sm-3 col-form-label">Membership</label>
        <div class="col-sm-9">
            <select id="membership" name="membership" class="form-select" required>
                <option value="non_member">Non Member</option>
                <option value="member">Member (-10% Diskon)</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">CHECK</button>
</form>



<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $weight = (int)$_POST['weight'];
    $service = $_POST['service'];
    $speed = $_POST['speed'];
    $membership = $_POST['membership'];

    
    $pricePerKg = 0;
    switch ($service) {
        case 'dry':
            $pricePerKg = 5000;
            break;
        case 'washIron':
            $pricePerKg = 8000; 
            break;
        case 'iron':
            $pricePerKg = 6000; 
            break;
    }

    
    $basePrice = $weight * $pricePerKg; 

    
    $expressFee = 0; 
    if ($speed == 'express') {
        $expressFee = $weight * 2000; 
        $basePrice += $expressFee; 
    }

   
    $totalTransactionBeforeDiscount = $basePrice; 

    $totalDiscount = 0;

    if ($membership == 'member') {
        $totalDiscount = $totalTransactionBeforeDiscount * 0.1; 
    }

  
    $finalPrice = $totalTransactionBeforeDiscount - $totalDiscount;

   
    if (!isset($_SESSION['laundry_count'])) {
        $_SESSION['laundry_count'] = 0; 
    }
    

  
    if ($_SESSION['laundry_count'] == 6) {
        $finalPrice -= (2000 * 2);
        $_SESSION['laundry_count'] = 0; 
    }

  
    echo "<div class='result mb-5'>";
    echo "<h4>Hasil Cek Harga</h4>";
    echo "<h4>Total Transaksi Sebelum Diskon: Rp " . number_format($totalTransactionBeforeDiscount, 0, ',', '.') . "</h4>"; 
    echo "<h4>Total Diskon: Rp " . number_format($totalDiscount, 0, ',', '.') . "</h4>";
    echo "<h4>Total Yang Harus Dibayar: Rp " . number_format($finalPrice, 0, ',', '.') . "</h4>"; 
    echo "</div>";
}
?>

</div>
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">© 2024 LondriKuy. All rights reserved.</p>
        </div>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
