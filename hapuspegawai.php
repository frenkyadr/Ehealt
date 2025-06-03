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

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Query untuk menghapus data pegawai
$sql = "DELETE FROM pegawai WHERE id = $id";

if ($conn->query($sql) === TRUE) {
  echo "Data berhasil dihapus. <a href='pegawai.php'>Kembali ke Pegawai</a>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
