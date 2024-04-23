
@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Vacantes</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active">Vacantes</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de vacantes</h3>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <button type="button" class="btn btn-outline-primary btn-sm mr-2 modal-vacante" data-modal="Nueva" disabled> + <i class="fas fa-clipboard-list"></i> Registrar Vacante</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbVacantes" class="table table-bordered table-hover text-center">
                  <thead>
                      <tr>
                          <th>GRADO</th>
                          <th>SECCION</th>
                          <th>N° VACANTES</th>
                          <th width="100" >ACCIONES</th>
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
  <div class="modal fade" id="modalVacante" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="overlay d-none">
            <i class="fas fa-2x fa-spinner fa-spin"></i>
          </div>
          <div class="modal-header bg-primary">
            <h4 class="modal-title" id="tituloVacante"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div>
                  <form id="formVacante">
                    @csrf
                    <div class="row">
                      <div class="col-sm-11">
                        <div class="form-horizontal">
                          <div class="form-group row">
                            <label class="col-sm-4 mt-2">GRADO :</label>
                            <div class="col-sm-6">
                              <select class="form-control gradoSelect" style="width: 100%;" name="id_grado"  id="id_grado"> </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="col-sm-11">
                      <div class="form-horizontal">
                        <div class="form-group row">
                          <label class="col-sm-4 mt-2">SECCION :</label>
                          <div class="col-sm-6">
                            <select class="form-control seccionSelect" style="width: 100%;" name="id_seccion"  id="id_seccion"> </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-11">
                      <div class="form-horizontal">
                        <div class="form-group row">
                          <label class="col-sm-4 mt-2">Nro Vacante :</label>
                          <div class="col-sm-6">
                            <input type="number" class="form-control" id="nroVacante" name="nroVacante"  autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-11" id="div-nueva-vacante">
                      <div class="form-horizontal">
                        <div class="form-group row">
                          <label class="col-sm-4 mt-2" id="lblvacanteopcion"></label>
                          <div class="col-sm-6">
                            <input type="number" class="form-control" id="nuevaVacante" name="nuevaVacante"  autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-success" id="btnVacante"></button>
                </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>

{{--  nuevos cambios  --}}
@include('layout.footer')
