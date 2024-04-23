@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Matriculas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Matriculas</li>
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
                <h3 class="card-title">Lista de alumnos matriculados</h3>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-outline-primary btn-sm mr-2 modal-matricular" data-modal="Matricular"> + <i class="fas fa-clipboard-list"></i> Nueva Matricula</button>
                <button type="button" class="btn btn-outline-success btn-sm modal-matricular" data-modal="Renovar"><i class="fas fa-undo-alt"></i> Renovar Matricula</button>
              </div>
            </div>
            <div class="card-header">
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Filtar Matriculas por año: </label>
                <div class="col-sm-6">
                  <select  id="selectYear" class="form-control col-sm-3">
                    @foreach($availableYears as $year)
                      <option value="{{ $year->year }}">{{ $year->year }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbMatriculas" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th class="text-center">ESTUDIANTE</th>
                          <th class="text-center">GRADO</th>
                          <th class="text-center" width="50">SECCION</th>
                          <th class="text-center">OBSERVACION</th>
                          <th class="text-center" width="100" >FECHA</th>
                          <th class="text-center" width="50">ACCIONES</th>
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
  <div class="modal fade" id="modalMatricula" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="overlay d-none">
            <i class="fas fa-2x fa-spinner fa-spin"></i>
          </div>
          <div class="modal-header bg-primary">
            <h4 class="modal-title" id="tituloMatricula"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <!-- general form elements disabled -->
                <div class="card-body">
                  <div class="card card-default">
                    <div class="card-header">
                      <h3 class="card-title">Estudiante</h3>
                    </div>
                    <div class="card-body">
                      <form id="buscarDni">
                        <div class="row">
                          <div class="col-1">
                            <label>DNI :</label> 
                          </div>
                          <div class="col-4">
                            <input type="text" class="form-control" name="dni" id="dni" autocomplete="off">
                          </div>
                          <div class="col-sm-4">
                            <button type="button" class="btn btn-info" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>
                            <button type="button" class="btn btn-success d-none" id="btnNuevo"><i class="fas fa-undo-alt"></i> Nuevo</button> 
                          </div>
                        </div>
                      </form>
                      <div class="row">
                        <div class="col-4 d-none" id="divnombres">
                          <label for="">NOMBRES</label>
                          <input type="text" class="form-control" id="nombres" readonly>
                        </div>
                        <div class="col-4 d-none" id="divapellidos">
                          <label for="">APELLIDOS</label>
                          <input type="text" class="form-control" id="apellidos" readonly>
                        </div>
                        <div class="col-4 d-none" id="divhistorial">
                          <label for="">HISTORIAL</label>
                          <select class="form-control" id="AñosEstudio" >
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  
                  <form id="formMatricula">
                    @csrf
                    <div class="row">
                      <div class="col-2" hidden >
                        <label for="">ID</label>
                        <input type="text" class="form-control" id="estudiante_id" name="estudiante_id" readonly>
                      </div>
                      <div class="col-sm-11">
                        <div class="form-horizontal">
                          <div class="form-group row">
                            <label class="col-sm-2 mt-2">GRADO :</label>
                            <div class="col-sm-6">
                              <select class="form-control selectGrado" style="width: 100%;" name="grado_id"  id="grado_id"> </select>
                            </div>
                            <div class="col-sm-4">
                              <button type="button" class="btn btn-outline-info btn-grado-seccion" modal-grado-seccion="Grado" ><i class="fas fa-plus"></i> Nuevo Grado</button> 
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="col-sm-11">
                      <div class="form-horizontal">
                        <div class="form-group row">
                          <label class="col-sm-2 mt-2">SECCION :</label>
                          <div class="col-sm-6">
                            <select class="form-control selectSeccion" style="width: 100%;" name="seccion_id"  id="seccion_id"> </select>
                          </div>
                          <div class="col-sm-4">
                            <button type="button" class="btn btn-outline-info btn-grado-seccion" modal-grado-seccion="Seccion"><i class="fas fa-plus"></i> Nueva Seccion</button> 
                          </div>
                        </div>
                      </div>
                    </div>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>OBSERVACIONES :</label>
                          <textarea class="form-control" placeholder="observacion ..." name="observacion" id="observacion"></textarea>
                        </div>  
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-success d-none" id="btnMatricula"></button>
                </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>

  <!-- MODAL GRADO O SECCION  -->
<div class="modal fade" id="modalGradoSeccion" data-backdrop="static" style="z-index: 1051;" data-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="overlay d-none">
        <i class="fas fa-2x fa-spinner fa-spin"></i>
      </div>
      <div class="modal-header bg-warning">
        <h4 class="modal-title" id="tituloGradoSeccion"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formGradoSeccion">
              @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label" id="lblGradoSeccion"></label>
                    <input type="text" class="form-control" id="gradoseccion" name="gradoseccion"  autocomplete="off">
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" id="btn-grado-seccion">Guardar</button>
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- MODAL DETALLES ALUMNOS -->
<div class="modal fade" id="detallesMataricula" data-backdrop="static" style="z-index: 1051;" data-keyboard="false">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="overlay d-none">
        <i class="fas fa-2x fa-spinner fa-spin"></i>
      </div>
      <div class="modal-header bg-info">
        <h4 class="modal-title">Mas datos de : <strong id="alumnoDetalle"></strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <table>
            <tr>
              <th width="120px"><label class="form-label">DNI :</label></th>
              <td><span id="dtDni"></span></td>
            </tr>
            <tr>
              <th><label class="form-label">Apoderado :</label></th>
              <td><span id="dtApoderado"></span></td>
            </tr>
            <tr>
              <th><label class="form-label">Direccion :</label></th>
              <td><span id="dtDireccion"></span></td>
            </tr>
            <tr>
              <th><label class="form-label">Celular :</label> </th>
              <td><span id="dtCelular"></span></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


@include('layout.footer')
