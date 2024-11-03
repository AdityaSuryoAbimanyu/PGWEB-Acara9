<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latihan7b";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memastikan ID tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit();
}

$id = intval($_GET['id']); // Mengamankan ID
$sql = "SELECT * FROM tabelpenduduk1 WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit();
}

// Proses pembaruan data jika metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kecamatan = $conn->real_escape_string($_POST['kecamatan']);
    $longitude = $conn->real_escape_string($_POST['longitude']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $luas = $conn->real_escape_string($_POST['luas']);
    $jumlah_penduduk = intval($_POST['jumlah_penduduk']);

    // Coba untuk melakukan update
    try {
        $update_sql = "UPDATE tabelpenduduk1 SET Kecamatan='$kecamatan', Longitude='$longitude', Latitude='$latitude', Luas='$luas', Jumlah_Penduduk='$jumlah_penduduk' WHERE id=$id";
        if ($conn->query($update_sql) === TRUE) {
            echo "Data updated successfully.";
            header('Location: index.php'); // Ganti dengan nama halaman utama Anda
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } catch (Exception $e) {
        echo "Caught exception: ",  $e->getMessage(), "\n";
    }
}
?>

<h1>Edit Data</h1>
<form method="POST">
    <label>Kecamatan:</label>
    <input type="text" name="kecamatan" value="<?= htmlspecialchars($row['Kecamatan']) ?>" required><br>
    
    <label>Longitude:</label>
    <input type="text" name="longitude" value="<?= htmlspecialchars($row['Longitude']) ?>" required><br>
    
    <label>Latitude:</label>
    <input type="text" name="latitude" value="<?= htmlspecialchars($row['Latitude']) ?>" required><br>
    
    <label>Luas:</label>
    <input type="text" name="luas" value="<?= htmlspecialchars($row['Luas']) ?>" required><br>
    
    <label>Jumlah Penduduk:</label>
    <input type="number" name="jumlah_penduduk" value="<?= htmlspecialchars($row['Jumlah_Penduduk']) ?>" required><br>
    
    <button type="submit">Update</button>
</form>
