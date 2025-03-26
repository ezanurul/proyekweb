<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ubegood"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'], $_POST['phone'], $_POST['menu'], $_POST['price'])) {
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $menu = trim($_POST['menu']);
        $price = intval($_POST['price']); 

        if (empty($name) || empty($phone) || empty($menu) || empty($price)) {
            die("Error: Semua data harus diisi!");
        }

        $stmt = $conn->prepare("INSERT INTO orders (name, phone, menu, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $phone, $menu, $price);

        if ($stmt->execute()) {
            echo "<script>alert('Pesanan berhasil disimpan!'); window.location.href='index.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Data tidak lengkap!";
    }
} else {
    echo "Error: Request harus menggunakan metode POST!";
}

// Tutup koneksi
$conn->close();
?>