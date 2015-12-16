$(document).ready(function() {
		    $('#temas').DataTable( {
		        "language": {
		            "lengthMenu": "Mostrando _MENU_ temas por página",
		            "zeroRecords": "Ningún resultado coincide con la búsqueda",
		            "info": "Mostrando página _PAGE_ de _PAGES_",
		            "search": "Buscar:",
		            "paginate": {
				        "first":      "Primero",
				        "last":       "Último",
				        "next":       "Siguiente",
				        "previous":   "Anterior"
				    },
		            "infoEmpty": "No hay resultados disponibles",
		            "infoFiltered": "(filtrado de _MAX_ registros totales)"
		        }
		    } );
		} );