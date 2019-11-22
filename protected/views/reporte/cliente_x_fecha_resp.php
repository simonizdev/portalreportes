<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte
$fecha_inicial = $model['fecha_inicial'];
$fecha_final = $model['fecha_final'];

set_time_limit(0);

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);


/*inicio configuración array de datos*/

//EXCEL

$query ="
  EXEC [dbo].[COM_CONS_CLIENTE_FCH] 
  @FECHA1 = N'".$FechaM1."',
  @FECHA2 = N'".$FechaM2."'
";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'ID Tercero');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Tipo de identificación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Nit cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Tipo de persona');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Razón social');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Apellidos');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Nombres');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'ID Sucursal');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Nombre sucursal');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Cupo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Estado');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Tipo cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Bloqueado');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Bloqueo de cupo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Bloqueo de mora');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Ciudad');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Dirección');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Condición de pago');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'Días de gracias');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Lista de precio');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'Iva');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'Ica');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'Renta');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X1', 'Rete IVA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'Rete ICA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'RTARTA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', 'CO facturación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AB1', 'CO movimiento');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AC1', 'Coordinador');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AD1', 'Ruta');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AE1', 'Descripción de ruta');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AF1', 'Fecha de nacimiento');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AG1', 'E-mail');
$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $A  = $reg1 ['C_ID_TERCERO']; 
    $B  = $reg1 ['C_TIPO_ID']; 
    $C  = $reg1 ['C_NIT_CLIENTE'];
    $D  = $reg1 ['C_TIPO_PERSONA'];
    $E  = $reg1 ['C_NOMBRE_CLIENTE'];
    $F  = $reg1 ['C_APELLIDO'];
    $G  = $reg1 ['C_NOMBRES'];
    $H  = $reg1 ['C_ID_SUCURSAL'];
    $I  = $reg1 ['C_NOMBRE_SUCURSAL']; 
    $J  = $reg1 ['C_CUPO']; 
    $K  = $reg1 ['C_ESTADO'];
    $L  = $reg1 ['C_TIPO_CLIENTE'];
    $M  = $reg1 ['C_BLOQUEADO'];
    $N  = $reg1 ['C_BLOQ_CUPO'];
    $O  = $reg1 ['C_BLOQ_MORA'];
    $P  = $reg1 ['C_CIUDAD'];
    $Q  = $reg1 ['C_DIRECCION']; 
    $R  = $reg1 ['C_COND_PAGO_CLI']; 
    $S  = $reg1 ['C_DIAS_GRACIA'];
    $T  = $reg1 ['C_LISTA_PRECIO'];
    $U  = $reg1 ['C_IVA'];
    $V  = $reg1 ['C_ICA'];
    $W  = $reg1 ['C_RENTA'];
    $X  = $reg1 ['C_RTIVA'];
    $Y  = $reg1 ['C_RTICA']; 
    $Z = $reg1 ['C_RTARTA']; 
    $AA = $reg1 ['C_CO_FACT'];
    $AB = $reg1 ['C_CO_MOVTO'];
    $AC = $reg1 ['COORDINADOR'];
    $AD = $reg1 ['C_RUTA'];
    $AE = $reg1 ['RUTA'];
    $AF = $reg1 ['C_FECHA_NAC'];
    $f = new DateTime($AF);
    $fecha = $f->format('Y-m-d');
    $AG = $reg1 ['CORREO'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $A);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $B);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $C);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $D);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $E);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $F);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $G);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$Fila, $H,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $I);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $J);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $K);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $L);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $M);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $N);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $O);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $P);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $Q);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $R);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $S);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('T'.$Fila, $T,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $U);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $V);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $W);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $X);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, $Y);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $Z);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AA'.$Fila, $AA,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AB'.$Fila, $AB,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AC'.$Fila, $AC);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AD'.$Fila, $AD);
    $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('AE'.$Fila, $AE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $fecha);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AG'.$Fila, $AG);

    $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':AG'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Consulta_clientes_x_fecha_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











