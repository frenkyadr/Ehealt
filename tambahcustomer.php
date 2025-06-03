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
  
  // Query untuk menambah data customer
  $sql = "INSERT INTO customer (nama_customer, alamat_customer, no_telepon) 
          VALUES ('$nama_customer', '$alamat_customer', '$no_telepon')";

  if ($conn->query($sql) === TRUE) {
    echo "Data berhasil ditambahkan. <a href='customer.php'>Lihat Customer</a>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
} else {
  ?>
  <h2>Tambah Customer</h2>
  <form action="tambahcustomer.php" method="post">
    <p>
      <label for="nama_customer">Nama Customer:</label>
      <input type="text" name="nama_customer" id="nama_customer" required>
    </p>
    <p>
      <label for="alamat_customer">Alamat:</label>
      <textarea name="alamat_customer" id="alamat_customer" required></textarea>
    </p>
    <p>
      <label for="no_telepon">No Telepon:</label>
      <input type="text" name="no_telepon" id="no_telepon" required>
    </p>
    <input type="submit" value="Submit">
  </form>
  <?php 
}
?>
