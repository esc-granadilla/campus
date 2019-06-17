-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-06-2019 a las 22:22:57
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `esc-granadilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id`, `nombre`, `teacher_id`, `section_id`, `subject_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Ciencias 1-1', 1, 1, 1, 1, '2019-05-29 04:23:15', '2019-05-29 04:23:15'),
(2, 'Matematicas 1-2', 3, 2, 8, 0, '2019-05-29 04:30:11', '2019-05-29 04:39:29'),
(3, 'Matematicas 1-1', 1, 1, 8, 1, '2019-06-03 22:24:08', '2019-06-03 22:24:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days`
--

CREATE TABLE `days` (
  `id` int(10) UNSIGNED NOT NULL,
  `dia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `days`
--

INSERT INTO `days` (`id`, `dia`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Lunes', 1, NULL, NULL),
(2, 'Martes', 1, NULL, NULL),
(3, 'Miercoles', 1, NULL, NULL),
(4, 'Jueves', 1, NULL, NULL),
(5, 'Viernes', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `files`
--

INSERT INTO `files` (`id`, `titulo`, `tipo`, `link`, `news_id`, `created_at`, `updated_at`) VALUES
(15, 'lolis', 'imagen', '/storage/imagen/0Vw4KPXFuJCoA0dMZHkjHnYCEQjX6mcJKs0BcIG1.jpeg', 1, '2019-06-11 07:08:41', '2019-06-11 07:08:41'),
(16, 'lolis2', 'imagen', '/storage/imagen/SfLvTMDFG0bQ1v46tebr5HUHmYcIrB5soN7G7I1b.jpeg', 1, '2019-06-11 07:08:41', '2019-06-11 07:08:41'),
(17, 'loli', 'imagen', '/storage/imagen/sZnrIhj7h5lqY7LxQ8hCG9dQUYAkxZd5bqe5gfo9.jpeg', 1, '2019-06-11 07:08:41', '2019-06-11 07:08:41'),
(19, 'loli', 'imagen', '/storage/imagen/qaWsmrLUYS5SurNGCmUNWAZ1Q1QZgUtm8Bu08Xtr.jpeg', 6, '2019-06-11 07:10:20', '2019-06-11 07:10:20'),
(23, 'nueva', 'imagen', '/storage/imagen/eU2SJm5y52O9oqTE2DzS6yv8rLucAANB4D7BfOZ2.jpeg', 7, '2019-06-11 07:33:27', '2019-06-11 07:33:27'),
(24, 'ultima', 'imagen', '/storage/imagen/OCRqyMK4pMmVm7xtBy48Xiy8qRAQ0Bfyrn5qKzGX.jpeg', 7, '2019-06-11 07:33:27', '2019-06-11 07:33:27'),
(26, 'Teminite - Firepower', 'video', 'https://www.youtube.com/embed/IbmAF99xgDM', 8, '2019-06-13 08:48:53', '2019-06-13 08:48:53'),
(27, 'Teminite - Shockwave', 'video', 'https://www.youtube.com/embed/qva3Eep9zeY', 9, '2019-06-13 08:53:03', '2019-06-13 08:53:03'),
(28, 'Teminite - Firepower', 'video', 'https://www.youtube.com/embed/IbmAF99xgDM', 9, '2019-06-13 08:53:03', '2019-06-13 08:53:03'),
(29, 'video', 'video', 'https://www.youtube.com/embed/S8r0FYzioXU', 10, '2019-06-13 10:26:38', '2019-06-13 10:26:38'),
(30, 'perros link', 'archivo', 'https://es.wikipedia.org/wiki/Canis_lupus_familiaris', 10, '2019-06-13 10:26:38', '2019-06-13 10:26:38'),
(31, 'gatos', 'archivo', 'https://elpais.com/elpais/2019/06/10/ciencia/1560161808_923748.html', 10, '2019-06-13 10:26:38', '2019-06-13 10:26:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grades`
--

CREATE TABLE `grades` (
  `id` int(10) UNSIGNED NOT NULL,
  `grado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grades`
--

INSERT INTO `grades` (`id`, `grado`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Primero', 1, NULL, NULL),
(2, 'Segundo', 1, NULL, NULL),
(3, 'Tercero', 1, NULL, NULL),
(4, 'Cuarto', 1, NULL, NULL),
(5, 'Quinto', 1, NULL, NULL),
(6, 'Sexto', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guardians`
--

CREATE TABLE `guardians` (
  `id` int(10) UNSIGNED NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primer_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parentesco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `guardians`
--

INSERT INTO `guardians` (`id`, `cedula`, `nombre`, `primer_apellido`, `segundo_apellido`, `parentesco`, `telefono`, `email`, `created_at`, `updated_at`) VALUES
(1, 664444643, 'edgar antonio', 'campos', 'mora', 'padredefam', '88888888', 'edgar@gmail.com', '2019-05-27 05:01:43', '2019-05-27 05:01:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lessons`
--

CREATE TABLE `lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `schedule_id` int(10) UNSIGNED NOT NULL,
  `day_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `schedule_id`, `day_id`, `created_at`, `updated_at`) VALUES
(17, 1, 1, 1, '2019-05-30 07:14:30', '2019-05-30 07:14:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_03_14_190800_create_roles_table', 1),
(4, '2019_03_14_191514_create_role_user_table', 1),
(5, '2019_05_26_073000_create_guardians_table', 1),
(6, '2019_05_26_192341_create_grades_table', 1),
(7, '2019_05_26_192645_create_teachers_table', 1),
(8, '2019_05_26_192707_create_days_table', 1),
(9, '2019_05_26_192717_create_schedules_table', 1),
(10, '2019_05_26_192804_create_subjects_table', 1),
(11, '2019_05_26_193630_create_sections_table', 1),
(12, '2019_05_26_194154_create_students_table', 1),
(13, '2019_05_26_194854_create_courses_table', 1),
(14, '2019_05_26_195649_create_lessons_table', 1),
(18, '2019_05_26_201931_create_qualifications_table', 2),
(26, '2019_05_26_203045_create_news_table', 3),
(27, '2019_06_03_133533_create_tasks_table', 3),
(28, '2019_06_03_133603_create_questions_table', 3),
(29, '2019_06_03_133611_create_taskhistories_table', 3),
(31, '2019_06_09_140707_create_files_table', 4),
(32, '2019_06_11_131751_add_foto_to_teachers_table', 5),
(33, '2019_06_11_131827_add_foto_to_students_table', 5),
(34, '2019_06_16_121758_add_puntaje_to_taskhistories_table', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `contenido` longtext COLLATE utf8mb4_unicode_ci,
  `tipo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Global',
  `fecha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `news`
--

INSERT INTO `news` (`id`, `titulo`, `descripcion`, `contenido`, `tipo`, `fecha`, `estado`, `course_id`, `created_at`, `updated_at`) VALUES
(1, 'Lolis', 'imagenes de loli', NULL, 'Global', 'Monday 10 June 2019 18:58:02', 1, NULL, '2019-06-11 00:58:02', '2019-06-11 00:58:02'),
(4, 'Nueva tareas', 'relleno', 'contenido', 'Global', 'Monday 10 June 2019 20:01:35', 1, NULL, '2019-06-11 02:01:35', '2019-06-11 07:08:00'),
(6, 'prueba', 'lolis', NULL, 'Global', 'Tuesday 11 June 2019 00:48:39', 1, NULL, '2019-06-11 06:48:39', '2019-06-11 07:07:41'),
(7, 'Lolis', 'mis lolis', NULL, 'Grupal', 'Tuesday 11 June 2019 01:33:13', 1, 3, '2019-06-11 07:33:13', '2019-06-11 07:33:13'),
(8, 'Videos prueba', NULL, NULL, 'Global', 'Thursday 13 June 2019 02:48:53', 1, NULL, '2019-06-13 08:48:53', '2019-06-13 08:48:53'),
(9, 'video prueba 2', NULL, NULL, 'Global', 'Thursday 13 June 2019 02:53:03', 1, NULL, '2019-06-13 08:53:03', '2019-06-13 08:53:03'),
(10, 'noticias', NULL, NULL, 'Global', 'Thursday 13 June 2019 04:26:37', 1, NULL, '2019-06-13 10:26:37', '2019-06-13 10:26:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `qualifications`
--

CREATE TABLE `qualifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_porcentual` decimal(6,2) NOT NULL,
  `porcentaje_obtenido` decimal(6,2) NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'realizada',
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trimestre` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `qualifications`
--

INSERT INTO `qualifications` (`id`, `titulo`, `valor_porcentual`, `porcentaje_obtenido`, `tipo`, `condicion`, `descripcion`, `trimestre`, `fecha`, `student_id`, `course_id`, `estado`, `created_at`, `updated_at`) VALUES
(9, '1 Examen', '25.00', '22.22', 'Examen', 'Aprobada', 'Primer parcial 2 trimestre', 2, '2019-04-08', 6, 1, 1, '2019-06-03 03:41:43', '2019-06-03 03:41:43'),
(10, '1 Examen', '25.00', '21.11', 'Examen', 'Aprobada', 'primer parcia 2 cuatrimestre', 2, '2019-04-09', 1, 1, 1, '2019-06-03 03:43:17', '2019-06-03 03:43:17'),
(11, 'Examen 1', '25.00', '12.00', 'Examen', 'Reprobada', 'Matematicas basicas', 1, '2019-06-04', 1, 3, 1, '2019-06-11 09:51:34', '2019-06-11 09:51:34'),
(12, 'Examen 1', '25.00', '20.00', 'Examen', 'Aprobada', 'Matematicas basicas', 1, '2019-06-04', 6, 3, 1, '2019-06-11 09:51:34', '2019-06-11 09:51:34'),
(13, 'Examen 2', '25.00', '22.00', 'Examen', 'Aprobada', 'Matematicas basicas', 1, '2019-06-14', 1, 3, 1, '2019-06-14 06:51:00', '2019-06-14 06:51:00'),
(14, 'Examen 2', '25.00', '22.00', 'Examen', 'Aprobada', 'Matematicas basicas', 1, '2019-06-14', 6, 3, 1, '2019-06-14 06:51:00', '2019-06-14 06:51:00'),
(15, 'Tarea 1', '10.00', '6.00', 'Tarea', 'Realisada', 'tarea de matematicas', 1, '2019-06-14', 1, 3, 1, '2019-06-14 06:52:42', '2019-06-14 06:52:42'),
(16, 'Tarea 1', '10.00', '7.00', 'Tarea', 'Realisada', 'tarea de matematicas', 1, '2019-06-14', 6, 3, 1, '2019-06-14 06:52:42', '2019-06-14 06:52:42'),
(17, 'Tarea 2', '10.00', '7.00', 'Tarea', 'Realisada', 'calculo simple', 1, '2019-06-14', 1, 3, 1, '2019-06-14 06:54:13', '2019-06-14 06:54:13'),
(18, 'Tarea 2', '10.00', '6.00', 'Tarea', 'Realisada', 'calculo simple', 1, '2019-06-14', 6, 3, 1, '2019-06-14 06:54:13', '2019-06-14 06:54:13'),
(19, 'Investigacion de Operaciones', '15.00', '12.00', 'Trabajo o investigación', 'Realisada', 'busqueda de operaciones matematicos', 1, '2019-06-14', 1, 3, 1, '2019-06-14 06:55:18', '2019-06-14 06:55:18'),
(20, 'Investigacion de Operaciones', '15.00', '13.00', 'Trabajo o investigación', 'Realisada', 'busqueda de operaciones matematicos', 1, '2019-06-14', 6, 3, 1, '2019-06-14 06:55:18', '2019-06-14 06:55:18'),
(21, 'Conducta', '15.00', '15.00', 'Otra', 'Aprobada', NULL, 1, '2019-06-14', 1, 3, 1, '2019-06-14 06:56:01', '2019-06-14 06:56:01'),
(22, 'Conducta', '15.00', '15.00', 'Otra', 'Aprobada', NULL, 1, '2019-06-14', 6, 3, 1, '2019-06-14 06:56:01', '2019-06-14 06:56:01'),
(23, 'Examen 1', '25.00', '22.00', 'Examen', 'Aprobada', 'Ciencias basicas', 1, '2019-06-14', 1, 1, 1, '2019-06-14 08:19:01', '2019-06-14 08:19:01'),
(24, 'Examen 1', '25.00', '23.00', 'Examen', 'Aprobada', 'Ciencias basicas', 1, '2019-06-14', 6, 1, 1, '2019-06-14 08:19:01', '2019-06-14 08:19:01'),
(25, 'Examen 2', '25.00', '23.00', 'Examen', 'Aprobada', 'Ciencias basicas', 1, '2019-06-14', 1, 1, 1, '2019-06-14 08:27:39', '2019-06-14 08:27:39'),
(26, 'Examen 2', '25.00', '23.00', 'Examen', 'Aprobada', 'Ciencias basicas', 1, '2019-06-14', 6, 1, 1, '2019-06-14 08:27:39', '2019-06-14 08:27:39'),
(27, 'Tarea 1', '10.00', '8.00', 'Tarea', 'Realisada', 'Ciencias basicas', 1, '2019-06-14', 1, 1, 1, '2019-06-14 08:28:12', '2019-06-14 08:28:12'),
(28, 'Tarea 1', '10.00', '7.00', 'Tarea', 'Realisada', 'Ciencias basicas', 1, '2019-06-14', 6, 1, 1, '2019-06-14 08:28:12', '2019-06-14 08:28:12'),
(29, 'Tarea 2', '10.00', '10.00', 'Tarea', 'Realisada', 'Ciencias basicas', 1, '2019-06-14', 1, 1, 1, '2019-06-14 08:28:38', '2019-06-14 08:28:38'),
(30, 'Tarea 2', '10.00', '10.00', 'Tarea', 'Realisada', 'Ciencias basicas', 1, '2019-06-14', 6, 1, 1, '2019-06-14 08:28:38', '2019-06-14 08:28:38'),
(31, 'Trabajo extra clase', '15.00', '14.00', 'Trabajo o investigación', 'Realisada', 'trabajo en casa', 1, '2019-06-14', 1, 1, 1, '2019-06-14 08:29:12', '2019-06-14 08:29:12'),
(32, 'Trabajo extra clase', '15.00', '12.00', 'Trabajo o investigación', 'Realisada', 'trabajo en casa', 1, '2019-06-14', 6, 1, 1, '2019-06-14 08:29:12', '2019-06-14 08:29:12'),
(33, 'Conducta', '15.00', '14.00', 'Otra', 'Aprobada', 'comportamiento en clases', 1, '2019-06-14', 1, 1, 1, '2019-06-14 08:29:48', '2019-06-14 08:29:48'),
(34, 'Conducta', '15.00', '13.00', 'Otra', 'Aprobada', 'comportamiento en clases', 1, '2019-06-14', 6, 1, 1, '2019-06-14 08:29:48', '2019-06-14 08:29:48'),
(35, 'Tarea 1', '10.00', '0.00', 'Tarea', 'No realisada', 'calculos matematicos basicos', 1, '2019-06-12', 1, 3, 1, '2019-06-15 22:54:49', '2019-06-15 22:54:49'),
(36, 'Tarea 1', '10.00', '0.00', 'Tarea', 'No realisada', 'calculos matematicos basicos', 1, '2019-06-12', 6, 3, 1, '2019-06-15 22:54:49', '2019-06-16 21:39:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `pregunta` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `opcion_a` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `opcion_b` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `opcion_c` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `opcion_d` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `questions`
--

INSERT INTO `questions` (`id`, `task_id`, `pregunta`, `opcion_a`, `opcion_b`, `opcion_c`, `opcion_d`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cuanto es 2 + 9?', '7', '8', '29', '11', '2019-06-15 22:53:51', '2019-06-15 22:53:51'),
(2, 1, 'Cuanto es 7 - 4?', '74', '3', '4', '5', '2019-06-15 22:53:51', '2019-06-15 22:53:51'),
(3, 1, 'Cuanto es 5 x 6?', '30', '40', '56', '65', '2019-06-15 22:53:51', '2019-06-15 22:53:51'),
(4, 1, 'Cuanto es 9/3?', '3', '96', '9', '2', '2019-06-15 22:53:51', '2019-06-15 22:53:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Usuario', 'Otorga permisos a los Estudiantes', 1, '2010-01-12 22:50:43', NULL),
(2, 'Profesor', 'Otroga permisos a los Maestros en el Sistema', 1, '2010-01-13 00:50:43', NULL),
(3, 'Administrador', 'Otroga permisos a los Administradores en el Sistema', 1, '2010-01-12 23:50:43', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, NULL),
(4, 3, 2, NULL, NULL),
(5, 3, 3, NULL, NULL),
(6, 5, 2, NULL, NULL),
(7, 6, 2, NULL, NULL),
(8, 7, 1, NULL, NULL),
(9, 8, 1, NULL, NULL),
(10, 9, 1, NULL, NULL),
(11, 10, 1, NULL, NULL),
(12, 11, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedules`
--

CREATE TABLE `schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `desde` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `schedules`
--

INSERT INTO `schedules` (`id`, `desde`, `hasta`, `estado`, `created_at`, `updated_at`) VALUES
(1, '08:15', '09:15', 1, '2019-05-27 06:05:09', '2019-05-27 06:06:43'),
(2, '09:20', '10:20', 1, '2019-05-30 06:46:06', '2019-05-30 06:46:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sections`
--

CREATE TABLE `sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `seccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_id` int(10) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sections`
--

INSERT INTO `sections` (`id`, `seccion`, `grade_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, '1-1', 1, 1, NULL, '2019-05-28 07:11:10'),
(2, '1-2', 1, 1, '2019-05-28 07:30:47', '2019-05-28 07:30:47'),
(3, '3-1', 3, 1, '2019-05-28 07:31:02', '2019-05-28 08:20:40'),
(4, '6-1', 6, 1, '2019-05-28 10:17:23', '2019-05-28 10:17:23'),
(5, '4-1', 4, 1, '2019-05-28 10:17:48', '2019-05-28 10:17:48'),
(6, '5-1', 5, 1, '2019-05-28 10:18:02', '2019-05-28 10:18:02'),
(7, '6-2', 6, 1, '2019-06-03 06:53:16', '2019-06-03 06:53:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primer_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `adecuacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `user_id` int(10) UNSIGNED NOT NULL,
  `guardian_id` int(10) UNSIGNED DEFAULT NULL,
  `section_id` int(10) UNSIGNED DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `cedula`, `nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `adecuacion`, `foto`, `user_id`, `guardian_id`, `section_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 121212121, 'Juan', 'Campos', 'Camacho', '2017-05-10', 'Ninguna', 'none', 2, 1, 1, 1, '2019-05-27 05:01:43', '2019-06-02 22:43:56'),
(2, 222222222, 'David', '12121212', 'camacho', '2016-06-10', 'Ninguna', 'none', 7, NULL, 3, 1, '2019-05-28 19:38:28', '2019-05-29 00:54:31'),
(3, 333333333, 'David', '12121212', 'camacho', '2015-05-06', 'Ninguna', 'none', 8, NULL, NULL, 1, '2019-05-28 19:39:22', '2019-05-28 19:39:22'),
(4, 444444444, 'Ciencias', 'camachos', '1121121111', '2016-06-10', 'Ninguna', 'none', 9, NULL, NULL, 1, '2019-05-28 19:40:14', '2019-05-28 23:14:01'),
(5, 555555555, 'Fisica', 'camacho', 'Camachos', '2016-05-12', 'Ninguna', 'none', 10, NULL, NULL, 1, '2019-05-28 19:42:39', '2019-05-28 19:42:39'),
(6, 113131313, 'David', 'Campos', 'Campos', '2014-06-08', 'Ninguna', '/storage/imagen/TFMTM0QfqzsqWqMfSocT2pzN1WaEjTIrA5pLMcLw.jpeg', 11, NULL, 1, 1, '2019-06-02 22:17:00', '2019-06-12 02:25:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subjects`
--

INSERT INTO `subjects` (`id`, `codigo`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'CIE', 'Ciencias', 'Ciencias basicas', 1, '2019-05-27 03:52:00', '2019-05-27 05:50:10'),
(8, 'MAT', 'Matematicas', 'Matematicas basicas', 1, '2019-05-27 05:49:37', '2019-05-27 05:53:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taskhistories`
--

CREATE TABLE `taskhistories` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `inicio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `final` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trimestre` int(11) NOT NULL,
  `puntaje` decimal(6,2) NOT NULL DEFAULT '0.00',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `taskhistories`
--

INSERT INTO `taskhistories` (`id`, `course_id`, `task_id`, `student_id`, `inicio`, `final`, `trimestre`, `puntaje`, `estado`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, '2019-06-12', '2019-06-21', 1, '0.00', 1, '2019-06-15 22:54:49', '2019-06-15 22:54:49'),
(2, 3, 1, 6, '2019-06-12', '2019-06-21', 1, '0.00', 1, '2019-06-15 22:54:49', '2019-06-16 21:39:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` decimal(6,2) NOT NULL,
  `respuestas` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tasks`
--

INSERT INTO `tasks` (`id`, `titulo`, `descripcion`, `valor`, `respuestas`, `subject_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'calculos matematicos basicos', 'Sumas resta multiplicaciones diviciones', '10.00', 'D),B),A),A),', 8, 1, '2019-06-15 22:53:51', '2019-06-15 22:53:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teachers`
--

CREATE TABLE `teachers` (
  `id` int(10) UNSIGNED NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primer_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `puesto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `telefono1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `user_id` int(10) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `teachers`
--

INSERT INTO `teachers` (`id`, `cedula`, `nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `puesto`, `fecha_ingreso`, `telefono1`, `telefono2`, `foto`, `user_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 121212129, 'Marcos', 'Ramirez', 'Perez', '1974-02-05', 'Administrador', '2014-05-14', '25454563', '78454563', '/storage/imagen/JyXrIdFxl20QrC6saDJtV0LzrvSxCABXcQzB6buA.jpeg', 3, 1, '2019-03-20 22:19:08', '2019-06-12 00:36:18'),
(2, 121212241, 'David', 'camacho', 'camacho', '2014-02-05', 'no tiene', '2016-05-04', '25454585', '78454544', 'none', 5, 0, '2019-05-27 08:14:39', '2019-05-27 08:30:13'),
(3, 121212222, 'David', 'camacho', 'Camacho', '1973-05-09', 'Profesor de Matematicas', '2017-05-10', '11111111', '11111111', 'none', 6, 1, '2019-05-27 08:24:55', '2019-05-27 09:16:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Juancampos', 'davidcamposch@gmail.com', '$2y$10$xG3jhR9HZ5LmU1zt.p441emRZQTCD6vKFcx8VTvyx/2EgVpxVePfy', 'UzpT6dL2kxYIQgBTptPrEaqg8lVS0euffPFZ5f9DZTKeZ9GRCHl3Qo5hgWmN', '2019-05-27 05:01:43', '2019-05-27 05:01:43'),
(3, 'administrador', 'administrador@gmail.com', '$2y$10$ZypPm1W7sKZ0cmUlcB7Fr.k2fRRwtyUBxQcq.39cXYlFxmCz7o6ue', 'ppXjSPzNV5Qj4ooh5FFe5pfB1Uvq2QbDsnWIW8wYMn61obpwsNNKwnQzRnPA', '2019-03-24 10:44:14', '2019-03-24 10:44:14'),
(5, 'davidcampos', 'davidcamposch13@gmail.com', '$2y$10$Z8QhxcQ0ndkqcE1prKgGCONGmvR05A0atDp2LKHHwS/B4Ts3li/mO', NULL, '2019-05-27 08:14:39', '2019-05-27 08:14:39'),
(6, 'davidcampos', 'hk21123@email.vccs.edu', '$2y$10$54DER6AR7AV9zn0UxAsnzOzWnOD0g03NHae5QJ5WTQ1hxFF4lxdBO', NULL, '2019-05-27 08:24:55', '2019-05-27 08:24:55'),
(7, 'nuevo1', 'das1@gmail.com', '$2y$10$4FJmVv.4N.6auEt1KI1nceuk0PFocK1oLorU3UPM8WbFheSUeLhVW', 'l4Ox6Cd1ObL7d05HQ9MtIwXapaKsBHltcPzBA5o4Xbs3mgMqdeYi1DgX3Vld', '2019-05-28 19:38:28', '2019-05-28 19:38:28'),
(8, 'test22', 'das2@gmail.com', '$2y$10$uwrFal5XPGnyt5akf.B56uLIjhGd8ExPizur1r/L8dw4/p2h.1wqC', 'V60xOc2VJXRQEHmZiLjp9uqMJhB3BteTa3udkc0yfnc0Kqq4igaMTCqv1s5L', '2019-05-28 19:39:22', '2019-05-28 19:39:22'),
(9, 'test38', 'dasd3@gmail.com', '$2y$10$NKQ745zgzOK43vaeZTHbFej7K3TbULkUOZlm4nsuoj7IvLM0hVwem', 'hcJdLblDri1PiwgJk2XaAbSaxMEZ9V5oglaHjtdWFtrjvUj4jrSbFYG1xD2n', '2019-05-28 19:40:14', '2019-05-28 19:40:14'),
(10, 'davidcampos', 'dasd@5gmail.com', '$2y$10$AG9RWsqHFL/oVCMsSdYije7t0EYfuX9CE5cWNOkTJvLiiiYjrkaLq', 'GflRJtoyjMNPx7FBv5m8QnrfV6BczYrJZBdCWrOljWngnDHTBNW8m7E8L73y', '2019-05-28 19:42:39', '2019-05-28 19:42:39'),
(11, 'estudiante', 'estudiante@gmail.com', '$2y$10$6UaegYGmJHxDwwpRZEGYNOZOBIMJIEO92j5GU1FFCRa7MaKStL69K', 'AaI5xylsowDNSfH55DkfKrbbSp7FDObeM8vu4RjU0OaPz47GcEviCIxkjnXG', '2019-06-02 22:17:00', '2019-06-02 22:17:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_unique` (`teacher_id`,`section_id`,`subject_id`),
  ADD KEY `courses_section_id_foreign` (`section_id`),
  ADD KEY `courses_subject_id_foreign` (`subject_id`);

--
-- Indices de la tabla `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `days_dia_unique` (`dia`);

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_news_id_foreign` (`news_id`);

--
-- Indices de la tabla `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grades_grado_unique` (`grado`);

--
-- Indices de la tabla `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lesson_unique` (`course_id`,`schedule_id`,`day_id`),
  ADD KEY `lessons_schedule_id_foreign` (`schedule_id`),
  ADD KEY `lessons_day_id_foreign` (`day_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_course_id_foreign` (`course_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualifications_student_id_foreign` (`student_id`),
  ADD KEY `qualifications_course_id_foreign` (`course_id`);

--
-- Indices de la tabla `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_task_id_foreign` (`task_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schedules_desde_hasta_unique` (`desde`,`hasta`);

--
-- Indices de la tabla `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sections_seccion_unique` (`seccion`),
  ADD KEY `sections_grade_id_foreign` (`grade_id`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_cedula_unique` (`cedula`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_guardian_id_foreign` (`guardian_id`),
  ADD KEY `students_section_id_foreign` (`section_id`);

--
-- Indices de la tabla `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_codigo_unique` (`codigo`);

--
-- Indices de la tabla `taskhistories`
--
ALTER TABLE `taskhistories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `taskhistory_unique` (`course_id`,`task_id`,`student_id`),
  ADD KEY `taskhistories_task_id_foreign` (`task_id`),
  ADD KEY `taskhistories_student_id_foreign` (`student_id`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_subject_id_foreign` (`subject_id`);

--
-- Indices de la tabla `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_cedula_unique` (`cedula`),
  ADD KEY `teachers_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `days`
--
ALTER TABLE `days`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `taskhistories`
--
ALTER TABLE `taskhistories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lessons_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lessons_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `qualifications`
--
ALTER TABLE `qualifications`
  ADD CONSTRAINT `qualifications_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `qualifications_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_guardian_id_foreign` FOREIGN KEY (`guardian_id`) REFERENCES `guardians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `taskhistories`
--
ALTER TABLE `taskhistories`
  ADD CONSTRAINT `taskhistories_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `taskhistories_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `taskhistories_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
