<?php

// ==========================================================
// CLASE DE CONVERSIÓN DE NÚMEROS A LETRAS (Mantenida)
// ==========================================================
class NumeroALetras
{
    private static $UNIDADES = [
        '',
        'un ',
        'dos ',
        'tres ',
        'cuatro ',
        'cinco ',
        'seis ',
        'siete ',
        'ocho ',
        'nueve ',
        'diez ',
        'once ',
        'doce ',
        'trece ',
        'catorce ',
        'quince ',
        'dieciseis ',
        'diecisiete ',
        'dieciocho ',
        'diecinueve ',
        'veinte '
    ];

    private static $DECENAS = [
        'veinti',
        'treinta ',
        'cuarenta ',
        'cincuenta ',
        'sesenta ',
        'setenta ',
        'ochenta ',
        'noventa ',
        'cien '
    ];

    private static $CENTENAS = [
        'ciento ',
        'doscientos ',
        'trescientos ',
        'cuatrocientos ',
        'quinientos ',
        'seiscientos ',
        'setecientos ',
        'ochocientos ',
        'novecientos '
    ];

    public static function convertir($number, $moneda = '', $centimos = '', $forzarCentimos = false)
    {
        $converted = '';
        $decimales = '';

        if (($number < 0) || ($number > 999999999)) {
            return 'NO ES POSIBLE CONVERTIR EL NUMERO A LETRAS';
        }

        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);

        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'un millon ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%smillones ', self::convertGroup($millones));
            }
        }

        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'mil ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%smil ', self::convertGroup($miles));
            }
        }

        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'un ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', self::convertGroup($cientos));
            }
        }

        $converted = trim($converted);

        if (empty($decimales)) {
            $valor_convertido = $converted;
        } else {
            $valor_convertido = $converted . ' con ' . $decimales . ' ' . strtoupper($centimos);
        }

        if (!empty($moneda) && $number >= 0) {
            $valor_convertido .= ' ' . $moneda;
        }

        return strtoupper($valor_convertido);
    }

    private static function convertGroup($n)
    {
        $output = '';

        if ($n == '100') {
            $output = "cien ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }

        $k = intval(substr($n, 1));

        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if (($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%s y %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }

        return $output;
    }
}
?>

<head>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .factura-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            padding: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        /* Borde exterior de toda la factura */
        .factura-borde {
            border: 3px solid #000;
            padding: 8px;
        }

        /* ENCABEZADO SUPERIOR */
        .encabezado-principal {
            display: grid;
            grid-template-columns: 35% 40% 25%;
            border: 2px solid #000;
            min-height: 100px;
        }

        .logo-empresa {
            border-right: 2px solid #000;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo-empresa img {
            max-width: 80px;
            max-height: 60px;
            margin-bottom: 5px;
        }

        .logo-empresa .nombre-empresa {
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
        }

        .datos-empresa {
            border-right: 2px solid #000;
            padding: 8px;
            font-size: 7.5pt;
            line-height: 1.3;
        }

        .datos-timbrado {
            padding: 8px;
            font-size: 7.5pt;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .factura-tipo {
            text-align: center;
            padding: 5px;
            border: 2px solid #000;
            margin-top: 5px;
            background-color: #f5f5f5;
        }

        .factura-tipo .titulo {
            font-weight: bold;
            font-size: 9pt;
        }

        .factura-tipo .numero {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 2px;
        }

        /* LÍNEA DE FECHA Y CONDICIÓN */
        .linea-fecha {
            display: grid;
            grid-template-columns: 15% 35% 25% 25%;
            border: 2px solid #000;
            border-top: none;
            font-size: 8pt;
        }

        .linea-fecha>div {
            padding: 6px 8px;
            border-right: 2px solid #000;
        }

        .linea-fecha>div:last-child {
            border-right: none;
        }

        .linea-fecha label {
            font-weight: bold;
            font-size: 7pt;
            display: block;
            margin-bottom: 2px;
        }

        /* DATOS DEL CLIENTE */
        .datos-cliente {
            border: 2px solid #000;
            border-top: none;
            font-size: 8pt;
        }

        .cliente-fila {
            display: grid;
            border-bottom: 1px solid #000;
        }

        .cliente-fila:last-child {
            border-bottom: none;
        }

        .cliente-fila-1 {
            grid-template-columns: 50% 50%;
        }

        .cliente-fila-2 {
            grid-template-columns: 25% 75%;
        }

        .cliente-fila>div {
            padding: 6px 8px;
            border-right: 1px solid #000;
        }

        .cliente-fila>div:last-child {
            border-right: none;
        }

        .cliente-fila label {
            font-weight: bold;
            font-size: 7pt;
        }

    /* TABLA DE PRODUCTOS - CSS CORREGIDO */
.tabla-productos {
    border: 2px solid #000;
    border-top: none;
}

.productos-header {
    display: grid;
    grid-template-columns: 8% 32% 15% 15% 15% 15%;
    background-color: #e8e8e8;
    border-bottom: 1px solid #000;
    font-weight: bold;
    font-size: 7pt;
}

.productos-header > div {
    padding: 5px 3px;
    border-right: 1px solid #000;
    text-align: center;
}

.productos-header > div:last-child {
    border-right: none;
}

.productos-subheader {
    display: grid;
    grid-template-columns: 8% 32% 15% 15% 15% 15%;
    background-color: #e8e8e8;
    border-bottom: 2px solid #000;
    font-weight: bold;
    font-size: 7pt;
}

.productos-subheader > div {
    padding: 3px;
    border-right: 1px solid #000;
}

.productos-subheader > div:last-child {
    border-right: none;
}

.producto-item {
    display: grid;
    grid-template-columns: 8% 32% 15% 15% 15% 15%;
    border-bottom: 1px solid #000;
    font-size: 8pt;
    min-height: 22px;
}

.producto-item > div {
    padding: 4px 5px;
    border-right: 1px solid #000;
}

.producto-item > div:last-child {
    border-right: none;
}

        .valores-venta {
            display: grid;
            grid-template-columns: 33.33% 33.33% 33.34%;
        }

        .valores-venta>div {
            border-right: 1px solid #000;
            text-align: right;
            padding: 4px 5px;
        }

        .valores-venta>div:last-child {
            border-right: none;
        }

        /* SECCIÓN DE TOTALES */
        .seccion-totales {
            display: grid;
            grid-template-columns: 60% 40%;
            border: 2px solid #000;
            border-top: none;
        }

        .totales-izquierda {
            border-right: 2px solid #000;
        }

        .subtotal-box {
            padding: 8px;
            border-bottom: 2px solid #000;
            font-size: 8pt;
        }

        .subtotal-box label {
            font-weight: bold;
            font-size: 7pt;
        }

        .total-pagar-box {
            padding: 8px;
            border-bottom: 2px solid #000;
            font-size: 9pt;
        }

        .total-pagar-label {
            font-weight: bold;
            font-size: 7pt;
            margin-bottom: 3px;
        }

        .total-pagar-monto {
            font-size: 12pt;
            font-weight: bold;
            text-align: right;
        }

        .liquidacion-box {
            padding: 8px;
            font-size: 7pt;
        }

        .liquidacion-titulo {
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
            padding: 3px;
            background-color: #e8e8e8;
            border: 1px solid #000;
        }

        .liquidacion-tabla {
            display: grid;
            grid-template-columns: 40% 20% 20% 20%;
            font-size: 7pt;
        }

        .liquidacion-tabla>div {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .liquidacion-header {
            background-color: #e8e8e8;
            font-weight: bold;
        }

        .totales-derecha {
            display: flex;
            flex-direction: column;
        }

        .subtotales-der {
            padding: 5px 8px;
            border-bottom: 1px solid #000;
            font-size: 8pt;
            flex: 1;
        }

        .subtotal-item {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }

        .subtotal-item label {
            font-size: 7pt;
        }

        .firma-box {
            padding: 10px;
            text-align: center;
            border-top: 2px solid #000;
            min-height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .firma-tipo {
            font-weight: bold;
            font-size: 8pt;
        }

        .firma-linea {
            border-top: 1px solid #000;
            padding-top: 5px;
            font-size: 7pt;
        }

        /* UTILIDADES */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        /* BOTÓN IMPRIMIR */
        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }

        .print-button button {
            background-color: #333;
            color: white;
            padding: 10px 25px;
            border: 2px solid #000;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            cursor: pointer;
            font-weight: bold;
        }

        .print-button button:hover {
            background-color: #555;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .factura-container {
                box-shadow: none;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <?php
    // ==========================================================
    // PREPARACIÓN DE DATOS (igual que antes)
    // ==========================================================

    $fecha_emision = date('Y-m-d');
    $fecha_inicio_vigencia = $fecha_emision;

    $fecha_fin_vigencia_obj = new DateTime($fecha_inicio_vigencia);
    $fecha_fin_vigencia_obj->modify('+1 month -1 day');
    $fecha_fin_vigencia = $fecha_fin_vigencia_obj->format('Y-m-d');

    $datos_timbrado = [
        'RUC_EMISOR' => '4011514-3',
        'TIMBRADO' => '300108',
        'FECHA_INICIO_VIGENCIA' => date("d/m/Y", strtotime($fecha_inicio_vigencia)),
        'FECHA_FIN_VIGENCIA' => date("d/m/Y", strtotime($fecha_fin_vigencia)),
        'SUCURSAL' => '001',
        'PUNTO_EXPEDICION' => '001',
    ];

    $id_venta = isset($_GET['id']) ? (int)$_GET['id'] : 1;
    $numero_factura_completo = "{$datos_timbrado['SUCURSAL']}-{$datos_timbrado['PUNTO_EXPEDICION']}-" . str_pad($id_venta, 7, '0', STR_PAD_LEFT);

    $RAZON_SOCIAL_EMISOR = 'MILLION TECH S.A.';
    $DIRECCION_EMISOR = 'Km10, Ciudad del Este';
    $CIUDAD_EMISOR = 'Ciudad del Este, Alto Paraná';
    $TELEFONO_EMISOR = '0981 123 456';
    $EMAIL_EMISOR = 'info@milliontech.com.py';

    $cliente = $cliente ?? (object)[
        'ci' => '123456-7',
        'nombre' => 'Cliente Ejemplo',
        'direccion' => 'Dirección del cliente',
        'telefono' => '0981 123 456',
    ];

    $productos = $productos ?? [];

    $sumaTotal10 = 0;
    foreach ($productos as $p) {
        $subtotal = $p->precio_unitario * $p->cantidad;
        $sumaTotal10 += $subtotal;
    }

    $sumaTotalexe = $sumaTotalexe ?? 0;
    $sumaTotal5 = $sumaTotal5 ?? 0;
    $sumaTotal = $sumaTotal10 + $sumaTotal5 + $sumaTotalexe;
    $iva10_calc = round($sumaTotal10 / 11);
    $ivaTotal_calc = $iva10_calc;
    $iva5 = $iva5 ?? 0;

    $sumaTotalexeV = number_format($sumaTotalexe, 0, ",", ".");
    $sumaTotal5V = number_format($sumaTotal5, 0, ",", ".");
    $sumaTotal10V = number_format($sumaTotal10, 0, ",", ".");
    $iva5V = number_format($iva5, 0, ",", ".");
    $iva10V = number_format($iva10_calc, 0, ",", ".");
    $ivaTotalV = number_format($ivaTotal_calc, 0, ",", ".");
    $sumaTotalV = number_format($sumaTotal, 0, ",", ".");
    ?>

    <!-- BOTÓN IMPRIMIR -->
    <div class="print-button no-print">
        <button onclick="window.print()">IMPRIMIR FACTURA</button>
    </div>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="factura-container">
        <div class="factura-borde">

            <!-- ENCABEZADO -->
            <div class="encabezado-principal">
                <div class="logo-empresa">
                    <img src="assets/img/logo.png" alt="Logo">
                    <div class="nombre-empresa"><?php echo $RAZON_SOCIAL_EMISOR; ?></div>
                </div>

                <div class="datos-empresa">
                    Construcciones de viviendas, edificios y casas<br>
                    Refacciones en General. Electricidad y Plomería<br>
                    <strong>Dirección:</strong> <?php echo $DIRECCION_EMISOR; ?><br>
                    <strong>Ciudad:</strong> <?php echo $CIUDAD_EMISOR; ?> - Tel.: <?php echo $TELEFONO_EMISOR; ?><br>
                    <strong>E-mail:</strong> <?php echo $EMAIL_EMISOR; ?>
                </div>

                <div class="datos-timbrado">
                    <div>
                        <strong>RUC:</strong> <?php echo $datos_timbrado['RUC_EMISOR']; ?><br>
                        <strong>TIMBRADO N°:</strong> <?php echo $datos_timbrado['TIMBRADO']; ?><br>
                        <strong>Inicio Vigencia:</strong><br><?php echo $datos_timbrado['FECHA_INICIO_VIGENCIA']; ?><br>
                        <strong>Fin de Vigencia:</strong><br><?php echo $datos_timbrado['FECHA_FIN_VIGENCIA']; ?>
                    </div>

                    <div class="factura-tipo">
                        <div class="titulo">FACTURA</div>
                        <div class="numero">N° <?php echo $numero_factura_completo; ?></div>
                    </div>
                </div>
            </div>

            <!-- LÍNEA DE FECHA Y CONDICIÓN -->
            <div class="linea-fecha">
                <div>
                    <label>FECHA DE EMISIÓN:</label>
                    <?php echo date('d/m/Y', strtotime($fecha_emision)); ?>
                </div>
                <div style="display: flex; gap: 10px;">
                    <div>
                        <label>CONDICIÓN DE VENTA:</label>
                        <input type="checkbox" checked> CONTADO
                        <input type="checkbox"> CRÉDITO
                    </div>
                </div>
                <div>
                    <label>NOTA DE REMISIÓN N°:</label>
                </div>
                <div>
                    <label>&nbsp;</label>
                </div>
            </div>

            <!-- DATOS DEL CLIENTE -->
            <div class="datos-cliente">
                <div class="cliente-fila cliente-fila-1">
                    <div>
                        <label>NOMBRE O RAZÓN SOCIAL:</label>
                        <?php echo $cliente->nombre; ?>
                    </div>
                    <div>
                        <label>RUC O CÉDULA DE IDENTIDAD:</label>
                        <?php echo $cliente->ci; ?>
                    </div>
                </div>
                <div class="cliente-fila cliente-fila-2">
                    <div>
                        <label>DIRECCIÓN:</label>
                        <?php echo $cliente->direccion; ?>
                    </div>
                    <div>
                        <label>TELÉFONO:</label>
                        <?php echo $cliente->telefono; ?>
                    </div>
                </div>
            </div>
<!-- TABLA DE PRODUCTOS - VERSIÓN CORREGIDA -->
<div class="tabla-productos">
    <div class="productos-header">
        <div style="grid-column: 1;">CANT</div>
        <div style="grid-column: 2;">DESCRIPCIÓN</div>
        <div style="grid-column: 3;">PRECIO<br>UNITARIO</div>
        <div style="grid-column: 4 / 7; text-align: center; padding: 5px;">
            VALOR DE VENTA
        </div>
    </div>
    
    <div class="productos-subheader">
        <div></div>
        <div></div>
        <div></div>
        <div class="text-center">EXENTAS</div>
        <div class="text-center">5 %</div>
        <div class="text-center">10 %</div>
    </div>

    <?php
    $cantidad_items = 0;
    foreach ($productos as $r) {
        $cantidad_items++;
        
        $descripcion = $r->nombre_producto ?? 'Producto';
        $cantidad = $r->cantidad ?? 1;
        $precio_unitario = $r->precio_unitario ?? 0;
        
        $monto_exentas = 0;
        $monto_5 = 0;
        $monto_10 = ($precio_unitario * $cantidad) / 11;
    ?>
    <div class="producto-item">
        <div class="text-center"><?php echo $cantidad; ?></div>
        <div><?php echo $descripcion; ?></div>
        <div class="text-right"><?php echo number_format($precio_unitario, 0, ',', '.'); ?></div>
        <div class="text-right"><?php echo number_format($monto_exentas, 0, ',', '.'); ?></div>
        <div class="text-right"><?php echo number_format($monto_5, 0, ',', '.'); ?></div>
        <div class="text-right"><?php echo number_format($monto_10, 0, ',', '.'); ?></div>
    </div>
    <?php
    }
    
    // Filas vacías
    $max_filas = 10;
    for ($i = $cantidad_items; $i < $max_filas; $i++) {
        echo '<div class="producto-item">';
        echo '<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>';
        echo '</div>';
    }
    ?>
</div>

            <!-- SECCIÓN DE TOTALES -->
            <div class="seccion-totales">
                <div class="totales-izquierda">
                    <div class="subtotal-box">
                        <label>SUB TOTAL:</label>
                    </div>

                    <div class="total-pagar-box">
                        <div class="total-pagar-label">TOTAL A PAGAR Gs.:</div>
                        <div class="total-pagar-monto"><?php echo $sumaTotalV; ?></div>
                    </div>

                    <div class="liquidacion-box">
                        <div class="liquidacion-titulo">LIQUIDACIÓN DEL IVA (5%)</div>
                        <div class="liquidacion-tabla">
                            <div class="liquidacion-header">&nbsp;</div>
                            <div class="liquidacion-header">(10 %)</div>
                            <div class="liquidacion-header">&nbsp;</div>
                            <div class="liquidacion-header">TOTAL IVA:</div>
                        </div>
                    </div>
                </div>

                <div class="totales-derecha">
                    <div class="subtotales-der">
                        <div class="subtotal-item">
                            <label>EXENTAS:</label>
                            <span><?php echo $sumaTotalexeV; ?></span>
                        </div>
                        <div class="subtotal-item">
                            <label>5%:</label>
                            <span><?php echo $sumaTotal5V; ?></span>
                        </div>
                        <div class="subtotal-item">
                            <label>10%:</label>
                            <span><?php echo $sumaTotal10V; ?></span>
                        </div>
                    </div>

                    <div class="firma-box">
                        <div class="firma-tipo">ORIGINAL - Comprobante</div>
                        <div class="firma-linea">COPIA - Arch. Tributario</div>
                    </div>
                </div>
            </div>

        </div>
    </div>