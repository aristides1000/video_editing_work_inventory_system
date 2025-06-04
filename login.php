<?php
  include_once('./includes/header.php');
?>
  <title>Inicio de Sesión</title>
<?php
  include_once('./includes/navbar.php');
?>

  <form class="mx-5 mt-5">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Nombre de usuario</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Clave</label>
      <input type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
  </form>
<?php
  include_once('./includes/footer.php');
?>