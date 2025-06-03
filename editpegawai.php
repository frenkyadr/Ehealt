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
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  
  // Validasi nomor telepon hanya berisi angka
  if (!preg_match('/^[0-9]+$/', $no_telpon)) {
    die("Nomor telepon hanya boleh berisi angka.");
  }
  
  // Query untuk mengupdate data pegawai
  $sql = "UPDATE pegawai SET nama_pegawai = '$nama_pegawai', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', no_telpon = '$no_telpon', jabatan = '$jabatan' WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    echo "Data berhasil diupdate. <a href='pegawai.php'>Lihat Pegawai</a>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
} else {
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  // Query untuk mengambil data pegawai berdasarkan id
  $sql = "SELECT id, nama_pegawai, jenis_kelamin, alamat, no_telpon, jabatan FROM pegawai WHERE id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      extract($row);
      ?>
      <h2>Edit Pegawai</h2>
      <form action="editpegawai.php" method="post">
        <p>
          <label for="nama_pegawai">Nama Pegawai:</label>
          <input type="text" name="nama_pegawai" id="nama_pegawai" value="<?php echo $nama_pegawai; ?>" required>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
        </p>
        <p>
          <label for="jenis_kelamin">Jenis Kelamin:</label>
          <select name="jenis_kelamin" id="jenis_kelamin">
            <option value="Laki-laki" <?php if($jenis_kelamin == "Laki-laki") echo "selected"; ?>>Laki-laki</option>
            <option value="Perempuan" <?php if($jenis_kelamin == "Perempuan") echo "selected"; ?>>Perempuan</option>
          </select>
        </p>
        <p>
          <label for="alamat">Alamat:</label>
          <textarea name="alamat" id="alamat" required><?php echo $alamat; ?></textarea>
        </p>
        <p>
          <label for="no_telpon">No Telepon:</label>
          <input type="text" name="no_telpon" id="no_telpon" value="<?php echo $no_telpon; ?>" required pattern="[0-9]+" title="Nomor telepon hanya boleh berisi angka">
        </p>
        <p>
          <label for="jabatan">Jabatan:</label>
          <select name="jabatan" id="jabatan">
            <option value="Kasir" <?php if($jabatan == "Kasir") echo "selected"; ?>>Kasir</option>
            <option value="Asisten Apoteker" <?php if($jabatan == "Asisten Apoteker") echo "selected"; ?>>Asisten Apoteker</option>
            <option value="Apoteker" <?php if($jabatan == "Apoteker") echo "selected"; ?>>Apoteker</option>
          </select>
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
