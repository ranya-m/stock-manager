<?php require_once("./components/header.php");?>
<main class="form-signin w-25 m-auto">
<form action="./traitement.php" method ="post">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
    <div class="form-floating mb-3">
        <input type="name"  class="form-control" id="name" placeholder="username" name="username">
        <label for="name">Username</label>
    </div>
    <div class="form-floating mb-3">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name="register">Sign in</button>
   
  </form>
</main>
  <?php
require_once("./components/footer.php") ?>