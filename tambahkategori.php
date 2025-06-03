
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ehealt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if($_POST){
	$kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
	$sql = "INSERT INTO `kategori_obat` 
	(`nama_kategori`	)
	VALUES ('$kategori')";

	if ($conn->query($sql) === TRUE) {
	  echo "Data masuk <a href='kategoriobat.php'>Lihat Kategori Obat</a>";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}
else{
	?>
	<form action="tambahkategori.php" method="post">
    <p>
        <label for="kategori">Kategori:</label>
        <input type="text" name="kategori" id="kategori">
    </p>
    <input type="submit" value="Submit">
</form>
	<?php 
}
?>
