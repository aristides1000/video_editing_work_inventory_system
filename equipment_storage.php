<?php
  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');

  if(isset($_GET['id_equipment'])) { # llego el id del equipo a almacenar

    $sql_verified_by_id = "SELECT
                            eq1.id AS id_equipment,
                            wa.id AS warehouse_id,
                            wa.in_the_warehouse,
                            CONVERT_TZ(wa.date, '+00:00', '-04:00') AS warehouse_changeover_date,
                            wa.verified_by_id
                          FROM
                            equipments eq1
                          INNER JOIN
                            warehouses wa ON wa.equipment_id = eq1.id
                          LEFT JOIN
                            warehouses wa2 ON wa.equipment_id = wa2.equipment_id
                            AND wa.date < wa2.date
                            AND wa2.is_deleted = 0
                          WHERE
                            eq1.id = " . $_GET['id'] . "
                            AND wa2.id IS NULL
                          ORDER BY
                            wa.in_the_warehouse,
                            wa.date DESC;";
    $query_verified_by_id = mysqli_query($link, $sql_verified_by_id);
    while($row_verified_by_id = mysqli_fetch_array($query_verified_by_id, MYSQLI_ASSOC)) {
      $sql_warehouses = "INSERT INTO warehouses (equipment_id,
                                                  in_the_warehouse,
                                                  type_of_activity_id,
                                                  activity,
                                                  responsible_id,
                                                  verified_by_id,
                                                  is_deleted)
                          VALUES (" . $_GET['id_equipment'] . ",
                                  1,
                                  3,
                                  'en almacen',
                                  $_SESSION[id],
                                  " . $row_verified_by_id['verified_by_id'] . ",
                                  0)";
    }
    mysqli_query($link, $sql_warehouses);

    if (mysqli_error($link)) {
      ?>
        <div class="modal fade" id="equipmentUpdateError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al Almacenar Equipo</h1>
                <a href="./view_equipment.php?id_equipment=<?php echo $_GET['id_equipment'] ?>" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Error al almacenar equipo. Por Favor intente de nuevo.
              </div>
              <div class="modal-footer">
                <a href="./view_equipment.php?id_equipment=<?php echo $_GET['id_equipment'] ?>">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script>
          const equipmentUpdateError = new bootstrap.Modal(document.getElementById('equipmentUpdateError'));
          equipmentUpdateError.show();
        </script>
      <?php
    } else { # Si no da error la insercion;
      ?>
        <div class="modal fade" id="successfulEquipmentStorage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Alamcenamiento Exitoso</h1>
                <a href="./view_equipment.php?id=<?php echo $_GET['id_equipment'] ?>" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Equipo Almacenado exitosamente.
              </div>
              <div class="modal-footer">
                <a href="./view_equipment.php?id=<?php echo $_GET['id_equipment'] ?>">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script>
          const successfulEquipmentStorage = new bootstrap.Modal(document.getElementById('successfulEquipmentStorage'));
          successfulEquipmentStorage.show();
        </script>
      <?php
      return 0;
    }
  } else { #No se llenaron todos los datos solicitados
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

  include_once('./includes/footer.php');
?>
