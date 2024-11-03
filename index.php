<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet JS</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
    <style>
        html,
        body,
        #map {
            height: 100%;
            width: 100%;
            margin: 0;
        }

        table {
            margin: 20px;
            border-collapse: collapse;
            width: calc(100% - 40px);
        }

        th,
        td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        h1 {
            text-align: center;
            margin: 20px;
        }
    </style>
</head>

<body>
    <h1>PGWEB ACARA 9</h1>

    <?php
    // Sesuaikan dengan setting MySQL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "latihan7b";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM tabelpenduduk1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr>
            <th>Kecamatan</th>
            <th>Longitude</th>
            <th>Latitude</th>
            <th>Luas</th>
            <th>Jumlah Penduduk</th>
            <th>Action</th></tr>";

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($row["Kecamatan"]) . "</td>
                <td>" . htmlspecialchars($row["Longitude"]) . "</td>
                <td>" . htmlspecialchars($row["Latitude"]) . "</td>
                <td>" . htmlspecialchars($row["Luas"]) . "</td>
                <td align='right'>" . htmlspecialchars($row["Jumlah_Penduduk"]) . "</td>
                <td>
                    <a href='edit.php?id=" . $row["id"] . "'>Edit</a> | 
                    <a href='delete.php?id=" . $row["id"] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Delete</a>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Tidak ada hasil.</p>";
    }

    $conn->close();
    ?>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
    <script>
        /* Initial Map */
        var map = L.map('map').setView([-7.77, 110.37], 14); //lat, long, zoom

        /* Tile Basemap */
        var basemap1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | <a href="DIVSIG UGM" target="_blank">DIVSIG UGM</a>'
        });
        basemap1.addTo(map);

        <?php
        // Koneksi dan ambil data untuk peta
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT * FROM tabelpenduduk1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lat = htmlspecialchars($row["Latitude"]);
                $long = htmlspecialchars($row["Longitude"]);
                $info = htmlspecialchars($row["Kecamatan"]);
                echo "L.marker([$lat, $long]).addTo(map).bindPopup('$info, $lat, $long');";
            }
        } else {
            echo "console.log('No results for map markers.');";
        }
        $conn->close();
        ?>
    </script>
</body>

</html>
