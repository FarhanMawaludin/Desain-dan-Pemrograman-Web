<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>Home - Laundry</title>
    <style>

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

        .navbar {
            background-color: white; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }
        
        #slider {
            position: relative;
            width: 100%; 
            height: 400px; 
            overflow: hidden;
            border-radius: 10px;
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }

        #slider img {
            position: absolute;
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }

        .slidertitle {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            font-size: 24px;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 5px 10px;
            border-radius: 5px;
            display: none; 
        }
    </style>
    <script>
        var i = 0;
        $(document).ready(function () {
            $(".slidertitle").hide(); 
            showNextImage();
            setInterval(showNextImage, 3000);
        });

        function showNextImage() {
            $(".slidertitle").hide(); 
            $("#SliderImage" + i)
                .fadeIn(1100)
                .delay(1100)
                .fadeOut(1100);

            $("#title" + i)
                .fadeIn(1100)
                .delay(1100)
                .fadeOut(1100);

            i++;
            if (i == 3) {
                i = 0;
            }
        }
    </script>
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

    <div class="container text-left" style="margin-top: 100px;">
        <h1 class="mb-4">Selamat Datang di LondriKuy</h1>
        <p class="lead">Nikmati Ruangan yang cozy saat mencuci</p>
        <div id="slider" class="container mt-4">
            <img src="img/Londri1.jpg" id="SliderImage0" alt="Banner 1">
            <img src="img/Londri2.jpg" id="SliderImage1" alt="Banner 2">
            <img src="img/Londri3.jpg" id="SliderImage2" alt="Banner 3">
            
        </div>
    </div>

    <div class="container mt-5">
   
    <section class="mb-4">
        <h2 class="mb-3 text-center">Profile Toko</h2>
        <div class="card">
            <div class="card-body">
                <p class="card-text">LondriKuy adalah penyedia layanan laundry terpercaya dengan berbagai jenis pelayanan untuk memenuhi kebutuhan Anda. Kami berkomitmen untuk memberikan kualitas terbaik dan layanan pelanggan yang memuaskan.</p>
            </div>
        </div>
    </section>


    <section class="mt-4">
        <h2 class="mb-3 text-center">Jenis Pelayanan</h2>

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cuci Kering</h5>
                        <p class="card-text">Layanan cuci kering yang menjaga kualitas bahan pakaian Anda.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cuci Basah</h5>
                        <p class="card-text">Layanan cuci basah yang efektif untuk menghilangkan noda membandel.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Setrika Saja</h5>
                        <p class="card-text">Layanan setrika untuk pakaian yang sudah dicuci.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pengemasan Khusus</h5>
                        <p class="card-text">Pengemasan khusus untuk menjaga pakaian tetap rapi dan bersih.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Servis Khusus untuk Baju Formal</h5>
                        <p class="card-text">Layanan khusus untuk perawatan baju formal Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



    <footer class="text-center">
        <div class="container">
            <p class="mb-0">© 2024 LondriKuy. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
