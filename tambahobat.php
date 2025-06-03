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

if($_POST) {
  $nama_obat = mysqli_real_escape_string($conn, $_POST['nama_obat']);
  $kategori_id = mysqli_real_escape_string($conn, $_POST['kategori_id']);
  $harga = mysqli_real_escape_string($conn, $_POST['harga']);
  $stok = mysqli_real_escape_string($conn, $_POST['stok']);

  $sql = "INSERT INTO `obat` (`nama_obat`, `kategori_id`, `harga`, `stok`) VALUES ('$nama_obat', '$kategori_id', '$harga', '$stok')";

  if ($conn->query($sql) === TRUE) {
    echo "Data obat berhasil ditambahkan. <a href='obat.php'>Lihat Obat</a>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
} else {
  // Query untuk mengambil daftar kategori dari tabel kategori_obat
  $kategori_sql = "SELECT id, nama_kategori FROM kategori_obat";
  $kategori_result = $conn->query($kategori_sql);
  ?>
  
  <form action="tambahobat.php" method="post">
    <p>
        <label for="nama_obat">Nama Obat:</label>
        <input type="text" name="nama_obat" id="nama_obat" required>
    </p>
    <p>
        <label for="kategori_id">Kategori:</label>
        <select name="kategori_id" id="kategori_id" required>
            <option value="">Pilih Kategori</option>
            <?php
            if ($kategori_result->num_rows > 0) {
                while ($row = $kategori_result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nama_kategori'] . "</option>";
                }
            } else {
                echo "<option value=''>Kategori tidak tersedia</option>";
            }
            ?>
        </select>
    </p>
    <p>
        <label for="harga">Harga:</label>
        <input type="number" name="harga" id="harga" required>
    </p>
    <p>
        <label for="stok">Stok:</label>
        <input type="number" name="stok" id="stok" required>
    </p>
    <input type="submit" value="Submit">
  </form>

  <?php
}
?>
