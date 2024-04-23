<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>MAT - {{ $datos['matricula']->id }}</title>
		<style>
			body {
				font-family: Arial, sans-serif;
				margin: 0;
				padding: 0;
				
			}

			.container {
				max-width: 800px;
				margin: 0 auto;
				padding: 20px;
				
			}

			h1, h2 {
				margin: 0;
				text-align: center;
			}

			h2 {
				font-size: 1.2em;
				margin-top: 20px;
				text-decoration: underline;
			}

			p {
				margin-top: 0;
				line-height: 1.5;
			}

			ul {
				list-style: none;
				padding: 0;
				margin: 0;
				line-height: 1.5;
			}

			li {
				margin-bottom: 10px;
			}

			.footer {
				font-size: 0.8em;
				text-align: center;
				margin-top: 20px;
				border-top: 1px solid #ccc;
				padding-top: 10px;
			}
			/* Centrar la imagen horizontalmente */
			img {
			display: block;
			margin: 0 auto;
			}
			
			/* Hacer la imagen responsive */
			img {
				max-width: 100%;
				height: auto;
			}
			.direccion {
				text-align: center;
			}
			h3 {
				text-align: center;
			}
			.contenido {
			
			margin: 0 auto;
			width: 85%; /* establece un ancho para el elemento contenedor */
			}
			.dia{
				text-align: right;
				padding-right: 50px
			}
			.firma {
			text-align: center;
			margin-top: 30px;
			}
			.firma hr {
			border: none;
			border-top: 1px solid #333;
			width: 35%;
			margin: 0 auto;
			}
			.firma p {
			margin-top: 10px;
			}
		
		</style>
	</head>
	<body>
		<div class="container">
			<header>
			{{--  //<img src="https://i.ibb.co/L0K0nBS/banercole.jpg"/>  --}}
			<img src="dist/img/banerPDF.jpg"/>

				<br>
				<h1>Constancia de Matrícula</h1>
			</header>
			<main>	
				<br><br>
				<p class="direccion">LA DIRECCION  DE LA INSTITUCION EDUCATIVA "C.A.V.M." CHIQUITOY</p>
				<br>
				<h3> HACE CONSTAR:</h3>
				<div class = "contenido">
				<P>Que el estudiante<span><strong> {{ $datos['estudiante']->nombres }}  {{ $datos['estudiante']->apellidos }}</strong></span> se encuentra matriculado en el grado / sección <span><strong>{{ $datos['grado']->nombre }} {{ $datos['seccion']->nombre }}</strong></span> en la I.E "C.A.V.M."
					con codigo de matricula <strong> MAT - {{ $datos['matricula']->id }}</strong></P>
				<p>Se emite la presente constancia de matricula a solicitud del interesado, para los fines que estime por conveniente.</p>
				</div>
				<br><br>
				<div class="dia">
					<p>CHIQUITOY, {{ $datos['matricula']->fecha_registro }}</p>
				</div>
				<br><br>
				<br><br>
				<br><br>
				<div class="firma">
				<hr> <!-- Línea para la firma -->
				<p>Elena Diaz Gabriel</p>
				<p>DIRECTORA</p> <!-- Nombre del director Helena Diaz Gabriel-->
				</div>
				<br><br>
				<br><br>
				<br>
			<footer class="footer">
				<p>I.E Cesar Abraham Vallejo Mendoza - Dirección: Prol. Cajamarca, Chiquitoy, Peru</p>
			</footer>		
			</main>
		</div>
	</body>
	</html>