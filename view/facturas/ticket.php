<?php

// ==========================================================
// CLASE DE CONVERSIÓN DE NÚMEROS A LETRAS
// ==========================================================
class NumeroALetras
{
    private static $UNIDADES = [
        '', 'UN ', 'DOS ', 'TRES ', 'CUATRO ', 'CINCO ', 'SEIS ', 'SIETE ', 'OCHO ', 'NUEVE ', 'DIEZ ',
        'ONCE ', 'DOCE ', 'TRECE ', 'CATORCE ', 'QUINCE ', 'DIECISEIS ', 'DIECISIETE ', 'DIECIOCHO ', 'DIECINUEVE ', 'VEINTE '
    ];

    private static $DECENAS = [
        'VENTI', 'TREINTA ', 'CUARENTA ', 'CINCUENTA ', 'SESENTA ', 'SETENTA ', 'OCHENTA ', 'NOVENTA ', 'CIEN '
    ];

    private static $CENTENAS = [
        'CIENTO ', 'DOSCIENTOS ', 'TRESCIENTOS ', 'CUATROCIENTOS ', 'QUINIENTOS ', 'SEISCIENTOS ', 'SETECIENTOS ', 'OCHOCIENTOS ', 'NOVECIENTOS '
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
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
            }
        }

        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', self::convertGroup($miles));
            }
        }

        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', self::convertGroup($cientos));
            }
        }

        $converted = trim($converted);

        if (empty($decimales)) {
            $valor_convertido = $converted;
        } else {
            $valor_convertido = $converted . ' CON ' . $decimales . ' ' . strtoupper($centimos);
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
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }

        $k = intval(substr($n, 1));

        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if (($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }

        return $output;
    }
}

// ==========================================================
// CONFIGURACIÓN
// ==========================================================
require_once('plugins/tcpdf2/tcpdf.php');

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

$numero_factura_completo = "{$datos_timbrado['SUCURSAL']}-{$datos_timbrado['PUNTO_EXPEDICION']}-" . 
                          str_pad($id_venta, 7, '0', STR_PAD_LEFT); 

$RAZON_SOCIAL_EMISOR = 'MILLION TECH S.A.'; 
$DIRECCION_EMISOR = 'Km10, Ciudad del Este';
$CIUDAD_EMISOR = 'Ciudad del Este, Alto Paraná';
$TELEFONO_EMISOR = '0981 123 456';

$cliente = $cliente;
$productos = $productos;

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

// ==========================================================
// CONFIGURACIÓN DE TCPDF PARA TICKET
// ==========================================================
$medidas = array(80, 297); // 80mm de ancho, altura automática
$pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(TRUE, 5);
$pdf->AddPage();

// ==========================================================
// ENCABEZADO DEL TICKET
// ==========================================================
$header_html = <<<EOF
<table width="100%" style="text-align:center; line-height: 12px; font-size:9px">
    <tr>
        <td><img src="assets/img/logo.png" width="60"></td>
    </tr>
    <tr>
        <td style="font-weight: bold; font-size:10px">$RAZON_SOCIAL_EMISOR</td>
    </tr>
    <tr>
        <td style="font-size:8px">$DIRECCION_EMISOR</td>
    </tr>
    <tr>
        <td style="font-size:8px">$CIUDAD_EMISOR</td>
    </tr>
    <tr>
        <td style="font-size:8px">Tel: $TELEFONO_EMISOR</td>
    </tr>
</table>
<table width="100%">
    <tr><td style="border-top: 1px dashed #000;"></td></tr>
</table>
<table width="100%" style="text-align:center; line-height: 12px; font-size:9px">
    <tr>
        <td style="font-weight: bold; font-size:10px">FACTURA ELECTRÓNICA</td>
    </tr>
    <tr>
        <td style="font-weight: bold; font-size:11px; color: #c00000">$numero_factura_completo</td>
    </tr>
</table>
<table width="100%" style="font-size:8px; line-height: 11px">
    <tr>
        <td><b>RUC:</b> {$datos_timbrado['RUC_EMISOR']}</td>
    </tr>
    <tr>
        <td><b>Timbrado:</b> {$datos_timbrado['TIMBRADO']}</td>
    </tr>
    <tr>
        <td><b>Vigencia:</b> {$datos_timbrado['FECHA_INICIO_VIGENCIA']} al {$datos_timbrado['FECHA_FIN_VIGENCIA']}</td>
    </tr>
</table>
<table width="100%">
    <tr><td style="border-top: 1px dashed #000;"></td></tr>
</table>
EOF;

$pdf->writeHTML($header_html, true, false, true, false, '');

// ==========================================================
// DATOS DEL CLIENTE
// ==========================================================
$fecha_hora = date('d/m/Y H:i:s', strtotime($fecha_emision));
$datos_cliente_html = <<<EOF
<table width="100%" style="font-size:8px; line-height: 11px">
    <tr>
        <td><b>Fecha:</b> $fecha_hora</td>
    </tr>
    <tr>
        <td><b>Cliente:</b> {$cliente->nombre}</td>
    </tr>
    <tr>
        <td><b>RUC/CI:</b> {$cliente->ci}</td>
    </tr>
    <tr>
        <td><b>Dirección:</b> {$cliente->direccion}</td>
    </tr>
    <tr>
        <td><b>Teléfono:</b> {$cliente->telefono}</td>
    </tr>
    <tr>
        <td><b>Condición:</b> Contado</td>
    </tr>
</table>
<table width="100%">
    <tr><td style="border-top: 1px dashed #000;"></td></tr>
</table>
EOF;

$pdf->writeHTML($datos_cliente_html, true, false, true, false, '');

// ==========================================================
// DETALLE DE PRODUCTOS
// ==========================================================
$items_header = <<<EOF
<table width="100%" style="font-size:7px; line-height: 10px">
    <tr style="font-weight: bold;">
        <td width="10%" align="center">Cant</td>
        <td width="50%" align="left">Descripción</td>
        <td width="20%" align="right">P.Unit</td>
        <td width="20%" align="right">Total</td>
    </tr>
</table>
<table width="100%">
    <tr><td style="border-top: 1px solid #000;"></td></tr>
</table>
EOF;

$pdf->writeHTML($items_header, true, false, true, false, '');

$cantidad_items = 0;
foreach ($productos as $r) {
    $cantidad_items++;
    
    $descripcion = $r->nombre_producto ?? 'Producto';
    $cantidad = $r->cantidad ?? 1;
    $precio_unitario = $r->precio_unitario ?? 0;
    $total_item = $precio_unitario * $cantidad;
    
    $precio_unit_format = number_format($precio_unitario, 0, ',', '.');
    $total_format = number_format($total_item, 0, ',', '.');

    $item_html = <<<EOF
<table width="100%" style="font-size:7px; line-height: 9px">
    <tr>
        <td width="10%" align="center">$cantidad</td>
        <td width="50%" align="left">$descripcion</td>
        <td width="20%" align="right">$precio_unit_format</td>
        <td width="20%" align="right">$total_format</td>
    </tr>
</table>
EOF;

    $pdf->writeHTML($item_html, true, false, true, false, '');
}

// ==========================================================
// TOTALES
// ==========================================================
$sumaTotalexeV = number_format($sumaTotalexe, 0, ",", "."); 
$sumaTotal5V = number_format($sumaTotal5, 0, ",", "."); 
$sumaTotal10V = number_format($sumaTotal10, 0, ",", "."); 
$iva10V = number_format($iva10_calc, 0, ",", ".");
$ivaTotalV = number_format($ivaTotal_calc, 0, ",", ".");
$sumaTotalV = number_format($sumaTotal, 0, ",", ".");

$totales_html = <<<EOF
<table width="100%">
    <tr><td style="border-top: 1px dashed #000;"></td></tr>
</table>
<table width="100%" style="font-size:8px; line-height: 11px">
    <tr>
        <td width="50%">Sub-Total Exentas:</td>
        <td width="50%" align="right">$sumaTotalexeV</td>
    </tr>
    <tr>
        <td width="50%">Sub-Total 5%:</td>
        <td width="50%" align="right">$sumaTotal5V</td>
    </tr>
    <tr>
        <td width="50%">Sub-Total 10%:</td>
        <td width="50%" align="right">$sumaTotal10V</td>
    </tr>
    <tr>
        <td width="50%">Liquidación IVA 10%:</td>
        <td width="50%" align="right">$iva10V</td>
    </tr>
</table>
<table width="100%">
    <tr><td style="border-top: 1px solid #000;"></td></tr>
</table>
<table width="100%" style="font-size:10px; line-height: 13px; font-weight: bold;">
    <tr>
        <td width="50%">TOTAL A PAGAR:</td>
        <td width="50%" align="right">$sumaTotalV</td>
    </tr>
</table>
<table width="100%">
    <tr><td style="border-top: 1px solid #000;"></td></tr>
</table>
EOF;

$pdf->writeHTML($totales_html, true, false, true, false, '');

// ==========================================================
// PIE DE PÁGINA
// ==========================================================
$montoEntero = intval(round($sumaTotal));
$letras = NumeroALetras::convertir($montoEntero, 'GUARANÍES');

$footer_html = <<<EOF
<table width="100%" style="font-size:7px; line-height: 10px; text-align:center;">
    <tr>
        <td><b>SON:</b> $letras</td>
    </tr>
</table>
<table width="100%">
    <tr><td style="border-top: 1px dashed #000;"></td></tr>
</table>
<table width="100%" style="font-size:7px; line-height: 10px; text-align:center;">
    <tr>
        <td>Items: $cantidad_items</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">ORIGINAL</td>
    </tr>
    <tr>
        <td>Gracias por su compra</td>
    </tr>
</table>
EOF;

$pdf->writeHTML($footer_html, true, false, true, false, '');

// ==========================================================
// SALIDA DEL PDF
// ==========================================================
$pdf->Output('ticket_factura.pdf', 'I');
?>