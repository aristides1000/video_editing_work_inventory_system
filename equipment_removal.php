<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Retirar Equipo</title>
<?php
  include_once('./includes/navbar.php');
  switch ($_SESSION['user_type_id']) {
    case "1":
    case "2":
    case "3":
    case "4":
      ?>
        <div class="container-fluid text-center mt-3">
          <div class="row">
            <div class="col">
              <h1>Retirar Equipo</h1>
            </div>
          </div>
        </div>
      <?php
      if (isset($_GET['id_equipment'])) {
      $sql = "SELECT
                eq1.id AS id_equipment,
                wa.id AS warehouse_id,
                ec.name AS equipment_category,
                et.name AS equipment_type,
                es.name AS equipment_status,
                eq1.image_path,
                eq1.qr_equipment_image,
                eq1.is_deleted AS equipment_is_deleted,
                wa.in_the_warehouse,
                CONVERT_TZ(wa.date, '+00:00', '-04:00') AS warehouse_changeover_date,
                ta.name AS type_of_activity,
                wa.activity,
                us1.nickname AS responsible,
                us2.nickname AS verified_by,
                wa.is_deleted AS warehouse_is_deleted
              FROM
                equipments eq1
              INNER JOIN
                warehouses wa ON wa.equipment_id = eq1.id
              LEFT JOIN
                warehouses wa2 ON wa.equipment_id = wa2.equipment_id
                AND wa.date < wa2.date
                AND wa2.is_deleted = 0
              INNER JOIN
                equipment_categories ec ON eq1.equipment_category_id = ec.id
              INNER JOIN
                equipment_types et ON eq1.type_of_equipment_id = et.id
              INNER JOIN
                equipments_status es ON eq1.equipment_status_id = es.id
              INNER JOIN
                types_of_activities ta ON wa.type_of_activity_id = ta.id
              INNER JOIN
                users us1 ON wa.responsible_id = us1.id
              INNER JOIN
                users us2 ON wa.verified_by_id = us2.id
              WHERE
                eq1.id = " . $_GET['id_equipment'] . "
                AND wa2.id IS NULL
              ORDER BY
                wa.in_the_warehouse,
                wa.date DESC;";
      $query = mysqli_query($link, $sql);
      $num = mysqli_num_rows($query);
        if ($num === 0){
          ?>
            <div class="container-fluid mt-3">
              <div class="row">
                <div class="col">
                  <h1>Equipo no registrado</h1>
                  <p>El equipo que intentas consultar no se encuentra registrado, seras redirigido en <span id="counter" class="fw-bolder"></span> segundos al <span class="fw-bolder">Inicio</span></p>

                  <meta http-equiv="refresh" content="5; URL=./index.php" />
                </div>
              </div>
            </div>
          <?php
        }
        $sql_equipment_categories = "SELECT * FROM equipment_categories;";
        $query_equipment_categories = mysqli_query($link, $sql_equipment_categories);
        $num_equipment_categories = mysqli_num_rows($query_equipment_categories);

        $sql_equipment_types = "SELECT * FROM equipment_types;";
        $query_equipment_types = mysqli_query($link, $sql_equipment_types);
        $num_equipment_types = mysqli_num_rows($query_equipment_types);

        $sql_equipments_status = "SELECT * FROM equipments_status;";
        $query_equipments_status = mysqli_query($link, $sql_equipments_status);
        $num_equipments_status = mysqli_num_rows($query_equipments_status);

        $sql_types_of_activities = "SELECT * FROM types_of_activities;";
        $query_types_of_activities = mysqli_query($link, $sql_types_of_activities);
        $num_types_of_activities = mysqli_num_rows($query_types_of_activities);

        $sql_user_responsible = "SELECT * FROM users;";
        $query_user_responsible = mysqli_query($link, $sql_user_responsible);
        $num_user_responsible = mysqli_num_rows($query_user_responsible);

        $sql_user_verifier = "SELECT * FROM users WHERE user_type_id < 3;";
        $query_user_verifier = mysqli_query($link, $sql_user_verifier);
        $num_user_verifier = mysqli_num_rows($query_user_verifier);
        if ($num_equipment_categories === 0 ||
          $num_equipment_types === 0 ||
          $num_equipments_status === 0 ||
          $num_types_of_activities === 0 ||
          $num_user_responsible === 0 ||
          $num_user_verifier === 0) {
          ?>
            <div class="modal fade" id="dataWithoutGenerating" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al cargar los datos de campos seleccionables</h1>
                    <a href="./user_registration.php" class="ms-auto">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </a>
                  </div>
                  <div class="modal-body">
                    No existen Categorias de los equipos, los tipos de equipos, el estatus de los equipos en el Sistema o los tipos de actividades, pongase en contacto con el programador.
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
            <div class="container-fluid mt-3">
              <?php
                while($row_general = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
              ?>
                <div class="row">
                  <div class="col-sm-4 col-12">
                    <img
                      src="./equipment_image/<?php echo $row_general['image_path'] ?>"
                      class="rounded mx-auto d-block resize-image-individual"
                      alt="equipo-numero-<?php echo $row_general['id'] ?>"
                    >
                  </div>
                  <div class="col-sm-8 col-12">
                    <form class="mx-3" action="equipment_removal_logic.php" method="post"  enctype="multipart/form-data">
                      <p>Numero del Equipo: <?php echo $row_general['id_equipment'] ?></p>
                      <input type="hidden" id="id_equipment" name="id_equipment" value="<?php echo $row_general['id_equipment'] ?>">
                      <p>Categoria del Equipo: <?php echo $row_general['equipment_category'] ?></p>
                      <p>Tipo de Equipo: <?php echo $row_general['equipment_type'] ?><p>
                      <p>Estatus del Equipo: <?php echo $row_general['equipment_status'] ?></p>
                      <p>El equipo está elimininado?: <?php echo ($row_general['equipment_is_deleted']) ? "Si" : "No" ?></p>
                      <input type="hidden" id="warehouse_id" name="warehouse_id" value="<?php echo $row_general['warehouse_id'] ?>">
                      <p>Se encuentra en el Almacen: <?php echo ($row_general['in_the_warehouse']) ? "Si" : "No" ?></p>
                      <p>Fecha de ultimo cambio en Almacen: <?php echo $row_general['warehouse_changeover_date'] ?></p>
                      <div class="mb-3">
                        <label for="type_of_activity_id" class="form-label">Tipo de Actividad</label>
                        <select class="form-select" aria-label="Tipo de Actividad" id="type_of_activity_id" name="type_of_activity_id">
                          <?php
                            while($row = mysqli_fetch_array($query_types_of_activities, MYSQLI_ASSOC)) {
                              $selected = ($row['name'] === $row_general['type_of_activity']) ? 'selected' : '';
                              if ($row['name'] === 'en almacen') {
                                continue;
                              }
                              echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="activity" class="form-label">Actividad</label>
                        <input type="text" class="form-control" id="activity" name="activity">
                      </div>
                      <div class="mb-3">
                        <label for="verified_by_id" class="form-label">Verificado por</label>
                        <select class="form-select" aria-label="Responsable" id="verified_by_id" name="verified_by_id">
                          <?php
                            while($row = mysqli_fetch_array($query_user_verifier, MYSQLI_ASSOC)) {
                              $selected = ($row['nickname'] === $row_general['responsible']) ? 'selected' : '';
                              echo "<option value='{$row['id']}' $selected>{$row['nickname']}</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="row text-center mt-3 mb-5">
                        <div class="col">
                          <a type="button" class="btn btn-secondary me-5" href="./view_equipment.php?id=<?php echo $_GET['id_equipment'] ?>">Cancelar</a>
                          <button type="submit" class="btn btn-primary">Retirar Equipo</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              <?php
                }
              ?>
            </div>
          <?php
        }
      } else {
        ?>
          <div class="container-fluid mt-3">
            <div class="row">
              <div class="col">
                <h1>No has seleccionado equipo</h1>
                <p>Seras redirigido en <span id="counter" class="fw-bolder"></span> segundos al <span class="fw-bolder">Inicio</span></p>

                <meta http-equiv="refresh" content="5; URL=./index.php" />
              </div>
            </div>
          </div>
        <?php
      }
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
    navLink.classList.remove('active');
  });
</script>

<?php
  include_once('./includes/footer.php');
?>