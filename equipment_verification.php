<?php
  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');

  if(isset($_GET['id_equipment'])) { # llego el id del equipo a almacenar
    $sql_warehouses = "UPDATE equipments
                        SET last_verification = CURRENT_TIMESTAMP()
                        WHERE id = " . $_GET['id_equipment'] . ";";
    mysqli_query($link, $sql_warehouses);

    if (mysqli_error($link)) {
      ?>
        <div class="modal fade" id="equipmentUpdateError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al Verificar Equipo</h1>
                <a href="./view_equipment.php?id_equipment=<?php echo $_GET['id_equipment'] ?>" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Error al verificar equipo. Por Favor intente de nuevo.
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Verificación Exitosa</h1>
                <a href="./view_equipment.php?id=<?php echo $_GET['id_equipment'] ?>" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Equipo verificado exitosamente.
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
