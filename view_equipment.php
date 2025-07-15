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
      if (isset($_GET['id'])) {
      $sql = "SELECT
                eq1.id AS id_equipment,
                wa.id AS warehouse_id,
      			    ec.name AS equipment_category,
                et.name AS equipment_type,
                es.name AS equipment_status,
                eq1.image_path,
                eq1.qr_equipment_image,
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
                eq1.id = " . $_GET['id'] . "
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
                  <p>Se encuentra en el Almacen: <?php echo ($row['in_the_warehouse']) ? "Si" : "No" ?></p>
                  <p>Fecha de ultimo cambio en Almacen: <?php echo $row['warehouse_changeover_date'] ?></p>
                  <p>Tipo de Actividad: <?php echo $row['type_of_activity'] ?></p>
                  <p>Actividad: <?php echo $row['activity'] ?></p>
                  <p>Responsable: <?php echo $row['responsible'] ?></p>
                  <p>Verificado por: <?php echo $row['verified_by'] ?></p>
                  <p>Está Elimininado?: <?php echo ($row['is_deleted']) ? "Si" : "No" ?></p>
                </div>
              </div>
              <div class="row text-center mt-3">
                <div class="col">
                  <?php
                  if ($row['in_the_warehouse']) {
                    ?>
                      <!-- Button modify equipment trigger modal -->
                      <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#removalEquipmentModal">
                        Retirar Equipo
                      </button>

                      <!-- Modal modify equipment -->
                      <div class="modal fade" id="removalEquipmentModal" tabindex="-1" aria-labelledby="removalEquipmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="removalEquipmentModalLabel">Retirar Equipo</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              ¿Está seguro que desea retirar éste equipo?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <a href="equipment_removal.php?id_equipment=<?php echo $row['id_equipment']?>" class="btn btn-primary mx-3">
                                Retirar Equipo
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php
                  } else {
                    ?>
                      <!-- <a href="equipment_storage.php?id=<?php echo $row['id_equipment']?>" class="btn btn-success mx-3">
                        Devolucion de Equipo
                      </a> -->

                      <!-- Button modify equipment trigger modal -->
                      <button type="button" class="btn btn-success mx-3" data-bs-toggle="modal" data-bs-target="#storageEquipmentModal">
                        Devolver Equipo
                      </button>

                      <!-- Modal modify equipment -->
                      <div class="modal fade" id="storageEquipmentModal" tabindex="-1" aria-labelledby="storageEquipmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="storageEquipmentModalLabel">Devolver Equipo</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              ¿Está seguro que desea Devolver éste equipo?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <a href="equipment_storage.php?id_equipment=<?php echo $row['id_equipment']?>" class="btn btn-success mx-3">
                                Devolver Equipo
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php
                  }
                  ?>
                  <?php
                    if ($_SESSION['user_type_id'] === "1" || $_SESSION['user_type_id'] === "2") {
                  ?>
                    <!-- Button modify equipment trigger modal -->
                    <button type="button" class="btn btn-warning mx-3" data-bs-toggle="modal" data-bs-target="#updateEquipmentModal">
                      Modificar Equipo
                    </button>

                    <!-- Modal modify equipment -->
                    <div class="modal fade" id="updateEquipmentModal" tabindex="-1" aria-labelledby="updateEquipmentModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="updateEquipmentModalLabel">Modificar Equipo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            ¿Está seguro que desea modificar éste equipo?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="update_equipment_warehouse.php?id_equipment=<?php echo $row['id_equipment']?>" class="btn btn-warning mx-3">
                              Modificar Equipo
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Button delete equipment trigger modal -->
                    <button type="button" class="btn btn-danger mx-3" data-bs-toggle="modal" data-bs-target="#deleteEquipmentModal">
                      Eliminar Equipo
                    </button>

                    <!-- Modal delete equipment -->
                    <div class="modal fade" id="deleteEquipmentModal" tabindex="-1" aria-labelledby="deleteEquipmentModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteEquipmentModalLabel">Eliminar Equipo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            ¿Está seguro que desea eliminar éste equipo?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="delete_equipment_warehouse.php?id_equipment=<?php echo $row['id_equipment']?>" class="btn btn-danger mx-3">
                              Eliminar Equipo
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <a href="equipment_movements.php?id_equipment=<?php echo $row['id_equipment']?>" class="btn btn-info mx-3">
                      Movimientos del Equipo
                    </a>
                  <?php
                    }
                  ?>
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