$(document).ready(function(){
    var tabla = $('#tbVacantes').DataTable({
        processing: true,
        serverSide: true,
        scrollCollapse: true,
        scrollY: '160px',
        ajax: '/home', 
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
            {data: 'id'}, 
            {data: 'grado'}, 
            {data: 'seccion'},
            {data: 'nro_vacante'},
            {data: 'action', orderable: false},
        ]
    });

    // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
   $('.gradoSelect').select2()
   // --- json que llena lso datos al combo bos de ocupaciones -------
   $("#id_grado").append('<option value="">-- SELECCIONAR --</option>');
   $.get('/matriculas/selectGrado',function(estudiante){
       $.each(estudiante, function () {
           $("#id_grado").append('<option value="' + this.id + '">'+ this.nombre +'</option>');
           
       });
   })
   // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
   $('.seccionSelect').select2()
   // --- json que llena lso datos al combo bos de ocupaciones -------
   $("#id_seccion").append('<option value="">-- SELECCIONAR --</option>');
   $.get('/matriculas/selectSeccion',function(estudiante){
       $.each(estudiante, function () {
           $("#id_seccion").append('<option value="' + this.id + '">' + this.nombre +'</option>');
           
       });
   })

    $(document).on('click', '.modal-vacante', function(){
        var id = $(this).attr('data-id');
        var modal = $(this).attr('data-modal')
        $("#tituloVacante").html(modal + " Vacantes");
        $("#lblvacanteopcion").html(modal + " Vacantes");
        if(modal === 'Nueva'){
            $("#div-nueva-vacante").addClass('d-none');
            $("#id_grado").prop('disabled', false);
            $("#id_seccion").prop('disabled', false);
            $("#nroVacante").prop('readonly', false);
        }   
        if(modal === 'Agregar' || modal === 'Restar'){
            $("#div-nueva-vacante").removeClass('d-none');
            $("#id_grado").prop('disabled', true);
            $("#id_seccion").prop('disabled', true);
            $("#nroVacante").prop('readonly', true);
        }
        $("#btnVacante").html(modal);
        $("#modalVacante").modal('toggle');
        if (modal === 'Agregar' || modal === 'Restar') {
            $("#modalVacante .overlay").removeClass("d-none").show();
            setTimeout(function(){
                $("#modalVacante .overlay").hide();
            }, 800);
            $.get('/vacantes/editar/'+id,function(vacante){
                $("#id_grado option").each(function () {
                    if ($(this).val() == vacante[0].grado_id) {
                         $(this).prop("selected", true);
                         $("#id_grado").trigger('change');
                         return false;
                     }
                 });
                 $("#id_seccion option").each(function () {
                    if ($(this).val() == vacante[0].seccion_id) {
                         $(this).prop("selected", true);
                         $("#id_seccion").trigger('change');
                         return false;
                     }
                 });
                $("#nroVacante").val(vacante[0].nro_vacante);
            })
        }
        // Desvincular eventos click anteriores para evitar duplicación
        $("#btnVacante").off('click').on('click', function(){
            if ($('#formVacante').valid()) {
                var formVacantes = $("#formVacante").serialize();
                if (modal === "Nueva") {
                    $.ajax({
                        url: "/vacantes/agregar",
                        method: "POST",
                        data: formVacantes,
                        success: function(response){
                            if (response.success) {
                                $("#modalVacante").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbVacantes").DataTable().ajax.reload();
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
                else if (modal === "Agregar"){
                    $.ajax({
                        url: "/vacantes/aumentar/"+id,
                        method: "POST",
                        data: formVacantes,
                        success: function(response){
                            if (response.success) {
                                $("#modalVacante").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbVacantes").DataTable().ajax.reload();
                            } else {
                                Toast.fire({icon: 'warning', title: response.message})
                            }
                        },
                        error: function(error){
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'ERROR!',
                                subtitle: 'Cerrar',
                                body: 'No se pudo agregar registro, ocurrió algo inseperado'
                            })
                        }
                    })
                }
                else if (modal === "Restar"){
                    $.ajax({
                        url: "/vacantes/restar/"+id,
                        method: "POST",
                        data: formVacantes,
                        success: function(response){
                            if (response.success) {
                                $("#modalVacante").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbVacantes").DataTable().ajax.reload();
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
            } else {
               return; 
            }
        })
        
    })
    $('#modalVacante').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formVacante').validate().resetForm();
        $('#modalVacante :input').each(function () {
            $("#tituloVacante").html('')
            $("#btnVacante").html('')
            $("#div-nueva-vacante").addClass('d-none');
            $("#id_grado").prop('disabled', false);
            $("#id_seccion").prop('disabled', false);
            $("#nroVacante").prop('readonly', false);
            $("#formVacante")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
        $("#id_grado").select2('destroy').empty();
        $("#id_seccion").select2('destroy').empty();
         // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.gradoSelect').select2()
        // --- json que llena lso datos al combo bos de ocupaciones -------
        $("#id_grado").append('<option value="">-- SELECCIONAR --</option>');
        $.get('/matriculas/selectGrado',function(estudiante){
            $.each(estudiante, function () {
                $("#id_grado").append('<option value="' + this.id + '">'+ this.nombre +'</option>');
                
            });
        })
        // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.seccionSelect').select2()
        // --- json que llena lso datos al combo bos de ocupaciones -------
        $("#id_seccion").append('<option value="">-- SELECCIONAR --</option>');
        $.get('/matriculas/selectSeccion',function(estudiante){
            $.each(estudiante, function () {
                $("#id_seccion").append('<option value="' + this.id + '">' + this.nombre +'</option>');
                
            });
        })

    });

    // validacion del selectd --/
    $('#id_grado').on('change', function() {
        $('#formVacante').validate().element('#id_grado');
    });
    
    // validacion del selectd --/
    $('#id_seccion').on('change', function() {
        $('#formVacante').validate().element('#id_seccion');
    });
    $('#formVacante').validate({
        ignore: [],
        rules: {
            id_grado: {
                required: function() {
                var selectedValue = $('#id_grado').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            id_seccion: {
                required: function() {
                var selectedValue = $('#id_seccion').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            nroVacante:{
                required: true,
            },
            
        },
        messages: {
            id_grado: {
                required: "Por favor seleccione un Grado"
            },
            id_seccion: {
                required: "Por favor seleccione una Seccion"
            },
            nroVacante:{
                required: "Por favor ingrese las vacantes disponibles"
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

})