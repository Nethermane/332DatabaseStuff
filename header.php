<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<?php
$active = 555;
if (strpos($_SERVER['REQUEST_URI'], 'home') !== false || $_SERVER['REQUEST_URI'] == "/") {
  $active = 0;
}
if (strpos($_SERVER['REQUEST_URI'], 'Search') !== false) {
  $active = 1;
}
if (strpos($_SERVER['REQUEST_URI'], 'Drive') !== false || strpos($_SERVER['REQUEST_URI'], 'drive') !== false) {
  $active = 2;
}
if (strpos($_SERVER['REQUEST_URI'], 'Adopt') !== false) {
  $active = 3;
}
if (strpos($_SERVER['REQUEST_URI'], 'SpcaTo') !== false) {
  $active = 4;
}
if (strpos($_SERVER['REQUEST_URI'], 'Donated') !== false) {
  $active = 5;
}
if (strpos($_SERVER['REQUEST_URI'], 'Rescued') !== false) {
  $active = 6;
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <?php echo '<li class="nav-item';
              echo ($active == 0) ? ' active"' : '"';
              echo '> <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a></li>'; ?>
        <?php echo '<li class="nav-item';
              echo ($active == 1) ? ' active"' : '"';
              echo '> <a class="nav-link" href="AnimalSearch.php">Animal Search</a></li>'; ?>
        <?php echo '<li class="nav-item';
              echo ($active == 2) ? ' active"' : '"';
              echo '> <a class="nav-link" href="Drivers.php">Drivers</a></li>'; ?>
        <?php echo '<li class="nav-item';
              echo ($active == 3) ? ' active"' : '"';
              echo '> <a class="nav-link" href="Adopt.php">Adopt</a></li>'; ?>
        <?php echo '<li class="nav-item';
              echo ($active == 4) ? ' active"' : '"';
              echo '> <a class="nav-link" href="SpcaToShelter.php">SPCA to shelter</a></li>'; ?>
        <?php echo '<li class="nav-item';
              echo ($active == 5) ? ' active"' : '"';
              echo '> <a class="nav-link" href="Donated-2018.php">Donated-2018</a></li>'; ?>
        <?php echo '<li class="nav-item';
              echo ($active == 6) ? ' active"' : '"';
              echo '> <a class="nav-link" href="Rescued-2018.php">Rescued-2018</a></li>'; ?>
      </ul>
    </div>
  </nav>
<body>
</html>