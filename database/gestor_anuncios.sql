-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-10-2023 a las 00:48:38
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor_anuncios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio`
--

CREATE TABLE `anuncio` (
  `id_anuncio` int(11) NOT NULL,
  `nombre_anuncio` varchar(50) NOT NULL,
  `precio` float NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `foto` varchar(80) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `validado` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `anuncio`
--

INSERT INTO `anuncio` (`id_anuncio`, `nombre_anuncio`, `precio`, `descripcion`, `foto`, `nombre_usuario`, `validado`) VALUES
(1, 'Iphone 13', 529, 'Lo vendo porque me voy a comprar el nuevo IPhone 15\r\nSalud batería: 87%\r\nGarantía vigente\r\n120gb\r\nFactura\r\nSe puede ver sin compromiso\r\nEstá totalmente nuevo\r\nPoco uso ya que utilizo el móvil de empresa con normalidad\r\nPRECIO POCO NEGOCIABLE\r\nAbstenerse ofertas ridículas', 'iphone13.webp', 'Admin_ekaitz', '1'),
(2, 'apuntes', 20, 'son los apuntes del año pasado en limpio y con un examen de regalo', 'apuntes.jpg', 'Admin_luka', '1'),
(3, 'Sillas escritorio IKEA', 25, 'Sillas escritorio modelo Logerbet / Malskar de IkEA. Silla blanca y cojín negro. Precio silla con cojín 25€. Venta 4 sillas conjuntamente 80€. NO negociable.', 'silla_ikea.webp', 'Admin_aketza', '1'),
(4, 'CAMISETA HOMBRE PRIMERA EQUIPACIÓN', 85, 'Esta camiseta de manga corta te hará sentir como un gran profesional. Celebra la historia del Athletic Club mientras apoyas a tu equipo favorito.', 'primeraEquip.webp', 'Admin_ekaitz', '1'),
(5, 'CAMISETA HOMBRE SEGUNDA EQUIPACIÓN', 85, 'Muévete como un león con esta camiseta de la segunda equipación para hombre. Confeccionada con un tejido ligero y transpirable y con un práctico cuello de pico, esta camiseta aporta comodidad para que te mantengas fresco en las gradas de San Mamés.', 'segundaEquip.webp', 'Admin_ekaitz', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id_noticia` int(11) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `categoria` enum('deportes','economia','arte','tiempo') NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `validado` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id_noticia`, `foto`, `titulo`, `descripcion`, `categoria`, `nombre_usuario`, `validado`) VALUES
(1, 'noticia-barca.webp', 'El Barça logró imponerse a todos sus fantasmas en Oporto', 'Ganó por fin fuera de casa un partido importante en Champions y con muchas bajas', 'deportes', 'Admin_ekaitz', '1'),
(2, 'noticia-ansu.webp', 'El plan del Brighton para poner a tope a Ansu Fati: \"No queremos presionarle\"', 'El español marcó su primer gol en la Premier y continúa creciendo poco a poco en el Brighton', 'deportes', 'Admin_ekaitz', '1'),
(3, 'noticia-mvps-euroliga.webp', 'Las estrellas que aspiran a coronarse MVP de la Euroliga', 'Nikola Mirotic, Wade Baldwin, Mike James, Edy Tavares, Kevin Punter, Will Clyburn, Nikola Milutinov, Facundo Campazzo... son algunos de los jugadores que optan a ser el el mejor de la temporada', 'deportes', 'Admin_ekaitz', '0'),
(4, 'noticia-calima-canarias-septiembre-2023.webp', 'Última hora calor y calima en Canarias: se suspenden las clases', 'Canarias suspende las clases este miércoles y el viernes debido a la situación meteorológica', 'tiempo', 'Admin_ekaitz', '1'),
(5, 'noticias-circo.avif', 'El Premio Nacional de Circo 2023 reconoce el gran formato en carpa de Productores de Sonrisas', 'El jurado ha destacado la trayectoria profesional de los hermanos González Villanueva y la fusión entre la tradición y la innovación', 'arte', 'Admin_dwayne', '1'),
(6, 'noticia-precipitaciones.webp', 'Previsión de lluvias en el Puente del Pilar 2023: ¿cuándo va a llover?', 'La lluvia y el cambio de tiempo llegará el fin de semana: llegan borrascas y ambiente más fresco', 'tiempo', 'Admin_luka', '1'),
(7, 'noticia-borrascas.webp', '¿Qué tiempo hará la próxima semana? Baile de borrascas y ambiente fresco', '¿Qué tiempo hará la próxima semana? Por fin tendremos tiempo otoñal, con la llegada de varias borrascas y temperaturas más frescas', 'tiempo', 'Admin_aketza', '1'),
(8, 'noticia-mitologia-japonesa.webp', 'Cómo la mitología japonesa explica los videojuegos y mangas: la huella ancestral en Pokémon y Hello Kitty', 'El nuevo museo Young V&A muestra en Londres la inspiración que mangas, animes y videojuegos han tomado de las tradiciones de la cultura nipona', 'arte', 'Admin_ekaitz', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `nombre_usuario` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `fecha_nac` date NOT NULL,
  `sexo` enum('Mujer','Hombre','Otros','') NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `tipo_usuario` enum('usuario','admin','','') NOT NULL,
  `foto` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`nombre_usuario`, `nombre`, `apellido`, `fecha_nac`, `sexo`, `correo`, `password`, `tipo_usuario`, `foto`) VALUES
('Admin_aketza', 'Aketza', 'Calle', '2002-12-08', 'Hombre', 'aketzacb@gmail.com', 'admin', 'admin', '0'),
('Admin_dwayne', 'Dwayne', 'Lucas', '2004-01-04', 'Hombre', 'dwaynelucas1119@gmail.com', 'admin', 'admin', '0'),
('Admin_ekaitz', 'Ekaitz', 'Angulo', '2004-01-12', 'Hombre', 'ekaitzanguloo@gmail.com', 'admin', 'admin', '0'),
('Admin_luka', 'Luka', 'Carmona', '2003-06-14', 'Hombre', 'lukacarmona115@gmail.com', 'admin', 'admin', '0'),
('usuario_1', 'usuario', 'usuario', '2001-01-01', 'Mujer', 'usuario@gmail.com', 'usuario_1', 'usuario', 'usuario_1.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD PRIMARY KEY (`id_anuncio`),
  ADD KEY `fk_nombre_usuario_anuncio` (`nombre_usuario`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id_noticia`),
  ADD KEY `fk_nombre_usuario_noticia` (`nombre_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  MODIFY `id_anuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD CONSTRAINT `fk_nombre_usuario_anuncio` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `fk_nombre_usuario_noticia` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2023 a las 12:27:50
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor_anuncios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio`
--

CREATE TABLE `anuncio` (
  `id_anuncio` int(11) NOT NULL,
  `nombre_anuncio` varchar(50) NOT NULL,
  `precio` float NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `foto` varchar(80) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `validado` enum('0','1','','') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `anuncio`
--

INSERT INTO `anuncio` (`id_anuncio`, `nombre_anuncio`, `precio`, `descripcion`, `foto`, `nombre_usuario`, `validado`) VALUES
(1, 'Iphone 13', 529, 'Lo vendo porque me voy a comprar el nuevo IPhone 15\r\nSalud batería: 87%\r\nGarantía vigente\r\n120gb\r\nFactura\r\nSe puede ver sin compromiso\r\nEstá totalmente nuevo\r\nPoco uso ya que utilizo el móvil de empresa con normalidad\r\nPRECIO POCO NEGOCIABLE\r\nAbstenerse ofertas ridículas', 'iphone13.webp', 'Admin_ekaitz', '0'),
(2, 'apuntes', 20, 'son los apuntes del año pasado en limpio y con un examen de regalo', 'apuntes.jpg', 'Admin_luka', '0'),
(3, 'Sillas escritorio IKEA', 25, 'Sillas escritorio modelo Logerbet / Malskar de IkEA. Silla blanca y cojín negro. Precio silla con cojín 25€. Venta 4 sillas conjuntamente 80€. NO negociable.', 'silla_ikea.webp', 'Admin_aketza', '0'),
(4, 'CAMISETA HOMBRE PRIMERA EQUIPACIÓN', 85, 'Esta camiseta de manga corta te hará sentir como un gran profesional. Celebra la historia del Athletic Club mientras apoyas a tu equipo favorito.', 'primeraEquip.webp', 'Admin_ekaitz', '0'),
(5, 'CAMISETA HOMBRE SEGUNDA EQUIPACIÓN', 85, 'Muévete como un león con esta camiseta de la segunda equipación para hombre. Confeccionada con un tejido ligero y transpirable y con un práctico cuello de pico, esta camiseta aporta comodidad para que te mantengas fresco en las gradas de San Mamés.', 'segundaEquip.webp', 'Admin_ekaitz', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id_noticia` int(11) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `categoria` enum('deportes','economia','arte','tiempo') NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `validado` enum('0','1','','') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id_noticia`, `foto`, `titulo`, `descripcion`, `categoria`, `nombre_usuario`, `validado`) VALUES
(1, 'noticia-barca.webp', 'El Barça logró imponerse a todos sus fantasmas en Oporto', 'Ganó por fin fuera de casa un partido importante en Champions y con muchas bajas', 'deportes', 'Admin_ekaitz', '0'),
(2, 'noticia-ansu.webp', 'El plan del Brighton para poner a tope a Ansu Fati: \"No queremos presionarle\"', 'El español marcó su primer gol en la Premier y continúa creciendo poco a poco en el Brighton', 'deportes', 'Admin_ekaitz', '0'),
(3, 'noticia-mvps-euroliga.webp', 'Las estrellas que aspiran a coronarse MVP de la Euroliga', 'Nikola Mirotic, Wade Baldwin, Mike James, Edy Tavares, Kevin Punter, Will Clyburn, Nikola Milutinov, Facundo Campazzo... son algunos de los jugadores que optan a ser el el mejor de la temporada', 'deportes', 'Admin_ekaitz', '0'),
(4, 'noticia-calima-canarias-septiembre-2023.webp', 'Última hora calor y calima en Canarias: se suspenden las clases', 'Canarias suspende las clases este miércoles y el viernes debido a la situación meteorológica', 'tiempo', 'Admin_ekaitz', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `nombre_usuario` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `fecha_nac` date NOT NULL,
  `sexo` enum('Mujer','Hombre','Otros','') NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `tipo_usuario` enum('usuario','admin','','') NOT NULL,
  `foto` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`nombre_usuario`, `nombre`, `apellido`, `fecha_nac`, `sexo`, `correo`, `password`, `tipo_usuario`, `foto`) VALUES
('Admin_aketza', 'Aketza', 'Calle', '2002-12-08', 'Hombre', 'aketzacb@gmail.com', 'admin', 'admin', '0'),
('Admin_dwayne', 'Dwayne', 'Lucas', '2004-01-04', 'Hombre', 'dwaynelucas1119@gmail.com', 'admin', 'admin', '0'),
('Admin_ekaitz', 'Ekaitz', 'Angulo', '2004-01-12', 'Hombre', 'ekaitzanguloo@gmail.com', 'admin', 'admin', '0'),
('Admin_luka', 'Luka', 'Carmona', '2003-06-14', 'Hombre', 'lukacarmona115@gmail.com', 'admin', 'admin', '0'),
('usuario_1', 'usuario', 'usuario', '2001-01-01', 'Mujer', 'usuario@gmail.com', 'usuario_1', 'usuario', 'usuario_1.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD PRIMARY KEY (`id_anuncio`),
  ADD KEY `fk_nombre_usuario_anuncio` (`nombre_usuario`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id_noticia`),
  ADD KEY `fk_nombre_usuario_noticia` (`nombre_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  MODIFY `id_anuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD CONSTRAINT `fk_nombre_usuario_anuncio` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `fk_nombre_usuario_noticia` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION