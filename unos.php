<?php
//provjerava je li forma koristila post metodu
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // podaci iz forme
    $naziv = htmlspecialchars($_POST['naziv']);
    $bend = htmlspecialchars($_POST['bend']);
    $zanr = htmlspecialchars($_POST['zanr']);
    $godina = $_POST['godina'];

    //inicijalizacija direktorija i varijable
    $upload_dir = 'uploads/';
    $upload_file = '';


    //provjerava je li unesena godina validni integer
    if (!filter_var($godina, FILTER_VALIDATE_INT)) {
        echo "Invalid year format";
    } else {
        // prilozena slika
        if (isset($_FILES['slika']) && $_FILES['slika']['error'] == UPLOAD_ERR_OK) {
            $upload_file = basename($_FILES['slika']['name']);
            $target_path = $upload_dir . $upload_file;
            move_uploaded_file($_FILES['slika']['tmp_name'], $target_path);
        }

        // kreiranje ili ažuriranje XML file
        $xml_file = 'albumi.xml';
        if (!file_exists($xml_file)) {
            $xml = new SimpleXMLElement('<albumi></albumi>');
        } else {
            $xml = simplexml_load_file($xml_file);
        }

        //dodavanje novog albuma u xml
        $album_entry = $xml->addChild('album');
        $album_entry->addChild('naziv', $naziv);
        $album_entry->addChild('bend', $bend);
        $album_entry->addChild('zanr', $zanr);
        $album_entry->addChild('godina', $godina);

        if ($upload_file) {
            $album_entry->addChild('slika', $upload_file);
        }

        // trazenje najveceg ID-a i dodavanje istog unesenom albumu
        $last_id = 0;
        foreach ($xml->album as $existing_album) {
            $last_id = max($last_id, (int) $existing_album['id']);
        }
        $album_entry->addAttribute('id', $last_id + 1);

        //spremanje xml-a
        $xml->asXML($xml_file);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unos albuma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .cinzel {
            font-family: "Cinzel", serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        body {
            background-color: black;
            color: white;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .album-img {
            width: 100%;
            max-width: 300px;
            height: auto;
        }
    </style>
</head>

<body class="cinzel">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="navbar-nav">
                <a class="nav-link" href="popis_albuma.php">Popis albuma</a>
                <a class="nav-link active" aria-current="page" href="index.html">Unos albuma</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <?php
                echo "<h2>Unešeni album:</h2>";
                echo "<div>Album: {$naziv}</div>";
                echo "<div>Bend: {$bend}</div>";
                echo "<div>Žanr: {$zanr}</div>";
                echo "<div>Godina izdanja: {$godina}</div>";
                if ($upload_file) {
                    echo "<div>Slika albuma:</div>";
                    echo "<div><img src='uploads/{$upload_file}' alt='{$naziv}' class='album-img mt-2'></div>";
                }
                ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <span>&copy; 2024 Martina Kolar</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
