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
    if ($num == 0) {
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
      <?php
    }
  }

  include_once('./includes/footer.php');
?>