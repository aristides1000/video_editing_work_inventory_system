<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Vista del Equipo</title>
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
              <h1>Vista del Equipo</h1>
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
                CONVERT_TZ(eq1.last_verification, '+00:00', '-04:00') AS last_verification_equipment,
                eq1.is_deleted,
                wa.in_the_warehouse,
                CONVERT_TZ(wa.date, '+00:00', '-04:00') AS warehouse_changeover_date,
                ta.name AS type_of_activity,
                wa.activity,
                us1.nickname AS responsible,
                us2.nickname AS verified_by
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
        ?>
          <div class="container-fluid mt-3">
            <?php
              while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            ?>
              <div class="row">
                <div class="col-sm-4 col-12">
                  <img
                    src="./equipment_image/<?php echo $row['image_path'] ?>"
                    class="rounded mx-auto d-block resize-image-individual"
                    alt="equipo-numero-<?php echo $row['id'] ?>"
                  >
                </div>
                <div class="col-sm-8 col-12">
                  <p>Numero del Equipo: <?php echo $row['id_equipment'] ?></p>
                  <p>Categoria del Equipo: <?php echo $row['equipment_category'] ?></p>
                  <p>Tipo de Equipo: <?php echo $row['equipment_type'] ?><p>
                  <p>Estatus del Equipo: <?php echo $row['equipment_status'] ?></p>
                  <p>Última verificación de existencia en almacén: <?php echo $row['last_verification_equipment'] ?></p>
                  <p>El equipo está elimininado?: <?php echo ($row['is_deleted']) ? "Si" : "No" ?></p>
                </div>
              </div>
              <?php
                $sql_table = "SELECT
                                wa.id,
                                wa.in_the_warehouse,
                                CONVERT_TZ(wa.date, '+00:00', '-04:00') AS warehouse_changeover_date,
                                ta.name AS type_of_activity,
                                wa.activity,
                                us1.nickname AS responsible,
                                us2.nickname AS verified_by,
                                wa.is_deleted
                              FROM warehouses wa
                              INNER JOIN
                                types_of_activities ta ON wa.type_of_activity_id = ta.id
                              INNER JOIN
                                users us1 ON wa.responsible_id = us1.id
                              INNER JOIN
                                users us2 ON wa.verified_by_id = us2.id
                              WHERE equipment_id = " . $_GET['id_equipment'] . "
                              ORDER BY warehouse_changeover_date DESC;";
                $query_table = mysqli_query($link, $sql_table);
                $num = mysqli_num_rows($query_table);
                if ($num === 0){
                  ?>
                    <div class="container-fluid mt-3">
                      <div class="row">
                        <div class="col">
                          <h1>Equipo no posee movimientos</h1>
                          <p>El equipo que intentas consultar no posee movimientos, seras redirigido en <span id="counter" class="fw-bolder"></span> segundos al <span class="fw-bolder">Inicio</span></p>

                          <meta http-equiv="refresh" content="5; URL=./index.php" />
                        </div>
                      </div>
                    </div>
                  <?php
                }
              ?>
              <div class="container-fluid text-center mt-3">
                <div class="row text-center mt-3">
                  <div class="col">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col"># Registro</th></th>
                          <th scope="col">En Almacen?</th>
                          <th scope="col">Fecha de almacen o retiro</th>
                          <th scope="col">Tipo de Actividad</th>
                          <th scope="col">Actividad</th>
                          <th scope="col">Responsable</th>
                          <th scope="col">Verificado por</th>
                          <th scope="col">Registro eliminado</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          while($row = mysqli_fetch_array($query_table, MYSQLI_ASSOC)) {
                            ?>
                              <tr
                                <?php echo ($row['in_the_warehouse']) ? '' : 'class="table-danger"' ?>
                              >
                                <th scope="row"><?php echo $row['id'] ?></th>
                                <td><?php echo ($row['in_the_warehouse']) ? "Si" : "No" ?></td>
                                <td><?php echo $row['warehouse_changeover_date'] ?></td>
                                <td><?php echo $row['type_of_activity'] ?></td>
                                <td><?php echo $row['activity'] ?></td>
                                <td><?php echo $row['responsible'] ?></td>
                                <td><?php echo $row['verified_by'] ?></td>
                                <td><?php echo ($row['is_deleted']) ? "Si" : "No" ?></td>
                              </tr>
                            <?php
                          }
                        ?>
                  </div>
                </div>
              </div>
            <?php
              }
            ?>
          </div>
        <?php
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