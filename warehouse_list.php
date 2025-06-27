<?php
  session_start();
  include_once('./conexion.php');
  include_once('./includes/header.php');
?>
  <title>Lista del Almacen</title>
<?php
  include_once('./includes/navbar.php');
  switch ($_SESSION['user_type_id']) {
    case "1":
    case "2":
      ?>
        <div class="container-fluid text-center mt-3">
          <div class="row">
            <div class="col">
              <h1>Lista del Almacen</h1>
            </div>
          </div>
        </div>
      <?php
      $sql = "SELECT
                DISTINCT eq1.id AS id_equipment,
                wa.id,
      			    ec.name AS equipment_category,
                et.name AS equipment_type,
                es.name AS equipment_status,
                eq1.image_path,
                eq1.qr_equipment_image,
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
              ORDER BY wa.in_the_warehouse, wa.date DESC;";
      $query = mysqli_query($link, $sql);
      $num = mysqli_num_rows($query);
      if ($num==0) {
        ?>
          <div class="container-fluid mt-3">
            <div class="row">
              <div class="col">
                <h2>No hay equipos en el almacen cargados</h2>
                <p>por favor comuniquese con el administrador para cargar los equipos en el almacen</p>
              </div>
            </div>
          </div>
        <?php
      } else {
        ?>
          <div class="container-fluid text-center mt-3">
            <div class="row">
              <div class="col">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col"># Equipo</th></th>
                      <th scope="col">Categoria del Equipo</th>
                      <th scope="col">Tipo de Equipo</th>
                      <th scope="col">Estatus del Equipo</th>
                      <th scope="col">Imagen del Equipo</th>
                      <th scope="col">Qr del Equipo</th>
                      <th scope="col">En Almacen?</th>
                      <th scope="col">Fecha de almacen o retiro</th>
                      <th scope="col">Tipo de Actividad</th>
                      <th scope="col">Actividad</th>
                      <th scope="col">Responsable</th>
                      <th scope="col">Verificado por</th>
                      <th scope="col">Ver Equipo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                        ?>
                          <tr
                            <?php echo ($row['in_the_warehouse']) ? '' : 'class="table-danger"' ?>
                          >
                            <th scope="row"><?php echo $row['id_equipment'] ?></th>
                            <td><?php echo $row['equipment_category'] ?></td>
                            <td><?php echo $row['equipment_type'] ?></td>
                            <td><?php echo $row['equipment_status'] ?></td>
                            <td>
                              <img
                                src="./equipment_image/<?php echo $row['image_path'] ?>"
                                class="rounded mx-auto d-block resize-image-list"
                                alt="equipo-numero-<?php echo $row['id'] ?>"
                              >
                            </td>
                            <td>
                              <img
                                src="./qr_equipment_image/<?php echo $row['qr_equipment_image'] ?>"
                                class="rounded mx-auto d-block resize-image-list"
                                alt="equipo-numero-<?php echo $row['id'] ?>"
                              >
                            </td>
                            <td><?php echo ($row['in_the_warehouse']) ? "Si" : "No" ?></td>
                            <td><?php echo $row['warehouse_changeover_date'] ?></td>
                            <td><?php echo $row['type_of_activity'] ?></td>
                            <td><?php echo $row['activity'] ?></td>
                            <td><?php echo $row['responsible'] ?></td>
                            <td><?php echo $row['verified_by'] ?></td>
                            <td>
                              <a href="view_equipment.php?id=<?php echo $row['id']?>" class="btn btn-primary">
                                Ver
                              </a>
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
    case "3":
    case "4":
      ?>
        <h1>No deberias estar aqui</h1>
        <p>No tienes permisos para estar en esta vista, seras redirigido en <span id="counter" class="fw-bolder"></span> segundos a <span class="fw-bolder">Retiro de Equipos</span></p>

        <meta http-equiv="refresh" content="5; URL=./equipment_removal.php" />
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
    if (navLink.textContent === 'Lista del almacén') {
      navLink.classList.add('active');
    } else {
      navLink.classList.remove('active');
    }
  });
</script>
<?php
  include_once('./includes/footer.php');
?>