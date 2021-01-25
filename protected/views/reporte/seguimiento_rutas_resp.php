<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

$anio = $model['anio'];
$rutas = implode(",", $model['ruta']);

set_time_limit(0);

//se obtiene la cadena de la fecha actual
$diatxt=date('l');
$dianro=date('d');
$mestxt=date('F');
$anionro=date('Y');
// *********** traducciones y modificaciones de fechas a letras y a español ***********
$ding=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$ming=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$mesp=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');


/*inicio configuración array de datos*/

$query1 = "
  SELECT DISTINCT
  t200_v.f200_nit as Cedula
  ,t200_v.f200_razon_social as Vendedor
  ,CONCAT(f430_id_co,'-',f430_id_tipo_docto,'-',f430_consec_docto) as Docto
  ,convert(nvarchar,f430_fecha_ts_creacion,112) as Fecha
  ,YEAR(f430_fecha_ts_creacion) as ANIO
  ,MONTH(f430_fecha_ts_creacion) as MES
  ,t200.f200_nit as Nit
  ,t200.f200_razon_social as Cliente
  ,f5790_id as Ruta
  FROM UnoEE1..t430_cm_pv_docto as t430 WITH (NOLOCK)
  INNER JOIN UnoEE1..t200_mm_terceros as t200 WITH (NOLOCK) ON f430_id_cia=t200.f200_id_cia  and t200.f200_rowid = f430_rowid_tercero_rem
  INNER JOIN UnoEE1..t201_mm_clientes as t201 WITH (NOLOCK) ON f430_id_cia=t200.f200_id_cia  and t201.f201_rowid_tercero = f430_rowid_tercero_rem and f201_id_sucursal= f430_id_sucursal_rem
  INNER JOIN UnoEE1..t5791_sm_ruta_frecuencia as t5791 WITH (NOLOCK) ON  f5791_rowid_tercero=f201_rowid_tercero and f5791_id_suc_cliente=f201_id_sucursal
  INNER JOIN UnoEE1..t5790_sm_ruta as t5790 WITH (NOLOCK) ON t5790.f5790_rowid=f5791_rowid_ruta
  INNER JOIN UnoEE1..t210_mm_vendedores as t210 WITH (NOLOCK) ON f210_id=f5790_id_vendedor
  INNER JOIN UnoEE1..t200_mm_terceros as t200_v WITH (NOLOCK) ON t200_v.f200_rowid=f210_rowid_tercero
  WHERE f430_id_cia = 2
  and f430_ind_facturado=1
  and f430_ind_estado=4
  and YEAR(f430_fecha_ts_creacion)=".$anio ."
  and f5790_id in (".$rutas.")
  order by 9,8
";

$q1 = Yii::app()->db->createCommand($query1)->queryAll();

$query2 = "
  SELECT DISTINCT
  t200_v.f200_nit as Cedula
  ,t200_v.f200_razon_social as Vendedor
  ,t200.f200_nit as Nit
  ,t200.f200_razon_social as Cliente
  ,t201.f201_id_sucursal as Sucursal
  ,f5790_id as Ruta
  ,t200.f200_fecha_nacimiento as Creacion_Cliente
  ,YEAR(t200.f200_fecha_nacimiento) as ANIO
  ,MONTH(t200.f200_fecha_nacimiento) as MES
  --select top 20 *
  FROM UnoEE1..t5790_sm_ruta as t5790 WITH (NOLOCK)
  INNER JOIN UnoEE1..t5791_sm_ruta_frecuencia as t5791 WITH (NOLOCK) ON t5790.f5790_rowid=f5791_rowid_ruta
  INNER JOIN UnoEE1..t201_mm_clientes as t201 WITH (NOLOCK) ON t201.f201_rowid_tercero = f5791_rowid_tercero and f201_id_sucursal= f5791_id_suc_cliente
  INNER JOIN UnoEE1..t200_mm_terceros as t200 WITH (NOLOCK) ON f201_id_cia=t200.f200_id_cia  and t200.f200_rowid = f201_rowid_tercero
  INNER JOIN UnoEE1..t210_mm_vendedores as t210 WITH (NOLOCK) ON f210_id=f5790_id_vendedor
  INNER JOIN UnoEE1..t200_mm_terceros as t200_v WITH (NOLOCK) ON t200_v.f200_rowid=f210_rowid_tercero
  WHERE t200.f200_id_cia = 2
  and YEAR(t200.f200_fecha_nacimiento)=".$anio ." 
  and f5790_id in (".$rutas.")
  order by 6,4,7
";

$q2 = Yii::app()->db->createCommand($query2)->queryAll();

$query3 = "
  SELECT DISTINCT
  f5790_id as Ruta
  ,t200.f200_nit as Nit
  ,f200_razon_social as Cliente 
  --select top 20 *
  FROM UnoEE1..t5790_sm_ruta as t5790 WITH (NOLOCK)
  INNER JOIN UnoEE1..t5791_sm_ruta_frecuencia as t5791 WITH (NOLOCK) ON t5790.f5790_rowid=f5791_rowid_ruta
  INNER JOIN UnoEE1..t201_mm_clientes as t201 WITH (NOLOCK) ON t201.f201_rowid_tercero = f5791_rowid_tercero and f201_id_sucursal= f5791_id_suc_cliente
  INNER JOIN UnoEE1..t200_mm_terceros as t200 WITH (NOLOCK) ON f201_id_cia=t200.f200_id_cia  and t200.f200_rowid = f201_rowid_tercero
  WHERE t200.f200_id_cia = 2
  and f5790_id in (".$rutas.")
  and f200_ind_estado=1
  order by 1
";

$q3 = Yii::app()->db->createCommand($query3)->queryAll();

/*fin configuración array de datos*/

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex();
$objPHPExcel->getActiveSheet()->setTitle('Pedidos');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Cédula');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Vendedor');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Docto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Fecha');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Año');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Mes');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Nit');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Ruta');

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
 
$Fila = 2; 

foreach ($q1 as $reg) {

  $cedula = $reg['Cedula'];
  $vendedor = $reg['Vendedor'];
  $docto = $reg['Docto'];
  $fecha = $reg['Fecha'];
  $anio = $reg['ANIO'];
  $mes = $reg['MES'];
  $nit = $reg['Nit'];
  $cliente = $reg['Cliente'];
  $ruta = $reg['Ruta'];
  
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $cedula);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $vendedor);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $docto);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $fecha);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $anio);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $mes);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $nit);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $cliente);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $ruta);

  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

  $Fila = $Fila + 1;
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

$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->setTitle('Clientes creados');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'Cédula');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', 'Vendedor');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', 'Nit');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'Cliente');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E1', 'Sucursal');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F1', 'Ruta');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', 'Fecha de creación');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H1', 'Año');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I1', 'Mes');

$objPHPExcel->getActiveSheet(1)->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(1)->getStyle('A1:I1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
 
$Fila = 2; 

foreach ($q2 as $reg) {

  $cedula = $reg['Cedula'];
  $vendedor = $reg['Vendedor'];
  $nit = $reg['Nit'];
  $cliente = $reg['Cliente'];
  $sucursal = $reg['Sucursal'];
  $ruta = $reg['Ruta'];
  $fecha_creacion = $reg['Creacion_Cliente'];
  $anio = $reg['ANIO'];
  $mes = $reg['MES'];
  
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$Fila, $cedula);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$Fila, $vendedor);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$Fila, $nit);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$Fila, $cliente);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$Fila, $sucursal);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$Fila, $ruta);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$Fila, $fecha_creacion);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$Fila, $anio);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$Fila, $mes);

  $objPHPExcel->getActiveSheet(1)->getStyle('A'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

  $Fila = $Fila + 1;
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

$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(2);
$objPHPExcel->getActiveSheet()->setTitle('Total clientes');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', 'Ruta');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('B1', 'Nit');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('C1', 'Cliente');

$objPHPExcel->getActiveSheet(2)->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(2)->getStyle('A1:C1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
 
$Fila = 2; 

foreach ($q3 as $reg) {

  $ruta = $reg['Ruta'];
  $nit = $reg['Nit'];
  $cliente = $reg['Cliente'];
  
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.$Fila, $ruta);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$Fila, $nit);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C'.$Fila, $cliente);

  $objPHPExcel->getActiveSheet(2)->getStyle('A'.$Fila.':C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

  $Fila = $Fila + 1;
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

$objPHPExcel->setActiveSheetIndex(0);

$n = 'Seguimiento_rutas_'.date('Y_m_d_H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>