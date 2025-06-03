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

// Tabel Customer
echo "<h3>Data Customer</h3>";
echo "<a href='customer.php'>Lihat Tabel Customer</a><br><br>";
$sql_customer = "SELECT id, nama_customer, alamat_customer, no_telepon FROM customer";
$result_customer = $conn->query($sql_customer);
echo '<table border=1><tr><td>Nama Customer</td><td>Alamat</td><td>No Telepon</td></tr>';
if ($result_customer->num_rows > 0) {
  while($row = $result_customer->fetch_assoc()) {
    extract($row);
    echo "<tr><td>$nama_customer</td><td>$alamat_customer</td><td>$no_telepon</td></tr>";
  }
  echo '</table><br>';
} else {
  echo "Data kosong<br><br>";
}

// Tabel Obat
echo "<h3>Data Obat</h3>";
echo "<a href='obat.php'>Lihat Tabel Obat</a><br><br>";
$sql_obat = "SELECT obat.id, obat.nama_obat, kategori_obat.nama_kategori, obat.harga, obat.stok 
        FROM obat 
        JOIN kategori_obat ON obat.kategori_id = kategori_obat.id";
$result_obat = $conn->query($sql_obat);
echo '<table border=1><tr><td>Nama Obat</td><td>Kategori</td><td>Harga</td><td>Stok</td></tr>';
if ($result_obat->num_rows > 0) {
  while($row = $result_obat->fetch_assoc()) {
    extract($row);
    echo "<tr><td>$nama_obat</td><td>$nama_kategori</td><td>$harga</td><td>$stok</td></tr>";
  }
  echo '</table><br>';
} else {
  echo "Data kosong<br><br>";
}

// Tabel Pegawai
echo "<h3>Data Pegawai</h3>";
echo "<a href='pegawai.php'>Lihat Tabel Pegawai</a><br><br>";
$sql_pegawai = "SELECT id, nama_pegawai, jenis_kelamin, alamat, no_telpon, jabatan FROM pegawai";
$result_pegawai = $conn->query($sql_pegawai);
echo '<table border=1><tr><td>Nama Pegawai</td><td>Jenis Kelamin</td><td>Alamat</td><td>No Telepon</td><td>Jabatan</td></tr>';
if ($result_pegawai->num_rows > 0) {
  while($row = $result_pegawai->fetch_assoc()) {
    extract($row);
    echo "<tr><td>$nama_pegawai</td><td>$jenis_kelamin</td><td>$alamat</td><td>$no_telpon</td><td>$jabatan</td></tr>";
  }
  echo '</table><br>';
} else {
  echo "Data kosong<br><br>";
}

// Query untuk mengambil data transaksi
$sql_transaksi = "SELECT transaksi.id, customer.nama_customer, obat.nama_obat, transaksi.jumlah, transaksi.total_harga, transaksi.tanggal_transaksi, pegawai.nama_pegawai 
        FROM transaksi 
        JOIN customer ON transaksi.customer_id = customer.id 
        JOIN obat ON transaksi.obat_id = obat.id 
        JOIN pegawai ON transaksi.pegawai_id = pegawai.id";
$result_transaksi = $conn->query($sql_transaksi);

// Menampilkan tabel transaksi

echo '<h3>Data Transaksi</h3>';
echo "<a href='tambahtransaksi.php'>Tambah Transaksi</a><br><br>";
echo '<table border=1><tr><td>Nama Customer</td><td>Nama Obat</td><td>Jumlah</td><td>Total Harga</td><td>Tanggal Transaksi</td><td>Pegawai</td></tr>';
if ($result_transaksi->num_rows > 0) {
  while($row = $result_transaksi->fetch_assoc()) {
    extract($row);
    echo "<tr><td>$nama_customer</td><td>$nama_obat</td><td>$jumlah</td><td>$total_harga</td><td>$tanggal_transaksi</td><td>$nama_pegawai</td></tr>";
  }
  echo '</table>';
} else {
  echo "Data transaksi kosong";
}

$conn->close();
?>
