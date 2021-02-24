-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2021 a las 08:50:10
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
(1, 2, 2, 'Camioneta 4x4', 'Los autos', 1, 1, 4, 0, '3851-6516'),
(2, 2, 2, 'Mueble', 'Muebles akw2', 3, 1, 3, 0, NULL),
(3, 3, 2, 'Librero', 'Es grande', 3, 2, 2, 1, NULL),
(4, 4, 6, 'Moto', 'modelo tokaw', 1, 1, 2, 0, '3521-654'),
(5, 3, 6, 'Telefono', 'Rin Rin', 3, 1, 2, 1, NULL),
(6, 2, 2, 'Televisor', 'tv', 3, 2, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afp`
--

CREATE TABLE `afp` (
  `codAFP` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `afp`
--

INSERT INTO `afp` (`codAFP`, `nombre`) VALUES
(1, 'PRIMA'),
(2, 'SNP'),
(3, 'INTEGRA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `codArea` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`codArea`, `nombre`) VALUES
(1, 'Gerencia');

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
(13, 19, NULL, NULL, '2021-02-20 16:01:21', '2021-02-20 16:01:26', 1, '2021-02-20'),
(14, 21, NULL, NULL, '2021-02-23 16:44:30', '2021-02-23 16:44:37', 2, '2021-02-23'),
(15, 21, NULL, NULL, NULL, NULL, 1, '2021-02-24');

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
(1, 'Huamachucos', 2, 14050, 13976, 7, 1),
(2, 'Trujillo', 3, 1500, 900, 6, 1),
(3, 'Huamachuco', 4, 1555, 1555, 0, 0),
(4, 'Cajamarca', 4, 1555, 1555, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `codCategoria` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(17, 29, '2020-02-17', '125125', 'as dads das', 125, 'adad', 8, 'jpeg', 1),
(18, 31, '2020-02-18', 'asd', 'ads', 25, 'asd', 8, 'iss', 1),
(19, 31, '2020-02-18', 'asd', 'ads', 2, 'asd', 3, 'iss', 2),
(20, 32, '2020-02-18', 'aasd', 'asbsadb', 25, 'asdb', 9, 'iss', 1),
(21, 32, '2020-02-18', 'asd', 'asd', 125, 'ads', 2, 'pdf', 2),
(22, 34, '2020-02-18', '12512', 'asd ads a', 21, 'asdad', 8, 'pdf', 1),
(23, 34, '2020-02-18', 'adsads', 'asddsa', 1511, 'adsasd', 2, 'pdf', 2),
(24, 35, '2020-02-18', 'ads', 'dsadsa', 1251, 'dsasad', 1, 'iss', 1),
(25, 35, '2020-02-18', 'das', 'adsasd', 1511, 'asd', 3, 'jpeg', 2),
(26, 36, '2020-02-18', 'adsads', 'ads', 1211, 'ads', 2, 'iss', 1),
(27, 36, '2020-02-18', 'das', 'adsasd', 151, 'ads', 6, 'pdf', 2),
(28, 37, '2020-01-19', '15212215', 'asdsab dsdbdsab', 15, '23131', 4, 'iss', 1),
(29, 38, '2020-02-20', '152152', 'adsdsa', 15, 'dsadsa', 11, 'sql', 1),
(30, 39, '2020-01-06', '1151131', 'Gaseosas de 3 litros', 15, '11121212', 1, 'pdf', 1),
(31, 39, '2020-02-23', '125125', 'Leche', 12, '121121', 4, 'pdf', 2);

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
(97, 32, 1, 'adssad ads', 125, '125125'),
(98, 33, 1, 'as da ds', 25, 'asd sad ads'),
(99, 34, 1, 'asdsad', 251, 'asdads'),
(100, 34, 2, 'adsdsa', 1, 'asdads'),
(101, 35, 1, 'dasdsad', 125, 'dsads'),
(102, 36, 1, 'asddsaasa', 121, 'asdasd'),
(103, 38, 1, 'asdasd', 15.3, 'asdasd'),
(104, 38, 2, 'ads', 1111, 'asdads'),
(105, 39, 1, 'asdsad', 125, 'dsasad'),
(108, 40, 1, 'adas', 2152, 'adsad'),
(109, 41, 1, 'dsa da s', 151, '23123123321'),
(111, 42, 1, 'asd', 25, '125'),
(113, 43, 1, 'dsadas', 151, 'sdasad'),
(114, 44, 1, 'gaseosa', 20, '111425156'),
(115, 45, 1, 'adssad', 25, '15152152');

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
(1, 1, 'admin', '', 'Iquitos 208 - Aranjuez', '2000-04-28', 'M', 0, 1, 'E001', '73742090', 2),
(2, 2, 'Diego Ernesto', 'Vigo Briones', 'Iquitos 208 - Aranjuezzzz', '2002-02-04', '1', 1, 1, 'E008', '73742090', 2),
(6, 3, 'Isaac Juan', 'Jimenez Valdivia', 'Saltillo', '2020-10-12', 'M', 1, 1, 'E0213', '12341234', 3),
(7, 5, 'Maricielo Estefany', 'Rodriguez Paredes', 'Av. Juan Manuel Ozuna # 2', '2000-01-05', '2', 1, 1, 'E1512', '98751563', 2),
(8, 8, 'Renzo Junior', 'Franco Valladolid', 'CALLE AGUSTIN LARA NO. 69-B', '2000-02-23', '1', 0, 1, 'E008', '45978635', 3);

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
  `stock` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `unidad` varchar(100) NOT NULL,
  `codCategoria` int(11) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `codigoInterno` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencias_perdidas`
--

CREATE TABLE `existencias_perdidas` (
  `codExistenciaPerdida` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `codEmpleadoEncargadoAlmacen` int(11) NOT NULL,
  `codExistencia` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(13, 5, 'Compra de ventilador pequeño', 25, 7, '2021-02-24', 3, 'erwin', 1, '1121221', '1515125521');

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
(2, 19, '2021-02-20', '2021-02-21', 'Consultas medicas', 3, '2021-02-20 16:13:00', 'justificacion2.pdf');

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
(2, 'Por maternidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `codMovimiento` int(11) NOT NULL,
  `tipoMovimiento` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` varchar(300) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `codEmpleadoResponsable` int(11) NOT NULL,
  `codEmpleadoEncargadoAlmacen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_detalle`
--

CREATE TABLE `movimiento_detalle` (
  `codMovimientoDetalle` int(11) NOT NULL,
  `codMovimiento` int(11) NOT NULL,
  `codExistencia` int(11) NOT NULL,
  `cantidadMovida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(5, '2021-02-14', NULL, 1, 14001, 13976, 7, NULL, 1);

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
  `nombreProyecto` varchar(300) DEFAULT NULL,
  `motivo` varchar(300) DEFAULT NULL,
  `codAFP` int(11) DEFAULT NULL,
  `asistencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodo_empleado`
--

INSERT INTO `periodo_empleado` (`codPeriodoEmpleado`, `fechaInicio`, `fechaFin`, `fechaContrato`, `codTurno`, `codEmpleado`, `sueldoFijo`, `activo`, `valorPorHora`, `diasRestantes`, `codPuesto`, `codTipoContrato`, `nombreFinanciador`, `nombreProyecto`, `motivo`, `codAFP`, `asistencia`) VALUES
(19, '2021-02-20', '2021-04-20', '2021-02-20', 12, 2, 4000, 1, 3, 30, 1, 1, 'UNT', 'Hacer una app', NULL, 1, 1),
(21, '2021-02-23', '2021-04-23', '2021-02-23', 13, 7, 5000, 1, 3, 30, 2, 1, 'Empresa', 'CUMBRES HERMOSAS', NULL, 1, 1),
(22, '2021-02-23', '2021-05-31', '2021-02-23', NULL, 7, 500005, 3, 3, 30, 1, 1, 'fghfg', 'gfhfgh', NULL, 1, 1),
(23, '2021-02-24', NULL, '2021-02-23', NULL, 7, 50000, 3, 3, 30, 1, 1, 'YOLO', 'Aprobar los cursos', NULL, 1, 1),
(24, '2021-02-24', NULL, '2021-02-23', NULL, 7, 453453000, 3, 3, 30, 1, 1, 'UNT', 'loooo', NULL, 1, 1);

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
  `codArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`codPuesto`, `nombre`, `codArea`) VALUES
(1, 'Agricultor', 1),
(2, 'Gerente', 1);

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
  `fechaRendicion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rendicion_gastos`
--

INSERT INTO `rendicion_gastos` (`codRendicionGastos`, `codSolicitud`, `codigoCedepas`, `totalImporteRecibido`, `totalImporteRendido`, `saldoAFavorDeEmpleado`, `resumenDeActividad`, `estadoDeReposicion`, `fechaRendicion`) VALUES
(29, 32, 'E0111-170221W3', 125, 125, 0, '125  as as', 1, '2021-02-17'),
(31, 33, 'E0111-180221YF', 25, 27, 2, 'asdasdbas dbasdbaab asdb sb ds', 1, '2021-02-18'),
(32, 34, 'E0111-180221VG', 252, 150, -102, 'adsasdbasdbsad', 1, '2021-02-18'),
(34, 35, 'E0111-180221KJ', 125, 1532, 1407, 'ads dasads', 1, '2021-02-18'),
(35, 36, 'E0111-180221SH', 121, 2762, 2641, 'adssadbasbasd', 1, '2021-02-18'),
(36, 38, 'E0111-180221NY', 1126.3, 1362, 235.7, 'asddasbasasa a sbdasbasas sbasas vsbasassbasassbasas', 1, '2021-02-18'),
(37, 39, 'E0111-200221WG', 125, 15, -110, 'ads d sdsdas', 1, '2021-02-20'),
(38, 41, 'E001-200221R0', 151, 15, -136, 'ads sads ds adsa', 1, '2021-02-20'),
(39, 44, 'E008-230221P6', 20, 27, 7, 'La actividdad X se realizó con normalidad...', 1, '2021-02-23');

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
(3, '2021-02-22 21:05:01', '2021-02-22 22:53:45', 2, 'hola'),
(4, '2021-02-23 12:24:56', '2021-02-23 12:27:01', 6, 'A probar'),
(5, '2021-02-23 12:33:30', '2021-02-23 12:36:11', 6, 'Este siii'),
(6, '2021-02-23 12:50:49', '2021-02-23 13:06:53', 2, 'prueba'),
(7, '2021-02-23 15:25:01', '2021-02-23 16:23:00', 2, 'Probando2'),
(13, '2021-02-23 17:00:06', '2021-02-23 17:03:21', 2, 'Prueba');

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
(35, 13, 3, 2, 1, 0),
(36, 13, 5, 2, 1, 0),
(37, 13, 6, 1, 1, 1);

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
(29, 19, '2021-02-20', '2021-02-22', 'Se le solicita tiempo para faltas', 2, '2021-02-20 16:02:01', 1, 'solicitud29.pdf');

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
  `razonRechazo` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `solicitud_fondos`
--

INSERT INTO `solicitud_fondos` (`codSolicitud`, `codProyecto`, `codigoCedepas`, `codEmpleadoSolicitante`, `fechaHoraEmision`, `totalSolicitado`, `girarAOrdenDe`, `numeroCuentaBanco`, `codBanco`, `justificacion`, `codEmpleadoEvaluador`, `fechaHoraRevisado`, `codEstadoSolicitud`, `codSede`, `fechaHoraAbonado`, `razonRechazo`) VALUES
(32, 2, 'E0111-170221MF', 1, '2021-02-17 22:12:08', 125, 'Juan Valdez Gutierrez Uriol', '214124 124 124214', 1, 'asd asds a', 1, '2021-02-17 22:12:43', 4, 2, '2021-02-17 22:37:28', NULL),
(33, 2, 'E0111-170221WW', 1, '2021-02-17 22:55:12', 25, 'asddsa', '1152251 215', 1, 'as dsad', 1, '2021-02-17 23:09:59', 4, 2, '2021-02-17 23:10:57', NULL),
(34, 3, 'E0111-180221N1', 1, '2021-02-18 00:53:11', 252, 'Juan Valdez Gutierrez Uriol', 'dsasda', 2, 'adssaadsasdasd', 1, '2021-02-18 00:53:18', 4, 1, '2021-02-18 00:53:22', NULL),
(35, 2, 'E0111-180221E5', 1, '2021-02-18 00:57:41', 125, 'saddsa', 'adsdas', 2, 'ads', 1, '2021-02-18 01:06:27', 4, 2, '2021-02-18 01:06:32', NULL),
(36, 2, 'E0111-180221SV', 1, '2021-02-18 01:17:41', 121, 'asddsabads', 'asdbadsa', 2, 'dsadsb', 1, '2021-02-18 01:17:46', 4, 1, '2021-02-18 01:17:50', NULL),
(38, 3, 'E0111-180221RV', 1, '2021-02-18 01:29:39', 1126.3, 'adsasd', 'adssad', 1, 'sdasad', 1, '2021-02-18 01:31:34', 4, 1, '2021-02-18 01:31:42', NULL),
(39, 3, 'E0111-190221NP', 1, '2021-02-19 19:26:31', 125, 'dassda', 'saddsa', 1, 'sadsda', 1, '2021-02-19 19:26:40', 4, 1, '2021-02-19 19:26:45', NULL),
(40, 2, 'E0111-190221JF', 1, '2021-02-19 19:57:19', 2152, 'adsdsaasd', 'adsasd', 2, 'dasdsa', 1, '2021-02-19 20:33:24', 5, 2, NULL, 'agava'),
(41, 2, 'E0111-200221Y1', 1, '2021-02-20 11:07:18', 151, 'Juan Valdez Gutierrez Uriol', '214124 124 124214', 2, 'adsd ds d sdas das ds ads ds d', 1, '2021-02-20 11:16:50', 4, 1, '2021-02-20 12:43:38', NULL),
(42, 2, 'E001-200221LR', 1, '2021-02-20 12:40:08', 25, 'Juan Valdez Gutierrez Uriol', '214124 124 124214', 3, 'asddsa', 1, '2021-02-20 12:41:35', 5, 2, NULL, 'nola'),
(43, 2, 'E001-200221JT', 1, '2021-02-20 15:26:27', 151, 'asddsa', 'adsds', 3, 'dsa', 1, '2021-02-20 15:26:48', 3, 1, '2021-02-23 17:20:04', NULL),
(44, 2, 'E008-230221NK', 2, '2021-02-23 17:13:01', 20, 'Diego Ernesto Vigo', '214124 124 124214', 2, 'Estos fondos serán usados para la actividad X', 2, '2021-02-23 17:13:37', 4, 1, '2021-02-23 17:14:02', NULL),
(45, 0, 'E008-230221X7', 2, '2021-02-23 17:19:47', 25, 'dsa', '125125', 4, 'adsasdads', NULL, NULL, 1, 2, NULL, NULL);

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
(27, 24, 2022, 1, 24, 37787800);

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
(12, '08:00:00', '13:00:00', '15:00:00', '17:00:00', 3),
(13, '07:00:00', '13:00:00', '15:00:00', '19:00:00', 3);

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
(2, 'vigo', '$2y$10$r6Z.zlGulxt8DCd16TEwyOHAnjk1lZKKOXIySTaV7rrLX/XdRUFf2', 0),
(3, 'grillo', '$2y$10$3mqgx5t1VCgUS43rU415yOD5fcZmB53035cLgioF0EjkFaxWMc5Li', 0),
(4, 'eli', '$2y$10$3cLZug88mHJpeHdBZrioGuS2sQini2/EZGB3t.dlmg4OQCEwHCYR.', 0),
(5, 'mari', '$2y$10$I6Qn3k6en/DCcTuGzbEXoO6nGNK5jydM5/hY7VLceMZ.gbr7sLR5W', 0),
(6, 'franco', '$2y$10$mLRYdoNFUpSgzYL0.aBJwew5srSp/f/t.W4zwTT82I/vHzsC.1QXC', 0),
(7, 'franco', '$2y$10$lyxNxrnHCQIjCZZ7fiKaeOIs0UyYEVmGI1q/WE7e/hhjZeXRGYR3O', 0),
(8, 'franco', '$2y$10$kd6xAQVI2SJRw.0Zs8fZiuRc54fGbiVA0aKwmtbpq9kb.N/9ah9Vq', 0);

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
  ADD PRIMARY KEY (`codExistencia`);

--
-- Indices de la tabla `existencias_perdidas`
--
ALTER TABLE `existencias_perdidas`
  ADD PRIMARY KEY (`codExistenciaPerdida`);

--
-- Indices de la tabla `gasto_caja`
--
ALTER TABLE `gasto_caja`
  ADD PRIMARY KEY (`codGastoPeriodo`);

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
  ADD PRIMARY KEY (`codMovimiento`);

--
-- Indices de la tabla `movimiento_detalle`
--
ALTER TABLE `movimiento_detalle`
  ADD PRIMARY KEY (`codMovimientoDetalle`);

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
  MODIFY `codActivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `afp`
--
ALTER TABLE `afp`
  MODIFY `codAFP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `codArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `codRegistroAsistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `avance_entregable`
--
ALTER TABLE `avance_entregable`
  MODIFY `codAvanceEntregable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `codCategoria` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `detalle_rendicion_gastos`
--
ALTER TABLE `detalle_rendicion_gastos`
  MODIFY `codDetalleRendicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `detalle_solicitud_fondos`
--
ALTER TABLE `detalle_solicitud_fondos`
  MODIFY `codDetalleSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `codEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `codExistencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `existencias_perdidas`
--
ALTER TABLE `existencias_perdidas`
  MODIFY `codExistenciaPerdida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gasto_caja`
--
ALTER TABLE `gasto_caja`
  MODIFY `codGastoPeriodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `justificacion_falta`
--
ALTER TABLE `justificacion_falta`
  MODIFY `codRegistroJustificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `licencia_tipo`
--
ALTER TABLE `licencia_tipo`
  MODIFY `codTipoSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `codMovimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento_detalle`
--
ALTER TABLE `movimiento_detalle`
  MODIFY `codMovimientoDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodo_caja`
--
ALTER TABLE `periodo_caja`
  MODIFY `codPeriodoCaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `periodo_empleado`
--
ALTER TABLE `periodo_empleado`
  MODIFY `codPeriodoEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `codProyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `codPuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rendicion_gastos`
--
ALTER TABLE `rendicion_gastos`
  MODIFY `codRendicionGastos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `revision`
--
ALTER TABLE `revision`
  MODIFY `codRevision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `revision_detalle`
--
ALTER TABLE `revision_detalle`
  MODIFY `codRevisionDetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `sede`
--
ALTER TABLE `sede`
  MODIFY `codSede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitud_falta`
--
ALTER TABLE `solicitud_falta`
  MODIFY `codRegistroSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `solicitud_fondos`
--
ALTER TABLE `solicitud_fondos`
  MODIFY `codSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `sueldo_mes`
--
ALTER TABLE `sueldo_mes`
  MODIFY `codSueldoMes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `codTurno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `turno_tipo`
--
ALTER TABLE `turno_tipo`
  MODIFY `codTipoTurno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codUsuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
