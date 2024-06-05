<?php
$xml = simplexml_load_file('albumi.xml');
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Popis albuma</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
  <style>
    .cinzel {
      font-family: "Cinzel", serif;
      font-optical-sizing: auto;
      font-weight: 400;
      font-style: normal;
    }

    body {
      background-color: black;
    }


    .footer {
      bottom: 0;
      width: 100%;
      color: white;
      text-align: center;
      padding: 10px 0;
    }

  </style>
</head>

<body class="cinzel">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="popis_albuma.php">Popis albuma</a>
        <a class="nav-link" href="index.html">Unos albuma</a>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h1 style="color:white;">Albumi</h1>
    <div class="row">
      <?php foreach ($xml->album as $album) : ?>
        <!--4 kartice u redu -->
        <div class="col-md-3">
          <div class="card mb-3">
            <!--sadrzaj u karticama -->
            <div class="card-body">
              <h5 class="card-title"><?php echo $album->naziv; ?></h5>
              <h6 class="card-subtitle mb-2 text-muted"><?php echo $album->bend; ?></h6>
              <p class="card-text"><strong>Žanr:</strong> <?php echo $album->zanr; ?></p>
              <p class="card-text"><strong>Godina:</strong> <?php echo $album->godina; ?></p>
              <!--provjerava ukoliko je slika učitana-->
              <?php if (isset($album->slika) && !empty($album->slika)) : ?>
                <img src="uploads/<?php echo $album->slika; ?>" class="card-img-top" alt="<?php echo $album->naziv; ?>">
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  
  
  <footer class="footer">
    <div class="container">
      <span>&copy; 2024 Martina Kolar</span>
    </div>ŁŁ
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>