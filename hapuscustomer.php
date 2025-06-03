<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ehealt";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
// Memeriksa koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan id dari parameter request
$id = $_REQUEST['id'];

// Query untuk menghapus data berdasarkan id
$sql = "DELETE FROM customer WHERE id = $id";

if ($conn->query($sql) === TRUE) {
  echo "Data berhasil dihapus. <a href='customer.php'>Lihat Customer</a>";
} else {
  echo "Gagal menghapus data: " . $conn->error;
}

// Menutup koneksi
$conn->close();
exit();
?>
