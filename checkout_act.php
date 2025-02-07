<?php 
include 'koneksi.php';

session_start();

if (!isset($_SESSION['customer_id'])) {
    header("location:login.php");
    exit;
}

$id_customer = $_SESSION['customer_id'];
$tanggal = date('Y-m-d');

$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$hp = mysqli_real_escape_string($koneksi, $_POST['hp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$provinsi = mysqli_real_escape_string($koneksi, $_POST['provinsi2']);
$kabupaten = mysqli_real_escape_string($koneksi, $_POST['kabupaten2']);
$kurir = mysqli_real_escape_string($koneksi, $_POST['kurir'] ." - ". $_POST['service']);
$ongkir = (int)$_POST['ongkir2'];
$total_bayar = (int)$_POST['total_bayar'] + $ongkir;

$berat_total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $id_produk = $item['produk'];
    $jumlah = $item['jumlah'];

    // Ambil berat produk
    $query = mysqli_query($koneksi, "SELECT produk_berat FROM produk WHERE produk_id='$id_produk'");
    $produk = mysqli_fetch_assoc($query);
    $berat_satuan = $produk['produk_berat'];

    $berat_total += $berat_satuan * $jumlah;
}

// Simpan invoice
$query_invoice = "INSERT INTO invoice VALUES (NULL, '$tanggal', '$id_customer', '$nama', '$hp', '$alamat', '$provinsi', '$kabupaten', '$kurir', '$berat_total', '$ongkir', '$total_bayar', '0', '', '')";
mysqli_query($koneksi, $query_invoice) or die(mysqli_error($koneksi));
$last_id = mysqli_insert_id($koneksi);

// Proses transaksi
foreach ($_SESSION['keranjang'] as $item) {
    $id_produk = $item['produk'];
    $jumlah = $item['jumlah'];

    $isi = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id='$id_produk'");
    $i = mysqli_fetch_assoc($isi);

    if (!$i || $i['produk_jumlah'] < $jumlah) {
        die("Stok tidak cukup untuk produk: " . $id_produk);
    }

    mysqli_query($koneksi, "UPDATE produk SET produk_jumlah = produk_jumlah - $jumlah WHERE produk_id = '$id_produk'");
    $harga = $i['produk_harga'];
    mysqli_query($koneksi, "INSERT INTO transaksi VALUES (NULL, '$last_id', '$id_produk', '$jumlah', '$harga')");
}

unset($_SESSION['keranjang']);
header("location:customer_pesanan.php?alert=sukses");
?>
