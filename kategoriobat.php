<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ehealt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Link untuk menambah data
echo "<a href='tambahkategori.php'>Tambah Data</a><br><br>";

// Query untuk mengambil data dari tabel
$sql = "SELECT id, nama_kategori FROM kategori_obat";
$result = $conn->query($sql);

// Membuat header tabel dengan kolom aksi
echo '<table border=1><tr><td>Nama Kategori</td><td>Aksi</td></tr>';

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    extract($row);
    $editLink = "<a href='editkategori.php?id=$id'>Update</a>";
    $hapusLink = "<a href='hapuskategori.php?id=$id' onclick=\"return confirm('Apakah Anda yakin ingin menghapus kategori ini?\\nKategori : $nama_kategori');\">Hapus</a>";
    $aksi = "$editLink | $hapusLink";
    
    // Menampilkan data dan kolom aksi
    //tets aja
    echo "<tr><td>$nama_kategori</td><td>$aksi</td></tr>";
  }
  echo '</table>';
} else {
  echo "Data kosong";
}

$conn->close();
?>
