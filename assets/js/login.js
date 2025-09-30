$(document).ready(function() {
    // Alternar entre Login y Registro
    $('#showRegister').on('click', function(e) {
        e.preventDefault();
        $('#loginCard').removeClass('active').css({
            'opacity': '0',
            'transform': 'rotateY(-180deg)'
        });
        setTimeout(function() {
            $('#loginCard').hide();
            $('#registerCard').show().addClass('active').css({
                'opacity': '1',
                'transform': 'rotateY(0deg)'
            });
        }, 300); // Duración de la transición
    });

    $('#showLogin, #showLoginFromRegister').on('click', function(e) {
        e.preventDefault();
        $('#registerCard').removeClass('active').css({
            'opacity': '0',
            'transform': 'rotateY(180deg)'
        });
        setTimeout(function() {
            $('#registerCard').hide();
            $('#loginCard').show().addClass('active').css({
                'opacity': '1',
                'transform': 'rotateY(0deg)'
            });
        }, 300); // Duración de la transición
    });

    // Función para mostrar/ocultar contraseña
    $('.toggle-password').on('click', function() {
        let targetId = $(this).data('target');
        let passwordField = $('#' + targetId);
        let icon = $(this);

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Validación AJAX para Email en Registro
    $('#registerEmail').on('input', function() {
        console.log('Validando email...');
        let email = $(this).val();
        console.log('Email a validar:', email);
        
        if (email && email.length > 0) {
            console.log('Enviando petición AJAX...');
            $.ajax({
                url: 'index.php?c=cliente&a=revisarEmail',
                method: 'POST',
                data: { email: email },
                dataType: 'json',
                beforeSend: function() {
                    let feedback = $('#emailFeedback');
                    feedback.html('<i class="fas fa-spinner fa-spin"></i> Verificando email...').removeClass('text-danger text-success');
                },
                success: function(response) {
                    let feedback = $('#emailFeedback');
                    if (response && response.hasOwnProperty('is_available')) {
                        if (response.is_available) {
                            feedback.html('<i class="fas fa-check-circle"></i> Email disponible.').removeClass('text-danger').addClass('text-success');
                            $('#registerEmail').removeClass('is-invalid').addClass('is-valid');
                        } else {
                            feedback.html('<i class="fas fa-times-circle"></i> Este email ya está registrado.').removeClass('text-success').addClass('text-danger');
                            $('#registerEmail').removeClass('is-valid').addClass('is-invalid');
                        }
                    } 
                },
            });
        } else {
            $('#emailFeedback').empty().removeClass('text-success text-danger');
            $('#registerEmail').removeClass('is-valid is-invalid');
        }
    });

    // Validación de fuerza de contraseña (ejemplo)
    $('#registerPassword').on('keyup', function() {
        let password = $(this).val();
        let strengthBadge = $('#passwordStrength');
        let strength = 0;

        if (password.length > 5) strength += 1;
        if (password.match(/[a-z]+/)) strength += 1;
        if (password.match(/[A-Z]+/)) strength += 1;
        if (password.match(/[0-9]+/)) strength += 1;
        if (password.match(/[$@#&!]+/)) strength += 1;

        let feedbackText = '';
        let feedbackClass = '';

        switch (strength) {
            case 0:
            case 1:
                feedbackText = 'Débil';
                feedbackClass = 'text-danger';
                break;
            case 2:
                feedbackText = 'Regular';
                feedbackClass = 'text-warning';
                break;
            case 3:
                feedbackText = 'Buena';
                feedbackClass = 'text-warning';
                break;
            case 4:
            case 5:
                feedbackText = 'Fuerte';
                feedbackClass = 'text-success';
                break;
        }
        strengthBadge.html(`<i class="fas fa-shield-alt"></i> Fuerza: ${feedbackText}`).attr('class', `form-text ${feedbackClass}`);
    });

    // Validación de confirmación de contraseña
    $('#confirmPassword').on('keyup', function() {
        let password = $('#registerPassword').val();
        let confirmPassword = $(this).val();
        let feedback = $('#confirmPasswordFeedback');

        if (password === confirmPassword && confirmPassword.length > 0) {
            feedback.html('<i class="fas fa-check-circle"></i> Las contraseñas coinciden.').removeClass('text-danger').addClass('text-success');
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else if (confirmPassword.length > 0) {
            feedback.html('<i class="fas fa-times-circle"></i> Las contraseñas no coinciden.').removeClass('text-success').addClass('text-danger');
            $(this).removeClass('is-valid').addClass('is-invalid');
        } else {
            feedback.empty().removeClass('text-success text-danger');
            $(this).removeClass('is-valid is-invalid');
        }
    });

    // También validar cuando cambie la contraseña principal
    $('#registerPassword').on('keyup', function() {
        let password = $(this).val();
        let confirmPassword = $('#confirmPassword').val();
        let feedback = $('#confirmPasswordFeedback');

        // Si ya hay texto en confirmar contraseña, validar de nuevo
        if (confirmPassword.length > 0) {
            if (password === confirmPassword) {
                feedback.html('<i class="fas fa-check-circle"></i> Las contraseñas coinciden.').removeClass('text-danger').addClass('text-success');
                $('#confirmPassword').removeClass('is-invalid').addClass('is-valid');
            } else {
                feedback.html('<i class="fas fa-times-circle"></i> Las contraseñas no coinciden.').removeClass('text-success').addClass('text-danger');
                $('#confirmPassword').removeClass('is-valid').addClass('is-invalid');
            }
        }
    });

    // Manejar el envío del formulario de login
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        let email = $('#loginEmail').val();
        let password = $('#loginPassword').val();
        
        if (!email || !password) {
            alert('Por favor, completa todos los campos.');
            return false;
        }
        
        // Mostrar indicador de carga
        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.text();
        submitBtn.text('Iniciando sesión...').prop('disabled', true);
        
        $.ajax({
            url: 'index.php?c=login&a=login',
            method: 'POST',
            data: {
                email: email,
                password: password
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Login exitoso
                    Swal.fire({
                        icon: 'success',
                        title: '¡Login exitoso!',
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    }).then(() => {
                        // Redirección después del toast
                        window.location.href = 'index.php?c=home';
                    });
                
                } else {
                    // Error en el login con SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el login',
                        text: response.message,
                        confirmButtonText: 'Intentar de nuevo'
                    });
                }
                
            },
            error: function(xhr, status, error) {
                console.error('Error en login:', error);
                console.error('Respuesta del servidor:', xhr.responseText);
                alert('Error de conexión. Por favor, intenta de nuevo.');
            },
            complete: function() {
                // Restaurar el botón
                submitBtn.text(originalText).prop('disabled', false);
            }
        });
    });

    // Prevenir envío de formularios si hay errores de validación
    $('#registerForm').on('submit', function(e) {
        let hasErrors = false;
        let errorMessages = [];

        // Verificar si las contraseñas coinciden
        if ($('#registerPassword').val() !== $('#confirmPassword').val()) {
            hasErrors = true;
            errorMessages.push('Las contraseñas no coinciden.');
        }

        // Verificar si el email es válido
        if (!$('#registerEmail').hasClass('is-valid')) {
            hasErrors = true;
            errorMessages.push('El email no es válido o ya está registrado.');
        }

        // Verificar si las contraseñas están vacías
        if ($('#registerPassword').val().length === 0) {
            hasErrors = true;
            errorMessages.push('La contraseña es requerida.');
        }

        // Verificar si el nombre está vacío
        if ($('#registerFirstName').val().trim().length === 0) {
            hasErrors = true;
            errorMessages.push('El nombre es requerido.');
        }

        if (hasErrors) {
            e.preventDefault(); // Detener el envío si hay errores
            alert('Por favor, corrige los siguientes errores:\n\n' + errorMessages.join('\n'));
            return false;
        }
    });
});