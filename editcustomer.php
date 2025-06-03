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
  $nama_customer = mysqli_real_escape_string($conn, $_POST['nama_customer']);
  $alamat_customer = mysqli_real_escape_string($conn, $_POST['alamat_customer']);
  $no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  
  // Query untuk mengupdate data customer
  $sql = "UPDATE customer SET nama_customer = '$nama_customer', alamat_customer = '$alamat_customer', no_telepon = '$no_telepon' WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    echo "Data berhasil diupdate. <a href='customer.php'>Lihat Customer</a>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
} else {
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  // Query untuk mengambil data customer berdasarkan id
  $sql = "SELECT id, nama_customer, alamat_customer, no_telepon FROM customer WHERE id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      extract($row);
      ?>
      <h2>Edit Customer</h2>
      <form action="editcustomer.php" method="post">
        <p>
          <label for="nama_customer">Nama Customer:</label>
          <input type="text" name="nama_customer" id="nama_customer" value="<?php echo $nama_customer; ?>" required>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
        </p>
        <p>
          <label for="alamat_customer">Alamat:</label>
          <textarea name="alamat_customer" id="alamat_customer" required><?php echo $alamat_customer; ?></textarea>
        </p>
        <p>
          <label for="no_telepon">No Telepon:</label>
          <input type="text" name="no_telepon" id="no_telepon" value="<?php echo $no_telepon; ?>" required>
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
