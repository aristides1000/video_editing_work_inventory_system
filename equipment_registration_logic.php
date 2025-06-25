<?php
  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');

  if(isset($_POST['equipment_category_id']) && $_POST['equipment_category_id']!='' && isset($_POST['type_of_equipment_id']) && $_POST['type_of_equipment_id']!='' && isset($_POST['equipment_status_id']) && $_POST['equipment_status_id']!='' && isset($_FILES['image_path']['name']) && $_FILES['image_path']['name']!='') {
    #llegaron los datos
    $temporal = $_FILES['image_path']['tmp_name'];
    $arch = $_FILES['image_path']['name'];
    $tipo = getimagesize($temporal);

    #El índice 2 del arreglo que genera getimagesize es una bandera que indica el tipo de imagen: 1 = GIF, 2 = JPG, 3 = PNG
    if($tipo[2] != 1 && $tipo[2] != 2 && $tipo[2] != 3) {
      ?>
        <div class="modal fade" id="fileTypeError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Error por tipo de archivo</h1>
                <a href="./equipment_registration.php" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Error por tipo de archivo cargado, el archivo debe ser extension: .jpg .png o .gif
              </div>
              <div class="modal-footer">
                <a href="./equipment_registration.php">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script>
          const fileTypeError = new bootstrap.Modal(document.getElementById('fileTypeError'));
          fileTypeError.show();
        </script>
      <?php
    } else { # el tipo de archivo es correcto se efectua la carga del producto
      if ($tipo !== false) { # Si la foto ha sido cargada
        /* Llegue hasta aqui 25jun25 */
        $sql = "INSERT INTO users (nickname, password, user_type_id)
                VALUES ('$_POST[nickname]', '".md5($_POST['password'])."', '$_POST[user_type_id]');";

        mysqli_query($link, $sql);
        if (mysqli_error($link)) {
          ?>
            <div class="modal fade" id="userRegistrationError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Error al Registrar</h1>
                    <a href="./user_registration.php" class="ms-auto">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </a>
                  </div>
                  <div class="modal-body">
                    Error en el registro de usuario. Por Favor intente de nuevo.
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
              const userRegistrationError = new bootstrap.Modal(document.getElementById('userRegistrationError'));
              userRegistrationError.show();
            </script>
          <?php
        } else {
          ?>
            <div class="modal fade" id="successfulUserRegistration" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro Exitoso</h1>
                    <a href="./user_registration.php" class="ms-auto">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </a>
                  </div>
                  <div class="modal-body">
                    Usuario registrado exitosamente.
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
              const successfulUserRegistration = new bootstrap.Modal(document.getElementById('successfulUserRegistration'));
              successfulUserRegistration.show();
            </script>
          <?php
        }
      } else { # La foto NO ha sido cargada
        ?>
          <script> alert("Error en la carga de la foto. Intente de nuevo"); </script>
          <meta http-equiv="refresh" content="2;URL=./producto.php" />
        <?php

        /* Modificar hasta lo interno de este else */
      }
    }
  } else {
    ?>
      <div class="modal fade" id="missingData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Faltan Datos</h1>
              <a href="./equipment_registration.php" class="ms-auto">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </a>
            </div>
            <div class="modal-body">
              Por favor ingrese toda la informacion solicitada
            </div>
            <div class="modal-footer">
              <a href="./equipment_registration.php">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </a>
            </div>
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
      <script>
        const missingData = new bootstrap.Modal(document.getElementById('missingData'));
        missingData.show();
      </script>
    <?php
  }

  include_once('./includes/footer.php');
?>
