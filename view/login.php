<!DOCTYPE html>
<html lang="es">

<head>
    <title>Iniciar Sesión - R&F Automotores</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'rojo-principal': '#FF1A1A',
                        'rojo-oscuro': '#B31212',
                        'negro-profundo': '#0A0A0A',
                        'gris-metalico': '#BFBFBF',
                        'gris-oscuro': '#2E2E2E',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-negro-profundo text-white flex items-center justify-center min-h-screen p-4">

    <div class="bg-gris-oscuro shadow-xl rounded-lg overflow-hidden flex flex-col md:flex-row max-w-4xl w-full">
        <div class="md:w-1/2 p-10 flex flex-col justify-center bg-cover bg-center relative" style="background-image: url('assets/img/auto.jpg');">
            <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
                <div class="relative z-10 bg-negro-profundo bg-opacity-80 p-6 rounded-lg">
                    <h1 class="text-3xl font-bold text-rojo-principal mb-4">R&F Automotores</h1>
                    <p class="text-gris-metalico mb-4">
                        Bienvenido al Sistema de Gestión Interno. Esta herramienta ha sido diseñada para optimizar y centralizar
                        la administración de clientes, ventas y pagos.
                    </p>
                    <p class="text-gris-metalico">
                        Digitaliza tus procesos, accede a historiales y genera reportes de manera eficiente para un control total de tu negocio.
                    </p>
                </div>
            </div>

    

    <div class="md:w-1/2 p-10 flex flex-col justify-center">
        <div class="text-center mb-6">
            <img src="assets/img/logo.png" alt="Logo R&F Automotores" class="w-32 md:w-40 mx-auto mb-4">
            <h2 class="text-3xl font-bold text-rojo-principal">Iniciar Sesión</h2>
        </div>

        <form id="loginForm" class="mt-4">
            <div class="relative mb-4">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-user text-rojo-principal"></i>
                </div>
                <input type="text" name="nombre" placeholder="Nombre de usuario" required
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gris-metalico bg-negro-profundo focus:border-rojo-principal focus:outline-none placeholder-gray-400">
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-lock text-rojo-principal"></i>
                </div>
                <input type="password" name="pass" placeholder="Contraseña" required
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gris-metalico bg-negro-profundo focus:border-rojo-principal focus:outline-none placeholder-gray-400">
            </div>

            <button type="submit" class="w-full bg-rojo-principal hover:bg-rojo-oscuro text-white font-bold py-3 rounded-lg transition-colors">
                Iniciar Sesión
            </button>
        </form>
    </div>
    </div>
</body>

</html>



<script>
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        const response = await fetch('index.php?c=login&a=login', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Bienvenido',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'index.php?c=cuota';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    });
</script>