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
echo "<a href='tambahpegawai.php'>Tambah Pegawai</a><br><br>";

// Query untuk mengambil data dari tabel pegawai
$sql = "SELECT id, nama_pegawai, jenis_kelamin, alamat, no_telpon, jabatan FROM pegawai";
$result = $conn->query($sql);

// Membuat header tabel dengan kolom aksi
echo '<table border=1><tr><td>Nama Pegawai</td><td>Jenis Kelamin</td><td>Alamat</td><td>No Telepon</td><td>Jabatan</td><td>Aksi</td></tr>';

if ($result->num_rows > 0) {
  // Output data dari tiap baris
  while($row = $result->fetch_assoc()) {
    extract($row);
    $editLink = "<a href='editpegawai.php?id=$id'>Update</a>";
    $hapusLink = "<a href='hapuspegawai.php?id=$id' onclick=\"return confirm('Apakah Anda yakin ingin menghapus pegawai ini?');\">Hapus</a>";
    $aksi = "$editLink | $hapusLink";
    
    // Menampilkan data dan kolom aksi
    echo "<tr><td>$nama_pegawai</td><td>$jenis_kelamin</td><td>$alamat</td><td>$no_telpon</td><td>$jabatan</td><td>$aksi</td></tr>";
  }
  echo '</table>';
} else {
  echo "Data kosong";
}

$conn->close();
?>
