<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fafafa;
            color: #333;
        }

        header {
            background-color: #ffffff;
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        .home-button {
            background-color: #ff7f00;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-right: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .home-button:hover {
            background-color: #e16b00;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border-left: 5px solid #ff7f00;
        }

        h1, h2, h3 {
            color: #ff7f00;
            text-align: center;
        }

        p {
            line-height: 1.6;
            text-align: justify;
        }

        footer {
            margin-top: 30px;
            text-align: center;
            padding: 15px 20px;
            background-color: #ff7f00;
            color: white;
        }

        .review-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .review-box {
            width: 70%;
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .review-box h5 {
            color: #ff7f00;
            margin-bottom: 10px;
        }

        .rating span {
            color: #ff7f00;
            font-size: 18px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="gambar/logo.jpg" alt="Logo Lares Frozen Food">
    </div>
    
    <button class="home-button" onclick="location.href='index.php'">Home</button>
</header>

<div class="container">
    <h2>Selamat Datang di Lares Frozen Food</h2>
    <p>
        Lares Frozen Food adalah toko online yang menyediakan berbagai macam produk makanan beku berkualitas tinggi. Kami berkomitmen untuk menghadirkan produk terbaik dengan harga yang bersaing, sehingga pelanggan dapat menikmati kemudahan dalam memenuhi kebutuhan makanan sehari-hari.
    </p>
    <p>
        Kami selalu memastikan bahwa setiap produk yang kami jual telah melalui proses penyimpanan yang higienis dan terjaga kualitasnya. Dengan berbagai pilihan makanan beku, mulai dari olahan daging, seafood, hingga camilan siap saji, kami siap menjadi solusi praktis bagi kebutuhan kuliner Anda.
    </p>
    <p>
        Visi kami adalah menjadi pilihan utama masyarakat dalam memenuhi kebutuhan makanan beku dengan menyediakan layanan yang cepat, ramah, dan profesional. Kami percaya bahwa kepuasan pelanggan adalah prioritas utama, sehingga kami terus berupaya memberikan pengalaman belanja yang mudah dan nyaman.
    </p>
    <p> 
        Jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut, jangan ragu untuk menghubungi kami melalui layanan yang tersedia. Terima kasih telah mempercayakan kebutuhan makanan beku Anda kepada Lares Frozen Food.
    </p>
</div>

<!-- Daftar Ulasan Section -->
<div class="container">
    <h3>Daftar Ulasan Pengguna</h3>

    <div class="review-container">
        <?php
        // Koneksi ke database
        include('koneksi.php');

        // Menggunakan prepared statement untuk keamanan
        $query = "SELECT nama, ulasan, rating, pengiriman, tanggal FROM ulasan ORDER BY tanggal DESC LIMIT 10";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Menampilkan ulasan
        while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="review-box">
    <h5><?php echo htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?></h5>
    <p><?php echo nl2br(htmlspecialchars($row['ulasan'], ENT_QUOTES, 'UTF-8')); ?></p>
    <p class="rating">
        Rating Produk: 
        <?php
        $rating = (int) $row['rating']; 
        for ($i = 1; $i <= 5; $i++) {
            echo $i <= $rating ? '<span>★</span>' : '<span style="color: #ccc;">★</span>';
        }
        ?>
    </p>
    <p class="rating">
        Rating Pengiriman: 
        <?php
        $pengiriman = (int) $row['pengiriman']; 
        for ($i = 1; $i <= 5; $i++) {
            echo $i <= $pengiriman ? '<span>★</span>' : '<span style="color: #ccc;">★</span>';
        }
        ?>
    </p>
    <small><?php echo date('d M Y H:i:s', strtotime($row['tanggal'])); ?></small>
</div>
        <?php endwhile; ?>
        
        <?php
        // Menutup statement
        mysqli_stmt_close($stmt);
        ?>
    </div>
</div>

<footer>
    &copy; 2025 Lares Frozen Food. Semua Hak Dilindungi.
</footer>

</body>
</html>

<?php
// Menutup koneksi database
mysqli_close($koneksi);
?>
