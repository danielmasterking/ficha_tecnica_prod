$(document).ready( function () {



  $('#w1-disp').prop('placeholder', 'Fecha Inicial');
  $('#w2-disp').prop('placeholder', 'Fecha Final');

 	$('#toggle-two').bootstrapToggle({
      on: 'Centro Costo',
      off: 'Ciudades'
    });

        $('#toggle-two').change(function(){

           if($(this).prop('checked')){
           	   $('#ciudades').addClass("hidden");
    	       $('#ccostos').removeClass("hidden");
    	       $('#ccostos').addClass("show");


           }else{

               $('#ccostos').addClass("hidden");
    	       $('#ciudades').removeClass("hidden");
    	       $('#ciudades').addClass("show");

           }

    });

    var table = $('.my-data').DataTable({
    
		dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel'
         ],

      //"order": [[0,"desc"]],
ordering:false,
    	language: {
        "sProcessing":     "Procesando...",
	    "sLengthMenu":     "Mostrar _MENU_ registros",
	    "sZeroRecords":    "No se encontraron resultados",
	    "sEmptyTable":     "Ningún dato disponible en esta tabla",
	    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix":    "",
	    "sSearch":         "Buscar:",
	    "sUrl":            "",
	    "sInfoThousands":  ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	        "sFirst":    "Primero",
	        "sLast":     "Último",
	        "sNext":     "Siguiente",
	        "sPrevious": "Anterior"
	    },
	    "oAria": {
	        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    }
     }

    }

    );

    var table2 = $('.my-data2').DataTable({

    //dom: 'Bfrtip',
        buttons: [
            
            'pdf',
            'excel'
         ],

      language: {
        "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
      },
      "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
     }

    }

    );

        var table3 = $('.my-data3').DataTable({
    
    dom: 'Bfrtip',
        buttons: ['excel', 'pdf'],

      //"order": [[4,"ASC"]],
ordering:false,
      language: {
        "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
      },
      "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
     }

    }

    );


    table.buttons().container()
   .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
       table2.buttons().container()
   .appendTo( $('.col-sm-6:eq(0)', table2.table().container() ) );
    table3.buttons().container()
   .appendTo( $('.col-sm-6:eq(0)', table3.table().container() ) );

    $('.check-all').click(function() {

        var selector = $(this).is(':checked') ? ':not(:checked)' : ':checked';
        $('.preaviso-form input[type="checkbox"]' + selector).each(function() {
               $(this).trigger('click');
         });



         $('.roles input[type="checkbox"]' + selector).each(function() {
               $(this).trigger('click');
         });


         $('#ccostos input[type="checkbox"]' + selector).each(function() {
               $(this).trigger('click');
         });


         $('#ciudades input[type="checkbox"]' + selector).each(function() {
               $(this).trigger('click');
         });

    });

    $('#tipo-visita').on('change',function(){




        var value = $('#tipo-visita option:selected').text();

        if(value == 'Técnica'){

          $('#detalle-tecnica').removeClass('hidden');
          $('#detalle-tecnica').addClass('show');


        }else{

          $('#detalle-tecnica').removeClass('show');
          $('#detalle-tecnica').addClass('hidden');


        }


    });


} );
