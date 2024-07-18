-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2024 a las 07:53:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `matriculas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscardniEstudiante` (IN `est_dni` VARCHAR(10))   BEGIN
    SELECT e.id,e.dni, e.nombres, e.apellidos 
    FROM estudiantes as e
    WHERE e.dni COLLATE utf8mb4_unicode_ci = est_dni COLLATE utf8mb4_unicode_ci;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscarEstudianteMatriculado` (IN `est_dni` VARCHAR(10))   BEGIN
    SELECT m.estudiante_id, e.nombres, e.apellidos, m.grado_id, g.nombre, m.seccion_id, s.nombre, m.observacion, m.fecha_registro
    FROM estudiantes as e
    INNER JOIN matriculas as m ON m.estudiante_id = e.id
    INNER JOIN grado as g ON g.id = m.grado_id
    INNER JOIN seccion as s ON s.id = m.seccion_id
    WHERE e.dni COLLATE utf8mb4_unicode_ci = est_dni COLLATE utf8mb4_unicode_ci AND 
YEAR(m.fecha_registro) != YEAR(CURRENT_DATE())
ORDER BY m.fecha_registro DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_constanciaAlumno` (IN `ce_id` INT)   BEGIN
SELECT m.estudiante_id, e.nombres, e.apellidos, m.grado_id, g.nombre as grado, m.seccion_id, s.nombre as seccion, m.observacion, m.fecha_registro
    FROM estudiantes as e
    INNER JOIN matriculas as m ON m.estudiante_id = e.id
    INNER JOIN grado as g ON g.id = m.grado_id
    INNER JOIN seccion as s ON s.id = m.seccion_id
WHERE m.id = ce_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_editarApoderado` (IN `id` INT)   BEGIN
  SELECT
  a.id,
  a.ocupacion_id,
  o.nombre AS ocupaciones,
  a.dni,
  a.nombres,
  a.apellidos,
  a.direccion,
  a.celular,
  a.fecha_nacimiento
FROM
  apoderados AS a
INNER JOIN
  ocupacion AS o
ON
  o.id = a.ocupacion_id
WHERE a.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_editarEstudiante` (IN `id` INT)   BEGIN
    SELECT e.id, e.apoderado_id, e.dni, e.nombres,e.apellidos, e.direccion, e.celular, e.fecha_nacimiento 
    FROM estudiantes as e 
    WHERE e.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_editarOcupacion` (IN `id` INT)   BEGIN
SELECT o.id, o.nombre FROM ocupacion as o WHERE o.id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_editarVacantes` (IN `id` INT)   BEGIN 
SELECT v.grado_id, v.seccion_id, v.nro_vacante 
FROM vacantes as v
WHERE v.id = id;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apoderados`
--

CREATE TABLE `apoderados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ocupacion_id` bigint(20) UNSIGNED NOT NULL,
  `dni` int(10) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `fecha_nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `apoderados`
--

INSERT INTO `apoderados` (`id`, `ocupacion_id`, `dni`, `nombres`, `apellidos`, `direccion`, `celular`, `fecha_nacimiento`) VALUES
(1, 1, 12345678, 'JUAN JOSÉ', 'PÉREZ GARCÍA', 'CHIQUITOY - AV. LIMA CUADRA 2', '987654321', '1996-12-12'),
(2, 2, 13456789, 'MARÍA SOFÍA', 'LÓPEZ GÓMEZ', 'CHICAMA - AV. UGARTE LT3', '987654321', '1998-05-14'),
(3, 3, 14567893, 'ANA LUCÍA', 'RODRIGUEZ HERNANDEZ', 'CHIQUITOY - AV. SAN MARTIN MZ 3', '974586412', '1968-11-06'),
(4, 4, 74851246, 'CARLOS ALBERTO', 'MARTINEZ SÁNCHEZ', 'CHIQUITOY - AV. JUAN II MZ 3', '974568123', '1989-08-06'),
(5, 5, 74684625, 'SOFÍA ISABEL', 'CASTILLO	DÍAZ', 'CHIQUITOY - CALLE LIMA LT4', '974584566', '2000-08-12'),
(6, 6, 74584561, 'LUIS ÁNGEL', 'GONZÁLEZ	FERNÁNDEZ', 'CHIQUITOY - CALLE 005', '948563812', '2004-09-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `apoderado_id` bigint(20) UNSIGNED NOT NULL,
  `dni` varchar(10) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `fecha_nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `apoderado_id`, `dni`, `nombres`, `apellidos`, `direccion`, `celular`, `fecha_nacimiento`) VALUES
(1, 1, '12345678', 'JOSÉ MANUEL', 'GÓMEZ	RODRÍGUEZ', 'CHIQUITOY - CALLE 001', '919025290', '2006-04-08'),
(2, 2, '47854265', 'PEDRO	ANTONIO', 'LÓPEZ	MARTÍNEZ', 'CHIQUITOY - CALLE 002', '986578522', '2001-04-08'),
(3, 3, '74584586', 'LAURA	ISABEL', 'PÉREZ	SÁNCHEZ', 'CHIQUITOY - CALLE 004', '985774568', '2003-12-05'),
(4, 4, '58745689', 'DANIEL ALEJANDRO', 'HERNÁNDEZ GÓMEZ', 'CHIQUITOY - CALLE 005', '985774568', '2005-05-06'),
(5, 5, '74584685', 'ROSA MARÍA', 'GARCÍA RODRÍGUEZ', 'CHIQUITOY - CALLE 006', '986578522', '2005-12-12'),
(6, 6, '96587456', 'ANDREA SOFÍA', 'CASTILLO DÍAZ', 'CHIQUITOY - CALLE 007', '999999996', '2008-12-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado`
--

CREATE TABLE `grado` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grado`
--

INSERT INTO `grado` (`id`, `nombre`) VALUES
(1, 'PRIMERO'),
(2, 'SEGUNDO'),
(3, 'TERCERO'),
(4, 'CUARTO'),
(5, 'QUINTO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `grado_id` bigint(20) UNSIGNED NOT NULL,
  `seccion_id` bigint(20) UNSIGNED NOT NULL,
  `observacion` varchar(150) DEFAULT NULL,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`id`, `estudiante_id`, `grado_id`, `seccion_id`, `observacion`, `fecha_registro`) VALUES
(1, 1, 1, 1, 'Sin observaciones', '2023-11-27'),
(2, 2, 2, 2, 'Sin observaciones', '2022-11-27'),
(3, 4, 3, 1, 'Sin observaciones', '2023-11-27'),
(4, 3, 4, 1, 'Sin observaciones', '2023-11-27'),
(5, 5, 5, 2, 'Sin observaciones', '2022-11-27'),
(6, 6, 1, 2, 'Sin observaciones', '2022-11-27'),
(7, 6, 2, 2, 'Sin observaciones', '2023-11-27'),
(8, 2, 5, 2, 'Sin observaciones', '2023-11-27'),
(9, 5, 5, 1, 'Sin observaciones', '2023-11-27'),
(10, 1, 2, 1, 'Sin observaciones', '2024-04-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(26, '2014_10_12_000000_create_users_table', 1),
(27, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(28, '2014_10_12_100000_create_password_resets_table', 1),
(29, '2019_08_19_000000_create_failed_jobs_table', 1),
(30, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocupacion`
--

CREATE TABLE `ocupacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ocupacion`
--

INSERT INTO `ocupacion` (`id`, `nombre`) VALUES
(1, 'ING CIVIL'),
(2, 'MAESTRO'),
(3, 'TRABAJADOR SOCIAL'),
(4, 'POLICÍA'),
(5, 'BOMBERO'),
(6, 'AGRICULTOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id`, `nombre`) VALUES
(1, 'A'),
(2, 'ÚNICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Inactivo',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `estado`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dalton Yndalecio Rodriguez', 'yndaleciorodriguezd@gmail.com', NULL, '$2y$10$CvbcYdTfWrIbytOtZpPzkO0ecPwtpXZuZxV9VVhE3Ln7b1RSkcNoK', 'Inactivo', NULL, '2023-10-20 02:25:21', '2023-10-20 02:25:21'),
(4, 'Elena Díaz Gabriel', 'elena@gmail.com', NULL, '$2y$10$rBVkY095n7RKpPMS651Va.pwPvhg2Si75TI5LU1ulhdN38XVyhB/e', 'Inactivo', NULL, '2023-11-28 05:36:27', '2023-11-28 05:36:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacantes`
--

CREATE TABLE `vacantes` (
  `id` int(10) UNSIGNED NOT NULL,
  `grado_id` bigint(20) UNSIGNED NOT NULL,
  `seccion_id` bigint(20) UNSIGNED NOT NULL,
  `nro_vacante` int(20) NOT NULL DEFAULT 25
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vacantes`
--

INSERT INTO `vacantes` (`id`, `grado_id`, `seccion_id`, `nro_vacante`) VALUES
(1, 1, 1, 34),
(2, 2, 1, 34),
(3, 1, 2, 34),
(4, 2, 2, 33),
(5, 3, 1, 34),
(6, 3, 2, 35),
(7, 4, 1, 34),
(8, 4, 2, 35),
(9, 5, 1, 34),
(10, 5, 2, 33);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apoderados`
--
ALTER TABLE `apoderados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apoderados_ocupacion_id_foreign` (`ocupacion_id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiantes_apoderado_id_foreign` (`apoderado_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `grado`
--
ALTER TABLE `grado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matriculas_estudiante_id_foreign` (`estudiante_id`),
  ADD KEY `matriculas_grado_id_foreign` (`grado_id`),
  ADD KEY `matriculas_seccion_id_foreign` (`seccion_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ocupacion`
--
ALTER TABLE `ocupacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `vacantes`
--
ALTER TABLE `vacantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seccion` (`seccion_id`),
  ADD KEY `vacantes_ibfk_1` (`grado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apoderados`
--
ALTER TABLE `apoderados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grado`
--
ALTER TABLE `grado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `ocupacion`
--
ALTER TABLE `ocupacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `vacantes`
--
ALTER TABLE `vacantes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apoderados`
--
ALTER TABLE `apoderados`
  ADD CONSTRAINT `apoderados_ocupacion_id_foreign` FOREIGN KEY (`ocupacion_id`) REFERENCES `ocupacion` (`id`);

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_apoderado_id_foreign` FOREIGN KEY (`apoderado_id`) REFERENCES `apoderados` (`id`);

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`),
  ADD CONSTRAINT `matriculas_grado_id_foreign` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`),
  ADD CONSTRAINT `matriculas_seccion_id_foreign` FOREIGN KEY (`seccion_id`) REFERENCES `seccion` (`id`);

--
-- Filtros para la tabla `vacantes`
--
ALTER TABLE `vacantes`
  ADD CONSTRAINT `vacantes_ibfk_1` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`),
  ADD CONSTRAINT `vacantes_ibfk_2` FOREIGN KEY (`seccion_id`) REFERENCES `seccion` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
