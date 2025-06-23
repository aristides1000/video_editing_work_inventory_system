<?php
  session_start();
  include_once('./conexion.php');
?>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.php">Sistema de Inventarios de equipos</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav w-100">
          <?php
            switch ($_SESSION['user_type_id']) {
              case "1":
              case "2":
                ?>
                  <a class="nav-link active" aria-current="page" href="./equipment_list.php">Listado de equipos</a>
                  <a class="nav-link" href="./warehouse_list.php">Lista del almacén</a>
                  <a class="nav-link" href="./user_registration.php">Registro de usuarios</a>
                  <a class="nav-link" href="./equipment_registration.php">Registro de Equipos</a>
                  <span class="ms-auto"></span>
                  <a class="nav-link" href="./logout.php">Cerrar sesión</a>
                <?php
                break;
              case "3":
              case "4":
                ?>
                  <a class="nav-link active" aria-current="page" href="./equipment_list.php">Listado de equipos</a>
                  <span class="ms-auto"></span>
                  <a class="nav-link" href="./logout.php">Cerrar sesión</a>
                <?php
                break;
              default:
                ?>
                  <span class="ms-auto"></span>
                  <a class="nav-link" href="./login.php">Iniciar sesión</a>
                <?php
            }
          ?>
        </div>
      </div>
    </div>
  </nav>