<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Eliminar Equipo</title>
<?php
  include_once('./includes/navbar.php');
  switch ($_SESSION['user_type_id']) {
    case "1":
    case "2":
      if (isset($_GET['id_equipment'])) {
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
                warehouses wa
              INNER JOIN
                equipments eq1 ON wa.equipment_id = eq1.id
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
              WHERE eq1.id = " . $_GET['id_equipment'] . "
              ORDER BY wa.in_the_warehouse, wa.date DESC;";
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
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
          $sql_delete_warehouses = "UPDATE warehouses SET is_deleted = 1 WHERE id = ". $row['warehouse_id'].";";
          mysqli_query($link, $sql_delete_warehouses);

          $sql_delete_equipments = "UPDATE equipments SET is_deleted = 1 WHERE id = ". $_GET['id_equipment'] .";";
          mysqli_query($link, $sql_delete_equipments);

          if (mysqli_error($link)) {
            ?>
              <div class="modal fade" id="deleteEquipmentError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al Eliminar</h1>
                      <a href="./view_equipment.php?id=<?php echo $row['id'] ?>" class="ms-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </a>
                    </div>
                    <div class="modal-body">
                      Error al eliminar el equipo. Por Favor intente de nuevo.
                    </div>
                    <div class="modal-footer">
                      <a href="./view_equipment.php?id=<?php echo $row['id'] ?>">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
              <script>
                const deleteEquipmentError = new bootstrap.Modal(document.getElementById('deleteEquipmentError'));
                deleteEquipmentError.show();
              </script>
            <?php
          } else { # Si no da error la eliminacion;
            ?>
              <div class="modal fade" id="successfulEquipmentDeleted" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminacion Existosa</h1>
                      <a href="./equipment_list.php" class="ms-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </a>
                    </div>
                    <div class="modal-body">
                      Equipo eliminado exitosamente.
                    </div>
                    <div class="modal-footer">
                      <a href="./equipment_list.php">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
              <script>
                const successfulEquipmentDeleted = new bootstrap.Modal(document.getElementById('successfulEquipmentDeleted'));
                successfulEquipmentDeleted.show();
              </script>
            <?php
          }
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
    navLink.classList.remove('active');
  });
</script>

<?php
  include_once('./includes/footer.php');
?>