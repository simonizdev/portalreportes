<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

$tipo = $model['tipo'];
$consecutivo = $model['consecutivo'];

$logo_simoniz = Yii::app()->getBaseUrl(true).'/images/logo_simonizco.png';

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
$diaesp=str_replace($ding, $desp, $diatxt);
$mesesp=str_replace($ming, $mesp, $mestxt);

$fecha_act= $diaesp.", ".$dianro." de ".$mesesp." de ".$anionro;

$query ="
  SET NOCOUNT ON
  EXEC [dbo].[POS_FEV]
  @NUM1 = N'".$consecutivo."',
  @NUM2 = N'".$consecutivo."',
  @TIPO = '".$tipo."'
";

$data = Yii::app()->db->createCommand($query)->queryAll();

$n_items = count($data);

$query2 ="
  SET NOCOUNT ON
  EXEC [dbo].[POS_FEV_MP]
  @NUM1 = N'".$consecutivo."',
  @NUM2 = N'".$consecutivo."',
  @TIPO = '".$tipo."'
";

$data2 = Yii::app()->db->createCommand($query2)->queryAll();

$n_f_pago = count($data2);

$array_header = array();
$array_data = array();
$array_f_pago = array();
$array_footer = array();
$code = "";

if($n_items > 0){

    //Cabecera
    $nit = utf8_decode($data[0]['TEXTO1']);
    $direccion = utf8_decode($data[0]['TEXTO2']);
    $telefono = utf8_decode($data[0]['TEXTO3']);
    $empresa = utf8_decode($data[0]['TEXTO4']);

    //Datos factura cliente
    $tvp = substr(utf8_decode($data[0]['TPV']), 0, 38);
    $cajero = substr(utf8_decode($data[0]['Cajero']), 0, 25);
    $fecha = substr(utf8_decode($data[0]['Fecha']), 0, 38);
    $n_factura = substr(utf8_decode($data[0]['Factura']), 0, 38);
    $cliente = substr(utf8_decode($data[0]['Cliente']), 0, 38);
    $ident_cliente = substr(utf8_decode($data[0]['Nit']), 0, 38);
    $direccion_cliente = substr(utf8_decode($data[0]['Direccion']), 0, 38);
    $telefono_cliente = substr(utf8_decode($data[0]['Telefono']), 0, 38);
    $celular = substr(utf8_decode($data[0]['Celular']), 0, 38);
    $vlr_total = number_format(floatval($data[0]['Vlr_Fact_Total']),0,".",",");


    $array_header = array($nit, $direccion, $telefono, $empresa, $tvp, $cajero, $fecha, $n_factura, $cliente, $ident_cliente, $direccion_cliente, $telefono_cliente, $celular, $vlr_total);

    //Datos de resol.
    
    $n_resol = trim(utf8_decode($data[0]['Nro_Resolucion']));
    $fr = date_create($data[0]['Fech_Resolucion']);
    $fecha_resol = date_format($fr,"Y/m/d");
    $fvr = date_create($data[0]['Fecha_Vcto_Resolucion']);
    $fecha_venc_resol = date_format($fvr,"Y/m/d");
    $prefijo = trim(utf8_decode($data[0]['Prefijo']));
    $num_inicial = trim(utf8_decode($data[0]['Num_Inicial']));
    $num_final = trim(utf8_decode($data[0]['Num_Final']));
    $texto5 = utf8_decode($data[0]['TEXTO5']);
    $texto6 = utf8_decode($data[0]['TEXTO6']);
    $texto7 = utf8_decode($data[0]['TEXTO7']);
    $texto8 = utf8_decode($data[0]['TEXTO8']);
    $texto9 = utf8_decode($data[0]['TEXTO9']);
    $texto10 = utf8_decode($data[0]['TEXTO10']);
    $texto11 = utf8_decode($data[0]['TEXTO11']);
    $texto12 = utf8_decode($data[0]['TEXTO12']);
    $texto13 = utf8_decode($data[0]['TEXTO13']);
    $texto14 = utf8_decode($data[0]['TEXTO14']);
    $texto15 = utf8_decode($data[0]['TEXTO15']);
    $texto16 = utf8_decode($data[0]['TEXTO16']);
    $texto17 = utf8_decode($data[0]['TEXTO17']);
    $texto18 = utf8_decode($data[0]['TEXTO18']);
    $texto19 = utf8_decode($data[0]['TEXTO19']);
    $code = str_replace(" ", "", utf8_decode($n_factura." - ".$fecha));
    
    $array_footer = array($n_resol, $fecha_resol, $fecha_venc_resol, $prefijo, $num_inicial, $num_final, $texto5, $texto6, $texto7, $texto8, $texto9, $texto10, $texto11, $texto12, $texto13, $texto14, $texto15, $texto16, $texto17, $texto18, $texto19, $code);

    //items
    foreach ($data as $info) {

        $desc = substr(utf8_decode($info['Descripcion']), 0, 38);
        $ref = $info['Referencia'];
        $cant = number_format(floatval($info['Cantidad']),2,".",",");
        $um = $info['UM'];
        $vlr_uni = number_format(floatval($info['Vlr_Uni']),0,".",",");
        $vlr_total = number_format(floatval($info['Vlr_Total']),0,".",",");

        $array_data[] = array($desc, $ref, $cant, $um, $vlr_uni, $vlr_total);
    }

    //formas de pago
    foreach ($data2 as $info_fp) {

        $tipo = utf8_decode($info_fp['TIPO']);
        $aux = $info_fp['Tarjeta'];
        $vlr = number_format(floatval($info_fp['Vlr_Tipo']),0,".",",");

        $array_f_pago[] = array($tipo, $aux, $vlr);
    }

}

$n_reg = $n_items + $n_f_pago;

/*fin configuración array de datos*/

//PDF

//se incluye la libreria pdf
require_once Yii::app()->basePath . '/extensions/fpdf/fpdf.php'; 

class PDF extends FPDF{

    protected $col = 0; // Current column
    protected $y0;      // Ordinate of column start

    function setLogoSimoniz($logo_simoniz){
        $this->logo_simoniz = $logo_simoniz;
    }

    function setDataHeader($header){
        $this->header = $header;
    }

    function setData($data){
        $this->data = $data;
    }

    function setDataPago($datapago){
        $this->datapago = $datapago;
    }

    function setDataFooter($footer){
        $this->footer = $footer;
    }

    function Header()
    {
        $this->Ln(10);
        // Save ordinate
        $this->y0 = $this->GetY();
    }

    function SetCol($col)
    {
        // Set position at a given column
        $this->col = $col;
        $x = 10+$col*65;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak()
    {
        // Method accepting or not automatic page break
        if($this->col<2){
            // Go to next column
            $this->SetCol($this->col+1);
            // Set ordinate to top
            $this->SetY($this->y0);
            // Keep on page
            return false;
        }else{
            // Go back to first column
            $this->SetCol(0);
            // Page break
            return true;
        }
    }

    function FactMargin()
    {
        $this->Ln(4);
        // Save ordinate
        $this->y0 = $this->GetY();
    }

    function FactBody()
    {
        $data_header = $this->header;
        $data = $this->data;
        $data_fp = $this->datapago;
        $data_footer = $this->footer;

        if(!empty($data)){

            $n_reg = count($data);
            $this->Image($this->logo_simoniz, 19, 3, 43, 18);
            $this->SetFont('Arial','B',7);
            $this->MultiCell(60,3,$data_header[0],0,'C');
            $this->MultiCell(60,3,$data_header[1],0,'C');
            $this->MultiCell(60,3,$data_header[2],0,'C');
            $this->MultiCell(60,3,$data_header[3],0,'C');
            $this->Ln(6);
            $this->SetFont('Arial','',7);
            $this->Cell(19,3,'TVP',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[4],0,0,'L');
            $this->Ln();
            $this->Cell(19,3,'Cajero',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[5],0,0,'L');
            $this->Ln();
            $this->Cell(19,3,'Fecha',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[6],0,0,'L');
            $this->Ln();
            $this->Cell(19,3,'Factura de venta',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[7],0,0,'L');
            $this->Ln();
            $this->Cell(19,3,'Cliente',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[8],0,0,'L');
            $this->Ln();
            $this->Cell(19,3,'Nit / C.C',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[9],0,0,'L');
            $this->Ln();
            $this->Cell(19,3,'Direccion',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[10],0,0,'L');
            $this->Ln();
            $this->Cell(19,3,'Telefono',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[11],0,0,'L');
            $this->Ln();
            $this->Cell(19,3,'Celular',0,0,'L');
            $this->Cell(1,3,':',0,0,'L');
            $this->Cell(40,3,$data_header[12],0,0,'L');
            $this->Ln();
            $this->MultiCell(60,3,'----------------------------------------------------------------------',0,'C');
            $this->Cell(60,3,'Descripcion de item',0,0,'L');
            $this->Ln();
            $this->Cell(16,3,'Referencia',0,0,'L');
            $this->Cell(8,3,'Cant.',0,0,'L');
            $this->Cell(8,3,'U.M',0,0,'L');
            $this->Cell(14,3,'V/r Uni.',0,0,'R');
            $this->Cell(14,3,'Total',0,0,'R');
            $this->Ln();
            $this->MultiCell(60,3,'----------------------------------------------------------------------',0,'C');
            foreach ($data as $info_item) {
                $this->Cell(60,3,$info_item[0],0,0,'L');
                $this->Ln();
                $this->Cell(16,3,$info_item[1],0,0,'L');
                $this->Cell(8,3,$info_item[2],0,0,'L');
                $this->Cell(8,3,$info_item[3],0,0,'L');
                $this->Cell(14,3,'$'.$info_item[4],0,0,'R');
                $this->Cell(14,3,'$'.$info_item[5],0,0,'R');
                $this->Ln();
            }
            $this->MultiCell(60,3,'----------------------------------------------------------------------',0,'C');
            $this->Cell(46,3,'TOTAL  ..........',0,0,'L');
            $this->Cell(14,3,'$'.$data_header[13],0,0,'R');
            $this->Ln();
            $this->MultiCell(60,3,'-----------------[DETALLE DE VALORES]------------------',0,'C');
            $this->Cell(46,3,'Venta excluida  ..........',0,0,'L');
            $this->Cell(14,3,'$'.$data_header[13],0,0,'R');
            $this->Ln();
            $this->MultiCell(60,3,'----------------------------------------------------------------------',0,'C');
            foreach ($data_fp as $info_f_pago) {
                $this->Cell(36,3,$info_f_pago[0],0,0,'L');
                $this->Cell(10,3,$info_f_pago[1],0,0,'L');
                $this->Cell(14,3,$info_f_pago[2],0,0,'R');
                $this->Ln();
            }
            /*$this->Cell(36,3,'TARJETA DEBITO',0,0,'L');
            $this->Cell(10,3,'8877',0,0,'L');
            $this->Cell(14,3,'$69.900',0,0,'R');
            $this->Ln();*/
            $this->MultiCell(60,3,'----------------------------------------------------------------------',0,'C');
            $this->Ln();
            $this->SetFont('Arial','',6);
            $this->MultiCell(60,3,'AUTORIZACION NUMERACION DE FACTURACION',0,'C');
            $this->MultiCell(60,3,'RESOLUC. '.$data_footer[0].' DESDE',0,'C');
            $this->MultiCell(60,3,$data_footer[1].' HASTA '.$data_footer[2],0,'C');
            $this->MultiCell(60,3,'PREFIJO. '.$data_footer[3].' DEL No. '.$data_footer[4].' AL '.$data_footer[5],0,'C');
            $this->MultiCell(60,3,'GRANDES CONTRIBUYENTES',0,'C');
            $this->MultiCell(60,3,'RESOL. 012635 DE 2018/12/14',0,'C');
            $this->Ln();
            $this->MultiCell(60,3,$data_footer[6],0,'C');
            $this->MultiCell(60,3,$data_footer[7],0,'C');
            $this->MultiCell(60,3,$data_footer[8],0,'C');
            $this->MultiCell(60,3,$data_footer[9],0,'C');

            $this->MultiCell(60,3,$data_footer[10],0,'C');
            $this->MultiCell(60,3,$data_footer[11],0,'C');
            $this->MultiCell(60,3,$data_footer[12],0,'C');
            $this->MultiCell(60,3,$data_footer[13],0,'C');
            $this->MultiCell(60,3,$data_footer[14],0,'C');
            $this->MultiCell(60,3,$data_footer[15],0,'C');
            $this->Ln();
            $this->SetFont('Arial','B',6);
            $this->MultiCell(60,3,$data_footer[16],0,'C');
            $this->Ln();
            $this->MultiCell(60,3,$data_footer[17],0,'C');
            $this->MultiCell(60,3,$data_footer[18],0,'C');
            $this->MultiCell(60,3,$data_footer[19],0,'C');
            $this->MultiCell(60,3,$data_footer[20],0,'C');
            $this->Ln();

            $newY = $this->getY();
            $newX = $this->getX() + 10;

            $this->Image('http://chart.googleapis.com/chart?chs=100x100&cht=qr&chl='.$data_footer[21].'.png', $newX, $newY, 40, 40);
            $this->SetCol(0);
        }
    }

    function PrintFact()
    {
        // Add chapter
        $this->AddPage();
        $this->SetCol(0);
        $this->FactMargin();
        $this->FactBody();
    }
}


if($n_reg > 12){
    $pdf = new PDF('P','mm','A4');
}else{
    $pagesize = array(297, 80);
    $pdf = new PDF('P', 'mm', $pagesize);   
}
$pdf->SetAutoPageBreak(true, 40);
$pdf->setLogoSimoniz($logo_simoniz);
$pdf->setDataHeader($array_header);
$pdf->setData($array_data);
$pdf->setDataPago($array_f_pago);
$pdf->setDataFooter($array_footer);
$pdf->PrintFact();

$pdf->Output('D','Factura_POS_'.$consecutivo.'.pdf');

?>
