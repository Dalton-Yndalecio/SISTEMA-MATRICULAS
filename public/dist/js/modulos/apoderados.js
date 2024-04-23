$(document).ready(function(){
     var tabla = $('#tbApoderados').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/apoderados', 
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
            {data: 'ocupacion'},
            {data: 'dni'},
            {data: 'nombres'},
            {data: 'apellidos'},
            {data: 'direccion'},
            {data: 'celular'},
            {data: 'fecha_nacimiento'},
            {data: 'action', orderable: false},
        ]
    });

    var tablaOcupaciones

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
    $('.select2').select2()

    // --- json que llena lso datos al combo bos de ocupaciones -------
    $("#ocupacion_id").append('<option value="">--------- SELECCIONAR ---------</option>');
    $.get('/apoderados/combo',function(ocupaciones){
        $.each(ocupaciones, function () {
            $("#ocupacion_id").append('<option value="' + this.id + '">' + this.nombre + '</option>');
            
        });
    })

    // ---- INPUT EN MAYUSCULA ---//
    $("#formApoderado input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
       
    });

    $("#formOcupacion input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
    });

    // ------ modal para agregar ocupcion ---- //
    $(".modal-ocupacion").off('click').on('click', function(){
        $("#modalocupacion").modal('toggle');
        var modalocupacion = $(this).attr('data-ocupacion');
        $("#tituloOcupacion").html(modalocupacion + " Ocupacion");
        $("#btn-ocupacion").html(modalocupacion);
        $("#btn-ocupacion").off('click').on('click', function(){
            if ($('#formOcupacion').valid()) {
                var formOcupacion = $("#formOcupacion").serialize();
                if(modalocupacion === "Agregar"){
                    $.ajax({
                        url: "/apoderados/ocupacion",
                        method: "POST",
                        data : formOcupacion,
                        success: function(response){
                            if (response.success) {
                                $("#modalocupacion").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbOcupaciones").DataTable().ajax.reload();
                                $("#ocupacion_id").select2('destroy').empty();
                                // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
                                $('.select2').select2()
                                $("#ocupacion_id").append('<option value="">--------- SELECCIONAR ---------</option>');
                                $.get('/apoderados/combo',function(ocupaciones){
                                    $.each(ocupaciones, function () {
                                        $("#ocupacion_id").append('<option value="' + this.id + '">' + this.nombre + '</option>');
                                        
                                    });
                                })
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
            }
        })
    })

    $("#modal-listaOcupaciones").off('click').on('click', function(){
        $("#lista-ocupaciones").modal('toggle');
        $("#lista-ocupaciones .overlay").removeClass("d-none").show();
        setTimeout(function(){
            $("#lista-ocupaciones .overlay").hide();
        }, 800);
        $(document).on('click','.editar-ocupacion',function(){
            var id = $(this).attr('data-id');
            var modalocupacion = $(this).attr('data-ocupacion');
            $("#tituloOcupacion").html(modalocupacion + " Ocupacion");
            $("#btn-ocupacion").html(modalocupacion);
            $("#modalocupacion").modal('toggle');
            $("#modalocupacion .overlay").removeClass("d-none").show();
            setTimeout(function(){
                $("#modalocupacion .overlay").hide();
            }, 800);
            if (modalocupacion === "Actualizar") {
                $.get('/apoderados/ocupacionEditar/'+id,function(ocupacion){
                    $("#nombre").val(ocupacion[0].nombre);
                })
                $("#btn-ocupacion").off('click').on('click', function(){
                    var formeditocupacion = $("#formOcupacion").serialize();
                    if ($('#formOcupacion').valid()) {
                        $.ajax({
                            url: "/apoderados/actualizarOcupacion/"+ id,
                            method: "POST",
                            data : formeditocupacion,
                            success: function(response){
                                if (response.success) {
                                    $("#modalocupacion").modal('hide');
                                    Toast.fire({icon: 'success', title: response.message})
                                    $("#tbOcupaciones").DataTable().ajax.reload();
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
                })
            }
        })
        if (!tablaOcupaciones) {
            tablaOcupaciones = $('#tbOcupaciones').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/apoderados/listaocupaciones', 
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
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
                    {data: 'nombre'},
                    {data: 'action', orderable: false},
                ]

               
            });
        }
    })
    
    // ---- modal para editar y agregar apoderado .off('click')------
    $(document).on('click', '.btn-modal', function(){
        var id = $(this).attr('data-id');
        var modal = $(this).attr('data-modal')
        $("#titulo").html(modal + " Apoderado");
        $("#btnformApoderado").html(modal);
        $("#modalApoderado").modal('toggle');
        // Desvincular eventos click anteriores para evitar duplicación
        $("#btnformApoderado").off('click').on('click', function(){
            if ($('#formApoderado').valid()) {
                var formApoderados = $("#formApoderado").serialize();
                if (modal === "Agregar") {
                    $.ajax({
                        url: "/apoderados/create",
                        method: "POST",
                        data: formApoderados,
                        success: function(response){
                            if (response.success) {
                                $("#modalApoderado").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbApoderados").DataTable().ajax.reload();
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
                else if (modal === "Editar"){
                    $.ajax({
                        url: "/apoderados/actualizar/"+id,
                        method: "POST",
                        data: formApoderados,
                        success: function(response){
                            if (response.success) {
                                $("#modalApoderado").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbApoderados").DataTable().ajax.reload();
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
            } else {
               return; 
            }
        })
        if (modal === "Editar") {
            $("#modalApoderado .overlay").removeClass("d-none").show();
            setTimeout(function(){
                $("#modalApoderado .overlay").hide();
            }, 800);
            $.get('/apoderados/editar/'+id,function(apoderado){

                $("#id").val(apoderado[0].id);
                $("#ocupacion_id option").each(function () {
                    if ($(this).val() == apoderado[0].ocupacion_id) {
                         $(this).prop("selected", true);
                         $("#ocupacion_id").trigger('change');
                         return false;
                     }
                 });
                $("#dni").val(apoderado[0].dni);
                $("#nombres").val(apoderado[0].nombres);
                $("#apellidos").val(apoderado[0].apellidos);
                $("#direccion").val(apoderado[0].direccion);
                $("#celular").val(apoderado[0].celular);
                $("#fecha_nacimiento").val(apoderado[0].fecha_nacimiento);
            })
        }
    })

    // limpiar datos cuando se cierre el modal
    $('#modalApoderado').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formApoderado').validate().resetForm();
        $('#modalApoderado :input').each(function () {
            $("#titulo").html("");
            $("#btnformApoderado").html("");
            $("#formApoderado")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
        $("#ocupacion_id").select2('destroy').empty();
        // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.select2').select2()
        $("#ocupacion_id").append('<option value="">--------- SELECCIONAR ---------</option>');
        $.get('/apoderados/combo',function(ocupaciones){
            $.each(ocupaciones, function () {
                $("#ocupacion_id").append('<option value="' + this.id + '">' + this.nombre + '</option>');
                
            });
        })
    });
    $('#modalocupacion').on('hidden.bs.modal', function () {
        $('#modalocupacion :input').each(function () {
            $("#formOcupacion")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
            
        });
    });
    // Destruye la instancia de DataTables cuando el modal se oculta
    $('#lista-ocupaciones').on('hidden.bs.modal', function () {
        $(document).off('click', '.editar-ocupacion');
        if (tablaOcupaciones) {
            tablaOcupaciones.destroy();
            tablaOcupaciones = null; // Restablece la variable a null
        }
    });

    // validacion del selectd --/
    $('#ocupacion_id').on('change', function() {
        $('#formApoderado').validate().element('#ocupacion_id');
    });
    $('#formApoderado').validate({
        ignore: [],
        rules: {
            ocupacion_id: {
                required: function() {
                var selectedValue = $('#ocupacion_id').val();
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
            ocupacion_id: {
                required: "Por favor seleccione una ocupacion"
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
    $('#formOcupacion').validate({
        ignore: [],
        rules: {
            nombre: {
                required: true,
            }
        },
        messages: {
            nombre: {
                required: "Por favor ingrese un ocupación",
            }
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