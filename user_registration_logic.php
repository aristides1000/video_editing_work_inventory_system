<?php
  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');

  if(isset($_POST['nickname']) && $_POST['nickname']!='' && isset($_POST['password']) && $_POST['password']!='' && isset($_POST['user_type_id']) && $_POST['user_type_id']!='') {
    #llegaron los datos
    /* Quede Aqui PENDIENTE */
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
  } else {
    ?>
      <div class="modal fade" id="missingData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Faltan Datos</h1>
              <a href="./user_registration.php" class="ms-auto">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </a>
            </div>
            <div class="modal-body">
              Por favor ingrese toda la informacion solicitada
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
        const missingData = new bootstrap.Modal(document.getElementById('missingData'));
        missingData.show();
      </script>
    <?php
  }

?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>
