<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Registro de Equipos</title>
<?php
  include_once('./includes/navbar.php');

  switch ($_SESSION['user_type_id']) {
    case "1":
    case "2":
      $sql_equipment_categories = "SELECT * FROM equipment_categories";
      $query_equipment_categories = mysqli_query($link, $sql_equipment_categories);
      $num_equipment_categories = mysqli_num_rows($query_equipment_categories);

      $sql_equipment_types = "SELECT * FROM equipment_types";
      $query_equipment_types = mysqli_query($link, $sql_equipment_types);
      $num_equipment_types = mysqli_num_rows($query_equipment_types);

      $sql_equipments_status = "SELECT * FROM equipments_status";
      $query_equipments_status = mysqli_query($link, $sql_equipments_status);
      $num_equipments_status = mysqli_num_rows($query_equipments_status);
      if ($num_equipment_categories === 0 ||
          $num_equipment_types === 0 ||
          $num_equipments_status === 0) {
        ?>
        <div class="modal fade" id="dataWithoutGenerating" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al Cargar los de seleccionables</h1>
                <a href="./user_registration.php" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                No existen Categorias de los equipos, los tipos de equipos o el estatus de los equipos en el Sistema, pongase en contacto con el programador.
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
          const dataWithoutGenerating = new bootstrap.Modal(document.getElementById('dataWithoutGenerating'));
          dataWithoutGenerating.show();
        </script>
        <?php
      } else {
        ?>
          <h1 class="mx-3">Registro de Nuevos Equipos</h1>

          <form class="mx-3" action="equipment_registration_logic.php" method="post"  enctype="multipart/form-data">
            <div class="mb-3">
              <label for="equipment_category_id" class="form-label">Categoría del equipo</label>
              <select class="form-select" aria-label="Categoría del equipo" id="equipment_category_id" name="equipment_category_id">
                <option selected>Seleccione la categoría del equipo</option>
                <?php
                  while($row = mysqli_fetch_array($query_equipment_categories, MYSQLI_ASSOC)) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="type_of_equipment_id" class="form-label">Tipo de equipo</label>
              <select class="form-select" aria-label="Tipo de equipo" id="type_of_equipment_id" name="type_of_equipment_id">
                <option selected>Seleccione el tipo de equipo</option>
                <?php
                  while($row = mysqli_fetch_array($query_equipment_types, MYSQLI_ASSOC)) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="equipment_status_id" class="form-label">Estatus del equipo</label>
              <select class="form-select" aria-label="Estatus del equipo" id="equipment_status_id" name="equipment_status_id">
                <option selected>Seleccione el estatus del equipo</option>
                <?php
                  while($row = mysqli_fetch_array($query_equipments_status, MYSQLI_ASSOC)) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="image_path" class="form-label">Cargue la imagen</label>
              <input class="form-control" type="file" id="image_path" name="image_path">
              <div id="imageHelp" class="form-text">Por favor, suba solo archivos de imagenes con extenciones .jpg .png o .gif</div>
            </div>
            <a type="button" class="btn btn-secondary" href="">Cancelar</a>
            <button type="submit" class="btn btn-primary">Registrar Equipo</button>
          </form>
        <?php
        break;
      }
    case "3":
    case "4":
      ?>
        <h1>No deberias estar aqui</h1>
        <p>No tienes permisos para estar en esta vista, seras redirigido en <span id="counter" class="fw-bolder"></span> segundos a <span class="fw-bolder">Lista de Equipos</span></p>

        <meta http-equiv="refresh" content="5; URL=./equipment_list.php" />
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
    if (navLink.textContent === 'Registro de equipos') {
      navLink.classList.add('active');
    } else {
      navLink.classList.remove('active');
    }
  });
</script>
<?php
  include_once('./includes/footer.php');
?>