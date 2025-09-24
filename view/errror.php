
    <style>
        :root {
            --primary-color: #8B1538;
            --primary-dark: #6B0F2A;
            --gold-color: #D4AF37;
            --bg-light: #F8F9FA;
            --text-dark: #2C3E50;
            --shadow-light: 0 2px 15px rgba(139, 21, 56, 0.1);
            --shadow-medium: 0 5px 25px rgba(139, 21, 56, 0.15);
        }

        * {
            font-family: 'Inter', sans-serif;
        }
        .nav-link {
            color: #6c757d !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .error-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .error-card {
            background: white;
            border-radius: 25px;
            box-shadow: var(--shadow-medium);
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(139, 21, 56, 0.1);
        }

        .error-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--gold-color), var(--primary-color));
        }

        .error-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: bounce 2s infinite;
            box-shadow: var(--shadow-medium);
        }

        .error-icon i {
            font-size: 3rem;
            color: white;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        .error-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(139, 21, 56, 0.1);
        }

        .error-subtitle {
            color: var(--gold-color);
            font-weight: 600;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
        }

        .error-description {
            color: #6c757d;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .error-code {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding: 1rem;
            margin: 1.5rem 0;
            border-left: 5px solid var(--primary-color);
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-light);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-medium);
            color: white;
        }

        .btn-secondary-custom {
            background: transparent;
            border: 2px solid var(--gold-color);
            border-radius: 25px;
            padding: 10px 28px;
            font-weight: 600;
            color: var(--gold-color);
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-left: 15px;
        }

        .btn-secondary-custom:hover {
            background: var(--gold-color);
            color: white;
            transform: translateY(-2px);
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            animation: float1 6s linear infinite;
        }

        .shape-2 {
            top: 60%;
            right: 15%;
            width: 60px;
            height: 60px;
            background: var(--gold-color);
            transform: rotate(45deg);
            animation: float2 8s linear infinite;
        }

        .shape-3 {
            bottom: 20%;
            left: 20%;
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            animation: float3 10s linear infinite;
        }

        @keyframes float1 {
            0% {
                transform: translateY(0px) rotate(0deg);
            }
            25% {
                transform: translateY(-30px) rotate(90deg);
            }
            50% {
                transform: translateY(-60px) rotate(180deg);
            }
            75% {
                transform: translateY(-30px) rotate(270deg);
            }
            100% {
                transform: translateY(0px) rotate(360deg);
            }
        }

        @keyframes float2 {
            0% {
                transform: translateX(0px) translateY(0px) rotate(45deg);
            }
            25% {
                transform: translateX(20px) translateY(-40px) rotate(135deg);
            }
            50% {
                transform: translateX(-20px) translateY(-80px) rotate(225deg);
            }
            75% {
                transform: translateX(-40px) translateY(-40px) rotate(315deg);
            }
            100% {
                transform: translateX(0px) translateY(0px) rotate(405deg);
            }
        }

        @keyframes float3 {
            0% {
                transform: translateY(0px) translateX(0px) scale(1);
            }
            20% {
                transform: translateY(-25px) translateX(15px) scale(1.1);
            }
            40% {
                transform: translateY(-50px) translateX(-10px) scale(0.9);
            }
            60% {
                transform: translateY(-75px) translateX(20px) scale(1.2);
            }
            80% {
                transform: translateY(-40px) translateX(-15px) scale(0.8);
            }
            100% {
                transform: translateY(0px) translateX(0px) scale(1);
            }
        }

        .tech-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(139, 21, 56, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
        }

        @media (max-width: 768px) {
            .error-card {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }
            
            .error-title {
                font-size: 2rem;
            }
            
            .error-subtitle {
                font-size: 1.1rem;
            }
            
            .btn-secondary-custom {
                margin-left: 0;
                margin-top: 10px;
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(139, 21, 56, 0.7);
            }
            70% {
                box-shadow: 0 0 0 20px rgba(139, 21, 56, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(139, 21, 56, 0);
            }
        }
    </style>
</head>
    <!-- Contenedor principal del error -->
    <div class="container error-container">
        <div class="error-card">
            <!-- Icono de error animado -->
            <div class="error-icon pulse">
                <i class="<?php echo isset($icono_error) ? $icono_error : 'fas fa-exclamation-triangle'; ?>"></i>
            </div>

            <!-- Título del error (variable desde PHP) -->
            <h1 class="error-title">
                <?php echo isset($problema) ? htmlspecialchars($problema) : '¡Houston, tenemos un problema!'; ?>
            </h1>

            <!-- Subtítulo del error -->
            <h2 class="error-subtitle">
                <?php echo isset($subtitulo_error) ? htmlspecialchars($subtitulo_error) : 'Error en el Sistema'; ?>
            </h2>

            <!-- Descripción del error (variable desde PHP) -->
            <p class="error-description">
                <?php echo isset($cuerpo_problema) ? htmlspecialchars($cuerpo_problema) : 'Parece que nuestros desarrolladores están tomando mucho café ☕ y algo no salió como esperábamos. No te preocupes, ya estamos trabajando en una solución.'; ?>
            </p>

            <!-- Código de error opcional -->
            <?php if(isset($codigo_error) && $codigo_error): ?>
            <div class="error-code">
                <strong>Código de Error:</strong> <?php echo htmlspecialchars($codigo_error); ?>
                <?php if(isset($timestamp)): ?>
                <br><strong>Timestamp:</strong> <?php echo htmlspecialchars($timestamp); ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Botones de acción -->
            <div class="mt-4">
                <a href="?c=home" class="btn-primary-custom">
                    <i class="fas fa-home me-2"></i>Volver al Inicio
                </a>
            </div>

            <!-- Mensaje adicional opcional -->
            <?php if(isset($mensaje_adicional) && $mensaje_adicional): ?>
            <div class="mt-4 p-3 bg-light rounded-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    <?php echo htmlspecialchars($mensaje_adicional); ?>
                </small>
            </div>
            <?php endif; ?>
        </div>
    </div>
