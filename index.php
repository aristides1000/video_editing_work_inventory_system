<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Inicio</title>
<?php
  include_once('./includes/navbar.php');

  switch ($_SESSION['user_type_id']) {
    case "1":
      ?>
        <h1>Hola <span class="fw-bolder"><?php echo $_SESSION['nickname'] ?></span>, Bienvenido a la pagina de inicio!</h1>
        <p>Seras redirigido en <span id="counter" class="fw-bolder"></span> segundos a <span class="fw-bolder">Registro de Usuarios</span></p>

        <meta http-equiv="refresh" content="5; URL=./user_registration.php" />
      <?php
      break;
    case "2":
      ?>
        <h1>Hola <span class="fw-bolder"><?php echo $_SESSION['nickname'] ?></span>, Bienvenido a la pagina de inicio!</h1>
        <p>Seras redirigido en <span id="counter" class="fw-bolder"></span> segundos a <span class="fw-bolder">Lista del almacén</span></p>

        <meta http-equiv="refresh" content="5; URL=./warehouse_list.php" />
      <?php
      break;
    case "3":
    case "4":
      ?>
        <h1>Hola <span class="fw-bolder"><?php echo $_SESSION['nickname'] ?></span>, Bienvenido a la pagina de inicio!</h1>
        <p>Seras redirigido en <span id="counter" class="fw-bolder"></span> segundos a <span class="fw-bolder">Lista de Equipos</span></p>

        <meta http-equiv="refresh" content="5; URL=./equipment_list.php" />
      <?php
      break;
    default:
      header("Location: ./login.php");
  }
  ?>

<script>
  const allNavbarLink = document.querySelectorAll('.nav-link');
  allNavbarLink.forEach((navLink) => {
    navLink.classList.remove('active');
  });
</script>

<?php
  include_once('./includes/footer.php');
?>