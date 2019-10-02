<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

$query ="EXEC [dbo].[CRM_CONS_USUARIO4]";

//EXCEL

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'FECHA DE CREACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'CONSECUTIVO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'ESTADO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'TIPIFICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'LLEGO PRODUCTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'GUÍA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'TRANSPORTADORA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'FECHA LLEGADA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'ADJUNTA RESP. TÉCNICA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'N° IDENTIFICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'DESC. CASO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'USUARIO CREACIÓN PQRS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'FECHA SOLUCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'DESC. SOLUCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'VENDEDOR');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'EJECUCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'USUARIO MODIFICACIÓN PQRS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'PUNTO COMPRA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'NOMBRES');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'APELLIDOS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'RAZÓN SOCIAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'TELÉFONO CONTACTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X1', 'TIPO IDENTIFICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'NOTIFICADA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'FECHA FABRICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', 'LOTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AB1', 'REF. PRODUCTO 1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AC1', 'REF. PRODUCTO 2');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AD1', 'COD. ITEM');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AE1', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AF1', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AG1', 'EST. VENTAS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AH1', 'FECHA ENT. PEDIDO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AI1', 'N° FACTURA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AJ1', 'N° RECLAMACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AK1', 'CENTRO OPERACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AL1', 'ÁREA EMPRESA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AM1', 'DIRECCIÓN ENVÍO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AN1', 'CONTACTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AO1', 'TELÉFONO CONTACTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AP1', 'E-MAIL CONTACTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AQ1', 'CARGO CONTACTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AR1', 'DEPTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AS1', 'CIUDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AT1', 'TIPO PQRS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AU1', 'TIPO CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AV1', 'TIPO SOLUCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AW1', 'CLIENTE POTENCIAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AX1', 'FECHA DE CREACIÓN GESTIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AY1', 'FECHA ACTUALIZACIÓN GESTIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AZ1', 'GESTIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('BA1', 'USUARIO CREACIÓN GESTIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('BB1', 'ADICIONAL 5');

$objPHPExcel->getActiveSheet()->getStyle('A1:BB1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:BB1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {
 
    $Fecha_creacion = $reg1 ['Fecha_creacion'];
    $Consecutivo = $reg1 ['Consecutivo'];
    $Estado = $reg1 ['Estado'];
    $Tipificacion = $reg1 ['Tipificacion'];
    $Llego_producto = $reg1 ['Llego_producto'];
    $Guia = $reg1 ['Guia'];
    $Transportadora = $reg1 ['Transportadora'];
    $Fecha_llegada = $reg1 ['Fecha_llegada'];
    $Adjunta_Respuesta_tecnica = $reg1 ['Adjunta_Respuesta_tecnica'];
    $Numero_identificacion = $reg1 ['Numero_identificacion'];
    $Cliente = $reg1 ['Cliente'];
    $Descripcion_caso = $reg1 ['Descripcion_caso'];
    $Usuario_Creacion_PQRS = $reg1 ['Usuario_Creacion_PQRS'];
    $Fecha_solucion = $reg1 ['Fecha_solucion'];
    $Descripcion_Solucion = $reg1 ['Descripcion_Solucion'];
    $Vendedor = $reg1 ['Vendedor'];
    $Ejecucion = $reg1 ['Ejecucion'];
    $Usuario_Modificacion_PQRS = $reg1 ['Usuario_Modificacion_PQRS'];
    $Punto_compra = $reg1 ['Punto_compra'];
    $Nombres = $reg1 ['Nombres'];
    $Apellidos = $reg1 ['Apellidos'];
    $Razon_social = $reg1 ['Razon_social'];
    $Telefono_contacto = $reg1 ['Telefono_contacto'];
    $Tipo_Identificacion = $reg1 ['Tipo_Identificacion'];
    $Notificada = $reg1 ['Notificada'];
    $Fecha_fabricacion = $reg1 ['Fecha_fabricacion'];
    $Lote = $reg1 ['Lote'];
    $Referencia_Producto1 = $reg1 ['Referencia_Producto1'];
    $Referencia_Producto2 = $reg1 ['Referencia_Producto2'];
    $codigo_item = $reg1 ['codigo_item'];
    $referencia = $reg1 ['referencia'];
    $descripcion = $reg1 ['descripcion'];
    $Estructura_Ventas = $reg1 ['Estructura_Ventas'];
    $Fecha_entrega_pedido = $reg1 ['Fecha_entrega_pedido'];
    $Numero_Factura = $reg1 ['Numero_Factura'];
    $Numero_Reclamacion = $reg1 ['Numero_Reclamacion'];
    $Centro_Operacion = $reg1 ['Centro_Operacion'];
    $Area_empresa = $reg1 ['Area_empresa'];
    $Direccion_envio = $reg1 ['Direccion_envio'];
    $Contacto = $reg1 ['Contacto'];
    $Telefono_contacto = $reg1 ['Telefono_contacto'];
    $Email_contacto = $reg1 ['Email_contacto'];
    $Cargo_contacto = $reg1 ['Cargo_contacto'];
    $Departamento = $reg1 ['Departamento'];
    $Ciudad = $reg1 ['Ciudad'];
    $Tipo_PQRS = $reg1 ['Tipo_PQRS'];
    $Tipo_cliente = $reg1 ['Tipo_cliente'];
    $Tipo_solucion = $reg1 ['Tipo_solucion'];
    $Cliente_potencial = $reg1 ['Cliente_potencial'];
    $Fecha_Creacion_Gestion = $reg1 ['Fecha_Creacion_Gestion'];
    $Fecha_Actualiz_Gestion = $reg1 ['Fecha_Actualiz_Gestion'];
    $Gestion = $reg1 ['Gestion'];
    $Usuario_Creacion_Gestion = $reg1 ['Usuario_Creacion_Gestion'];
    $Adicional5 = $reg1 ['Adicional5'];

    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('A'.$Fila, $Fecha_creacion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('B'.$Fila, $Consecutivo,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('C'.$Fila, $Estado,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('D'.$Fila, $Tipificacion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('E'.$Fila, $Llego_producto,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('F'.$Fila, $Guia,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('G'.$Fila, $Transportadora,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('H'.$Fila, $Fecha_llegada,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('I'.$Fila, $Adjunta_Respuesta_tecnica,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('J'.$Fila, $Numero_identificacion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('K'.$Fila, $Cliente,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('L'.$Fila, $Descripcion_caso,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('M'.$Fila, $Usuario_Creacion_PQRS,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('N'.$Fila, $Fecha_solucion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('O'.$Fila, $Descripcion_Solucion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('P'.$Fila, $Vendedor,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('Q'.$Fila, $Ejecucion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('R'.$Fila, $Usuario_Modificacion_PQRS,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('S'.$Fila, $Punto_compra,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('T'.$Fila, $Nombres,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('U'.$Fila, $Apellidos,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('V'.$Fila, $Razon_social,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('W'.$Fila, $Telefono_contacto,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('X'.$Fila, $Tipo_Identificacion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('Y'.$Fila, $Notificada,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('Z'.$Fila, $Fecha_fabricacion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AA'.$Fila, $Lote,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AB'.$Fila, $Referencia_Producto1,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AC'.$Fila, $Referencia_Producto2,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AD'.$Fila, $codigo_item,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AE'.$Fila, $referencia,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AF'.$Fila, $descripcion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AG'.$Fila, $Estructura_Ventas,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AH'.$Fila, $Fecha_entrega_pedido,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AI'.$Fila, $Numero_Factura,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AJ'.$Fila, $Numero_Reclamacion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AK'.$Fila, $Centro_Operacion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AL'.$Fila, $Area_empresa,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AM'.$Fila, $Direccion_envio,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AN'.$Fila, $Contacto,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AO'.$Fila, $Telefono_contacto,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AP'.$Fila, $Email_contacto,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AQ'.$Fila, $Cargo_contacto,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AR'.$Fila, $Departamento,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AS'.$Fila, $Ciudad,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AT'.$Fila, $Tipo_PQRS,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AU'.$Fila, $Tipo_cliente,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AV'.$Fila, $Tipo_solucion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AW'.$Fila, $Cliente_potencial,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AX'.$Fila, $Fecha_Creacion_Gestion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AY'.$Fila, $Fecha_Actualiz_Gestion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AZ'.$Fila, $Gestion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('BA'.$Fila, $Usuario_Creacion_Gestion,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('BB'.$Fila, $Adicional5,  PHPExcel_Cell_DataType::TYPE_STRING);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':BB'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $Fila = $Fila + 1; 
      
  }
}

/*fin contenido tabla*/

//se configura el ancho de cada columna en automatico solo funciona en el rango A-Z
foreach($objPHPExcel->getWorksheetIterator() as $worksheet) {

    $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

    $sheet = $objPHPExcel->getActiveSheet();
    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    foreach ($cellIterator as $cell) {
        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
    }
}

$n = 'Indicador_pqrs_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
