$(document).ready(function() {
    $('#crudModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var c = button.data('c'); 
        
		if(id>0){
			var url = "?c="+c+"&a=crud&id="+id;
		} else if(c == 'factura'){
			var id_venta = button.data('id_venta');
			var id_cliente = button.data('id_cliente');
			console.log('ID Venta:', id_venta, 'ID Cliente:', id_cliente); // Para debug
			var url = "?c="+c+"&a=crud&id_venta="+id_venta+"&id_cliente="+id_cliente;
		}
		else{
			var url = "?c="+c+"&a=crud";
		}

		console.log(url)
		$.ajax({

			url: url,
			method : "POST",
			data: id,
			cache: false,
			contentType: false,
			processData: false,
			success:function(respuesta){
				$("#edit_form").html(respuesta);
			}

		})
	})
});


