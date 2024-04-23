@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Apoderados</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Apoderados</li>
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
                <h3 class="card-title">Lista de Apoderados</h3>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <a  class="btn btn-outline-primary btn-sm mr-2 btn-modal" data-modal="Agregar"><i class="fas fa-user-plus"></i> Nuevo Apoderado</a>
                  <a class="btn btn-outline-success btn-sm mr-2" id="modal-listaOcupaciones" ><i class="fas fa-th-list"></i> Lista Ocupaciones</a>          
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbApoderados" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                        <th class="text-center" width="150">OCUPACION</th>
                        <th class="text-center" width="10">DNI</th>
                        <th class="text-center" width="170">NOMBRES</th>
                        <th class="text-center" width="170">APELLIDOS</th>
                        <th class="text-center" width="170">DIRECCION</th>
                        <th class="text-center" width="70">CELULAR</th>
                        <th class="text-center" width="50">F. NAC</th>
                        <th class="text-center" width="50" >EDITAR</th>
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
  <!-- MODAL  APODERADO  -->
<div class="modal fade" id="modalApoderado" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="overlay d-none">
          <i class="fas fa-2x fa-spinner fa-spin"></i>
        </div>
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="titulo"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <!-- general form elements disabled -->
              <div class="card-body">
                <form id="formApoderado">
                  @csrf
                  <div class="row">
                    <div class="col-sm-9">
                        <div class="form-horizontal">
                          <div class="form-group row">
                            <label class="col-sm-2 mt-2">OCUPACION</label>
                            <div class="col-sm-10">
                              <select class="form-control select2" style="width: 65%;" name="ocupacion_id"  id="ocupacion_id"> </select>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label></label>
                        <button type="button" class="btn btn-warning modal-ocupacion" data-ocupacion="Agregar"><i class="fas fa-plus"></i> Nueva Ocupacion</button>             
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text" class="form-control" name="dni" autocomplete="off" id="dni">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombres" autocomplete="off" id="nombres">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" autocomplete="off" id="apellidos">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Direccion</label>
                            <input type="text" class="form-control" name="direccion" autocomplete="off" id="direccion">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Celular</label>
                            <input type="text" class="form-control" name="celular" autocomplete="off" id="celular" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Fecha Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento"  id="fecha_nacimiento">
                        </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnformApoderado">Agregar</button>
              </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- MODAL NUEVA OCUPACION -->
<div class="modal fade" id="modalocupacion" data-backdrop="static" style="z-index: 1051;" data-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="overlay d-none">
        <i class="fas fa-2x fa-spinner fa-spin"></i>
      </div>
      <div class="modal-header bg-warning">
        <h4 class="modal-title" id="tituloOcupacion"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formOcupacion">
              @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Ocupacion</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"  autocomplete="off">
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" id="btn-ocupacion">Guardar</button>
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<! -- MODAL LISTA DE OCUPACIONES -->
<div class="modal fade" id="lista-ocupaciones" data-backdrop="static" style="z-index: 1050;" data-keyboard="false">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="overlay d-none">
        <i class="fas fa-2x fa-spinner fa-spin"></i>
      </div>
      <div class="modal-header">
        <h4 class="modal-title">Ocupaciones</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Lista de Ocupaciones</h3>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-outline-warning btn-sm mr-2 modal-ocupacion" data-ocupacion="Agregar" > + <i class="fas fa-briefcase"></i> Nueva Ocupacion</a>                 
              </div>
          </div>
            <div class="table-responsive">
              <table id="tbOcupaciones" class="table table-bordered table-hover">
                <thead>
                    <tr>
                      <th class="text-center" width="200">Ocupacion</th>
                      <th class="text-center" width="20">Editar</th>
                    </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

@include('layout.footer') 