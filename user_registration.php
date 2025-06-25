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
    case "2":
      $sql = "SELECT * FROM types_of_user";
      $query = mysqli_query($link, $sql);
      $num = mysqli_num_rows($query);
      if ($num==0) {
        ?>
        <div class="modal fade" id="typesOfUsersWithoutGenerating" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al Cargar Tipos de Usuarios</h1>
                <a href="./user_registration.php" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                No Existen Tipos de Usuarios en el Sistema, pongase en contacto con el programador.
              </div>
              <div class="modal-footer">
                <a href="./user_registration.php">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script>
          const typesOfUsersWithoutGenerating = new bootstrap.Modal(document.getElementById('typesOfUsersWithoutGenerating'));
          typesOfUsersWithoutGenerating.show();
        </script>
      <?php
      } else {
        ?>
          <h1 class="mx-3">Registro de Nuevos Usuarios</h1>

          <form class="mx-3" action="user_registration_logic.php" method="post">
            <div class="mb-3">
              <label for="nickname" class="form-label">Nombre de usuario</label>
              <input type="text" class="form-control" id="nickname" aria-describedby="nicknameHelp" name="nickname">
              <div id="emailHelp" class="form-text">Por favor, escriba su nombre de usuario sin caracteres de espacio</div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
              <label for="user_type_id" class="form-label">Tipo de usuario</label>
              <select class="form-select" aria-label="Tipo de usuario" id="user_type_id" name="user_type_id">
                <option selected>Seleccione el Tipo de Usuario</option>
                <?php
                  while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    if ($_SESSION['user_type_id'] == 2 && $row['id'] == 1) {
                      continue;
                    }
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                  }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        <?php
        break;
      }
    case "3":
    case "4":
      ?>
        <h1>No deberias estar aqui</h1>
        <p>No tienes permisos para estar en esta vista, seras redirigido en <span id="counter" class="fw-bolder"></span> segundos a <span class="fw-bolder">Retiro de Equipos</span></p>

        <meta http-equiv="refresh" content="5; URL=./equipment_removal.php" />
      <?php
      break;
    default:
      ?>
        <h1>No has iniciado sesion</h1>
        <p>Por favor inicia sesion, seras redirigido en <span id="counter" class="fw-bolder"></span> segundos a <span class="fw-bolder">Inicio de Sesion</span></p>

        <meta http-equiv="refresh" content="5; URL=./login.php" />
      <?php
  }
  ?>

<script>
  const allNavbarLink = document.querySelectorAll('.nav-link');
  allNavbarLink.forEach((navLink) => {
    if (navLink.textContent === 'Registro de usuarios') {
      navLink.classList.add('active');
    } else {
      navLink.classList.remove('active');
    }
  });
</script>
<?php
  include_once('./includes/footer.php');
?>