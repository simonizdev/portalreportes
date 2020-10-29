<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte

$a_ordenes = $model['n_oc'];

//se genera un array por el arreglo que llega con las ordenes de compra
$array_ordenes_v = array();
$array_ordenes = explode(",", $a_ordenes);
foreach ($array_ordenes as $key => $orden) {
    if(is_numeric($orden)){
        $array_ordenes_v[] = trim($orden);
    }
}

$array_oc = array();

foreach ($array_ordenes_v as $key => $orden) {

    $query ="SET NOCOUNT ON EXEC [dbo].[LOG_CROSSDOKIN ] 
    @OC  = '".$orden."'";
    
    $q = Yii::app()->db->createCommand($query)->queryAll();
    
    $suma_und = 0;
    $suma_peso = 0;
    $suma_vol = 0;

    if(!empty($q)){
        foreach ($q as $reg) {
            $Fecha = date("Y-m-d", strtotime($reg['FECHA']));
            $Factura = $reg['FACTURA'];
            $Pedido = $reg['PEDIDO'];
            $Cliente = $reg['CLIENTE'];
            $Ciudad = $reg['CIUDAD'];
            $Subtotal = $reg['SUBTOTAL'];
            $suma_und = $suma_und + $reg['UNIDADES'];
            $suma_peso = $suma_peso + $reg['PESO'];
            $suma_vol = $suma_vol + $reg['VOLUMEN'];

        }

        $array_oc[] = array('Fecha' => $Fecha, 'Factura' => $Factura, 'Pedido' => $Pedido, 'Cliente' => $Cliente, 'Ciudad' => $Ciudad, 'OC' => $orden, 'Subtotal' => $Subtotal, 'Und' => $suma_und, 'Peso' => $suma_peso , 'Volumen' => $suma_vol);
    }
}

/*inicio configuración array de datos*/

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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Fecha');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Factura');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Pedido');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Ciudad');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Orden de compra');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Subtotal');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Unidades');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Peso');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Volumen');

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$Fila = 2;

foreach ($array_oc as $data) {
    
    $Fecha = $data['Fecha']; 
    $Factura = $data['Factura']; 
    $Pedido = $data['Pedido'];
    $Cliente = $data['Cliente']; 
    $Ciudad = $data['Ciudad']; 
    $OC = $data['OC'];
    $Subtotal = $data['Subtotal'];
    $Und = $data['Und']; 
    $Peso = $data['Peso'];
    $Volumen = $data['Volumen'];
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $Fecha);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $Factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $Pedido);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $Cliente);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $Ciudad);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $OC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $Subtotal);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $Und);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $Peso);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $Volumen);

    $Fila = $Fila + 1; 

    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':J'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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

$n = 'Log_Crossdocking_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
