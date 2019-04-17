-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2019 a las 19:52:09
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `point_sale`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `product` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(48) NOT NULL,
  `generic_name` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `arrival_date` date NOT NULL,
  `expiration_date` date NOT NULL,
  `sale_price` int(11) NOT NULL,
  `original_price` int(11) NOT NULL,
  `moneymaking` int(11) NOT NULL,
  `provider` int(11) NOT NULL,
  `status` enum('STOCK','SELLED') NOT NULL DEFAULT 'STOCK',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `brand_name`, `generic_name`, `description`, `arrival_date`, `expiration_date`, `sale_price`, `original_price`, `moneymaking`, `provider`, `status`, `create_at`) VALUES
(1, 'Toshiba', 'Laptop Toshiba Core i5', 'Tecnologia', '2019-03-22', '2099-12-12', 15000, 10000, 5000, 1, 'STOCK', '2019-03-18 20:03:50'),
(2, 'Samsumg', 'Samsung S10', 'Tecnologia', '2019-03-12', '2099-12-12', 22299, 20000, 2299, 4, 'STOCK', '2019-03-18 20:08:31'),
(3, 'Dell', 'TelevisiÃ³n Dell 50 pulgadas Smart', 'Tecnologia', '2019-03-13', '2099-12-12', 15450, 13210, 2240, 2, 'STOCK', '2019-03-18 20:10:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `name` varchar(48) NOT NULL,
  `address` varchar(128) NOT NULL,
  `contact_person` varchar(128) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `providers`
--

INSERT INTO `providers` (`id`, `name`, `address`, `contact_person`, `phone`, `note`, `create_at`) VALUES
(1, 'Toshiba', 'Colonia las Palmas, Avenida los Olivos #103', 'Luis Gomez Perez', '5598231234', 'Es un proveedor nuevo y fue referencia do por X persona', '2019-03-18 05:50:19'),
(2, 'Dell', 'Colonia Roma, Calle la nueva vida #01', 'Juan Garcia Garcia', '5500129423', 'Proveedor de gran renombre y brinda buenos precios', '2019-03-18 05:59:15'),
(4, 'Samsumg', 'Colonia Cuauhtemoc, Avenida Mariano Escobedo #12', 'Andrea Moreno Moreno', '5541234523', 'DescipciÃ³n de prueba', '2019-03-18 06:06:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL,
  `description` varchar(64) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `create_at`) VALUES
(1, 'ADMIN', 'Todos los permisos', '2019-03-03 03:56:03'),
(2, 'MANAGER', 'Este usuario puede administrar todo el contenido', '2019-03-04 19:57:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(24) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(48) NOT NULL,
  `rol` int(11) NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `name`, `rol`, `create_at`) VALUES
(7, 'admin', '$2y$10$gKy29Yy.t8vZ3/M5Kr/07uHk0xYvoK.ZOc.C5bRhsQRI6LsZtzp5e', 'admin', 1, '2019-03-18 03:33:27'),
(8, 'aleixs', '$2y$10$MTeW0cpc.u2oPlm9VpSuH.o8fEr1JTz355rSKSANjHZQADJqKfCNu', 'Alexis Mozo Hernandez', 2, '2019-03-18 03:45:34');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
