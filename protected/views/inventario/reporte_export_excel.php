<?php
/* @var $this PromocionController */
/* @var $model Promocion */

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

  /*Inicio contenido tabla*/

  $fecha_act = date("Y-m");

  $nuevafecha = strtotime ('-4 month', strtotime($fecha_act));
  $a = date ('Y', $nuevafecha);
  $m = date ('m', $nuevafecha);

  $fecha = date('Y-m-d', mktime(0,0,0, $m, 1, $a));

  $array = array(1 => 'B1', 2 => 'D1', 3 => 'F1', 4 => 'H1', 5 => 'J1');


  for ($i = 1; $i <= 5 ; $i++) { 
    
    $anio = date("Y", strtotime($fecha));  

    $mes = date("m", strtotime($fecha)); 

    $objPHPExcel->setActiveSheetIndex()->setCellValue($array[$i], $anio.'-'.$mes);

    $fecha = strtotime ('+1 month', strtotime($fecha));
    $fecha = date('Y-m-d', $fecha);
  }

  $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A2', 'Departamento');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B2', 'PPAP-C');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C2', 'PPAP-P');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D2', 'PPAP-C');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E2', 'PPAP-P');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F2', 'PPAP-C');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G2', 'PPAP-P');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H2', 'PPAP-C');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I2', 'PPAP-P');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J2', 'PPAP-C');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K2', 'PPAP-P');

  $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);

  $departamentos = Departamento::model()->FindAllByAttributes(array('Estado' => 1), array('order'=>'Descripcion'));

  $Fila = 4;

  foreach ($departamentos as $deptos) {
     
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $deptos->Descripcion);

    $fecha_act = date("Y-m");

    $nuevafecha = strtotime ('-4 month', strtotime($fecha_act));

    $a = date ('Y', $nuevafecha);
    $m = date ('m', $nuevafecha);

    $fecha = date('Y-m-d', mktime(0,0,0, $m, 1, $a));

    $array_p = array(1 => 'B,C', 2 => 'D,E', 3 => 'F,G', 4 => 'H,I', 5 => 'J,K');

    for ($i = 1; $i <= 5 ; $i++) {

      $anio = date("Y", strtotime($fecha));  

      $mes = date("m", strtotime($fecha)); 

      $day_f = date("d", mktime(0,0,0, $mes + 1, 0, $anio));
        
      $fecha_inicial = date('Y-m-d', mktime(0,0,0, $mes, 1, $anio));

      $fecha_final = date('Y-m-d', mktime(0,0,0, $mes, $day_f, $anio));

      $query_PPAP_C ="
      SELECT 
      SUM(i.Cantidad) AS TOTAL_CANT
      FROM TH_INVENTARIO i
      WHERE i.Tipo = 2 AND i.Id_Suministro = ".Yii::app()->params->sum_res_car." AND i.Id_Departamento = ".$deptos->Id_Departamento." AND i.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
      ";
      
      $resp_PPAP_C = Yii::app()->db->createCommand($query_PPAP_C)->queryRow();

      $query_PPAP_P ="
      SELECT 
      SUM(i.Cantidad) AS TOTAL_CANT
      FROM TH_INVENTARIO i
      WHERE i.Tipo = 2 AND i.Id_Suministro = ".Yii::app()->params->sum_res_ofi." AND i.Id_Departamento = ".$deptos->Id_Departamento." AND i.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
      ";

      $resp_PPAP_P = Yii::app()->db->createCommand($query_PPAP_P)->queryRow();


      if($resp_PPAP_C['TOTAL_CANT'] == ''){
          $cc = 0;
      }else{
          $cc = $resp_PPAP_C['TOTAL_CANT'];
      }

      if($resp_PPAP_P['TOTAL_CANT'] == ''){
          $co = 0;
      }else{
          $co = $resp_PPAP_P['TOTAL_CANT'];
      }

      $pos = explode(",", $array_p[$i]);

      $objPHPExcel->setActiveSheetIndex()->setCellValue($pos[0].$Fila, $cc);
      $objPHPExcel->setActiveSheetIndex()->setCellValue($pos[1].$Fila, $co);

      $fecha = strtotime ('+1 month', strtotime($fecha));
      $fecha = date('Y-m-d', $fecha);

    }

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':K'.$Fila.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $Fila ++;
  }

  //totales

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'TOTAL');

  $array_p = array(1 => 'B,C', 2 => 'D,E', 3 => 'F,G', 4 => 'H,I', 5 => 'J,K');

  $fecha_act = date("Y-m");

  $nuevafecha = strtotime ('-4 month', strtotime($fecha_act));

  $a = date ('Y', $nuevafecha);
  $m = date ('m', $nuevafecha);

  $fecha = date('Y-m-d', mktime(0,0,0, $m, 1, $a));

  for ($i = 1; $i <= 5 ; $i++) {

      $anio = date("Y", strtotime($fecha));  

      $mes = date("m", strtotime($fecha)); 

      $day_f = date("d", mktime(0,0,0, $mes + 1, 0, $anio));
        
      $fecha_inicial = date('Y-m-d', mktime(0,0,0, $mes, 1, $anio));

      $fecha_final = date('Y-m-d', mktime(0,0,0, $mes, $day_f, $anio));

      $query_PPAP_C ="
      SELECT 
      SUM(i.Cantidad) AS TOTAL_CANT
      FROM TH_INVENTARIO i
      WHERE i.Tipo = 2 AND i.Id_Suministro = ".Yii::app()->params->sum_res_car."  AND i.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
      ";
      
      $resp_PPAP_C = Yii::app()->db->createCommand($query_PPAP_C)->queryRow();

      $query_PPAP_P ="
      SELECT 
      SUM(i.Cantidad) AS TOTAL_CANT
      FROM TH_INVENTARIO i
      WHERE i.Tipo = 2 AND i.Id_Suministro = ".Yii::app()->params->sum_res_ofi." AND i.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
      ";

      $resp_PPAP_P = Yii::app()->db->createCommand($query_PPAP_P)->queryRow();


      if($resp_PPAP_C['TOTAL_CANT'] == ''){
          $cc = 0;
      }else{
          $cc = $resp_PPAP_C['TOTAL_CANT'];
      }

      if($resp_PPAP_P['TOTAL_CANT'] == ''){
          $co = 0;
      }else{
          $co = $resp_PPAP_P['TOTAL_CANT'];
      }

      $pos = explode(",", $array_p[$i]);

      $objPHPExcel->setActiveSheetIndex()->setCellValue($pos[0].$Fila, $cc);
      $objPHPExcel->setActiveSheetIndex()->setCellValue($pos[1].$Fila, $co);

      $fecha = strtotime ('+1 month', strtotime($fecha));
      $fecha = date('Y-m-d', $fecha);

  }

  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':K'.$Fila.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':K'.$Fila.'')->getFont()->setBold(true);

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

  $n = 'Salida_papeleria_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

