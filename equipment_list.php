<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Lista de Equipos</title>
<?php
  include_once('./includes/navbar.php');
  switch ($_SESSION['user_type_id']) {
    case "1":
    case "2":
    case "3":
    case "4":
      ?>
        <div class="container text-center mt-3">
          <div class="row">
            <div class="col">
              <h1>Lista de Equipos</h1>
            </div>
          </div>
        </div>
      <?php
      $sql = "SELECT
                equipments.id,
                equipment_categories.name AS equipment_categorie,
                equipment_types.name AS equipment_type,
                equipments_status.name AS equipment_status,
                equipments.image_path,
                equipments.qr_equipment_image
              FROM
                equipments
              INNER JOIN
                equipment_categories ON equipments.equipment_category_id = equipment_categories.id
              INNER JOIN
                equipment_types ON equipments.type_of_equipment_id = equipment_types.id
              INNER JOIN
                equipments_status ON equipments.equipment_status_id = equipments_status.id
              ORDER BY
              	equipments_status.id DESC;";
      $query = mysqli_query($link, $sql);
      $num = mysqli_num_rows($query);
      if ($num==0) {
        ?>
          <div class="container mt-3">
            <div class="row">
              <div class="col">
                <h2>No hay equipos cargados</h2>
                <p>por favor comuniquese con el administrador para cargar los equipos</p>
              </div>
            </div>
          </div>
        <?php
      } else {
        ?>
          <div class="container text-center mt-3">
            <div class="row">
              <div class="col">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">identificador</th>
                      <th scope="col">Categoria del Equipo</th>
                      <th scope="col">Tipo de Equipo</th>
                      <th scope="col">Estatus del Equipo</th>
                      <th scope="col">Imagen del Equipo</th>
                      <th scope="col">Qr del Equipo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                        ?>
                          <tr
                            <?php echo ($row['equipment_status'] === 'averiado') ? 'class="table-danger"' : '' ?>
                          >
                            <th scope="row"><?php echo $row['id'] ?></th>
                            <td><?php echo $row['equipment_categorie'] ?></td>
                            <td><?php echo $row['equipment_type'] ?></td>
                            <td><?php echo $row['equipment_status'] ?></td>
                            <td>
                              <img
                                src="<?php echo $row['image_path'] ?>"
                                class="rounded mx-auto d-block"
                                alt="equipo-numero-<?php echo $row['id'] ?>"
                              >
                            </td>
                            <td>
                              <img
                                src="<?php echo $row['qr_equipment_image'] ?>"
                                class="rounded mx-auto d-block"
                                alt="equipo-numero-<?php echo $row['id'] ?>"
                              >
                            </td>
                          </tr>
                        <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php
      }
      break;
    default:
      ?>
        <h1>No has iniciado sesion</h1>
        <p>Por favor inicia sesion, seras redirigido en <span id="contador" class="fw-bolder"></span> segundos a <span class="fw-bolder">Inicio de Sesion</span></p>

        <meta http-equiv="refresh" content="5; URL=./login.php" />
      <?php
  }
?>

<script>
  const allNavbarLink = document.querySelectorAll('.nav-link');
  allNavbarLink.forEach((navLink) => {
    if (navLink.textContent === 'Listado de equipos') {
      navLink.classList.add('active');
    } else {
      navLink.classList.remove('active');
    }
  });
</script>

<?php
  include_once('./includes/footer.php');
?>