<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD AJAX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .error{
            color: red
        }
    </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <div class="card m-3">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary btn_agregar_curso" type="button" data-bs-toggle="modal"
                        data-bs-target="#curso_modal">Agregar curso</button>
                </div>
            </div>
            <div class="card-body">
                <div id="contenido_tabla">
                    <h1>HOLA MUNDO</h1>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="curso_modal" tabindex="-1" aria-labelledby="curso_modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title_modal">Registrar curso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formulario_curso">
                        @csrf
                        <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                        <input type="hidden" name="id_curso_editar" id="id_curso_editar" value="">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="nombre_curso" class="form-label">Nombre de curso</label>
                                        <input type="text" name="nombre_curso" class="form-control" id="nombre_curso"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">descripcion</label>
                                        <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script>
        //csrf
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            mostrar_lista_cursos();
            //alt +96

            // $("#contenido_tabla").append(tabla);
            $(".btn_agregar_curso").click(function() {
                $("#title_modal").html('Registrar curso');
                $("#tipo_formulario").val(1);
                $("#id_curso_editar").val("");
                console.log("AGREGAR CURSO");
            });

            //VALIDACION
            $("#formulario_curso").validate({
                submitHandler: function(form) {
                    registrar_curso();
                }
            });
        });

        //FUNCIONES
        function mostrar_lista_cursos() {
            //alert("HOLA MUNDO")
            //console.log("LISTAR CURSOS");
            //petición ajax
            $.ajax({
                type: 'POST',
                url: '{{ route('curso.lista') }}',
                dataType: 'json',
                beforeSend: function() {
                    $("#contenido_tabla").html(
                        '<div class="cargando"><i class="fa-solid fa-spinner fa-5x"></i></div>');
                },
                error: function(data) {
                    let errorJson = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorJson.message,
                        footer: '<a href="">Vuelva a intentarlo</a>'
                    })
                },
                success: function(data) {
                    $("#contenido_tabla").html(data.html);
                    btn_editar_curso();
                    btn_eliminar_curso();
                }
            });
        }

        //FUNCION AGREGAR
        function registrar_curso() {
            console.log("REGISTRAR CURSO");
            Swal.fire({
                title: 'Esta seguro?',
                icon: 'warning',
                text: 'Verifique los datos antes de enviar.',
                showCancelButton: true,
                confirmButtonText: 'Si, estoy seguro',
                cancelButtonText: `Cancelar`,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    let token = $('meta[name="csrf-token"]').attr('content');
                    let formElement = document.getElementById("formulario_curso");
                    let formData = new FormData(formElement);
                    return fetch('{{ route('curso.registrar') }}', {
                        method: "POST",
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        }
                    }).then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(text)
                            })
                        } else {
                            return response.json()
                        }
                    }).catch(response => {
                        let texto = JSON.parse(response.toString().substring(7));
                        let mensaje = texto.message;
                        Swal.showValidationMessage(
                            `Error: ${mensaje}`
                        )
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Atención!',
                        icon: 'success',
                        text: 'Se registro correctamente.',
                        confirmButtonText: 'Ok',
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            //const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                // b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((confirmar) => {
                        if (confirmar.isConfirmed || confirmar.dismiss === Swal.DismissReason.timer) {
                            $("#formulario_curso")[0].reset();
                            $("#curso_modal").modal('hide');
                            mostrar_lista_cursos();
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Error de registro', '', 'info')
                }
            })
        }
        //EDITAR CURSO
        function btn_editar_curso() {
            $("#tabla_cursos tbody").on('click', '.btn_editar_curso', function() {
               let id_curso = $(this).attr('data-id-curso');
               $("#tipo_formulario").val(2);
                $("#id_curso_editar").val(id_curso);
               /*console.log("ID_CURSO");
               console.log(id_curso);*/
               $.ajax({
                type: 'POST',
                url: '{{ route('curso.obtener_curso') }}',
                data: {id_curso: id_curso},
                dataType: 'json',
                beforeSend: function() {
                   /* $("#contenido_tabla").html(
                        '<div class="cargando"><i class="fa-solid fa-spinner fa-5x"></i></div>');*/
                },
                error: function(data) {
                    let errorJson = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorJson.message,
                        footer: '<a href="">Vuelva a intentarlo</a>'
                    })
                },
                success: function(data) {
                   console.log(data.curso);
                   let curso = data.curso;
                   $("#title_modal").html('Editar curso');
                   $("#nombre_curso").val(curso.nombre_curso);
                   $("#descripcion").val(curso.descripcion);
                   $("#curso_modal").modal('show');
                }
            });
            })
        }

         //ELIMINAR CURSO
         function btn_eliminar_curso() {
            $("#tabla_cursos tbody").on('click', '.btn_eliminar_curso', function() {
               let id_curso = $(this).attr('data-id-curso');
               console.log("ID_CURSO_ELIMINAR");
               console.log(id_curso);
            })
        }
    </script>
</body>

</html>
