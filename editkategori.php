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
  $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  
  // Query untuk mengupdate data kategori
  $sql = "UPDATE kategori_obat SET nama_kategori = '$nama_kategori' WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    echo "Data berhasil diupdate. <a href='kategoriobat.php'>Lihat kategori obat</a>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
} else {
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  // Query untuk mengambil data kategori berdasarkan id
  $sql = "SELECT id, nama_kategori FROM kategori_obat WHERE id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      extract($row);
      ?>
      <h2>Edit Kategori Obat</h2>
      <form action="editkategori.php" method="post">
        <p>
          <label for="nama_kategori">Nama Kategori:</label>
          <input type="text" name="nama_kategori" id="nama_kategori" value="<?php echo $nama_kategori; ?>">
          <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        </p>
        <input type="submit" value="Submit">
      </form>
      <?php 
    }
  } else {
    echo "Data tidak ditemukan.";
  }
}
?>
