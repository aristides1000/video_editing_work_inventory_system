<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Inicio de Sesión</title>
<?php
  include_once('./includes/navbar.php');
?>

  <form class="mx-5 mt-5" action="login_logic.php" method="post">
    <div class="mb-3">
      <label for="nickname" class="form-label">Nombre de usuario</label>
      <input type="text" class="form-control" id="nickname" name="nickname" aria-describedby="nicknameHelp">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Clave</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    <button type="reset" class="btn btn-warning">Limpiar</button>
  </form>

<script>
  const allNavbarLink = document.querySelectorAll('.nav-link');
  allNavbarLink.forEach((navLink) => {
    if (navLink.textContent === 'Iniciar sesión') {
      navLink.classList.add('active');
    } else {
      navLink.classList.remove('active');
    }
  });
</script>

<?php
  include_once('./includes/footer.php');
?>