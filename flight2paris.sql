-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Servidor: db.esfriki.com
-- Tiempo de generación: 15-01-2013 a las 10:23:19
-- Versión del servidor: 5.1.56
-- Versión de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `flight2paris`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(12) unsigned NOT NULL,
  `old_password` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(80) CHARACTER SET utf8 NOT NULL,
  `public_key` text CHARACTER SET utf8 NOT NULL,
  `challenge` text COLLATE utf8_bin NOT NULL,
  `answer` text COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `failed` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) COLLATE utf8_bin NOT NULL,
  `to` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `node`
--

CREATE TABLE IF NOT EXISTS `node` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `content` longtext CHARACTER SET utf8,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uri` (`uri`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `score`
--

CREATE TABLE IF NOT EXISTS `score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` decimal(20,4) unsigned NOT NULL,
  `fibo` int(3) NOT NULL,
  `win_last` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `uri` (`uri`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

