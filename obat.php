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


// Tabel Kategori Obat - Ditempatkan di atas tabel Data Obat

echo "<h3>Data Kategori Obat</h3>";
echo "<a href='kategoriobat.php'>Lihat Kategori Obat</a><br><br>";
$sql_kategori = "SELECT id, nama_kategori FROM kategori_obat";
$result_kategori = $conn->query($sql_kategori);

// Membuat header tabel untuk kategori obat (tanpa kolom aksi)
echo '<table border=1><tr><td>Nama Kategori</td></tr>';

if ($result_kategori->num_rows > 0) {
  // Output data dari tiap baris
  while($row = $result_kategori->fetch_assoc()) {
    extract($row);
    // Menampilkan data kategori tanpa kolom aksi
    echo "<tr><td>$nama_kategori</td></tr>";
  }
  echo '</table>';
} else {
  echo "Data kategori obat kosong<br><br>";
}


// Query untuk mengambil data dari tabel obat dan kategori_obat
$sql = "SELECT obat.id, obat.nama_obat, kategori_obat.nama_kategori, obat.harga, obat.stok 
        FROM obat 
        JOIN kategori_obat ON obat.kategori_id = kategori_obat.id";
$result = $conn->query($sql);

// Membuat header tabel untuk obat
echo '<h3>Data Obat</h3>';
echo "<a href='tambahobat.php'>Tambah Data Obat</a><br><br>";
echo '<table border=1><tr><td>Nama Obat</td><td>Kategori</td><td>Harga</td><td>Stok</td><td>Aksi</td></tr>';

if ($result->num_rows > 0) {
  // Output data dari tiap baris
  while($row = $result->fetch_assoc()) {
    extract($row);
    $editLink = "<a href='editobat.php?id=$id'>Update</a>";
    $hapusLink = "<a href='hapusobat.php?id=$id' onclick=\"return confirm('Apakah Anda yakin ingin menghapus obat ini?\\nNama Obat: $nama_obat\\nKategori: $nama_kategori\\nStok: $stok\\nHarga: $harga');\">Hapus</a>";
    $aksi = "$editLink | $hapusLink";
    
    // Menampilkan data dan kolom aksi
    echo "<tr><td>$nama_obat</td><td>$nama_kategori</td><td>$harga</td><td>$stok</td><td>$aksi</td></tr>";
  }
  echo '</table>';
} else {
  echo "Data obat kosong";
}

$conn->close();
?>
