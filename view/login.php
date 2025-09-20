<?php
$isLoggedIn = $_SESSION['isLoggedIn'] ?? false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MILLION TECH - Iniciar Sesión / Registrarse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/login.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="auth-body">
    <div class="background-animation"></div>

    <div class="auth-container">
        <div class="auth-card active" id="loginCard">
            <div class="auth-header">
                <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i></a>
                <img src="assets/img/logo.png" alt="Million Tech Logo" class="auth-logo">
                <h2 class="auth-title">Bienvenido de nuevo</h2>
                <p class="auth-subtitle">Tu portal a la innovación</p>
            </div>
            <form id="loginForm" action="index.php?c=login&a=login" method="POST">
                <div class="mb-3 form-group">
                    <label for="loginEmail" class="form-label">Email</label>
                    <div class="input-icon-group">
                        <i class="fas fa-envelope icon-left"></i>
                        <input type="email" class="form-control" id="loginEmail" name="email" placeholder="john.doe@example.com" required>
                    </div>
                </div>
                <div class="mb-3 form-group">
                    <label for="loginPassword" class="form-label">Contraseña</label>
                    <div class="input-icon-group">
                        <i class="fas fa-lock icon-left"></i>
                        <input type="password" class="form-control" id="loginPassword" name="password" placeholder="********" required>
                        <i class="fas fa-eye toggle-password" data-target="loginPassword"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="index.php?c=login&a=forgot_password" class="forgot-password-link">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="btn btn-primary auth-btn">Iniciar Sesión</button>
            </form>
            <div class="auth-footer">
                <p>¿No tienes una cuenta? <a href="#" id="showRegister" class="auth-switch-link">Regístrate</a></p>
            </div>
        </div>

        <div class="auth-card" id="registerCard">
            <div class="auth-header">
                <a href="#" id="showLogin" class="back-link"><i class="fas fa-arrow-left"></i></a>
                <img src="assets/img/logo.png" alt="Million Tech Logo" class="auth-logo">
                <h2 class="auth-title">Crea tu cuenta</h2>
                <p class="auth-subtitle">Únete a la experiencia Million Tech</p>
            </div>
            <form id="registerForm" action="index.php?c=cliente&a=signUp" method="POST">
                <div class="mb-3 form-group">
                    <label for="registerFirstName" class="form-label">Nombre Completo</label>
                    <div class="input-icon-group">
                        <i class="fas fa-user icon-left"></i>
                        <input type="text" class="form-control" id="registerFirstName" name="nombre" placeholder="John" required>
                    </div>
                </div>
                <div class="mb-3 form-group">
                    <label for="registerEmail" class="form-label">Email</label>
                    <div class="input-icon-group">
                        <i class="fas fa-envelope icon-left"></i>
                        <input type="email" class="form-control" id="registerEmail" name="email" placeholder="john.doe@example.com" required>
                    </div>
                    <div id="emailFeedback" class="form-text"></div>
                </div>
                <div class="mb-3 form-group">
                    <label for="registerPassword" class="form-label">Contraseña</label>
                    <div class="input-icon-group">
                        <i class="fas fa-lock icon-left"></i>
                        <input type="password" class="form-control" id="registerPassword" name="password" placeholder="********" required>
                        <i class="fas fa-eye toggle-password" data-target="registerPassword"></i>
                    </div>
                    <div id="passwordStrength" class="form-text"></div>
                </div>
                <div class="mb-4 form-group">
                    <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                    <div class="input-icon-group">
                        <i class="fas fa-lock icon-left"></i>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="********" required>
                        <i class="fas fa-eye toggle-password" data-target="confirmPassword"></i>
                    </div>
                    <div id="confirmPasswordFeedback" class="form-text"></div>
                </div>
                <button type="submit" class="btn btn-primary auth-btn">Registrarse</button>
            </form>
            <div class="auth-footer">
                <p>¿Ya tienes una cuenta? <a href="#" id="showLoginFromRegister" class="auth-switch-link">Inicia Sesión</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/login.js"></script>
</body>
</html>