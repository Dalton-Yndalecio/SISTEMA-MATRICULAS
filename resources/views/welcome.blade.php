<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>César Vallejo | Chiquitoy</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="welcome/assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="welcome/css/styles.css" rel="stylesheet" />
        <!-- Select2 -->
        <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-info">César Vallejo, CHIQUITOY</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    @if (Route::has('login'))
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        @auth
                        <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                      
                            @if (Route::has('register'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                            @endif
                        @endauth
                        <li class="nav-item"><a class="btn btn-info btn-social mx-2" href="https://www.facebook.com/IECESARVALLEJOCHIQUITOY" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    </ul>
                    @endif
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading text-warning">Hola, Bienvenido a</div>
                <div class="masthead-heading text-warning">I.E. César A. Vallejo M.</div>
                <div class="masthead-heading text-warning">Nivel Secundario</div>
            </div>
        </header>
        {{--  <!-- Services-->
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Nosotros</h2>
                    <h3 class="section-subheading text-muted">Institución Eductaiva nivel secundario</h3>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">E-Commerce</h4>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">Responsive Design</h4>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">Web Security</h4>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                    </div>
                </div>
            </div>
        </section>  --}}
        <!-- Team-->
        {{--  <section class="page-section bg-light" id="team">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Team de Desarrollo</h2>
                    <h3 class="section-subheading text-muted">Programadores de sistemas de gestión para la institución educativa de Chiquitoy</h3>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="welcome/assets/img/dalton.png" alt="..." />
                            <h4>Dalton Yndalecio Rodriguez</h4>
                            <p class="text-muted">Ing. Software</p>
                            <a class="btn btn-dark btn-social mx-2" href="https://www.instagram.com/yndalecio_d/" aria-label="Parveen Anand Twitter Profile"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/indalecio.rodriguez.1029" aria-label="Parveen Anand Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="welcome/assets/img/franco.jpg" alt="..." />
                            <h4>Franco Pereda Ibañez</h4>
                            <p class="text-muted">Ing. Software</p>
                            <a class="btn btn-dark btn-social mx-2" href="https://instagram.com/frankito_pereda?igshid=OGQ5ZDc2ODk2ZA==" aria-label="Diana Petersen Twitter Profile"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/franco.peredaibanez" aria-label="Diana Petersen Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="welcome/assets/img/benjamin.jpg" alt="..." />
                            <h4>Benjamin Lizarraga Villanueva</h4>
                            <p class="text-muted">Ing. Software</p>
                            <a class="btn btn-dark btn-social mx-2" href="https://www.instagram.com/b3njaminlizarraga.villanueva/" aria-label="Larry Parker Twitter Profile"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/benjaminmisael.lizarragavillanueva" aria-label="Larry Parker Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="team-member">
                          <img class="mx-auto rounded-circle" src="welcome/assets/img/fabrizio.jpg" alt="..." />
                          <h4>Fabrizio García Reyes</h4>
                          <p class="text-muted">Ing. Software</p>
                          <a class="btn btn-dark btn-social mx-2" href="https://www.instagram.com/garciareyesfabrizio/" aria-label="Larry Parker Twitter Profile"><i class="fab fa-instagram"></i></a>
                          <a class="btn btn-dark btn-social mx-2" href="https://www.facebook.com/fabrizio.garciareyes.7" aria-label="Larry Parker Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                      </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center"><p class="large text-muted">Somos un grupo de estudiantes practicantes de ingeniería de software que desarrollamos el sistema presente como proyecto de innovación para el centro de estudios. Nos apasiona la tecnología y creemos que puede ser un instrumento de cambio positivo. Gracias por visitar nuestra página web. Te invitamos a seguirnos en nuestras redes sociales para conocer más sobre nuestro trabajo y apoyarnos en nuestro proyecto.</p></div>
                </div>
            </div>
        </section>  --}}
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Select2 -->
        <script src="plugins/select2/js/select2.full.min.js"></script>
        <script src="welcome/js/scripts.js"></script>
        <script src="dist/js/modulos/welcome.js"></script>
        <!-- SweetAlert2 -->
        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- Toastr -->
        <script src="plugins/toastr/toastr.min.js"></script>

        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
