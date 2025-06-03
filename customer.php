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

// Link untuk menambah data
echo "<a href='tambahcustomer.php'>Tambah Customer</a><br><br>";

// Query untuk mengambil data dari tabel customer
$sql = "SELECT id, nama_customer, alamat_customer, no_telepon FROM customer";
$result = $conn->query($sql);

// Membuat header tabel dengan kolom aksi
echo '<table border=1><tr><td>Nama Customer</td><td>Alamat</td><td>No Telepon</td><td>Aksi</td></tr>';

if ($result->num_rows > 0) {
  // Output data dari tiap baris
  while($row = $result->fetch_assoc()) {
    extract($row);
    $editLink = "<a href='editcustomer.php?id=$id'>Update</a>";
    $hapusLink = "<a href='hapuscustomer.php?id=$id' onclick=\"return confirm('Apakah Anda yakin ingin menghapus customer ini?\\nNama: $nama_customer\\nAlamat: $alamat_customer\\nNo Telepon: $no_telepon');\">Hapus</a>";
    $aksi = "$editLink | $hapusLink";
    
    // Menampilkan data dan kolom aksi
    echo "<tr><td>$nama_customer</td><td>$alamat_customer</td><td>$no_telepon</td><td>$aksi</td></tr>";
  }
  echo '</table>';
} else {
  echo "Data kosong";
}

$conn->close();
?>
