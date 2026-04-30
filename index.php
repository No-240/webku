<?php
// Tampilkan error untuk proses pengembangan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Menghubungkan ke koneksi.php
include "koneksi.php";

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama  = trim($_POST['nama']);
    $harga = $_POST['harga'];

    // Gunakan Prepared Statement agar AMAN dari SQL Injection
    $stmt = mysqli_prepare($conn, "INSERT INTO nama_produk (nama_pdk, harga) VALUES (?, ?)");
    
    if ($stmt) {
        // "sd" -> string untuk nama, d untuk harga (double/decimal)
        mysqli_stmt_bind_param($stmt, "sd", $nama, $harga);
        
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, langsung pindah ke index.php agar tidak duplikat saat refresh
            header("Location: index.php");
            exit;
        } else {
            $error_msg = "Gagal menyimpan: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penugasan 3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>HELLO WORLD</h1>
</header>

<nav>
    <div class="nav-links">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </div>
</nav>

<div class="container">

    <!-- HERO SECTION / ABOUT -->
    <div class="card">
        <h2>Hello Mate!</h2>
        <p>Halo! Saya Yuda Maulana, seorang mahasiswa Teknik Informatika yang sedang menempuh pendidikan di Universitas Muhammadiyah Sukabumi. Saya memiliki ketertarikan besar pada dunia teknologi, khususnya pengembangan perangkat lunak, web development, serta eksplorasi ide-ide kreatif yang bisa memberikan solusi nyata bagi masyarakat.</p>
    </div>

    <div class="card">
        <h2>CONTOH GAMBAR</h2>
        <img src="wa.jpeg" alt="Gambar"> 
    </div>

    <!-- TABEL DATABASE -->
    <div class="card">
        <h2>Daftar Produk</h2>
        <div style="overflow-x: auto;">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($conn, "SELECT * FROM nama_produk ORDER BY id DESC");
                    
                    if (mysqli_num_rows($data) > 0) {
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>" . htmlspecialchars($row['nama_pdk']) . "</td>
                                    <td>Rp" . number_format($row['harga'], 0, ',', '.') . "</td>
                                  </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='3'>Belum ada data.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FORM INPUT -->
    <div class="card">
        <h2>Tambah Produk Baru</h2>
        <?php if ($error_msg): ?>
            <p style="color: red;"><?= $error_msg ?></p>
        <?php endif; ?>
        
        <form method="POST" class="form-input">
            <div class="form-group">
                <input type="text" name="nama" placeholder="Nama Produk" required>
            </div>
            <div class="form-group">
                <input type="number" name="harga" placeholder="Harga (Contoh: 5000)" required>
            </div>
            <button type="submit" class="btn-kirim">Simpan Produk</button>
        </form>
    </div>

</div>

<footer>
    <p>TERIMA KASIH</p>
</footer>

<script src="script.js"></script>

</body>
</html>