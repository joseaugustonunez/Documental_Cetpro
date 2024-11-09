<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tramite Documental</title>
    <link
        rel="shortcut icon"
        type="image/png"
        href="/sistemado/assets/images/logos/seodashlogo.png" />
    <link rel="stylesheet" href="/sistemado/assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div
        class="page-wrapper"
        id="main-wrapper"
        data-layout="vertical"
        data-navbarbg="skin6"
        data-sidebartype="full"
        data-sidebar-position="fixed"
        data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger mt-2">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <div class="card mb-0">
                            <div class="card-body">
                                <a
                                    href="./index.html"
                                    class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="/sistemado//assets/images/logos/Logoslg.svg" alt="" />
                                </a>
                                <p class="text-center">Escuela de Emprendedores</p>
                                <form method="POST" action="index.php?controller=login&action=login">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            aria-describedby="emailHelp" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="password"
                                            name="password" />
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <a class="btn btn-outline-primary m-1" href="/sistemado/view/tramite/consulta.php" role="button">Consultar</a>
                                            <a class="btn btn-outline-primary m-1" href="/sistemado/view/tramite/crear.php" role="button">Nuevo Tramite</a>

                                        </div>
                                        <a class="text-primary fw-bold" href="./index.html">¿Olvidó su contraseña?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Ingresar</button>
                                    <div
                                        class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">¿Eres nuevo?</p>
                                        <a
                                            class="text-primary fw-bold ms-2"
                                            href="./authentication-register.html">Registrarse</a>
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
</body>


</html>