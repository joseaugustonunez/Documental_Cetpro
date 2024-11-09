<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tramite Documental</title>
    <link rel="shortcut icon" type="image/png" href="/sistemado/assets/images/logos/seodashlogo.png" />
    <link rel="stylesheet" href="/sistemado/assets/css/styles.min.css" />
    <style>
        /* Ajustar el ancho de la tarjeta */
        .card {
            width: 100%;
            max-width: 800px;
            min-height: 200px;
        }

        /* Asegurar que el contenido sea responsivo */
        .container {
            max-width: 100%;
            padding: 15px;
        }

        /* Contenedor que permite desplazamiento vertical */
        .scrollable-content {
            max-height: 80vh;
            overflow-y: auto;
        }

        .btn-inicio {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 100;
            padding: 10px 20px;
            font-size: 16px;
        }

        /* Media Queries para pantallas más pequeñas */
        @media (max-width: 768px) {
            .card {
                width: 100%;
                margin-top: 0;
            }

            .move-up {
                margin-top: 0;
            }

            .scrollable-content {
                max-height: 60vh;
            }
        }
    </style>
</head>

<body>

    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <a href="../usuario/login.php" class="btn btn-primary btn-inicio">Inicio</a>
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="card mb-0 move-up">
                        <div class="card-body">
                            <h2>Consultar Tramite</h2>
                            <!-- Formulario de búsqueda -->
                            <form class="row g-3" method="POST" action="index.php?controller=tramite&action=buscar">
                                <div class="col-md-6">
                                    <label for="dni" class="form-label">DNI/RUC</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="dni" name="dni" />
                                        <span class="input-group-text">
                                            <iconify-icon icon="mdi:account-card-details-outline"></iconify-icon>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="codigo" class="form-label">Código de Búsqueda</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="codigo" name="codigo" />
                                        <span class="input-group-text">
                                            <iconify-icon icon="mdi:magnify"></iconify-icon>
                                        </span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </form>
                        </div>
                    </div>

                    <!-- Resultados de la búsqueda -->
                    <div class="card mt-4 scrollable-content">
                        <div class="card-body">
                            <h3>Resultados de la Búsqueda</h3>
                            <?php if (isset($resultados) && !empty($resultados)): ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Asunto</th>
                                            <th>Tipo Persona</th>
                                            <th>Código</th>
                                            <th>Número</th>
                                            <th>Teléfono</th>
                                            <th>Mensaje</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($resultados as $tramite): ?>
                                            <tr>
                                                <td>
                                                    <a href="index.php?controller=seguimiento&action=mostrarSeguimientos&tramite_id=<?php echo $tramite['id']; ?>"
                                                        class="btn btn-secondary btn-sm m-1 rounded-circle d-flex justify-content-center align-items-center"
                                                        style="width: 30px; height: 30px;">
                                                        <iconify-icon icon="solar:add-circle-broken" style="font-size: 20px;"></iconify-icon>
                                                    </a>
                                                </td>

                                                <td><?php echo $tramite['asunto']; ?></td>
                                                <td><?php echo $tramite['tipopersona']; ?></td>
                                                <td><?php echo $tramite['codigo']; ?></td>
                                                <td><?php echo $tramite['numero']; ?></td>
                                                <td><?php echo $tramite['telefono']; ?></td>
                                                <td><?php echo $tramite['mensaje']; ?></td>
                                                <td> <span class="badge rounded-pill" style="background-color: <?php echo htmlspecialchars($tramite['estado_color']); ?>; color: #ffffff;">
                                                        <?php echo htmlspecialchars($tramite['estado_nombre']); ?>
                                                    </span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>No se encontraron resultados.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>