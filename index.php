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
      ?> <meta http-equiv="refresh" content="2; URL=./user_registration.php" /> <?php
      break;
    case "2":
      ?> <meta http-equiv="refresh" content="2; URL=./equipment_list.php" /> <?php
      break;
    case "3":
    case "4":
      ?> <meta http-equiv="refresh" content="2; URL=./equipment_list.php" /> <?php
      break;
    default:
      ?> <meta http-equiv="refresh" content="2; URL=./login.php" /> <?php
  }
  ?>
    <h1>Hola <?php echo $_SESSION['nickname'] ?>, Bienvenido al index!</h1>
<?php
  include_once('./includes/footer.php');
?>