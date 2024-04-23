$(document).ready(function(){
    var tabla;

    function loadDataTable(selectedYear) {
        tabla = $('#tbMatriculas').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/matriculas',
                data: function (d) {
                    d.selectedYear = selectedYear;
                }
            },
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
                {data: 'estudiante'},
                {data: 'grado'},
                {data: 'seccion'},
                {data: 'observacion'},
                {data: 'fecha_registro'},
                {data: 'action', orderable: false},
            ]
        });
    }

    // Carga la tabla con el año seleccionado al cargar la página
    loadDataTable($('#selectYear').val());

    // Maneja el cambio en el select
    $('#selectYear').on('change', function () {
        tabla.destroy(); // Destruye la tabla actual
        loadDataTable($(this).val()); // Carga la tabla con el nuevo año seleccionado
    });
   // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
   $('.selectGrado').select2()
   // --- json que llena lso datos al combo bos de ocupaciones -------
   $("#grado_id").append('<option value="">-- SELECCIONAR --</option>');
   $.get('/matriculas/selectGrado',function(estudiante){
       $.each(estudiante, function () {
           $("#grado_id").append('<option value="' + this.id + '">'+ this.nombre +'</option>');
           
       });
   })
   // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
   $('.selectSeccion').select2()
   // --- json que llena lso datos al combo bos de ocupaciones -------
   $("#seccion_id").append('<option value="">-- SELECCIONAR --</option>');
   $.get('/matriculas/selectSeccion',function(estudiante){
       $.each(estudiante, function () {
           $("#seccion_id").append('<option value="' + this.id + '">' + this.nombre +'</option>');
           
       });
   })
   $(".modal-matricular").off('click').on('click', function(){
    var operacion = $(this).attr('data-modal')
    $("#buscardni").removeClass("d-none");
    if(operacion === 'Matricular'){
        $("#tituloMatricula").html(operacion + ' nuevo Estudiante')
    }
    else if(operacion === 'Renovar'){
        $("#tituloMatricula").html(operacion + ' matricula Estudiante')
    }
    $("#btnMatricula").html(operacion)
    $("#modalMatricula").modal('toggle');
    $("#btnBuscar").off('click').on('click', function () {
        if ($('#buscarDni').valid()) {
            var dni = $("#dni").val();
            if(operacion === 'Matricular'){
                $.get('/matriculas/buscardni/'+dni,function(estudiante){
                    if (estudiante.error) {
                        Toast.fire({icon: 'warning', title:  estudiante.error})
                    } else {
                        // Si se encontró un estudiante, muestra los datos
                        $("#divnombres").removeClass("d-none");
                        $("#divapellidos").removeClass("d-none");
                        $("#dni").prop('readonly', true);
                        $("#estudiante_id").val(estudiante.estudiante.id);
                        $("#nombres").val(estudiante.estudiante.nombres);
                        $("#apellidos").val(estudiante.estudiante.apellidos);
                        $("#btnNuevo").removeClass("d-none");
                        $("#btnBuscar").addClass("d-none");
                        if ($("#estudiante_id").val() !== '') {
                            $("#btnMatricula").removeClass("d-none");
                        }
                        $("#btnNuevo").off('click').on('click', function(){
                            $("#dni").prop('readonly', false);
                            $("#dni").val('');
                            $("#estudiante_id").val('');
                            $("#nombres").val('');
                            $("#apellidos").val('');
                            $("#divnombres").addClass("d-none");
                            $("#divapellidos").addClass("d-none");
                            $("#btnNuevo").addClass("d-none");
                            $("#btnBuscar").removeClass("d-none");
                            $("#btnMatricula").addClass("d-none");
                            $("#seccion_id").select2('destroy').empty();
                            // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
                            $('.selectGrado').select2()
                            // --- json que llena lso datos al combo bos de ocupaciones -------
                            $("#grado_id").append('<option value="">-- SELECCIONAR --</option>');
                            $.get('/matriculas/selectGrado',function(estudiante){
                                $.each(estudiante, function () {
                                    $("#grado_id").append('<option value="' + this.id + '">'+ this.nombre +'</option>');
                                    
                                });
                            })
                            // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
                            $('.selectSeccion').select2()
                            // --- json que llena lso datos al combo bos de ocupaciones -------
                            $("#seccion_id").append('<option value="">-- SELECCIONAR --</option>');
                            $.get('/matriculas/selectSeccion',function(estudiante){
                                $.each(estudiante, function () {
                                    $("#seccion_id").append('<option value="' + this.id + '">' + this.nombre +'</option>');
                                    
                                });
                            })
                        })
    
                    }
                })
            }
            else if(operacion === 'Renovar'){
                $.get('/matriculas/buscardniMatriculado/'+dni,function(estudiante){
                    if (estudiante.error) {
                        Toast.fire({icon: 'warning', title:  estudiante.error})
                    } else {
                        // Si se encontró un estudiante, muestra los datos
                        $("#divnombres").removeClass("d-none");
                        $("#divapellidos").removeClass("d-none");
                        $("#divhistorial").removeClass("d-none");
                        $("#dni").prop('readonly', true);
                        $("#estudiante_id").val(estudiante.estudiante.estudiante_id);
                        $("#nombres").val(estudiante.estudiante.nombres);
                        $("#apellidos").val(estudiante.estudiante.apellidos);
                        // Seleccionar el grado del estudiante
                        $("#grado_id").val(estudiante.estudiante.grado_id);
                        // Seleccionar la sección del estudiante
                        $("#seccion_id").val(estudiante.estudiante.seccion_id);
                        $("#observacion").val(estudiante.estudiante.observacion);
                        // Actualizar el select2 para reflejar los valores seleccionados
                        $("#grado_id").trigger('change');
                        $("#seccion_id").trigger('change');
                        if ($("#estudiante_id").val() !== '') {
                            $("#btnMatricula").removeClass("d-none");
                        }
                            var cmbYears = document.getElementById('AñosEstudio');
                            cmbYears.innerHTML = '';
                            estudiante.years.forEach(function(year) {
                                var option = document.createElement('option');
                                option.value = year;
                                option.text = year;
                                cmbYears.appendChild(option);
                            });
                        $("#btnNuevo").removeClass("d-none");
                        $("#btnBuscar").addClass("d-none");
                        $("#btnNuevo").off('click').on('click', function(){
                            $("#dni").prop('readonly', false);
                            $("#dni").val('');
                            $("#estudiante_id").val('');
                            $("#nombres").val('');
                            $("#apellidos").val('');
                            $("#AñosEstudio").val('');
                            $("#divnombres").addClass("d-none");
                            $("#divapellidos").addClass("d-none");
                            $("#divhistorial").addClass("d-none");
                            $("#btnNuevo").addClass("d-none");
                            $("#btnBuscar").removeClass("d-none");
                            $("#btnMatricula").addClass("d-none");
                            $("#grado_id").select2('destroy').empty();
                            $("#seccion_id").select2('destroy').empty();
                            // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
                            $('.selectGrado').select2()
                            // --- json que llena lso datos al combo bos de ocupaciones -------
                            $("#grado_id").append('<option value="">-- SELECCIONAR --</option>');
                            $.get('/matriculas/selectGrado',function(estudiante){
                                $.each(estudiante, function () {
                                    $("#grado_id").append('<option value="' + this.id + '">'+ this.nombre +'</option>');
                                    
                                });
                            })
                            // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
                            $('.selectSeccion').select2()
                            // --- json que llena lso datos al combo bos de ocupaciones -------
                            $("#seccion_id").append('<option value="">-- SELECCIONAR --</option>');
                            $.get('/matriculas/selectSeccion',function(estudiante){
                                $.each(estudiante, function () {
                                    $("#seccion_id").append('<option value="' + this.id + '">' + this.nombre +'</option>');
                                    
                                });
                            })
                        })
    
                    }
                })
            }
            
        }
    })
   })

   $("#btnMatricula").off('click').on('click', function(){
    if ($('#formMatricula').valid()) {
        var formMatricula = $("#formMatricula").serialize();
        $.ajax({
            url: "/matriculas/create",
            method: "POST",
            data: formMatricula,
            success: function(response){
                if (response.success) {
                    $("#modalMatricula").modal('hide');
                    Toast.fire({icon: 'success', title: response.message})
                    $("#tbMatriculas").DataTable().ajax.reload();
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
   // limpiar datos cuando se cierre el modal
   $('#modalMatricula').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formMatricula').validate().resetForm();
        $('#buscarDni').validate().resetForm();
        $('#modalMatricula :input').each(function () {
            $("#tituloMatricula").html('')
            $("#btnMatricula").html('')
            $("#divhistorial").addClass("d-none");
            $("#divnombres").addClass("d-none");
            $("#divapellidos").addClass("d-none");
            $("#formMatricula")[0].reset();
            $("#buscarDni")[0].reset();
            $("#dni").val('');
            $("#estudiante_id").val('');
            $("#nombres").val('');
            $("#apellidos").val('');
            $("#dni").prop('readonly', false);
            $("#btnNuevo").addClass("d-none");
            $("#btnBuscar").removeClass("d-none");
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
        $("#grado_id").select2('destroy').empty();
        $("#seccion_id").select2('destroy').empty();
        // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.selectGrado').select2()
        // --- json que llena lso datos al combo bos de ocupaciones -------
        $("#grado_id").append('<option value="">-- SELECCIONAR --</option>');
        $.get('/matriculas/selectGrado',function(estudiante){
            $.each(estudiante, function () {
                $("#grado_id").append('<option value="' + this.id + '">'+ this.nombre +'</option>');
                
            });
        })
        // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.selectSeccion').select2()
        // --- json que llena lso datos al combo bos de ocupaciones -------
        $("#seccion_id").append('<option value="">-- SELECCIONAR --</option>');
        $.get('/matriculas/selectSeccion',function(estudiante){
            $.each(estudiante, function () {
                $("#seccion_id").append('<option value="' + this.id + '">' + this.nombre +'</option>');
                
            });
        })
    });

    $(".btn-grado-seccion").off('click').on('click', function(){
        var accion = $(this).attr('modal-grado-seccion');
        $("#tituloGradoSeccion").html('Registrar ' + accion)
        $("#lblGradoSeccion").html(accion)
        $("#modalGradoSeccion").modal('toggle');
        $("#btn-grado-seccion").off('click').on('click', function(){
            if ($('#formGradoSeccion').valid()) {
                var form_grado_seccion = $("#formGradoSeccion").serialize();
                if(accion === 'Grado'){
                    $.ajax({
                        url: "/matriculas/addgrado",
                        method: "POST",
                        data: form_grado_seccion,
                        success : function(response){
                            if (response.success) {
                                $("#modalGradoSeccion").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#grado_id").select2('destroy').empty();
                                // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
                                $('.selectGrado').select2()
                                // --- json que llena lso datos al combo bos de ocupaciones -------
                                $("#grado_id").append('<option value="">-- SELECCIONAR --</option>');
                                $.get('/matriculas/selectGrado',function(estudiante){
                                    $.each(estudiante, function () {
                                        $("#grado_id").append('<option value="' + this.id + '">'+ this.nombre +'</option>');
                                        
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
                else if(accion === 'Seccion'){
                    $.ajax({
                        url: "/matriculas/addseccion",
                        method: "POST",
                        data: form_grado_seccion,
                        success : function(response){
                            if (response.success) {
                                $("#modalGradoSeccion").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#seccion_id").select2('destroy').empty();
                                $('.selectSeccion').select2()
                                // --- json que llena lso datos al combo bos de ocupaciones -------
                                $("#seccion_id").append('<option value="">-- SELECCIONAR --</option>');
                                $.get('/matriculas/selectSeccion',function(estudiante){
                                    $.each(estudiante, function () {
                                        $("#seccion_id").append('<option value="' + this.id + '">' + this.nombre +'</option>');
                                        
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
    $('#modalGradoSeccion').on('hidden.bs.modal', function () {
        $('#modalGradoSeccion :input').each(function () {
            $("#formGradoSeccion")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
            
        });
    });

    $(document).on('click', '.btn-constancia', function(){
        var id = $(this).attr('data-id');
        $.get('/matriculas/constancia/'+id,function(){

            window.open('/matriculas/constancia/'+id);
            //window.open('/OrdenServicioAuto/OrdenServicioPdf?IdOrden=' + idOrden);
        })
    })
    $(document).on('click', '.btn-detalles', function(){
        var id = $(this).attr('data-id');
        $("#detallesMataricula").modal('toggle');
        $.get('/matriculas/detalles/'+id,function(detalle){
            $("#alumnoDetalle").html(detalle.estudiante.nombre + ' ' + detalle.estudiante.apellido);
            $("#dtDni").html(detalle.estudiante.dni);
            $("#dtApoderado").html(detalle.apoderado.nombre + ' ' + detalle.apoderado.apellido);
            $("#dtDireccion").html(detalle.estudiante.direccion);
            $("#dtCelular").html(detalle.estudiante.celular);
        })
    })

    $("#formGradoSeccion input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
    });


    // validacion del selectd --/
    $('#estudiante_id').on('change', function() {
        $('#formMatricula').validate().element('#estudiante_id');
    });
    
    // validacion del selectd --/
    $('#grado_id').on('change', function() {
        $('#formMatricula').validate().element('#grado_id');
    });
    
    // validacion del selectd --/
    $('#seccion_id').on('change', function() {
        $('#formMatricula').validate().element('#seccion_id');
    });
    $('#formMatricula').validate({
        ignore: [],
        rules: {
            estudiante_id: {
                required: function() {
                var selectedValue = $('#estudiante_id').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            grado_id: {
                required: function() {
                var selectedValue = $('#grado_id').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            seccion_id: {
                required: function() {
                var selectedValue = $('#seccion_id').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            
        },
        messages: {
            estudiante_id: {
                required: "Por favor seleccione un Estudiante"
            },
            grado_id: {
                required: "Por favor seleccione un Grado"
            },
            seccion_id: {
                required: "Por favor seleccione una Seccion"
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
    $('#buscarDni').validate({
        ignore: [],
        rules: {
            dni: {
                required: true,
                minlength: 8,
                maxlength: 8,
                
            },
            
        },
        messages: {
            dni: {
                required: "Por favor ingrese número de DNI",
                minlength: "El DNI debe tener 8 caracteres",
                maxlength: "El DNI debe tener solo 8 caracteres",
               
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
    $('#formGradoSeccion').validate({
        ignore: [],
        rules: {
            gradoseccion: {
                required: true,
            }
        },
        messages: {
            gradoseccion: {
                required: "No puede registar un campo vacio",
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

})