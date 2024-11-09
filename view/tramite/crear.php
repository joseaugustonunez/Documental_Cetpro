<?php
require_once("../../model/DocumentoModel.php"); // Asegúrate de incluir el modelo de Rol

// Crear una instancia del modelo de Rol
$documentoModel = new Documento();
$tramites = $documentoModel->listar();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tramite Documental</title>
    <link rel="shortcut icon" type="image/png" href="/sistemado/assets/images/logos/seodashlogo.png" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote JS y CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link rel="stylesheet" href="/sistemado/assets/css/styles.min.css" />

</head>
<style>
    /* Deshabilitar el redimensionamiento del textarea */
    #summernote {
        resize: none;
    }

    /* Tamaño fijo para el editor */
    .note-editor {
        max-width: 100%;
        height: 200px;
    }

    #summernote {
        max-width: 100%;
        height: 200px;
    }
</style>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <?php if (isset($_GET['error'])): ?>
                        <p style="color: red;"><?php echo $_GET['error']; ?></p>
                    <?php endif; ?>
                    <div class="col-md-10 col-lg-8 col-xxl-6"> <!-- Aumentar el ancho del card -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <?php
                                if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'tramite_realizado') {
                                    echo "<div class='alert alert-success'>Su trámite ha sido realizado exitosamente.</div>";
                                }
                                ?>
                                <h2>Nuevo Tramite</h2>
                                <form action="index.php?controller=tramite&action=guardar" method="POST" enctype="multipart/form-data">
                                    <!-- Primera Sección (Asunto, Tipo Tramite, Documento Adjunto, Mensaje) -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="asunto" class="form-label">Asunto</label>
                                                <input type="text" class="form-control" id="asunto" name="asunto" />
                                            </div>
                                            <div class="mb-4">
                                                <label for="tipoTramite" class="form-label">Tipo Tramite</label>
                                                <select class="form-select" name="tipo_tramite_id" id="tipoTramite" aria-label="Seleccionar tipo de trámite">
                                                    <option selected>Seleccionar Tramite</option>
                                                    <?php foreach ($tramites as $tramite): ?>
                                                        <option value="<?php echo $tramite['id']; ?>"><?php echo $tramite['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Documento Adjunto</label>
                                                <input class="form-control" type="file" id="documento" name="documentos">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="mensaje" class="form-label">Mensaje</label>
                                                <textarea id="summernote" name="mensaje"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Separador -->
                                    <hr class="my-4">

                                    <!-- Segunda Sección (Remitente) -->
                                    <h2 class="text-center">Remitente</h2>
                                    <div class="row g-3">
                                        <!-- Agrupar los inputs en 3 por fila -->
                                        <div class="col-md-4">
                                            <label for="tipopersona" class="form-label">Tipo de Persona</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <iconify-icon icon="ic:baseline-person"></iconify-icon> <!-- Icono de Persona -->
                                                </span>
                                                <select class="form-select" id="tipopersona" name="tipopersona">
                                                    <option value="" selected>Tipo de Persona</option>
                                                    <option value="Persona Natura">Persona Natural</option>
                                                    <option value="Persona Jurídica">Persona Jurídica</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="nombre" class="form-label">Nombre/Razón Social</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <iconify-icon icon="ic:outline-business"></iconify-icon> <!-- Icono de Negocio -->
                                                </span>
                                                <input type="text" class="form-control" id="nombre" name="nombre" />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="telefono" class="form-label">Telefono</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <iconify-icon icon="ic:baseline-phone"></iconify-icon> <!-- Icono de Teléfono -->
                                                </span>
                                                <input type="text" class="form-control" id="telefono" name="telefono" />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="correo" class="form-label">Correo Electronico</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <iconify-icon icon="ic:outline-email"></iconify-icon> <!-- Icono de Correo -->
                                                </span>
                                                <input type="email" class="form-control" id="correo" name="correo" />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="dni" class="form-label">DNI</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <iconify-icon icon="ic:baseline-credit-card"></iconify-icon> <!-- Icono de DNI -->
                                                </span>
                                                <input type="text" class="form-control" id="numero" name="numero" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary mb-4">Crear Tramite</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 115, // Altura inicial
                minHeight: 115, // Altura mínima
                maxHeight: 115, // Altura máxima
                focus: true // Enfocar el editor al cargar
            });
        });
    </script>
</body>

</html>