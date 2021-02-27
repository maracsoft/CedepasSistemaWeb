-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-02-2021 a las 17:58:28
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdcedepaspesi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo`
--

CREATE TABLE `activo` (
  `codActivo` int(11) NOT NULL,
  `codProyectoDestino` int(11) NOT NULL,
  `codEmpleadoResponsable` int(11) NOT NULL,
  `nombreDelBien` varchar(300) NOT NULL,
  `caracteristicas` varchar(300) NOT NULL,
  `codCategoriaActivo` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `placa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `activo`
--

INSERT INTO `activo` (`codActivo`, `codProyectoDestino`, `codEmpleadoResponsable`, `nombreDelBien`, `caracteristicas`, `codCategoriaActivo`, `codSede`, `codEstado`, `activo`, `placa`) VALUES
(1, 2, 2, 'Camioneta 4x4', 'Amplia camioneta 4x4 marca Nissan', 1, 1, 4, 1, '3851-6516'),
(2, 2, 2, 'Mueble', 'Muebles akw2', 3, 1, 1, 1, NULL),
(3, 3, 2, 'Librero', 'Es grande', 3, 2, 2, 1, NULL),
(4, 4, 6, 'Moto', 'modelo tokaw', 1, 1, 2, 1, '3521-654'),
(5, 3, 6, 'Telefono', 'Rin Rin', 3, 1, 2, 0, NULL),
(6, 2, 2, 'Televisor', 'tv', 3, 2, 2, 1, NULL),
(7, 2, 8, 'Mesa', 'Mesa amplia de madera', 3, 1, 2, 0, 'No tiene'),
(8, 3, 8, 'Linterna', 'Linterna marca Samsung a pilas', 2, 1, 1, 1, 'No tiene');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afp`
--

CREATE TABLE `afp` (
  `codAFP` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `aporteObligatorio` float NOT NULL,
  `comisionFlujo` float NOT NULL,
  `comisionMixta` float NOT NULL,
  `primaDeSeguro` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `afp`
--

INSERT INTO `afp` (`codAFP`, `nombre`, `aporteObligatorio`, `comisionFlujo`, `comisionMixta`, `primaDeSeguro`) VALUES
(1, 'PRIMA', 10, 1.6, 0.18, 1.35),
(2, 'SNP', 0, 0, 0, 0),
(3, 'INTEGRA', 10, 1.69, 0, 1.35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `codArea` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`codArea`, `nombre`, `estado`) VALUES
(1, 'Gerencia', 1),
(2, 'Administración', 1),
(3, 'RRHH', 1),
(5, 'Direccion', 1),
(6, 'Contabilidad', 1),
(7, 'Almacen', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `codRegistroAsistencia` int(11) NOT NULL,
  `codPeriodoEmpleado` int(11) NOT NULL,
  `fechaHoraEntrada` datetime DEFAULT NULL,
  `fechaHoraSalida` datetime DEFAULT NULL,
  `fechaHoraEntrada2` datetime DEFAULT NULL,
  `fechaHoraSalida2` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`codRegistroAsistencia`, `codPeriodoEmpleado`, `fechaHoraEntrada`, `fechaHoraSalida`, `fechaHoraEntrada2`, `fechaHoraSalida2`, `estado`, `fecha`) VALUES
(13, 19, NULL, NULL, '2021-02-20 16:01:21', '2021-02-20 16:01:26', 2, '2021-02-20'),
(14, 21, NULL, NULL, '2021-02-23 16:44:30', '2021-02-23 16:44:37', 2, '2021-02-23'),
(15, 21, NULL, NULL, NULL, NULL, 2, '2021-02-24'),
(16, 21, '2021-02-25 00:20:23', '2021-02-25 00:20:58', NULL, NULL, 2, '2021-02-25'),
(17, 19, NULL, NULL, NULL, NULL, 1, '2021-02-25'),
(18, 21, NULL, NULL, NULL, NULL, 1, '2021-02-26'),
(19, 28, NULL, NULL, NULL, NULL, 1, '2021-02-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avance_entregable`
--

CREATE TABLE `avance_entregable` (
  `codAvanceEntregable` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `fechaEntrega` date NOT NULL,
  `porcentaje` int(11) NOT NULL,
  `monto` float NOT NULL,
  `codPeriodoEmpleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `avance_entregable`
--

INSERT INTO `avance_entregable` (`codAvanceEntregable`, `descripcion`, `fechaEntrega`, `porcentaje`, `monto`, `codPeriodoEmpleado`) VALUES
(10, 'yuioyuio', '2021-02-24', 50, 25000, 26),
(11, 'yuioyuio', '2021-03-24', 50, 25000, 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `codBanco` int(11) NOT NULL,
  `nombreBanco` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `banco`
--

INSERT INTO `banco` (`codBanco`, `nombreBanco`) VALUES
(1, 'BCP'),
(2, 'Interbank'),
(3, 'BBVA'),
(4, 'Banco de la Nacion'),
(5, 'Pichincha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `codCaja` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  `montoMaximo` float NOT NULL,
  `montoActual` float NOT NULL,
  `codEmpleadoCajeroActual` int(11) NOT NULL,
  `activa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`codCaja`, `nombre`, `codProyecto`, `montoMaximo`, `montoActual`, `codEmpleadoCajeroActual`, `activa`) VALUES
(1, 'Huamachucos', 2, -5000, 12750, 11, 1),
(2, 'Trujillo', 3, 1500, 900, 6, 1),
(3, 'Huamachuco', 4, 1555, 1555, 0, 0),
(4, 'Cajamarca', 4, 1555, 1555, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `codCategoria` int(11) NOT NULL,
  `nombre` char(18) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`codCategoria`, `nombre`) VALUES
(4, 'UTILES ESCRITORIO'),
(5, 'MATERIAL LIMPIEZA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_activo`
--

CREATE TABLE `categoria_activo` (
  `codCategoriaActivo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria_activo`
--

INSERT INTO `categoria_activo` (`codCategoriaActivo`, `nombre`) VALUES
(1, 'vehiculo'),
(2, 'maquinaria'),
(3, 'muebles y enseres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdp`
--

CREATE TABLE `cdp` (
  `codTipoCDP` int(11) NOT NULL,
  `nombreCDP` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cdp`
--

INSERT INTO `cdp` (`codTipoCDP`, `nombreCDP`) VALUES
(1, 'Fact.'),
(2, 'Rec. Hon.'),
(3, 'Bol. Venta'),
(4, 'Liq. Compra'),
(5, 'Boleto Aéreo'),
(6, 'Rec. Alquiler'),
(7, 'Ticket'),
(8, 'Rec. Serv. Pub'),
(9, 'Pasajes'),
(10, 'DJ Mov'),
(11, 'DJ Viat'),
(12, 'DJ Varios'),
(13, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato_tipo`
--

CREATE TABLE `contrato_tipo` (
  `codTipoContrato` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contrato_tipo`
--

INSERT INTO `contrato_tipo` (`codTipoContrato`, `nombre`) VALUES
(1, 'Plazo Fijo'),
(2, 'por Locacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `declaracion`
--

CREATE TABLE `declaracion` (
  `codDeclaracion` int(11) NOT NULL,
  `ingresos` float NOT NULL,
  `gastos` float NOT NULL,
  `gastoPlanilla` float NOT NULL,
  `impuestos` float NOT NULL,
  `fechaDeclaracion` date NOT NULL,
  `codEmpleadoAutor` int(11) NOT NULL,
  `mesDeclarado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_gasto_planilla`
--

CREATE TABLE `detalle_gasto_planilla` (
  `codDetalleGastoPlanilla` int(11) NOT NULL,
  `sueldoContrato` float NOT NULL,
  `costoDiario` float NOT NULL,
  `diasVac` int(11) NOT NULL,
  `diasFalta` int(11) NOT NULL,
  `sueldoBrutoXTrabajar` float NOT NULL,
  `montoPagadoVacaciones` float NOT NULL,
  `baseImpAntesDeFaltas` float NOT NULL,
  `descFaltas` float NOT NULL,
  `baseImponible` float NOT NULL,
  `SNP` float NOT NULL,
  `aporteObligatorio` float NOT NULL,
  `comisionMixta` float NOT NULL,
  `primaSeguro` float NOT NULL,
  `totalDesctos` float NOT NULL,
  `netoAPagar` float NOT NULL,
  `codGastoPlanilla` int(11) NOT NULL,
  `codAFP` int(11) NOT NULL,
  `codEmpleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_gasto_planilla`
--

INSERT INTO `detalle_gasto_planilla` (`codDetalleGastoPlanilla`, `sueldoContrato`, `costoDiario`, `diasVac`, `diasFalta`, `sueldoBrutoXTrabajar`, `montoPagadoVacaciones`, `baseImpAntesDeFaltas`, `descFaltas`, `baseImponible`, `SNP`, `aporteObligatorio`, `comisionMixta`, `primaSeguro`, `totalDesctos`, `netoAPagar`, `codGastoPlanilla`, `codAFP`, `codEmpleado`) VALUES
(3, 1000, 33.3333, 0, 0, 1000, 0, 1000, 0, 1000, 0, 100, 1.8, 13.5, 115.3, 884.7, 3, 1, 2),
(4, 1500, 50, 0, 0, 1500, 0, 1500, 0, 1500, 195, 0, 0, 0, 195, 1305, 3, 2, 7),
(5, 1000, 33.3333, 9, 3, 700, 300, 1000, 100, 900, 0, 90, 1.62, 12.15, 103.77, 796.23, 4, 1, 2),
(6, 1500, 50, 0, 4, 1500, 0, 1500, 200, 1300, 169, 0, 0, 0, 169, 1131, 4, 2, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_rendicion_gastos`
--

CREATE TABLE `detalle_rendicion_gastos` (
  `codDetalleRendicion` int(11) NOT NULL,
  `codRendicionGastos` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nroComprobante` varchar(200) NOT NULL,
  `concepto` varchar(500) NOT NULL,
  `importe` float NOT NULL,
  `codigoPresupuestal` varchar(200) NOT NULL,
  `codTipoCDP` int(11) NOT NULL,
  `terminacionArchivo` varchar(10) DEFAULT NULL,
  `nroEnRendicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_rendicion_gastos`
--

INSERT INTO `detalle_rendicion_gastos` (`codDetalleRendicion`, `codRendicionGastos`, `fecha`, `nroComprobante`, `concepto`, `importe`, `codigoPresupuestal`, `codTipoCDP`, `terminacionArchivo`, `nroEnRendicion`) VALUES
(36, 46, '2020-02-24', '152215', 'hola', 90, '141414', 4, 'php', 1),
(37, 47, '2020-02-17', '251521215', 'cafe', 200, '125215215', 6, 'xlsx', 1),
(38, 48, '2020-02-24', '112441', 'adsas ddsadsa', 151, 'asdads', 4, 'erwin', 1),
(39, 49, '2020-02-24', '123123', 'Saco de Tierra', 121, '12231213', 1, 'jpg', 1),
(40, 50, '2020-02-26', '123123', 'Arroz 1000gr graneado', 90, '12131231', 3, 'jpg', 1),
(41, 51, '2020-02-28', '001-110', 'Utiles', 90, '121112', 2, 'jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_solicitud_fondos`
--

CREATE TABLE `detalle_solicitud_fondos` (
  `codDetalleSolicitud` int(11) NOT NULL,
  `codSolicitud` int(11) NOT NULL,
  `nroItem` int(11) NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `importe` float NOT NULL,
  `codigoPresupuestal` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_solicitud_fondos`
--

INSERT INTO `detalle_solicitud_fondos` (`codDetalleSolicitud`, `codSolicitud`, `nroItem`, `concepto`, `importe`, `codigoPresupuestal`) VALUES
(124, 47, 1, 'gaseosa', 12, '11121212'),
(125, 47, 2, 'papel higienico', 51, '13001'),
(126, 47, 3, 'Galletas para el snack', 50, '1112121'),
(127, 48, 1, 'Compra de café para la actividad', 251, '15215251'),
(129, 49, 1, 'Compra de cafe', 151, '11121212'),
(133, 50, 1, 'Camara 1040p', 124, '421211221'),
(134, 51, 1, 'Cajas para la box store', 125, '122151215'),
(135, 52, 1, 'Caja de 100 lápices', 50, '12121121'),
(136, 52, 2, 'Millar de hojas', 20, '122131'),
(137, 53, 1, 'Materiales para arreglar cafetera', 252, '21213112'),
(139, 54, 1, 'Tierra para las plantas a sembrar', 125, '1231233123'),
(140, 55, 1, 'ads', 125, 'sad'),
(142, 56, 1, 'Arroz graneado 1000gr', 100, '123132132'),
(144, 57, 1, 'Útiles de escritorio para capacitación (lapice)', 100, '1112221112');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `codEmpleado` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `nombres` varchar(300) NOT NULL,
  `apellidos` varchar(300) NOT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `fechaNacimiento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `tieneHijos` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `codigoCedepas` varchar(50) NOT NULL,
  `dni` char(8) NOT NULL,
  `codProyecto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`codEmpleado`, `codUsuario`, `nombres`, `apellidos`, `direccion`, `fechaNacimiento`, `sexo`, `tieneHijos`, `activo`, `codigoCedepas`, `dni`, `codProyecto`) VALUES
(1, 1, 'admin', 'admin', 'Iquitos 208 - Aranjuez', '2000-04-28', 'M', 0, 1, 'E001', '73742090', 2),
(2, 2, 'Diego Ernesto', 'Vigo Briones', 'Iquitos 208 - Aranjuezzzz', '2002-02-04', 'M', 1, 1, 'E008', '73742090', 2),
(6, 3, 'Isaac Juan', 'Jimenez Valdivia', 'Saltillo', '2020-10-12', 'M', 1, 1, 'E0213', '12341234', 3),
(7, 5, 'Estefany Maricielo', 'Rodriguez Paredes', 'Av. Juan Manuel Ozuna # 2', '2000-01-05', 'F', 1, 1, 'E1512', '98751563', 2),
(8, 8, 'Renzo Junior', 'Franco Valladolid', 'CALLE AGUSTIN LARA NO. 69-B', '2000-02-23', 'M', 0, 1, 'E008', '45978635', 3),
(9, 9, 'Jorge Luis', 'Azabache Noriega', 'Av. Condorcanqui #2574', '1997-04-12', 'M', 0, 1, 'E009', '76662693', 0),
(10, 11, 'Elisa Margarita', 'Maslucán Rojas', 'Trujillo, San Isidro Calle Cristal 362 Interior A5', '1994-01-22', 'F', 0, 1, 'E0011', '12345224', 4),
(11, 12, 'Mariana Angela', 'Castro Vidal', 'Trujillo, San Isidro Calle Cristal 362 Interior A5', '2000-02-26', 'F', 0, 1, 'E0012', '72201251', 0),
(12, 13, 'Juan Hermando', 'Fernandez Valla', 'Trujillo, San Isidro Calle Cristal 362 Interior A5', '2000-02-26', 'M', 1, 1, 'E0013', '12357545', 3),
(13, 14, 'Renzo', 'Franco Valladolid', 'Av. América Sur #2000', '1998-10-08', 'M', 0, 1, 'E0014', '73710888', 2),
(14, 15, 'Eloy', 'Ortiz Vasquez', 'Av. América Sur #1245 Urb el sol', '1995-06-05', 'M', 1, 1, 'E0015', '18393233', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_activo`
--

CREATE TABLE `estado_activo` (
  `codEstado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_activo`
--

INSERT INTO `estado_activo` (`codEstado`, `nombre`) VALUES
(0, 'Aun no revisado'),
(1, 'Disponible'),
(2, 'No habido'),
(3, 'Deteriorado'),
(4, 'Donado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_periodo_caja`
--

CREATE TABLE `estado_periodo_caja` (
  `codEstado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_periodo_caja`
--

INSERT INTO `estado_periodo_caja` (`codEstado`, `nombre`) VALUES
(1, 'En proceso'),
(2, 'Esperando Reposicion'),
(3, 'Finalizada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_solicitud_fondos`
--

CREATE TABLE `estado_solicitud_fondos` (
  `codEstadoSolicitud` int(11) NOT NULL,
  `nombreEstado` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_solicitud_fondos`
--

INSERT INTO `estado_solicitud_fondos` (`codEstadoSolicitud`, `nombreEstado`) VALUES
(1, 'Creada'),
(2, 'Aprobada'),
(3, 'Abonada'),
(4, 'Rendida'),
(5, 'Rechazada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencia`
--

CREATE TABLE `existencia` (
  `codExistencia` int(11) NOT NULL,
  `codigoInterno` varchar(18) NOT NULL,
  `stock` char(18) DEFAULT NULL,
  `nombre` char(18) DEFAULT NULL,
  `marca` char(18) DEFAULT NULL,
  `unidad` char(18) DEFAULT NULL,
  `codCategoria` char(18) DEFAULT NULL,
  `estado` char(18) DEFAULT NULL,
  `modelo` char(18) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `existencia`
--

INSERT INTO `existencia` (`codExistencia`, `codigoInterno`, `stock`, `nombre`, `marca`, `unidad`, `codCategoria`, `estado`, `modelo`) VALUES
(1, 'LAP', '431', 'LAPICERO', 'PILOT', '12', '4', '1', 'DSCSDC'),
(2, 'COR', '100', 'CORRECTOR', 'C', 'CAJA', '4', '1', 'NULL'),
(3, 'CUA', '88', 'CUADERNO', 'JUSTUS', 'CAJAS', '4', '1', 'NULL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencias_perdidas`
--

CREATE TABLE `existencias_perdidas` (
  `codExistenciaPerdida` int(11) NOT NULL,
  `fecha` char(18) DEFAULT NULL,
  `codEmpleadoEncargadoAlmacen` char(18) DEFAULT NULL,
  `codExistencia` char(18) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `cantidad` char(18) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `existencias_perdidas`
--

INSERT INTO `existencias_perdidas` (`codExistenciaPerdida`, `fecha`, `codEmpleadoEncargadoAlmacen`, `codExistencia`, `descripcion`, `cantidad`, `updated_at`, `created_at`) VALUES
(5, '2021-02-26', '1', '1', 'SE VERIFICA EN EL ALMANCEN QUE FISICAMENTE HAY 420 LAPICEROS PERO EL SISTEMA REPORTA 431', '11', '2021-02-27 04:11:21', '2021-02-27 04:11:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasto_caja`
--

CREATE TABLE `gasto_caja` (
  `codGastoPeriodo` int(11) NOT NULL,
  `codPeriodoCaja` int(11) NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `monto` float NOT NULL,
  `codEmpleadoDestino` int(11) NOT NULL,
  `fechaComprobante` date NOT NULL,
  `codTipoCDP` int(11) NOT NULL,
  `terminacionArchivo` varchar(10) NOT NULL,
  `nroEnPeriodo` int(11) NOT NULL,
  `codigoPresupuestal` varchar(30) NOT NULL,
  `nroCDP` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gasto_caja`
--

INSERT INTO `gasto_caja` (`codGastoPeriodo`, `codPeriodoCaja`, `concepto`, `monto`, `codEmpleadoDestino`, `fechaComprobante`, `codTipoCDP`, `terminacionArchivo`, `nroEnPeriodo`, `codigoPresupuestal`, `nroCDP`) VALUES
(1, 1, 'movilidad para santiago', 100, 6, '2021-02-17', 1, '', 1, '111411', '001-1110'),
(2, 1, 'asddsabadsba gaaa', 123, 6, '2021-02-21', 3, 'jpg', 2, '21', '151'),
(3, 1, 'cajas', 15, 6, '2021-02-22', 3, 'jpg', 3, '25', '003-000004'),
(4, 1, 'camara', 1511, 2, '2021-02-22', 3, 'jpg', 4, '15125', '531 1515252'),
(5, 1, 'ga', 22, 6, '2021-02-22', 5, 'docx', 5, '151', '25'),
(6, 1, 'a', 5, 6, '2021-02-22', 1, 'png', 6, '252', '531 1515252'),
(7, 1, 'asdads', 51, 6, '2021-02-22', 2, 'png', 7, '11121212', 'ads'),
(8, 1, 'adssda', 15, 6, '2021-02-22', 3, 'docx', 8, '11121212', '003-000004'),
(9, 3, 'Compra parlantes', 50, 2, '2021-02-23', 4, 'sql', 1, '1125121212', '121-488'),
(10, 3, 'papel higienico', 151, 6, '2020-12-29', 4, 'php', 2, '12121221', '003-000004'),
(11, 3, 'papel higienico', 151, 6, '2020-12-29', 4, 'php', 3, '12121221', '003-000004'),
(12, 4, 'Agua', 5, 6, '2021-02-23', 5, 'pdf', 1, '15', '215152'),
(13, 5, 'Compra de ventilador pequeño', 25, 7, '2021-02-24', 3, 'erwin', 1, '1121221', '1515125521'),
(14, 7, 'Laptop', 1300, 2, '2021-02-26', 3, 'pdf', 1, 'A12', '001-000012'),
(15, 7, 'Laptop', 1300, 8, '2021-02-26', 3, 'pdf', 2, 'A12', '001-000012'),
(16, 7, 'Laptop', 1300, 9, '2021-02-26', 3, 'pdf', 3, 'A12', '001-000012'),
(17, 8, 'Movilidad a la SUNAT', 1300, 11, '2021-02-26', 9, 'jpeg', 1, 'B12', '001-0000100');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasto_planilla`
--

CREATE TABLE `gasto_planilla` (
  `codGastoPlanilla` int(11) NOT NULL,
  `fechaGeneracion` date NOT NULL,
  `mes` int(11) NOT NULL,
  `año` int(11) NOT NULL,
  `montoTotal` float NOT NULL,
  `codEmpleadoCreador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gasto_planilla`
--

INSERT INTO `gasto_planilla` (`codGastoPlanilla`, `fechaGeneracion`, `mes`, `año`, `montoTotal`, `codEmpleadoCreador`) VALUES
(3, '2021-02-26', 1, 2021, 7130.88, 10),
(4, '2021-02-26', 2, 2021, 1927.23, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `justificacion_falta`
--

CREATE TABLE `justificacion_falta` (
  `codRegistroJustificacion` int(11) NOT NULL,
  `codPeriodoEmpleado` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `estado` int(11) NOT NULL,
  `fechaHoraRegistro` datetime NOT NULL,
  `documentoPrueba` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `justificacion_falta`
--

INSERT INTO `justificacion_falta` (`codRegistroJustificacion`, `codPeriodoEmpleado`, `fechaInicio`, `fechaFin`, `descripcion`, `estado`, `fechaHoraRegistro`, `documentoPrueba`) VALUES
(2, 19, '2021-02-20', '2021-02-21', 'Consultas medicas', 3, '2021-02-20 16:13:00', 'justificacion2.pdf'),
(3, 21, '2021-02-24', '2021-02-25', 'Emergencia medica', 2, '2021-02-24 15:45:03', 'justificacion3.pdf'),
(4, 21, '2021-02-25', '2021-02-27', 'Tuve un accidente de tránsito', 1, '2021-02-25 01:24:19', 'justificacion4.pdf'),
(5, 21, '2021-02-25', '2021-02-26', 'Tuve un accidente de tránsito', 0, '2021-02-25 01:24:19', 'justificacion5.pdf'),
(6, 19, '2021-02-25', '2021-02-25', 'Familiar fallecido', 1, '2021-02-25 02:45:28', 'justificacion6.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia_tipo`
--

CREATE TABLE `licencia_tipo` (
  `codTipoSolicitud` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `licencia_tipo`
--

INSERT INTO `licencia_tipo` (`codTipoSolicitud`, `descripcion`) VALUES
(1, 'Vacaciones'),
(2, 'Por maternidad'),
(3, 'Conceptos de Salud');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `codMovimiento` int(11) NOT NULL,
  `tipoMovimiento` char(18) DEFAULT NULL,
  `fecha` char(18) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `codEmpleadoResponsable` char(18) DEFAULT NULL,
  `codEmpleadoEncargadoAlmacen` char(18) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movimiento`
--

INSERT INTO `movimiento` (`codMovimiento`, `tipoMovimiento`, `fecha`, `observaciones`, `descripcion`, `codEmpleadoResponsable`, `codEmpleadoEncargadoAlmacen`, `created_at`, `updated_at`) VALUES
(16, '1', '2021-02-26', 'NINGUNA', 'NINGUNA', '8', '1', '2021-02-26 23:03:54', '2021-02-27 04:03:54'),
(15, '1', '2021-02-17', 'INGRESA PLUMONES DE DISTINTOS COLORES', 'NINGUNA', '11', '1', '2021-02-26 23:01:48', '2021-02-27 04:00:35'),
(14, '1', '2021-02-16', 'SE INGRESAN MATERIALES DE DIFERENTES MATERIALES', 'NINGUNA', '8', '1', '2021-02-26 23:01:41', '2021-02-27 03:59:55'),
(13, '1', '2021-02-15', 'se ingresa cartucho azul , amarillo ,rojo 20 de cada uno y 60 cartuchos negros', 'ninguna', '8', '1', '2021-02-26 23:01:19', '2021-02-27 03:55:54'),
(12, '1', '2021-02-14', 'NINGUNA', 'NINGUNA', '8', '1', '2021-02-26 23:01:10', '2021-02-27 03:53:23'),
(17, '2', '2021-02-26', 'NINGUNA', 'SE EMITEN LAPICEROS DE DIFENTES COLORES', '6', '1', '2021-02-26 23:10:13', '2021-02-27 04:10:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_detalle`
--

CREATE TABLE `movimiento_detalle` (
  `codMovimiento` char(18) DEFAULT NULL,
  `codMovimientoDetalle` int(11) NOT NULL,
  `codExistencia` char(18) DEFAULT NULL,
  `cantidadMovida` char(18) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movimiento_detalle`
--

INSERT INTO `movimiento_detalle` (`codMovimiento`, `codMovimientoDetalle`, `codExistencia`, `cantidadMovida`) VALUES
('1', 1, '1', '1'),
('2', 2, '1', '101'),
('3', 3, '1', '100'),
('4', 4, '2', '100'),
('5', 5, '3', '100'),
('6', 6, '3', '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_caja`
--

CREATE TABLE `periodo_caja` (
  `codPeriodoCaja` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFinal` date DEFAULT NULL,
  `codCaja` int(11) NOT NULL,
  `montoApertura` float NOT NULL,
  `montoFinal` float NOT NULL,
  `codEmpleadoCajero` int(11) NOT NULL,
  `justificacion` varchar(500) DEFAULT NULL,
  `codEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodo_caja`
--

INSERT INTO `periodo_caja` (`codPeriodoCaja`, `fechaInicio`, `fechaFinal`, `codCaja`, `montoApertura`, `montoFinal`, `codEmpleadoCajero`, `justificacion`, `codEstado`) VALUES
(1, '2021-02-08', '2021-02-17', 1, 1400, 1300, 2, 'estoy tratando', 3),
(2, '2021-02-03', NULL, 2, 1500, 900, 6, '', 1),
(3, '2021-02-12', '2021-02-23', 1, 1400, 1048, 2, 'ya gasté todo', 3),
(4, '2021-02-13', '2021-02-23', 1, 1400, 1395, 2, 'gaste poquito', 3),
(5, '2021-02-14', '2021-02-25', 1, 14001, 13976, 7, 'Ya se culmina el mes', 3),
(6, '2021-02-14', NULL, 4, 1555, 1555, 2, NULL, 1),
(7, '2021-02-16', '2021-02-26', 1, 14050, 10150, 11, 'Se realizó capacitaciones presenciales y se registro gastos para implementación de labotarorio', 3),
(8, '2021-02-16', NULL, 1, 14050, 12750, 11, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_empleado`
--

CREATE TABLE `periodo_empleado` (
  `codPeriodoEmpleado` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date DEFAULT NULL,
  `fechaContrato` date NOT NULL,
  `codTurno` int(11) DEFAULT NULL,
  `codEmpleado` int(11) NOT NULL,
  `sueldoFijo` float NOT NULL,
  `activo` int(11) NOT NULL,
  `valorPorHora` float NOT NULL,
  `diasRestantes` int(11) NOT NULL,
  `codPuesto` int(11) DEFAULT NULL,
  `codTipoContrato` int(11) NOT NULL,
  `nombreFinanciador` varchar(300) DEFAULT NULL,
  `motivo` varchar(300) DEFAULT NULL,
  `codAFP` int(11) DEFAULT NULL,
  `asistencia` int(11) NOT NULL,
  `codProyecto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodo_empleado`
--

INSERT INTO `periodo_empleado` (`codPeriodoEmpleado`, `fechaInicio`, `fechaFin`, `fechaContrato`, `codTurno`, `codEmpleado`, `sueldoFijo`, `activo`, `valorPorHora`, `diasRestantes`, `codPuesto`, `codTipoContrato`, `nombreFinanciador`, `motivo`, `codAFP`, `asistencia`, `codProyecto`) VALUES
(19, '2021-02-20', '2021-04-20', '2021-02-20', 12, 2, 1000, 1, 3, 30, 6, 1, 'UNT', NULL, 1, 1, 2),
(21, '2021-02-23', '2021-04-23', '2021-02-23', 13, 7, 1500, 1, 3, 30, 4, 1, 'Empresa', NULL, 2, 1, 3),
(22, '2021-02-23', '2021-05-31', '2021-02-23', NULL, 7, 1000, 3, 3, 30, 1, 1, 'fghfg', NULL, 1, 1, 2),
(23, '2021-02-24', NULL, '2021-02-23', 14, 7, 1850, 3, 3, 30, 1, 1, 'YOLO', NULL, 1, 1, 2),
(24, '2021-02-24', NULL, '2021-02-23', NULL, 7, 1400, 3, 3, 30, 1, 1, 'UNT', NULL, 1, 1, 2),
(25, '2021-02-24', '2021-05-27', '2021-02-24', NULL, 7, 1100, 3, 3, 30, 1, 1, '45245', NULL, 1, 1, 3),
(26, '2021-02-24', '2021-04-24', '2021-02-24', NULL, 2, 2000, 3, 3, 30, NULL, 2, NULL, 'Creación de un programa muy importante', NULL, 0, NULL),
(27, '2021-02-24', NULL, '2021-02-24', NULL, 2, 2100, 3, 3, 30, 6, 1, '7867867', NULL, 1, 1, 3),
(28, '2021-02-26', '2022-03-25', '2021-02-26', 15, 10, 2000, 1, 3, 30, 3, 1, 'Manos Unidas', NULL, 1, 1, 3),
(29, '2021-02-26', '2022-02-26', '2021-02-26', NULL, 11, 2500, 1, 3, 30, 7, 1, 'Manos Unidas', NULL, 3, 1, 2),
(30, '2021-02-26', '2022-02-26', '2021-02-26', NULL, 12, 1500, 1, 3, 30, 1, 1, 'Manos Unidas', NULL, 2, 0, 2),
(31, '2021-02-26', NULL, '2021-02-26', NULL, 13, 1000, 1, 3, 30, 8, 1, 'Backus', NULL, 3, 1, 2),
(32, '2021-02-26', NULL, '2021-02-26', NULL, 14, 2000, 1, 3, 30, 9, 1, 'Plásticos Rey', NULL, 1, 1, 4),
(33, '2021-02-26', NULL, '2021-02-26', 16, 9, 930, 1, 3, 30, 10, 1, 'CEDEPAS', NULL, 2, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `codProyecto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `codEmpleadoDirector` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`codProyecto`, `nombre`, `codEmpleadoDirector`) VALUES
(0, 'Ninguno', NULL),
(2, 'PROMOCIÓN DEL EMPODERAMIENTO DE MUJERES PROMOTORAS RURALES FRENTE AL CORONAVIRUS.', 2),
(3, 'Innovación y equidad para el desarrollo rural en 6 regiones del Perú.', 2),
(4, 'Diseño e implementación del programa de liderazgo de mujeres para la gestión del agua.', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE `puesto` (
  `codPuesto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `codArea` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`codPuesto`, `nombre`, `codArea`, `estado`) VALUES
(1, 'Agricultor', 1, 1),
(2, 'Gerente', 1, 1),
(3, 'Jefe de Administración', 2, 1),
(4, 'Jefe de RRHH', 3, 1),
(6, 'Director', 5, 1),
(7, 'Cajero', 6, 1),
(8, 'Jefe de Inventario', 7, 1),
(9, 'Encargado inventario', 7, 1),
(10, 'Encargado almacén', 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rendicion_gastos`
--

CREATE TABLE `rendicion_gastos` (
  `codRendicionGastos` int(11) NOT NULL,
  `codSolicitud` int(11) NOT NULL,
  `codigoCedepas` varchar(50) NOT NULL,
  `totalImporteRecibido` float DEFAULT NULL,
  `totalImporteRendido` float DEFAULT NULL,
  `saldoAFavorDeEmpleado` float DEFAULT NULL,
  `resumenDeActividad` varchar(200) NOT NULL,
  `estadoDeReposicion` int(11) NOT NULL,
  `fechaRendicion` date DEFAULT NULL,
  `terminacionArchivo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rendicion_gastos`
--

INSERT INTO `rendicion_gastos` (`codRendicionGastos`, `codSolicitud`, `codigoCedepas`, `totalImporteRecibido`, `totalImporteRendido`, `saldoAFavorDeEmpleado`, `resumenDeActividad`, `estadoDeReposicion`, `fechaRendicion`, `terminacionArchivo`) VALUES
(46, 47, 'E001-240221Q6', 113, 90, -23, 'Actividad, sobraron 23 soles', 2, '2021-02-24', 'xlsx'),
(47, 49, 'E001-240221ZV', 151, 200, 49, 'Se gastó 200, me deben 49', 11, '2021-02-24', 'php'),
(48, 51, 'E001-240221CD', 125, 151, 26, 'Deba', 1, '2021-02-24', NULL),
(49, 54, 'E001-250221DB', 125, 121, -4, 'aa', 2, '2021-02-25', 'php'),
(50, 56, 'E0013-260221UO', 100, 90, -10, 'arroz comprado', 2, '2021-02-26', 'jpg'),
(51, 57, 'E0013-260221WN', 100, 90, -10, 'Actividad capacitacion 28 de febrero\r\ncomprados en libreria', 2, '2021-02-26', 'jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revision`
--

CREATE TABLE `revision` (
  `codRevision` int(11) NOT NULL,
  `fechaHoraInicio` datetime NOT NULL,
  `fechaHoraCierre` datetime DEFAULT NULL,
  `codEmpleadoResponsable` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `revision`
--

INSERT INTO `revision` (`codRevision`, `fechaHoraInicio`, `fechaHoraCierre`, `codEmpleadoResponsable`, `descripcion`) VALUES
(2, '2021-02-22 12:42:17', '2021-02-22 20:53:22', 2, 'Primera revision del año'),
(3, '2021-02-22 21:05:01', '2021-02-26 18:51:49', 2, 'Revisión almacen 3'),
(4, '2021-02-23 12:24:56', '2021-02-23 12:27:01', 6, 'Revisión oficina 5'),
(5, '2021-02-23 12:33:30', '2021-02-23 12:36:11', 6, 'Revisión cuarto de técnicos'),
(6, '2021-02-23 12:50:49', '2021-02-23 13:06:53', 2, 'Revisión cuarto de implementos de limpieza.'),
(13, '2021-02-23 17:00:06', '2021-02-23 17:03:21', 2, 'Revisión oficina de administrador'),
(14, '2021-02-24 22:25:23', '2021-02-25 01:24:41', 8, 'Revisión de inventarios almacén 1'),
(15, '2021-02-25 23:02:20', '2021-02-25 23:17:07', 8, 'Conteo de almacén 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revision_detalle`
--

CREATE TABLE `revision_detalle` (
  `codRevisionDetalle` int(11) NOT NULL,
  `codRevision` int(11) NOT NULL,
  `codActivo` int(11) NOT NULL,
  `codEstado` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `seReviso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `revision_detalle`
--

INSERT INTO `revision_detalle` (`codRevisionDetalle`, `codRevision`, `codActivo`, `codEstado`, `activo`, `seReviso`) VALUES
(1, 2, 1, 3, 1, 1),
(2, 2, 2, 2, 0, 1),
(3, 2, 3, 4, 1, 1),
(4, 3, 1, 4, 1, 1),
(6, 3, 3, 2, 1, 1),
(8, 4, 1, 4, 0, 1),
(9, 4, 3, 1, 1, 1),
(10, 4, 4, 2, 0, 1),
(11, 5, 3, 1, 1, 1),
(12, 5, 5, 3, 1, 1),
(13, 5, 6, 1, 1, 1),
(14, 6, 3, 1, 1, 1),
(15, 6, 5, 2, 1, 1),
(16, 6, 6, 1, 1, 1),
(17, 7, 3, 1, 1, 1),
(18, 7, 5, 2, 1, 0),
(19, 7, 6, 1, 1, 1),
(20, 8, 3, 1, 1, 0),
(21, 8, 5, 2, 1, 0),
(22, 8, 6, 1, 1, 0),
(23, 9, 3, 1, 1, 0),
(24, 9, 5, 2, 1, 0),
(25, 9, 6, 1, 1, 0),
(26, 10, 3, 1, 1, 0),
(27, 10, 5, 2, 1, 0),
(28, 10, 6, 1, 1, 0),
(29, 11, 3, 1, 1, 0),
(30, 11, 5, 2, 1, 0),
(31, 11, 6, 1, 1, 0),
(32, 12, 3, 1, 1, 0),
(33, 12, 5, 2, 1, 0),
(34, 12, 6, 1, 1, 0),
(35, 13, 3, 2, 1, 1),
(36, 13, 5, 2, 0, 1),
(37, 13, 6, 1, 1, 1),
(38, 14, 1, 2, 1, 1),
(39, 14, 3, 2, 0, 1),
(40, 14, 6, 4, 1, 1),
(41, 15, 1, 2, 1, 0),
(42, 15, 2, 1, 1, 1),
(43, 15, 6, 2, 1, 0),
(44, 15, 7, 2, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `codSede` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`codSede`, `nombre`) VALUES
(1, 'Trujillo'),
(2, 'Cajamarca'),
(4, 'Lima'),
(5, 'Santiago de Chuco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_falta`
--

CREATE TABLE `solicitud_falta` (
  `codRegistroSolicitud` int(11) NOT NULL,
  `codPeriodoEmpleado` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `estado` int(11) NOT NULL,
  `fechaHoraRegistro` datetime NOT NULL,
  `codTipoSolicitud` int(11) NOT NULL,
  `documentoPrueba` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `solicitud_falta`
--

INSERT INTO `solicitud_falta` (`codRegistroSolicitud`, `codPeriodoEmpleado`, `fechaInicio`, `fechaFin`, `descripcion`, `estado`, `fechaHoraRegistro`, `codTipoSolicitud`, `documentoPrueba`) VALUES
(29, 19, '2021-02-20', '2021-02-22', 'Se le solicita tiempo para faltas', 2, '2021-02-20 16:02:01', 1, 'solicitud29.pdf'),
(30, 21, '2021-02-24', '2021-02-25', 'Por cumpleaños', 3, '2021-02-24 15:44:33', 1, 'solicitud30.pdf'),
(31, 21, '2021-02-25', '2021-02-28', 'Tengo 5 meses de embarazo, solicitud falta por consulta', 1, '2021-02-25 01:09:11', 2, 'solicitud31.pdf'),
(32, 19, '2021-02-25', '2021-03-26', 'Emergencia medica', 1, '2021-02-25 01:17:23', 2, 'solicitud32.pdf'),
(33, 21, '2021-02-26', '2021-02-27', 'Solo 2 dias', 1, '2021-02-26 01:35:01', 1, 'solicitud33.pdf'),
(34, 21, '2021-02-26', '2021-03-07', 'Control natal', 1, '2021-02-26 02:00:07', 2, 'solicitud34.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_fondos`
--

CREATE TABLE `solicitud_fondos` (
  `codSolicitud` int(11) NOT NULL,
  `codProyecto` int(11) NOT NULL,
  `codigoCedepas` varchar(200) NOT NULL,
  `codEmpleadoSolicitante` int(11) NOT NULL,
  `fechaHoraEmision` datetime NOT NULL,
  `totalSolicitado` float DEFAULT NULL,
  `girarAOrdenDe` varchar(200) NOT NULL,
  `numeroCuentaBanco` varchar(200) NOT NULL,
  `codBanco` int(11) NOT NULL,
  `justificacion` varchar(500) NOT NULL,
  `codEmpleadoEvaluador` int(11) DEFAULT NULL,
  `fechaHoraRevisado` datetime DEFAULT NULL,
  `codEstadoSolicitud` int(11) NOT NULL,
  `codSede` int(11) NOT NULL,
  `fechaHoraAbonado` datetime DEFAULT NULL,
  `razonRechazo` varchar(300) DEFAULT NULL,
  `terminacionArchivo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `solicitud_fondos`
--

INSERT INTO `solicitud_fondos` (`codSolicitud`, `codProyecto`, `codigoCedepas`, `codEmpleadoSolicitante`, `fechaHoraEmision`, `totalSolicitado`, `girarAOrdenDe`, `numeroCuentaBanco`, `codBanco`, `justificacion`, `codEmpleadoEvaluador`, `fechaHoraRevisado`, `codEstadoSolicitud`, `codSede`, `fechaHoraAbonado`, `razonRechazo`, `terminacionArchivo`) VALUES
(47, 3, 'E001-240221ZL', 1, '2021-02-24 19:23:38', 113, 'Juan Valdez Gutierrez Uriol', '214124 124 1242145', 4, 'Para proyecto X', 1, '2021-02-24 19:24:47', 4, 2, '2021-02-24 19:25:31', NULL, 'php'),
(49, 2, 'E001-240221RJ', 1, '2021-02-24 20:02:55', 151, 'Juan Valdez Gutierrez Uriol', '214124 124 124214', 3, '215521asdasd', 1, '2021-02-24 20:03:25', 4, 2, '2021-02-24 20:03:58', NULL, 'php'),
(50, 2, 'E001-240221W4', 1, '2021-02-24 22:30:33', 124, 'Cesar Arellano', '214141 244214 21142', 3, 'adsasd saddsa', 1, '2021-02-24 22:31:44', 5, 2, NULL, 'Invalido', NULL),
(51, 3, 'E001-240221CI', 1, '2021-02-24 22:47:20', 125, 'Elisa Margarita Maslucán Rojas', '215125 125 21521', 3, 'asd d sadsa dsa', 1, '2021-02-24 22:47:31', 4, 2, '2021-02-24 22:53:58', NULL, 'php'),
(52, 2, 'E008-250221SG', 2, '2021-02-25 17:46:21', 70, 'Elisa Margarita Maslucán Rojas', '214124 124 124214', 3, 'Útiles Para la capacitación', 2, '2021-02-25 17:54:34', 3, 2, '2021-02-25 18:01:35', NULL, 'jpg'),
(53, 4, 'E008-250221L1', 2, '2021-02-25 17:49:18', 252, 'Juan Valdez Gutierrez Uriol', '114455232-411', 1, 'La cafetera principal del proyecto de investigación se averió', NULL, NULL, 1, 4, NULL, NULL, NULL),
(54, 2, 'E001-250221T3', 1, '2021-02-25 18:14:09', 125, 'Juan Valdez Gutierrez Uriol', '214124 124 124214', 3, 'Proyecto', 1, '2021-02-25 18:14:34', 4, 1, '2021-02-25 18:14:47', NULL, 'jpg'),
(55, 3, 'E001-250221EW', 1, '2021-02-25 19:18:55', 125, 'asddsasda', 'a', 3, 'ads', NULL, NULL, 1, 4, NULL, NULL, NULL),
(56, 2, 'E0013-260221XY', 12, '2021-02-26 13:29:23', 100, 'Juan Hernando Valla Valdez', '145-1555549878', 2, 'Sacos de arroz para actividades olla comun', 2, '2021-02-26 13:31:15', 4, 2, '2021-02-26 13:31:42', NULL, 'jpg'),
(57, 2, 'E0013-260221B7', 12, '2021-02-26 18:43:57', 100, 'Juan Valdez Gutierrez Uriol', '214124 124 124214', 2, 'Fondos para capacitacion del día 28/02/2021', 2, '2021-02-26 18:45:16', 4, 1, '2021-02-26 18:45:37', NULL, 'jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sueldo_mes`
--

CREATE TABLE `sueldo_mes` (
  `codSueldoMes` int(11) NOT NULL,
  `codPeriodoEmpleado` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `diaInicio` int(11) NOT NULL,
  `sueldoMensual` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sueldo_mes`
--

INSERT INTO `sueldo_mes` (`codSueldoMes`, `codPeriodoEmpleado`, `anio`, `mes`, `diaInicio`, `sueldoMensual`) VALUES
(9, 19, 2021, 2, 20, 2000),
(10, 19, 2021, 3, 20, 2000),
(11, 21, 2021, 2, 23, 2500),
(12, 21, 2021, 3, 23, 2500),
(13, 22, 2021, 2, 23, 166668),
(14, 22, 2021, 3, 23, 166668),
(15, 22, 2021, 4, 23, 166668),
(16, 24, 2021, 2, 24, 37787800),
(17, 24, 2021, 3, 24, 37787800),
(18, 24, 2021, 4, 24, 37787800),
(19, 24, 2021, 5, 24, 37787800),
(20, 24, 2021, 6, 24, 37787800),
(21, 24, 2021, 7, 24, 37787800),
(22, 24, 2021, 8, 24, 37787800),
(23, 24, 2021, 9, 24, 37787800),
(24, 24, 2021, 10, 24, 37787800),
(25, 24, 2021, 11, 24, 37787800),
(26, 24, 2021, 12, 24, 37787800),
(27, 24, 2022, 1, 24, 37787800),
(28, 25, 2021, 2, 24, 16666.7),
(29, 25, 2021, 3, 24, 16666.7),
(30, 25, 2021, 4, 24, 16666.7),
(31, 27, 2021, 2, 24, 678679000),
(32, 27, 2021, 3, 24, 678679000),
(33, 27, 2021, 4, 24, 678679000),
(34, 27, 2021, 5, 24, 678679000),
(35, 27, 2021, 6, 24, 678679000),
(36, 27, 2021, 7, 24, 678679000),
(37, 27, 2021, 8, 24, 678679000),
(38, 27, 2021, 9, 24, 678679000),
(39, 27, 2021, 10, 24, 678679000),
(40, 27, 2021, 11, 24, 678679000),
(41, 27, 2021, 12, 24, 678679000),
(42, 27, 2022, 1, 24, 678679000),
(43, 28, 2021, 2, 26, 2000),
(44, 28, 2021, 3, 26, 2000),
(45, 28, 2021, 4, 26, 2000),
(46, 28, 2021, 5, 26, 2000),
(47, 28, 2021, 6, 26, 2000),
(48, 28, 2021, 7, 26, 2000),
(49, 28, 2021, 8, 26, 2000),
(50, 28, 2021, 9, 26, 2000),
(51, 28, 2021, 10, 26, 2000),
(52, 28, 2021, 11, 26, 2000),
(53, 28, 2021, 12, 26, 2000),
(54, 28, 2022, 1, 26, 2000),
(55, 29, 2021, 2, 26, 2500),
(56, 29, 2021, 3, 26, 2500),
(57, 29, 2021, 4, 26, 2500),
(58, 29, 2021, 5, 26, 2500),
(59, 29, 2021, 6, 26, 2500),
(60, 29, 2021, 7, 26, 2500),
(61, 29, 2021, 8, 26, 2500),
(62, 29, 2021, 9, 26, 2500),
(63, 29, 2021, 10, 26, 2500),
(64, 29, 2021, 11, 26, 2500),
(65, 29, 2021, 12, 26, 2500),
(66, 29, 2022, 1, 26, 2500),
(67, 30, 2021, 2, 26, 1500),
(68, 30, 2021, 3, 26, 1500),
(69, 30, 2021, 4, 26, 1500),
(70, 30, 2021, 5, 26, 1500),
(71, 30, 2021, 6, 26, 1500),
(72, 30, 2021, 7, 26, 1500),
(73, 30, 2021, 8, 26, 1500),
(74, 30, 2021, 9, 26, 1500),
(75, 30, 2021, 10, 26, 1500),
(76, 30, 2021, 11, 26, 1500),
(77, 30, 2021, 12, 26, 1500),
(78, 30, 2022, 1, 26, 1500),
(79, 31, 2021, 2, 26, 1000),
(80, 31, 2021, 3, 26, 1000),
(81, 31, 2021, 4, 26, 1000),
(82, 31, 2021, 5, 26, 1000),
(83, 31, 2021, 6, 26, 1000),
(84, 31, 2021, 7, 26, 1000),
(85, 31, 2021, 8, 26, 1000),
(86, 31, 2021, 9, 26, 1000),
(87, 31, 2021, 10, 26, 1000),
(88, 31, 2021, 11, 26, 1000),
(89, 31, 2021, 12, 26, 1000),
(90, 31, 2022, 1, 26, 1000),
(91, 32, 2021, 2, 26, 2000),
(92, 32, 2021, 3, 26, 2000),
(93, 32, 2021, 4, 26, 2000),
(94, 32, 2021, 5, 26, 2000),
(95, 32, 2021, 6, 26, 2000),
(96, 32, 2021, 7, 26, 2000),
(97, 32, 2021, 8, 26, 2000),
(98, 32, 2021, 9, 26, 2000),
(99, 32, 2021, 10, 26, 2000),
(100, 32, 2021, 11, 26, 2000),
(101, 32, 2021, 12, 26, 2000),
(102, 32, 2022, 1, 26, 2000),
(103, 33, 2021, 2, 26, 930),
(104, 33, 2021, 3, 26, 930),
(105, 33, 2021, 4, 26, 930),
(106, 33, 2021, 5, 26, 930),
(107, 33, 2021, 6, 26, 930),
(108, 33, 2021, 7, 26, 930),
(109, 33, 2021, 8, 26, 930),
(110, 33, 2021, 9, 26, 930),
(111, 33, 2021, 10, 26, 930),
(112, 33, 2021, 11, 26, 930),
(113, 33, 2021, 12, 26, 930),
(114, 33, 2022, 1, 26, 930);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `codTurno` int(11) NOT NULL,
  `horaInicio` time DEFAULT NULL,
  `horaFin` time DEFAULT NULL,
  `horaInicio2` time DEFAULT NULL,
  `horaFin2` time DEFAULT NULL,
  `codTipoTurno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`codTurno`, `horaInicio`, `horaFin`, `horaInicio2`, `horaFin2`, `codTipoTurno`) VALUES
(12, '08:00:00', '13:00:00', '16:00:00', '17:00:00', 3),
(13, '08:00:00', '13:00:00', '14:00:00', '18:00:00', 3),
(14, '08:00:00', '13:00:00', '14:00:00', '18:00:00', 3),
(15, '07:00:00', '13:00:00', NULL, NULL, 1),
(16, '09:00:00', '13:00:00', '15:00:00', '18:00:00', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno_tipo`
--

CREATE TABLE `turno_tipo` (
  `codTipoTurno` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `turno_tipo`
--

INSERT INTO `turno_tipo` (`codTipoTurno`, `nombre`) VALUES
(1, 'Mañana'),
(2, 'Tarde'),
(3, 'Mañana y Tarde');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `codUsuario` bigint(20) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `isAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`codUsuario`, `usuario`, `password`, `isAdmin`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(2, 'vigo', '$2y$10$iFUlWmc29pRTFM7cCz9CcO7P5h2i1M97GUI1jAq/vZroCXa9uE9ke', 0),
(3, 'felix', '$2y$10$esGFAWbCExCUjF2p5YzI/uO.bNi4lJgIvY8hYyi6nWpXoYP63UEJa', 0),
(4, 'felix', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0),
(5, 'mari', '$2y$10$I6Qn3k6en/DCcTuGzbEXoO6nGNK5jydM5/hY7VLceMZ.gbr7sLR5W', 1),
(8, 'franco', '$2y$10$iFUlWmc29pRTFM7cCz9CcO7P5h2i1M97GUI1jAq/vZroCXa9uE9ke', 0),
(9, 'jorge', '$2y$10$xvxA8.6DlIFcmuhFyqQDGeZ5cwayga5BYGS78z21X.QrOwj2AMxJ6', 0),
(11, 'eli', '$2y$10$L9TIHlrX0AN/Rxhf/iPYHuoSysgFL0j0Jdch9elTijx8Bn9aSEpBy', 0),
(12, 'mary', '$2y$10$yQnO9tGhTIqUWq29ixIUKOJAYG4wY9oVhcOgt75RHRBkIXx.bVPgy', 0),
(13, 'juan', '$2y$10$/kBMO84j6RVHHmCBrN5xCufwgNcjVTqPmaGkbb/8Wk3u7kaVbxN5m', 0),
(14, 'renzo', '$2y$10$y/7kU/atVmMWv4J93yqule9/ohR47JdGA4ESTZtToRRqWfp9LFTsy', 0),
(15, 'eloy', '$2y$10$5IXAzj7ZvIaUSvRmGQmsFOvdE6tYTXtM0j4AWSE6p6moIKcpPb8KO', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activo`
--
ALTER TABLE `activo`
  ADD PRIMARY KEY (`codActivo`);

--
-- Indices de la tabla `afp`
--
ALTER TABLE `afp`
  ADD PRIMARY KEY (`codAFP`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`codArea`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`codRegistroAsistencia`);

--
-- Indices de la tabla `avance_entregable`
--
ALTER TABLE `avance_entregable`
  ADD PRIMARY KEY (`codAvanceEntregable`);

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`codBanco`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`codCaja`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codCategoria`);

--
-- Indices de la tabla `categoria_activo`
--
ALTER TABLE `categoria_activo`
  ADD PRIMARY KEY (`codCategoriaActivo`);

--
-- Indices de la tabla `cdp`
--
ALTER TABLE `cdp`
  ADD PRIMARY KEY (`codTipoCDP`);

--
-- Indices de la tabla `contrato_tipo`
--
ALTER TABLE `contrato_tipo`
  ADD PRIMARY KEY (`codTipoContrato`);

--
-- Indices de la tabla `detalle_gasto_planilla`
--
ALTER TABLE `detalle_gasto_planilla`
  ADD PRIMARY KEY (`codDetalleGastoPlanilla`);

--
-- Indices de la tabla `detalle_rendicion_gastos`
--
ALTER TABLE `detalle_rendicion_gastos`
  ADD PRIMARY KEY (`codDetalleRendicion`);

--
-- Indices de la tabla `detalle_solicitud_fondos`
--
ALTER TABLE `detalle_solicitud_fondos`
  ADD PRIMARY KEY (`codDetalleSolicitud`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`codEmpleado`);

--
-- Indices de la tabla `estado_activo`
--
ALTER TABLE `estado_activo`
  ADD PRIMARY KEY (`codEstado`);

--
-- Indices de la tabla `estado_periodo_caja`
--
ALTER TABLE `estado_periodo_caja`
  ADD PRIMARY KEY (`codEstado`);

--
-- Indices de la tabla `estado_solicitud_fondos`
--
ALTER TABLE `estado_solicitud_fondos`
  ADD PRIMARY KEY (`codEstadoSolicitud`);

--
-- Indices de la tabla `existencia`
--
ALTER TABLE `existencia`
  ADD PRIMARY KEY (`codExistencia`),
  ADD KEY `R_27` (`codCategoria`);

--
-- Indices de la tabla `existencias_perdidas`
--
ALTER TABLE `existencias_perdidas`
  ADD PRIMARY KEY (`codExistenciaPerdida`),
  ADD KEY `R_28` (`codEmpleadoEncargadoAlmacen`),
  ADD KEY `R_29` (`codExistencia`);

--
-- Indices de la tabla `gasto_caja`
--
ALTER TABLE `gasto_caja`
  ADD PRIMARY KEY (`codGastoPeriodo`);

--
-- Indices de la tabla `gasto_planilla`
--
ALTER TABLE `gasto_planilla`
  ADD PRIMARY KEY (`codGastoPlanilla`);

--
-- Indices de la tabla `justificacion_falta`
--
ALTER TABLE `justificacion_falta`
  ADD PRIMARY KEY (`codRegistroJustificacion`);

--
-- Indices de la tabla `licencia_tipo`
--
ALTER TABLE `licencia_tipo`
  ADD PRIMARY KEY (`codTipoSolicitud`);

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`codMovimiento`),
  ADD KEY `R_26` (`codEmpleadoResponsable`),
  ADD KEY `R_30` (`codEmpleadoEncargadoAlmacen`);

--
-- Indices de la tabla `movimiento_detalle`
--
ALTER TABLE `movimiento_detalle`
  ADD PRIMARY KEY (`codMovimientoDetalle`),
  ADD KEY `R_24` (`codMovimiento`),
  ADD KEY `R_25` (`codExistencia`);

--
-- Indices de la tabla `periodo_caja`
--
ALTER TABLE `periodo_caja`
  ADD PRIMARY KEY (`codPeriodoCaja`);

--
-- Indices de la tabla `periodo_empleado`
--
ALTER TABLE `periodo_empleado`
  ADD PRIMARY KEY (`codPeriodoEmpleado`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`codProyecto`);

--
-- Indices de la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`codPuesto`);

--
-- Indices de la tabla `rendicion_gastos`
--
ALTER TABLE `rendicion_gastos`
  ADD PRIMARY KEY (`codRendicionGastos`);

--
-- Indices de la tabla `revision`
--
ALTER TABLE `revision`
  ADD PRIMARY KEY (`codRevision`);

--
-- Indices de la tabla `revision_detalle`
--
ALTER TABLE `revision_detalle`
  ADD PRIMARY KEY (`codRevisionDetalle`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`codSede`);

--
-- Indices de la tabla `solicitud_falta`
--
ALTER TABLE `solicitud_falta`
  ADD PRIMARY KEY (`codRegistroSolicitud`);

--
-- Indices de la tabla `solicitud_fondos`
--
ALTER TABLE `solicitud_fondos`
  ADD PRIMARY KEY (`codSolicitud`);

--
-- Indices de la tabla `sueldo_mes`
--
ALTER TABLE `sueldo_mes`
  ADD PRIMARY KEY (`codSueldoMes`);

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`codTurno`);

--
-- Indices de la tabla `turno_tipo`
--
ALTER TABLE `turno_tipo`
  ADD PRIMARY KEY (`codTipoTurno`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activo`
--
ALTER TABLE `activo`
  MODIFY `codActivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `afp`
--
ALTER TABLE `afp`
  MODIFY `codAFP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `codArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `codRegistroAsistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `avance_entregable`
--
ALTER TABLE `avance_entregable`
  MODIFY `codAvanceEntregable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `codBanco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `codCaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `codCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categoria_activo`
--
ALTER TABLE `categoria_activo`
  MODIFY `codCategoriaActivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cdp`
--
ALTER TABLE `cdp`
  MODIFY `codTipoCDP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `contrato_tipo`
--
ALTER TABLE `contrato_tipo`
  MODIFY `codTipoContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_gasto_planilla`
--
ALTER TABLE `detalle_gasto_planilla`
  MODIFY `codDetalleGastoPlanilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_rendicion_gastos`
--
ALTER TABLE `detalle_rendicion_gastos`
  MODIFY `codDetalleRendicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `detalle_solicitud_fondos`
--
ALTER TABLE `detalle_solicitud_fondos`
  MODIFY `codDetalleSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `codEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `estado_activo`
--
ALTER TABLE `estado_activo`
  MODIFY `codEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_periodo_caja`
--
ALTER TABLE `estado_periodo_caja`
  MODIFY `codEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado_solicitud_fondos`
--
ALTER TABLE `estado_solicitud_fondos`
  MODIFY `codEstadoSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `existencia`
--
ALTER TABLE `existencia`
  MODIFY `codExistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `existencias_perdidas`
--
ALTER TABLE `existencias_perdidas`
  MODIFY `codExistenciaPerdida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `gasto_caja`
--
ALTER TABLE `gasto_caja`
  MODIFY `codGastoPeriodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `gasto_planilla`
--
ALTER TABLE `gasto_planilla`
  MODIFY `codGastoPlanilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `justificacion_falta`
--
ALTER TABLE `justificacion_falta`
  MODIFY `codRegistroJustificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `licencia_tipo`
--
ALTER TABLE `licencia_tipo`
  MODIFY `codTipoSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `codMovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `movimiento_detalle`
--
ALTER TABLE `movimiento_detalle`
  MODIFY `codMovimientoDetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `periodo_caja`
--
ALTER TABLE `periodo_caja`
  MODIFY `codPeriodoCaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `periodo_empleado`
--
ALTER TABLE `periodo_empleado`
  MODIFY `codPeriodoEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `codProyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `codPuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rendicion_gastos`
--
ALTER TABLE `rendicion_gastos`
  MODIFY `codRendicionGastos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `revision`
--
ALTER TABLE `revision`
  MODIFY `codRevision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `revision_detalle`
--
ALTER TABLE `revision_detalle`
  MODIFY `codRevisionDetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `codSede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitud_falta`
--
ALTER TABLE `solicitud_falta`
  MODIFY `codRegistroSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `solicitud_fondos`
--
ALTER TABLE `solicitud_fondos`
  MODIFY `codSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `sueldo_mes`
--
ALTER TABLE `sueldo_mes`
  MODIFY `codSueldoMes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `codTurno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `turno_tipo`
--
ALTER TABLE `turno_tipo`
  MODIFY `codTipoTurno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codUsuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
