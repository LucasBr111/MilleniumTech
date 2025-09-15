$(document).ready(function() {
    $('#crudModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var c = button.data('c'); 
        console.log("ID: " + id);
        
		if(id>0){
			var url = "?c="+c+"&a=crud&id="+id;
		}else{
			var url = "?c="+c+"&a=crud";
		}
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


