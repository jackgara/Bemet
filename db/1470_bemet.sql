-- phpMyAdmin SQL Dump
-- version 3.0.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-08-2009 a las 12:15:23
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `1470_bemet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `categoria_id` int(10) unsigned NOT NULL auto_increment,
  `categoria` varchar(100) NOT NULL,
  `fotografia_type` varchar(5) NOT NULL,
  PRIMARY KEY  (`categoria_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `categoria`, `fotografia_type`) VALUES
(1, 'Categoria 1', 'jpg'),
(2, 'categoria 2', 'jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE IF NOT EXISTS `presentaciones` (
  `presentacion_id` int(10) unsigned NOT NULL auto_increment,
  `producto_id` int(10) unsigned NOT NULL,
  `campo1` varchar(100) NOT NULL,
  `campo2` varchar(100) NOT NULL,
  `campo3` varchar(100) NOT NULL,
  PRIMARY KEY  (`presentacion_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`presentacion_id`, `producto_id`, `campo1`, `campo2`, `campo3`) VALUES
(1, 1, '4654646', '5x3mm', 'lorem ipsum'),
(2, 2, 'asas', 'asas', 'asas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `producto_id` int(10) unsigned NOT NULL auto_increment,
  `subcategoria_id` int(10) unsigned NOT NULL,
  `producto` varchar(100) NOT NULL,
  `fotografia_type` varchar(5) NOT NULL,
  `descripcion` text NOT NULL,
  `catalogo_type` varchar(5) default NULL,
  `campo1` varchar(100) NOT NULL,
  `campo2` varchar(100) NOT NULL,
  `campo3` varchar(100) NOT NULL,
  PRIMARY KEY  (`producto_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `productos`
--

INSERT INTO `productos` (`producto_id`, `subcategoria_id`, `producto`, `fotografia_type`, `descripcion`, `catalogo_type`, `campo1`, `campo2`, `campo3`) VALUES
(1, 1, 'test', 'jpg', 'test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr <br />\r\ntest decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr test decr <br />\r\ntest decr test decr test decr test decr test decr test decr test decr ', 'pdf', 'codigo', 'medidas', 'descripcion'),
(2, 2, 'a', 'jpg', 'a', 'pdf', 'a', 'a', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE IF NOT EXISTS `subcategorias` (
  `subcategoria_id` int(10) unsigned NOT NULL auto_increment,
  `categoria_id` int(10) unsigned NOT NULL,
  `subcategoria` varchar(100) NOT NULL,
  PRIMARY KEY  (`subcategoria_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`subcategoria_id`, `categoria_id`, `subcategoria`) VALUES
(1, 1, 'subacat 1'),
(2, 1, 'subcat 2');
