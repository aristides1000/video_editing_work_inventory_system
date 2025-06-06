<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Registro de usuarios</title>
<?php
  include_once('./includes/navbar.php');

  switch ($_SESSION['user_type_id']) {
    case "1":
      ?>
        <h1 class="mx-3">Registro de Nuevos Usuarios</h1>

        <form class="mx-3" action="user_registration_logic.php" method="post">
          <div class="mb-3">
            <label for="nickname" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="nickname" aria-describedby="nicknameHelp">
            <div id="emailHelp" class="form-text">Por favor, escriba su nombre de usuario sin caracteres de espacio</div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password">
          </div>
          <div class="mb-3">
            <label for="user_type_id" class="form-label">tipo de </label>
            <select class="form-select" aria-label="Tipo de usuario" id="user_type_id">
              <option selected>Seleccione el Tipo de Usuario</option>
              <option value="1">Super Usuario</option>
              <option value="2">Administrador</option>
              <option value="3">Verificador</option>
              <option value="4">Responsable</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      <?php
      break;
    case "2":
      ?>
        <h1>No deberias estar aqui</h1>
        <p>No tienes permisos para estar en esta vista, seras redirigido en <span id="contador" class="fw-bolder"></span> segundos a <span class="fw-bolder">Lista de Equipos</span></p>

        <meta http-equiv="refresh" content="5; URL=./equipment_list.php" />
      <?php
      break;
    case "3":
    case "4":
      ?>
        <h1>No deberias estar aqui</h1>
        <p>No tienes permisos para estar en esta vista, seras redirigido en <span id="contador" class="fw-bolder"></span> segundos a <span class="fw-bolder">Retiro de Equipos</span></p>

        <meta http-equiv="refresh" content="5; URL=./equipment_removal.php" />
      <?php
      break;
    default:
      ?>
        <h1>No has iniciado sesion</h1>
        <p>Por favor inicia sesion, seras redirigido en <span id="contador" class="fw-bolder"></span> segundos a <span class="fw-bolder">Inicio de Sesion</span></p>

        <meta http-equiv="refresh" content="5; URL=./login.php" />
      <?php
  }
  ?>
<?php
  include_once('./includes/footer.php');
?>