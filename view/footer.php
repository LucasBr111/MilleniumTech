</div>
 </div>
 </div>

 <script src="view/ajax.js"> </script>
 <script type="text/javascript">
   $('.delete').on("click", function(e) {
     e.preventDefault();
     Swal.fire({
       title: '¿Estás seguro?',
       text: "No se pueder revertir!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Si, deseo eliminar!',
       cancelButtonText: 'Cancelar'
     }).then((result) => {
       if (result.value) {

         window.location.href = $(this).attr('href');

       }
     })
   });
 </script>
 <script type="text/javascript">
   // Toggle Sidebar y ajuste de área de contenido
   (function() {
     const sidebarContainer = document.getElementById('sidebar-container');
     const content = document.getElementById('content');
     const toggleBtn = document.getElementById('sidebarCollapse');

     if (!sidebarContainer || !content || !toggleBtn) return;

     const setContentShift = () => {
       const isDesktop = window.matchMedia('(min-width: 992px)').matches;
       if (isDesktop) {
         // En desktop el sidebar siempre está visible
         sidebarContainer.classList.add('active');
         content.classList.add('with-sidebar');
       } else {
         // En móvil inicia oculto si no está activo
         if (!sidebarContainer.classList.contains('active')) {
           content.classList.remove('with-sidebar');
         }
       }
     };

     // Inicialización y en cambios de tamaño
     setContentShift();
     window.addEventListener('resize', setContentShift);

     // Click para alternar
     toggleBtn.addEventListener('click', function() {
       sidebarContainer.classList.toggle('active');
       const isActive = sidebarContainer.classList.contains('active');
       const isDesktop = window.matchMedia('(min-width: 992px)').matches;
       if (isDesktop) {
         // En desktop mantener desplazamiento siempre activo
         content.classList.add('with-sidebar');
       } else {
         // En móvil desplazar contenido solo cuando el sidebar esté activo
         if (isActive) {
           content.classList.add('with-sidebar');
         } else {
           content.classList.remove('with-sidebar');
         }
       }
     });
   })();
   
    // Manejar el botón de agregar al carrito
    $('.btn-add-cart').on('click', function() {
        const button = $(this);
        const id = button.data('id');
        const isLoggedIn = <?= isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] ? 'true' : 'false' ?>;

        if (!isLoggedIn) {
            Swal.fire({
                icon: 'warning',
                title: 'Debes iniciar sesión',
                text: 'Para agregar productos al carrito necesitas iniciar sesión.',
                confirmButtonText: 'Ir al login'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php?c=login";
                }
            });
            return;
        }

        if (button.prop('disabled')) {
            return;
        }

        button.prop('disabled', true);
        const originalText = button.text();
        button.html('<i class="fas fa-spinner fa-spin me-2"></i>Agregando...');

        $.ajax({
            url: 'index.php?c=carrito&a=agregar',
            method: 'POST',
            data: {
                id_producto: id,
                cantidad: 1
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });

                    // Actualizar contadores en el navbar
                    if (typeof updateFavoritesCounter === 'function') {
                        updateFavoritesCounter();
                    }
                    if (typeof updateCartCounter === 'function') {
                        updateCartCounter();
                    }
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Error al agregar al carrito.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            },
            complete: function() {
                button.prop('disabled', false);
                button.html('<i class="fas fa-shopping-cart me-2"></i>Añadir al Carrito');
            }
        });
    });
 </script>