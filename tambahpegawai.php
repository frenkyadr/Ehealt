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
  $nama_pegawai = mysqli_real_escape_string($conn, $_POST['nama_pegawai']);
  $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
  $no_telpon = mysqli_real_escape_string($conn, $_POST['no_telpon']);
  $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);

  // Validasi nomor telepon hanya berisi angka
  if (!preg_match('/^[0-9]+$/', $no_telpon)) {
    die("Nomor telepon hanya boleh berisi angka.");
  }
  
  // Query untuk menambah data pegawai
  $sql = "INSERT INTO pegawai (nama_pegawai, jenis_kelamin, alamat, no_telpon, jabatan) 
          VALUES ('$nama_pegawai', '$jenis_kelamin', '$alamat', '$no_telpon', '$jabatan')";

  if ($conn->query($sql) === TRUE) {
    echo "Data berhasil ditambahkan. <a href='pegawai.php'>Lihat Pegawai</a>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
} else {
  ?>
  <h2>Tambah Pegawai</h2>
  <form action="tambahpegawai.php" method="post">
    <p>
      <label for="nama_pegawai">Nama Pegawai:</label>
      <input type="text" name="nama_pegawai" id="nama_pegawai" required>
    </p>
    <p>
      <label for="jenis_kelamin">Jenis Kelamin:</label>
      <select name="jenis_kelamin" id="jenis_kelamin">
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
    </p>
    <p>
      <label for="alamat">Alamat:</label>
      <textarea name="alamat" id="alamat" required></textarea>
    </p>
    <p>
      <label for="no_telpon">No Telepon:</label>
      <input type="text" name="no_telpon" id="no_telpon" required pattern="[0-9]+" title="Nomor telepon hanya boleh berisi angka">
    </p>
    <p>
      <label for="jabatan">Jabatan:</label>
      <select name="jabatan" id="jabatan">
        <option value="Kasir">Kasir</option>
        <option value="Asisten Apoteker">Asisten Apoteker</option>
        <option value="Apoteker">Apoteker</option>
      </select>
    </p>
    <input type="submit" value="Submit">
  </form>
  <?php 
}
?>
