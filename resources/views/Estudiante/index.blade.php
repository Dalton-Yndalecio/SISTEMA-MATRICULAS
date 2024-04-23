@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Estudiantes</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Estudiantes</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de Estudiantes</h3>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <button type="button" class="btn btn-outline-primary btn-sm modal-Estudiante" modal-estudiante="Agregar"> + <i class="fas fa-user-graduate"></i> Nuevo Estudiante</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbEstudiantes" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th class="text-center">DNI</th>
                          <th class="text-center">NOMBRES</th>
                          <th class="text-center">APELLIDOS</th>
                          <th class="text-center">DIRECCION</th>
                          <th class="text-center">CELULAR</th>
                          <th class="text-center">F. NAC</th>
                          <th class="text-center">APODERADO</th>
                          <th class="text-center">EDITAR</th>
                      </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- MODAL  ESTUDIANTE  -->
<div class="modal fade" id="modalEstudiante" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="overlay d-none">
          <i class="fas fa-2x fa-spinner fa-spin"></i>
        </div>
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="tituloEstudiante"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <!-- general form elements disabled -->
              <div class="card-body">
                <form id="formEstudiante">
                  @csrf
                  <div class="row">
                    <div class="col-sm-11">
                      <div class="form-horizontal">
                        <div class="form-group row">
                          <label class="col-sm-2 mt-2">APODERADO</label>
                          <div class="col-sm-10">
                            <select class="form-control selectApoderado" style="width: 100%;" name="apoderado_id"  id="apoderado_id"> </select>                          </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text" class="form-control" name="dni" id="dni" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="nombres" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Direccion</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Celular</label>
                            <input type="text" class="form-control" name="celular" id="celular">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Fecha Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
                        </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnEstudiante"></button>
              </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@include('layout.footer') 