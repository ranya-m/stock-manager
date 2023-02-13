<?php 
session_start();

// $LOGGED SUIT LA VALEUR CONTROLE DU ISSET $FETCHUSER : boolean value true
$logged = isset($_SESSION["fetchUser"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>STOCK MANAGER</title>
</head>
<body>
    
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">STOCK MANAGER</a>
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarCollapse" style="">
      <ul class="navbar-nav ms-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="./index.php">Home</a>
        </li>
        
        <?php if($logged) :?>
          <li class="nav-item">
          <a class="nav-link" href="./products.php">Products</a>
        </li>
          <li class="nav-item">
          <a class="nav-link" href="./logout.php">Logout</a>
        </li>
        <?php else :?>
           <li class="nav-item">
          <a class="nav-link" href="./login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./register.php">Register</a>
        </li>
        <?php endif; ?>

        
      </ul>
    </div>
  </div>
</nav>

<!-- DISPLAYING ERRORS ON THE PAGE -->

<!--ONE OR MULTIPLE ERRORS FOR REGISTERING AT A TIME -->

<?php if(isset($_SESSION["errors"])) : ?>
  <ul class="container-fluid">
    <?php foreach($_SESSION["errors"] as $error): ?>
    
        <li class="list-group-item bg-danger text-white">
          <?= $error ?>
        </li>
    
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<!-- ONE ERROR AT A TIME FOR LOG IN -->
<?php if(isset($_SESSION["error"])):?>
  <div class="alert alert-danger">
    <?= $_SESSION["error"] ?>
  </div>
<?php endif; ?>

<!-- ONE SUCCESS AT A TIME FOR LOG IN -->
<?php if(isset($_SESSION["success"])):?>
  <div class="alert alert-success ">
    <?= $_SESSION["success"] ?>
  </div>
<?php endif; ?>