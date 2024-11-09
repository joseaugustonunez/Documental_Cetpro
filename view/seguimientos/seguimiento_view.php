<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Seguimiento del Trámite</title>
    <link rel="shortcut icon" type="image/png" href="/sistemado/assets/images/logos/seodashlogo.png" />
    <link rel="stylesheet" href="/sistemado/assets/css/styles.min.css" />
    <style>
        .card {
            width: 100%;
            max-width: 800px;
            min-height: 200px;
        }

        .container {
            max-width: 100%;
            padding: 15px;
        }

        .scrollable-content {
            max-height: 80vh;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .card {
                width: 100%;
                margin-top: 0;
            }

            .scrollable-content {
                max-height: 60vh;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="card mt-4 scrollable-content">
                        <div class="card-body">
                            <h3>Seguimiento del Trámite</h3>
                            <?php if (isset($seguimientos) && !empty($seguimientos)): ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Comentario</th>
                                            <th>Documento</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($seguimientos as $seguimiento): ?>
                                            <tr>
                                                <td><?php echo date('d-m-Y H:i', strtotime($seguimiento['created_at'])); ?></td>
                                                <td><?php echo htmlspecialchars($seguimiento['comentario']); ?></td>
                                                <td>
                                                    <?php if (!empty($seguimiento['documento'])): ?>
                                                        <a href="http://localhost/sistemado/Seguimientos/<?php echo str_replace(' ', '%20', basename($seguimiento['documento'])); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                                            Ver Documento
                                                        </a>
                                                    <?php else: ?>
                                                        No disponible
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge rounded-pill" style="background-color: <?php echo htmlspecialchars($seguimiento['estado_color']); ?>; color: #ffffff;">
                                                        <?php echo htmlspecialchars($seguimiento['estado_nombre']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>No se encontraron seguimientos para este trámite.</p>
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