<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Millenium Tech ✨</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ==============================
         ICONOS Y FUENTES
    =============================== -->
    <!-- Font Awesome (iconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <!-- Google Fonts: Montserrat y Lato -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- ==============================
         BOOTSTRAP 5.3.3
    =============================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">

    <!-- ==============================
         DATATABLES
    =============================== -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">



    <!-- ==============================
         ESTILOS PERSONALIZADOS
    =============================== -->
    <link rel="stylesheet" href="assets/styles/sidebar.css" />
    <link rel="icon" href="assets/img/logo.png" type="image/png" />

    <!-- ==============================
         LIBRERÍAS JS (orden correcto)
    =============================== -->
    <!-- jQuery (necesario para DataTables y algunos plugins) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <!-- Librerías para exportación PDF/Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap 5.3.3 JS Bundle (incluye Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</head>
<style>
    .page-header {
        margin: 0px 0 20px;
    }

    .my-class {
        text-align: center;
    }

    .my-class2 {
        text-align: right;
    }

    .swal-wide {
        font-size: 15px;
        width: 270px;
        height: 80px;
    }

    /* modal de alerta grande */
    .swal-lg {
        font-size: 15px;
        min-width: 500px;
        max-width: 700px;
        height: fit-content;
    }

    .notification-container {
        position: relative;
        display: inline-block;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 4px 8px;
        font-size: 12px;
    }
</style>

<body>
    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true && $_SESSION['nivel'] == 1): ?>
        <div class="d-flex wrapper" id="wrapper">
                <?php include "sidebar.php"; ?>
                <div id="content" class="flex-grow-1 p-4" style="background-color: white">
                <?php else: ?>
                    <div class="d-flex wrapper" id="wrapper">
                        <div id="content" class="flex-grow-1 p-4">
                            <?php include "navbar.php"; ?>
                        <?php endif; ?>