
CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `imagen` text NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `ci` int(11) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nivel` int(1) DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `envios` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `direccion_completa` text DEFAULT NULL,
  `departamento` text DEFAULT NULL,
  `ciudad` text DEFAULT NULL,
  `contacto` text DEFAULT NULL,
  `referencias_adicionales` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `campo` int(11) NOT NULL,
  `valor_anterior` text NOT NULL,
  `valor_posterior` text NOT NULL,
  `Id_cliente` int(11) NOT NULL,
  `fecha_modificacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `id_categoria` int(11) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `imagen` text NOT NULL,
  `destacado` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `promo_desde` date DEFAULT NULL,
  `promo_hasta` date DEFAULT NULL,
  `precio_promo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `producto_imagenes` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `puntos` (
  `id` int(11) NOT NULL,
  `puntos` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_obtencion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL DEFAULT 1,
  `id_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`cantidad` * `precio_unitario`) STORED,
  `descuento` decimal(10,2) DEFAULT 0.00,
  `impuesto` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `estado_pago` enum('pendiente','pagado','cancelado') DEFAULT 'pendiente',
  `fecha_venta` datetime DEFAULT current_timestamp(),
  `direccion_envio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

