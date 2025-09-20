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
 </script>