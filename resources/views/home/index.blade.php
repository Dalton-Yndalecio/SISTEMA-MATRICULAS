@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><i class="fas fa-folder"></i> {{ $cantidadApoderados }}</h3>

              <p>Apoderados</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="{{ url('/apoderados')}}" class="small-box-footer">Ver Lista <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><i class="fas fa-folder"></i> {{ $totalEstudiantes }}</h3>

              <p>Estudiantes</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-graduate"></i>
            </div>
            <a href="{{ url('/estudiantes')}}" class="small-box-footer">Ver Lista <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><i class="fas fa-folder"></i> {{ $totalMatriculas}}</h3>

              <p>Matriculas</p>
            </div>
            <div class="icon">
              <i class="fas fa-file-invoice"></i>
            </div>
            <a href="{{ url('/matriculas')}}" class="small-box-footer">Ver Lista <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><i class="fas fa-folder"></i> {{$totalOcupaciones}}</h3>

              <p>Ocupaciones</p>
            </div>
            <div class="icon">
              <i class="fas fa-briefcase"></i>
            </div>
            <a class="small-box-footer"><i class="fas fa-times"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->


      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">Vacantes</h3>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbVacantes" class="table table-bordered table-hover text-center">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>GRADO</th>
                          <th>SECCION</th>
                          <th>N° VACANTES</th>
                          <th width="100" >ACCIONES</th>
                      </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">Estudiantes Matriculados</h3>
                <a href="{{ url('/matriculas')}}">Lista Matricula</a>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold text-lg"><i class="fas fa-user-graduate"></i> <strong id="totalAlumnos"></strong></span>
                  <span>Alumnos</span>
                </p>
                {{--  <p class="ml-auto d-flex flex-column text-right">
                  <span class="text-danger"> Retirados</span>
                  <span class="text-muted" id="retirados" ></span>
                </p>  --}}
              </div>
              <!-- /.d-flex -->

              <div class="position-relative mb-4">
                <canvas id="sales-chart" height="200"></canvas>
              </div>
            </div>
          </div>
          <!-- /.card -->

         
        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>


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
  
@include('layout.footer')

