<?php

// ==========================================================
// CLASE DE CONVERSIÓN DE NÚMEROS A LETRAS (Mantenida)
// ==========================================================
class NumeroALetras
{
    private static $UNIDADES = [
        '', 'un ', 'dos ', 'tres ', 'cuatro ', 'cinco ', 'seis ', 'siete ', 'ocho ', 'nueve ', 'diez ',
        'once ', 'doce ', 'trece ', 'catorce ', 'quince ', 'dieciseis ', 'diecisiete ', 'dieciocho ', 'diecinueve ', 'veinte '
    ];

    private static $DECENAS = [
        'veinti', 'treinta ', 'cuarenta ', 'cincuenta ', 'sesenta ', 'setenta ', 'ochenta ', 'noventa ', 'cien '
    ];

    private static $CENTENAS = [
        'ciento ', 'doscientos ', 'trescientos ', 'cuatrocientos ', 'quinientos ', 'seiscientos ', 'setecientos ', 'ochocientos ', 'novecientos '
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


// ==========================================================
// INCLUSIÓN DE LIBRERÍAS
// ==========================================================
require_once('plugins/tcpdf2/tcpdf.php'); 


// ==========================================================
// 1. CONFIGURACIÓN DEL TIMBRADO Y DATOS DINÁMICOS (SU CÓDIGO ORIGINAL)
// ==========================================================

// Fecha de inicio de vigencia: Hoy (o la fecha de emisión de la factura)
$fecha_emision = date('Y-m-d'); 
$fecha_inicio_vigencia = $fecha_emision;

// Fecha de fin de vigencia: Un mes después (el último día del mes siguiente)
$fecha_fin_vigencia_obj = new DateTime($fecha_inicio_vigencia);
// Ajustamos para que termine, por ejemplo, el 30/10 si empieza el 30/09
$fecha_fin_vigencia_obj->modify('+1 month -1 day'); 
$fecha_fin_vigencia = $fecha_fin_vigencia_obj->format('Y-m-d');

// Datos de la empresa emisora (El Timbrado) - SUS DATOS ORIGINALES
$datos_timbrado = [
    'RUC_EMISOR' => '4011514-3', 
    'TIMBRADO' => '300108',
    'FECHA_INICIO_VIGENCIA' => date("d/m/Y", strtotime($fecha_inicio_vigencia)),
    'FECHA_FIN_VIGENCIA' => date("d/m/Y", strtotime($fecha_fin_vigencia)),
    'SUCURSAL' => '001', // Asumido para el formato KuDE (Sucursal-Punto-Nro)
    'PUNTO_EXPEDICION' => '001', // Asumido para el formato KuDE
];

// ID de Venta
$id_venta = isset($_GET['id']) ? (int)$_GET['id'] : 1; // Usamos un fallback si no hay ID

// Componemos el número de factura completo (Sucursal - Punto - ID Venta)
$numero_factura_completo = "{$datos_timbrado['SUCURSAL']}-{$datos_timbrado['PUNTO_EXPEDICION']}-" . 
                          str_pad($id_venta, 7, '0', STR_PAD_LEFT); 

// Datos estáticos de su empresa (MILLION TECH)
$RAZON_SOCIAL_EMISOR = 'MILLION TECH S.A.'; 
$DIRECCION_EMISOR = 'Km10, Ciudad del Este'; // Dirección asumida en base al Punto de Expedición
$CIUDAD_EMISOR = 'Ciudad del Este, Alto Paraná';
$TELEFONO_EMISOR = '0981 123 456';
$ACTIVIDAD_ECONOMICA = 'Venta de productos electrónicos';


// ***************************************************************
// NOTA: Las variables $cliente, $productos, $sumaTotal, $iva5, etc.
// DEBEN ser cargadas ANTES de este código para que el PDF muestre datos.
// Se utilizan valores de FALLBACK genéricos para que el código compile.
// ***************************************************************

// FALLBACK para variables del cliente/venta (usted debe cargarlas dinámicamente)
$cliente = $cliente;
$productos = $productos;
$sumaTotal10 = $sumaTotal10 ?? 0;
$sumaTotalexe = $sumaTotalexe ?? 0;
$sumaTotal5 = $sumaTotal5 ?? 0;
$iva10_calc = round($sumaTotal10 / 11);
$iva5 = $iva5 ?? 0;
$ivaTotal_calc = round($iva5 + $iva10_calc);
$credito = $credito ?? false; // false para "Contado"
$montoNoCobrado = $montoNoCobrado ?? 0; // Para descuentos


// ==========================================================
// 2. INICIALIZACIÓN DE PDF y CSS PARA ESTÉTICA KUDE
// ==========================================================

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();

// CSS para la estética KuDE (Adaptado para TCPDF HTML/CSS)
$style = <<<EOT
<style>
    .factura-box {
        border: 1px solid #000;
        padding: 5px;
        background-color: #f7f7f7;
        line-height: 12px;
    }
    .header-info {
        font-size: 8pt;
        line-height: 12px;
    }
    .datos-cliente-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
        margin-top: 8px;
        font-size: 8pt;
    }
    .datos-cliente-table td {
        border-right: 1px solid #000;
        padding: 3px;
        line-height: 10px;
    }
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 7.5pt;
    }
    .items-table th, .items-table td {
        border: 1px solid #000;
        padding: 3px 2px;
        line-height: 9px;
    }
    .items-table th {
        background-color: #e8e8e8;
        font-weight: bold;
        text-align: center;
    }
    .items-table .text-right { text-align: right; }
    .items-table .text-center { text-align: center; }
    .totales-table {
        width: 100%;
        margin-top: 10px;
        font-size: 8pt;
    }
    .totales-table td {
        line-height: 12px;
        padding: 1px 3px;
    }
    .totales-table .total-line {
        font-weight: bold;
        border: 1px solid #000;
        padding: 3px;
    }
    .liquid-iva-box {
        border: 1px solid #000;
        padding: 3px;
        margin-top: 5px;
        background-color: #f7f7f7;
    }
    .liquidacion-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 7.5pt;
    }
    .liquidacion-table td {
        padding: 2px 5px;
        line-height: 10px;
    }
</style>
EOT;

$pdf->writeHTML($style, true, false, true, false, '');


// ==========================================================
// 3. ESTRUCTURA DE LA FACTURA (KuDE)
// ==========================================================

// --- BLOQUE 1: LOGO, DATOS EMISOR Y CAJA TIMBRADO ---

$header_html = '
    <table width="100%" class="header-info">
        <tr>
            <td width="30%" valign="top">
                    <img src="assets/img/logo.png" alt="Logo" style="max-width: 35px; max-height: 35px; vertical-align: middle;">
            </td>
            <td width="35%" valign="top">
                <div style="font-size: 8pt; line-height: 10px;">
                    <span style="font-weight: bold;">'.$RAZON_SOCIAL_EMISOR.'</span><br>
                    Sistema Integrado de Facturación Electrónica Nacional<br>
                    Dirección: '.$DIRECCION_EMISOR.'<br>
                    Ciudad: '.$CIUDAD_EMISOR.'<br>
                    Teléfono: '.$TELEFONO_EMISOR.'<br>
                    Actividad económica: '.$ACTIVIDAD_ECONOMICA.'
                </div>
            </td>
            <td width="35%" valign="top">
                <div class="factura-box">
                    RUC: <span style="font-weight: bold;">'.$datos_timbrado['RUC_EMISOR'].'</span><br>
                    Timbrado N°: <span style="font-weight: bold;">'.$datos_timbrado['TIMBRADO'].'</span><br>
                    Fecha de Inicio de Vigencia: '.$datos_timbrado['FECHA_INICIO_VIGENCIA'].'<br>
                    Fecha de Fin de Vigencia: '.$datos_timbrado['FECHA_FIN_VIGENCIA'].'<br>
                    <div style="border-top: 1px solid #ccc; margin-top: 3px; padding-top: 3px;">
                        <span style="font-weight: bold; font-size: 9pt;">FACTURA ELECTRÓNICA</span><br>
                        <span style="font-weight: bold; font-size: 11pt; color: #d9534f;">'.$numero_factura_completo.'</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <br><br>
';
$pdf->writeHTML($header_html, true, false, true, false, '');

// --- BLOQUE 2: DATOS DE LA VENTA Y CLIENTE ---

$datos_transaccion_cliente_html = '
    <table class="datos-cliente-table">
        <tr>
            <td width="50%">
                <span style="font-weight: bold;">Fecha y hora de emisión:</span> '.date('d-m-Y H:i:s', strtotime($fecha_emision)).'<br>
                <span style="font-weight: bold;">Condición de venta:</span> <span style="text-decoration: underline;">Contado,</span><br>
                <span style="font-weight: bold;">Moneda:</span> PYG<br>
            </td>
            <td width="50%">
                <span style="font-weight: bold;">RUC/Documento de Identidad No:</span> '.$cliente->ci.'<br>
                <span style="font-weight: bold;">Nombre o Razón Social:</span> '.$cliente->nombre.'<br>
                <span style="font-weight: bold;">Dirección:</span> '.$cliente->direccion.'<br>
                <span style="font-weight: bold;">Teléfono:</span> '.$cliente->telefono.'<br>
                <span style="font-weight: bold;">Correo Electrónico:</span> '.$cliente->email.'<br>
                <span style="font-weight: bold;">Tipo de Operación:</span> Venta de Mercadería
            </td>
        </tr>
    </table>
';
$pdf->writeHTML($datos_transaccion_cliente_html, true, false, true, false, '');

// --- BLOQUE 3: DETALLE DE PRODUCTOS ---

$items_html = '
    <table class="items-table">
        <thead>
            <tr>
                <th width="8%" class="text-center">Cod</th>
                <th width="28%" class="text-center">Descripción</th>
                <th width="10%" class="text-center">Unidad de medida</th>
                <th width="8%" class="text-center">Cantidad</th>
                <th width="12%" class="text-center">Precio Unitario</th>
                <th width="10%" class="text-center">Descuento</th>
                <th width="24%" class="text-center" colspan="3">Valor de Venta</th>
            </tr>
            <tr>
                <th width="8%"></th>
                <th width="28%"></th>
                <th width="10%"></th>
                <th width="8%"></th>
                <th width="12%"></th>
                <th width="10%"></th>
                <th width="8%" class="text-center">Exentas</th>
                <th width="8%" class="text-center">5%</th>
                <th width="8%" class="text-center">10%</th>
            </tr>
        </thead>
        <tbody>
';

$cantidad_items = 0;
foreach ($productos as $r) {
    $cantidad_items++;
    
    // Variables para el ítem
    $codigo = substr($r->id_producto ?? $r['id'], -5) ?? '';
    $descripcion = $r->nombre_producto ?? $r['nombre_producto'] ?? 'Producto Desconocido';
    $cantidad = $r->cantidad ?? $r['cantidad'] ?? 1;
    $precio_unitario = $r->precio_unitario ?? $r['precio_unitario'] ?? 0;
    
    // Su lógica de valor de venta (Debe ser llenada en el $productos original)
    $monto_exentas = 0; // Ejemplo: 0
    $monto_5 = 0;      // Ejemplo: 0
    $monto_10 = $r->total ?? $r['total'] ?? 0; // Ejemplo: Se asume que el total del ítem es 10%

    $items_html .= '
        <tr>
            <td class="text-center">'.$codigo.'</td>
            <td>'.$descripcion.'</td>
            <td class="text-center">UNI</td>
            <td class="text-center">'.$cantidad.'</td>
            <td class="text-right">'.number_format($precio_unitario, 0, ',', '.').'</td>
            <td class="text-right">0</td>
            <td class="text-right">'.number_format($monto_exentas, 0, ',', '.').'</td>
            <td class="text-right">'.number_format($monto_5, 0, ',', '.').'</td>
            <td class="text-right">'.number_format($monto_10, 0, ',', '.').'</td>
        </tr>
    ';
}

// LÍNEA DE DESCUENTO (Si $montoNoCobrado es > 0)
if ($montoNoCobrado > 0) {
    $cantidad_items++;
    $items_html .= '
        <tr>
            <td class="text-center">DSCTO</td>
            <td>DESCUENTO</td>
            <td class="text-center">UNI</td>
            <td class="text-center">1</td>
            <td class="text-right">'.number_format(-$montoNoCobrado, 0, ',', '.').'</td>
            <td class="text-right">0</td>
            <td class="text-right">0</td>
            <td class="text-right">0</td>
            <td class="text-right">'.number_format(-$montoNoCobrado, 0, ',', '.').'</td>
        </tr>
    ';
}

// Rellenar con líneas vacías para mantener la estética KuDE (8 filas mínimo)
$max_filas = 8;
for ($i = $cantidad_items; $i < $max_filas; $i++) {
    $items_html .= '
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    ';
}

$items_html .= '</tbody></table>';
$pdf->writeHTML($items_html, true, false, true, false, '');

// --- BLOQUE 4: TOTALES Y LIQUIDACIÓN IVA ---

// Formato de los totales
$montoEntero = intval(round($sumaTotal));
$letras = NumeroALetras::convertir($montoEntero, 'Guaraníes');
$sumaTotalV = number_format($montoEntero, 0, ",", ".");
$sumaTotalexeV = number_format($sumaTotalexe, 0, ",", "."); 
$sumaTotal5V = number_format($sumaTotal5, 0, ",", "."); 
$sumaTotal10V = number_format($sumaTotal10, 0, ",", "."); 
$iva5V = number_format($iva5, 0, ",", "."); 
$iva10V = number_format($iva10_calc, 0, ",", ".");
$ivaTotalV = number_format($ivaTotal_calc, 0, ",", ".");


$totales_html = '
    <table class="totales-table" style="border: 1px solid #000;">
        <tr>
            <td width="70%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 5px;">
                <span style="font-weight: bold;">TOTAL EN LETRAS:</span> '.$letras.'
            </td>
            <td width="30%" style="border-bottom: 1px solid #000; padding: 0;">
                <table width="100%" border="0" cellpadding="3" cellspacing="0">
                    <tr>
                        <td width="55%" style="font-weight: bold; border-bottom: 1px solid #ccc; padding: 3px;">SUB-TOTALES:</td>
                        <td width="45%" class="text-right" style="border-bottom: 1px solid #ccc; padding: 3px;"></td>
                    </tr>
                    <tr>
                        <td width="55%" style="padding: 3px;">Exentas:</td>
                        <td width="45%" class="text-right" style="padding: 3px;">'.$sumaTotalexeV.'</td>
                    </tr>
                    <tr>
                        <td width="55%" style="padding: 3px;">Gravadas 5%:</td>
                        <td width="45%" class="text-right" style="padding: 3px;">'.$sumaTotal5V.'</td>
                    </tr>
                    <tr>
                        <td width="55%" style="padding: 3px; border-bottom: 1px solid #ccc;">Gravadas 10%:</td>
                        <td width="45%" class="text-right" style="padding: 3px; border-bottom: 1px solid #ccc;">'.$sumaTotal10V.'</td>
                    </tr>
                    <tr>
                        <td width="55%" style="font-weight: bold; padding: 3px; border-bottom: 1px solid #000;">TOTAL A PAGAR:</td>
                        <td width="45%" class="text-right" style="font-weight: bold; padding: 3px; border-bottom: 1px solid #000; background-color: #e8e8e8;">'.$sumaTotalV.'</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="70%" style="border-right: 1px solid #000; padding: 5px;" valign="top">
                <div style="border: 1px solid #000; padding: 5px; background-color: #f7f7f7;">
                    <div style="font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 3px; margin-bottom: 5px;">LIQUIDACIÓN DEL IVA</div>
                    <table width="100%" border="0" cellpadding="3" cellspacing="0" style="font-size: 7.5pt;">
                        <tr style="font-weight: bold; background-color: #e8e8e8; border-bottom: 1px solid #000;">
                            <td width="40%">Concepto</td>
                            <td width="20%" class="text-right">5%</td>
                            <td width="20%" class="text-right">10%</td>
                            <td width="20%" class="text-right">Total</td>
                        </tr>
                        <tr>
                            <td width="40%" style="padding: 3px;">Valor de Venta:</td>
                            <td width="20%" class="text-right" style="padding: 3px;">'.$sumaTotal5V.'</td>
                            <td width="20%" class="text-right" style="padding: 3px;">'.$sumaTotal10V.'</td>
                            <td width="20%" class="text-right" style="padding: 3px;">'.number_format($sumaTotal5 + $sumaTotal10, 0, ",", ".").'</td>
                        </tr>
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td width="40%" style="padding: 3px; border-top: 1px solid #ccc;">Liquidación IVA:</td>
                            <td width="20%" class="text-right" style="padding: 3px; border-top: 1px solid #ccc;">'.$iva5V.'</td>
                            <td width="20%" class="text-right" style="padding: 3px; border-top: 1px solid #ccc;">'.$iva10V.'</td>
                            <td width="20%" class="text-right" style="padding: 3px; border-top: 1px solid #ccc; background-color: #e8e8e8;">'.$ivaTotalV.'</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="30%" style="padding: 5px;" valign="top">
                <div style="border: 1px solid #000; padding: 5px; text-align: center; min-height: 60px;">
                    <div style="font-size: 7pt; margin-bottom: 30px;">ORIGINAL</div>
                    <div style="border-top: 1px solid #000; padding-top: 3px; font-size: 7pt;">
                        Firma y Sello del Emisor
                    </div>
                </div>
            </td>
        </tr>
    </table>
';
$pdf->writeHTML($totales_html, true, false, true, false, '');


// ==========================================================
// 4. GENERACIÓN DEL PDF (Incluye Duplicado sin Pie de Página)
// ==========================================================

// Duplicado (Salto de página para la copia)
$pdf->AddPage(); 
$pdf->writeHTML($header_html, true, false, true, false, '');
$pdf->writeHTML($datos_transaccion_cliente_html, true, false, true, false, '');
$pdf->writeHTML($items_html, true, false, true, false, '');
$pdf->writeHTML($totales_html, true, false, true, false, '');

$pdf->Output('factura_electronica_kude.pdf', 'I');
//============================================================+