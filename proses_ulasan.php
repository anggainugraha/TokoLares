<?php
// Include file koneksi.php
include('koneksi.php');

// Set timezone (Waktu Jakarta)
date_default_timezone_set('Asia/Jakarta');

// Proses kirim ulasan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $ulasan = $_POST['ulasan'];
    $rating = isset($_POST['rating']) ? $_POST['rating'] : NULL; // Rating produk
    $pengiriman = isset($_POST['pengiriman_rating']) ? $_POST['pengiriman_rating'] : NULL; // Rating pengiriman
    $tanggal = date('Y-m-d H:i:s'); // Waktu sekarang
    
    // Simpan ke database
    $insertQuery = "INSERT INTO ulasan (nama, ulasan, tanggal, rating, pengiriman) 
                    VALUES ('$nama', '$ulasan', '$tanggal', '$rating', '$pengiriman')";
    if (mysqli_query($koneksi, $insertQuery)) {
        echo "<script>alert('Ulasan berhasil dikirim!'); window.location.href='tentang.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal mengirim ulasan!');</script>";
    }
}

// Menutup koneksi
mysqli_close($koneksi);
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome untuk ikon bintang -->
    <style>
        body {
            background-color: #fff5e6;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #ffa500;
        }
        .btn-secondary {
            background-color: #ffa500;
            border-color: #ffa500;
        }
        .btn-secondary:hover {
            background-color: #ff8c00;
            border-color: #ff8c00;
        }
        footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
        }
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            font-size: 25px;
            color: #ccc;
            cursor: pointer;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffa500;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Lares Frozen Food</a>
        <div class="d-flex ms-auto">
            <a href="index.php" class="btn btn-secondary">Home</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Ulasan Pengguna</h2>
    
    <!-- Form Ulasan -->
    <form method="POST" action="proses_ulasan.php">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="ulasan" class="form-label">Ulasan</label>
            <textarea class="form-control" id="ulasan" name="ulasan" rows="3" required></textarea>
        </div>

        <!-- Rating Produk -->
        <div class="mb-3">
            <label class="form-label">Rating Produk</label>
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5"><label for="star5">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
                <input type="radio" id="star1" name="rating" value="1"><label for="star1">&#9733;</label>
            </div>
        </div>

        <!-- Rating Pengiriman -->
        <div class="mb-3">
            <label class="form-label">Rating Pengiriman</label>
            <div class="star-rating">
                <input type="radio" id="ship5" name="pengiriman_rating" value="5"><label for="ship5">&#9733;</label>
                <input type="radio" id="ship4" name="pengiriman_rating" value="4"><label for="ship4">&#9733;</label>
                <input type="radio" id="ship3" name="pengiriman_rating" value="3"><label for="ship3">&#9733;</label>
                <input type="radio" id="ship2" name="pengiriman_rating" value="2"><label for="ship2">&#9733;</label>
                <input type="radio" id="ship1" name="pengiriman_rating" value="1"><label for="ship1">&#9733;</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
    </form>
</div>

<!-- Footer -->
<footer>
    &copy;<script>document.write(new Date().getFullYear());</script> Lares Frozen Food
</footer>

</body>
</html>
