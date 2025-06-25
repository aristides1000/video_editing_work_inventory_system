<?php
  session_start();
  include 'conexion.php';
  include_once('./includes/header.php');
  include_once('./includes/navbar.php');

  if(isset($_POST['nickname']) && $_POST['nickname']!='' && isset($_POST['password']) && $_POST['password']!='') {
    #llegaron los datos
    $sql = "SELECT * FROM users WHERE nickname='$_POST[nickname]'";
    $query = mysqli_query($link, $sql);
    $num = mysqli_num_rows($query);
    $row = mysqli_fetch_array($query); # descargo en el arreglo $row la primera fila
    if ($num == 0 || $row['password'] != md5($_POST['password'])) {
      ?>
        <div class="modal fade" id="incorrectData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Datos Incorrectos</h1>
                <a href="./login.php" class="ms-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </a>
              </div>
              <div class="modal-body">
                Algunos de los datos introducidos son incorrectos, por favor verifique y vuelva a intentarlo.
              </div>
              <div class="modal-footer">
                <a href="./login.php">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script>
          const incorrectData = new bootstrap.Modal(document.getElementById('incorrectData'));
          incorrectData.show();
        </script>
      <?php
    } else {
      # Autentificacion (Creamos variables de sesión con los datos del usuario)
      $_SESSION['id'] = $row['id'];
      $_SESSION['nickname'] = $row['nickname'];
      $_SESSION['user_type_id'] = $row['user_type_id'];
      ?>
        <meta http-equiv="refresh" content="0; URL=./index.php" />
      <?php
    }
  } else {
    ?>
      <div class="modal fade" id="missingData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Faltan Datos</h1>
              <a href="./login.php" class="ms-auto">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </a>
            </div>
            <div class="modal-body">
              Por favor ingrese toda la informacion solicitada
            </div>
            <div class="modal-footer">
              <a href="./login.php">
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
