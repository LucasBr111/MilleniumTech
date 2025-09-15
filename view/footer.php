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