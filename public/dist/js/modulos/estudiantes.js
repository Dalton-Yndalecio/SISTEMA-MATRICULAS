$(document).ready(function(){
    var tabla = $('#tbEstudiantes').DataTable({
       processing: true,
       serverSide: true,
       ajax: '/estudiantes', 
       language: {
           "decimal": "",
           "emptyTable": "No hay información",
           "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
           "infoEmpty": "Mostrando 0 a 0 de 0 Registros",
           "infoFiltered": "(Filtrado de _MAX_ total Registros)",
           "infoPostFix": "",
           "thousands": ",",
           "lengthMenu": "Mostrar _MENU_ Registros",   
           "loadingRecords": "Cargando...",
           "processing": "Cargando...",
           "search": "Buscar:",
           "zeroRecords": "Sin resultados encontrados",
           "paginate": {
               "first": "Primero",
               "last": "Ultimo",
               "next": "Siguiente",
               "previous": "Anterior"
           }
       },
       columns: [
            {data: 'dni'},
            {data: 'nombres'},
            {data: 'apellidos'},
            {data: 'direccion'},
            {data: 'celular'},
            {data: 'fecha_nacimiento'},
            {data: 'apoderados'},
            {data: 'action', orderable: false},
        ]
   });

   $("#dni").on("input", function() {
       // Remover caracteres no numéricos y mantener solo números
       var inputValue = $(this).val().replace(/[^0-9]/g, "");
       $(this).val(inputValue);
   });
   $("#celular").on("input", function() {
       // Remover caracteres no numéricos y mantener solo números
       var inputValue = $(this).val().replace(/[^0-9]/g, "");
       $(this).val(inputValue);
   });


   // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
   $('.selectApoderado').select2()
   // --- json que llena lso datos al combo bos de ocupaciones -------
   $("#apoderado_id").append('<option value="">--------- SELECCIONAR ---------</option>');
   $.get('/estudiantes/select',function(apoderados){
       $.each(apoderados, function () {
           $("#apoderado_id").append('<option value="' + this.id + '">' + this.nombres + ' '+ this.apellidos +'</option>');
           
       });
   })

   // ---- INPUT EN MAYUSCULA ---//
   $("#formEstudiante input[type='text']").on('input', function() {
       var valorActual = $(this).val().toLowerCase()
       var valorEnMayusculas = valorActual.toUpperCase();
       $(this).val(valorEnMayusculas);
      
   });

   
   // ---- modal para editar y agregar apoderado .off('click')------
   $(document).on('click', '.modal-Estudiante', function(){
       var id = $(this).attr('data-id');
       var modal = $(this).attr('modal-estudiante');
       $("#tituloEstudiante").html(modal + " Estudiante");
       $("#btnEstudiante").html(modal);
       $("#modalEstudiante").modal('toggle');
       // Desvincular eventos click anteriores para evitar duplicación
       $("#btnEstudiante").off('click').on('click', function(){
           if ($('#formEstudiante').valid()) {
               var formEstdudiantes = $("#formEstudiante").serialize();
               if (modal === "Agregar") {
                   $.ajax({
                       url: "/estudiantes/create",
                       method: "POST",
                       data: formEstdudiantes,
                       success: function(response){
                           if (response.success) {
                               $("#modalEstudiante").modal('hide');
                               Toast.fire({icon: 'success', title: response.message})
                               $("#tbEstudiantes").DataTable().ajax.reload();
                           } else {
                               Toast.fire({icon: 'warning', title: response.message})
                           }
                       },
                       error: function(){
                           $(document).Toasts('create', {
                               class: 'bg-danger',
                               title: 'ERROR!',
                               subtitle: 'Cerrar',
                               body: 'No se pudo agregar registro, ocurrió algo inseperado'
                           })
                       }
                   })
               }
               else if (modal === "Actualizar"){
                   $.ajax({
                       url: "/estudiantes/actualizar/"+id,
                       method: "POST",
                       data: formEstdudiantes,
                       success: function(response){
                           if (response.success) {
                               $("#modalEstudiante").modal('hide');
                               Toast.fire({icon: 'success', title: response.message})
                               $("#tbEstudiantes").DataTable().ajax.reload();
                           } else {
                               Toast.fire({icon: 'warning', title: response.message})
                           }
                       },
                       error: function(error){
                           $(document).Toasts('create', {
                               class: 'bg-danger',
                               title: 'ERROR!',
                               subtitle: 'Cerrar',
                               body: 'No se pudo actualizar registro, ocurrió algo inseperado'
                           })
                       }
                   })
               }
           } else {
              return; 
           }
       })
       if (modal === "Actualizar") {
           $("#modalEstudiante .overlay").removeClass("d-none").show();
           setTimeout(function(){
               $("#modalEstudiante .overlay").hide();
           }, 800);
           $.get('/estudiantes/editar/'+id,function(estudiante){

               $("#id").val(estudiante[0].id);
               $("#apoderado_id option").each(function () {
                   if ($(this).val() == estudiante[0].apoderado_id) {
                        $(this).prop("selected", true);
                        $("#apoderado_id").trigger('change');
                        return false;
                    }
                });
               $("#dni").val(estudiante[0].dni);
               $("#nombres").val(estudiante[0].nombres);
               $("#apellidos").val(estudiante[0].apellidos);
               $("#direccion").val(estudiante[0].direccion);
               $("#celular").val(estudiante[0].celular);
               $("#fecha_nacimiento").val(estudiante[0].fecha_nacimiento);
           })
       }
   })

    // limpiar datos cuando se cierre el modal
    $('#modalEstudiante').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formEstudiante').validate().resetForm();
        $('#modalEstudiante :input').each(function () {
            $("#tituloEstudiante").html("");
            $("#btnEstudiante").html("");
            $("#formEstudiante")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
        $("#apoderado_id").select2('destroy').empty();
        // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.selectApoderado').select2()

        // --- json que llena lso datos al combo bos de ocupaciones -------
        $("#apoderado_id").append('<option value="">--------- SELECCIONAR ---------</option>');
            $.get('/estudiantes/select',function(apoderados){
                $.each(apoderados, function () {
                    $("#apoderado_id").append('<option value="' + this.id + '">' + this.nombres + ' '+ this.apellidos +'</option>');
                    
                });
            })
    });
   // validacion del selectd --/
   $('#apoderado_id').on('change', function() {
       $('#formEstudiante').validate().element('#apoderado_id');
   });
   $('#formEstudiante').validate({
       ignore: [],
       rules: {
           apoderado_id: {
               required: function() {
               var selectedValue = $('#apoderado_id').val();
               return selectedValue === '' || selectedValue === '0';
               }
           },
           dni: {
               required: true,
               minlength: 8,
               maxlength: 8,
               
           },
           nombres: {
               required: true,
           },
           apellidos: {
               required: true,
           },
           direccion: {
               required: true,
           },
           celular: {
               required: true,
               minlength: 9,
               maxlength: 9,
               
           },
           
           fecha_nacimiento: {
               required: true,
           },

           
       },
       messages: {
           apoderado_id: {
               required: "Por favor seleccione una Apoderado"
           },
           dni: {
               required: "Por favor ingrese número de DNI",
               minlength: "El DNI debe tener 8 caracteres",
               maxlength: "El DNI debe tener solo 8 caracteres",
              
           },
           nombres: {
               required: "Por favor ingrese los nombres",
           },
           apellidos: {
               required: "Por favor ingrese los apellidos",
           },
           direccion: {
               required: "Por favor ingrese una dirección",
           },
           celular: {
               required: "Por favor ingrese un  número de celular",
               minlength: "El número de celular debe tener 9 digitos",
               maxlength: "El número de celular debe tener solo 9 digitos",
               
           },
           fecha_nacimiento: {
               required: "Por favor ingrese la fecha de nacimiento",
           },
       },
       errorElement: 'span',
       errorPlacement: function (error, element) {
           error.addClass('invalid-feedback');
           element.closest('.form-group').append(error);
       },
       highlight: function (element, errorClass, validClass) {
           $(element).addClass('is-invalid');
       },
       unhighlight: function (element, errorClass, validClass) {
           $(element).removeClass('is-invalid');
       }
   });
   var Toast = Swal.mixin({
       toast: true,
       position: 'top-end',
       showConfirmButton: false,
       timer: 3000
   });
});