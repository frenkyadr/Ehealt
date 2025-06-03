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

if ($_POST) {
  $nama_obat = mysqli_real_escape_string($conn, $_POST['nama_obat']);
  $kategori_id = mysqli_real_escape_string($conn, $_POST['kategori_id']);
  $harga = mysqli_real_escape_string($conn, $_POST['harga']);
  $stok = mysqli_real_escape_string($conn, $_POST['stok']);
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  
  // Query untuk mengupdate data obat
  $sql = "UPDATE obat SET nama_obat = '$nama_obat', kategori_id = $kategori_id, harga = $harga, stok = $stok WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    echo "Data berhasil diupdate. <a href='obat.php'>Lihat obat</a>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

} else {
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  // Query untuk mengambil data obat berdasarkan id
  $sql = "SELECT id, nama_obat, kategori_id, harga, stok FROM obat WHERE id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    extract($row);

    // Query untuk mengambil daftar kategori obat
    $kategoriSql = "SELECT id, nama_kategori FROM kategori_obat";
    $kategoriResult = $conn->query($kategoriSql);
    ?>
    <h2>Edit Obat</h2>
    <form action="editobat.php" method="post">
      <p>
        <label for="nama_obat">Nama Obat:</label>
        <input type="text" name="nama_obat" id="nama_obat" value="<?php echo $nama_obat; ?>">
      </p>
      <p>
        <label for="kategori_id">Kategori:</label>
        <select name="kategori_id" id="kategori_id">
          <?php
          if ($kategoriResult->num_rows > 0) {
            while ($kategori = $kategoriResult->fetch_assoc()) {
              $selected = ($kategori['id'] == $kategori_id) ? 'selected' : '';
              echo "<option value='{$kategori['id']}' $selected>{$kategori['nama_kategori']}</option>";
            }
          }
          ?>
        </select>
      </p>
      <p>
        <label for="harga">Harga:</label>
        <input type="number" name="harga" id="harga" value="<?php echo $harga; ?>">
      </p>
      <p>
        <label for="stok">Stok:</label>
        <input type="number" name="stok" id="stok" value="<?php echo $stok; ?>">
      </p>
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <input type="submit" value="Submit">
    </form>
    <?php 
  } else {
    echo "Data tidak ditemukan.";
  }
}

// Menutup koneksi hanya satu kali setelah semua proses selesai
$conn->close();
?>
