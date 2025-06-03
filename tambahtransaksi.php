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

// Jika form disubmit
if ($_POST) {
  $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
  $obat_id = mysqli_real_escape_string($conn, $_POST['obat_id']);
  $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
  $pegawai_id = mysqli_real_escape_string($conn, $_POST['pegawai_id']);  // Menambahkan pegawai_id
  
  // Mendapatkan harga dan stok obat yang dipilih
  $query = "SELECT harga, stok FROM obat WHERE id = $obat_id";
  $result = $conn->query($query);
  $obat = $result->fetch_assoc();
  
  if ($obat['stok'] <= 0) {
    echo "Transaksi tidak dapat dilakukan, stok obat habis.";
  } elseif ($jumlah > $obat['stok']) {
    echo "Jumlah melebihi stok yang tersedia. Stok saat ini adalah " . $obat['stok'];
  } else {
    // Menghitung total harga
    $total_harga = $jumlah * $obat['harga'];
    
    // Query untuk menyimpan data transaksi dengan pegawai_id
    $sql = "INSERT INTO transaksi (customer_id, obat_id, jumlah, total_harga, tanggal_transaksi, pegawai_id) 
            VALUES ('$customer_id', '$obat_id', '$jumlah', '$total_harga', NOW(), '$pegawai_id')";
    
    if ($conn->query($sql) === TRUE) {
      // Mengurangi stok obat setelah transaksi berhasil
      $updateStok = "UPDATE obat SET stok = stok - $jumlah WHERE id = $obat_id";
      $conn->query($updateStok);
      
      echo "Transaksi berhasil ditambahkan. <a href='transaksi.php'>Lihat Transaksi</a>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  $conn->close();
} else {
  // Menampilkan form tambah transaksi
  ?>

  <h2>Tambah Transaksi</h2>
  <form action="tambahtransaksi.php" method="post">
    <p>
      <label for="customer_id">Nama Customer:</label>
      <select name="customer_id" id="customer_id" required>
        <?php
        // Mengambil data customer untuk dropdown
        $customerQuery = "SELECT id, nama_customer FROM customer";
        $customerResult = $conn->query($customerQuery);
        while ($customer = $customerResult->fetch_assoc()) {
          echo "<option value='" . $customer['id'] . "'>" . $customer['nama_customer'] . "</option>";
        }
        ?>
      </select>
    </p>
    <p>
      <label for="obat_id">Nama Obat:</label>
      <select name="obat_id" id="obat_id" required onchange="updateHarga(this.value)">
        <option value="">Pilih Obat</option>
        <?php
        // Mengambil data obat untuk dropdown
        $obatQuery = "SELECT id, nama_obat, harga, stok FROM obat";
        $obatResult = $conn->query($obatQuery);
        while ($obat = $obatResult->fetch_assoc()) {
          echo "<option value='" . $obat['id'] . "' data-harga='" . $obat['harga'] . "' data-stok='" . $obat['stok'] . "'>" 
               . $obat['nama_obat'] . " - Stok: " . $obat['stok'] . "</option>";
        }
        ?>
      </select>
    </p>
    <p>
      <label for="jumlah">Jumlah:</label>
      <input type="number" name="jumlah" id="jumlah" min="1" required oninput="calculateTotal()">
    </p>
    <p>
      <label for="pegawai_id">Nama Pegawai:</label>
      <select name="pegawai_id" id="pegawai_id" required>
        <?php
        // Mengambil data pegawai untuk dropdown
        $pegawaiQuery = "SELECT id, nama_pegawai FROM pegawai";
        $pegawaiResult = $conn->query($pegawaiQuery);
        while ($pegawai = $pegawaiResult->fetch_assoc()) {
          echo "<option value='" . $pegawai['id'] . "'>" . $pegawai['nama_pegawai'] . "</option>";
        }
        ?>
      </select>
    </p>
    <p>
      <label for="total_harga">Total Harga:</label>
      <input type="text" name="total_harga" id="total_harga" readonly>
    </p>
    <input type="submit" value="Submit">
  </form>

  <script>
    let hargaObat = 0;
    let stokObat = 0;

    // Fungsi untuk mengupdate harga obat dan stok
    function updateHarga(obatId) {
      const select = document.getElementById('obat_id');
      const selectedOption = select.options[select.selectedIndex];
      hargaObat = parseFloat(selectedOption.getAttribute('data-harga'));
      stokObat = parseInt(selectedOption.getAttribute('data-stok'));
      calculateTotal();
    }

    // Fungsi untuk menghitung total harga
    function calculateTotal() {
      const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
      if (jumlah > stokObat) {
        alert('Jumlah melebihi stok yang tersedia: ' + stokObat);
        document.getElementById('jumlah').value = stokObat;
        document.getElementById('total_harga').value = stokObat * hargaObat;
      } else {
        document.getElementById('total_harga').value = jumlah * hargaObat;
      }
    }
  </script>

  <?php
}
?>
