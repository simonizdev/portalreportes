<?php

// setup scriptmap for jquery and jquery-ui cdn
$cs = Yii::app()->clientScript;
$cs->scriptMap["jquery.js"] = Yii::app()->getBaseUrl(true) . "/components/jquery/dist/jquery.min.js";;
$cs->scriptMap["jquery.min.js"] = $cs->scriptMap["jquery.js"];
$cs->scriptMap["jquery-ui.min.js"] = Yii::app()->getBaseUrl(true) . "/components/jquery-ui/jquery-ui.min.js";
$cs->scriptMap["jquery.ba-bbq.js"] = Yii::app()->theme->baseUrl . "/assets/js/jquery.ba-bbq.min.js";

// register js files
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerScriptFile(Yii::app()->getBaseUrl(true) . "/components/bootstrap/dist/js/bootstrap.min.js", CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . "/assets/js/main.js", CClientScript::POS_END);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
    <!-- CSS -->
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/main.css" rel="stylesheet">
    <!-- Jquery ui theme -->
    <link rel="stylesheet" type="text/css" href="components/jquery-ui/themes/ui-lightness/jquery-ui.css"/>
    <!-- daterange picker -->
    <link rel="stylesheet" href="components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- Jquery tree -->
    <link rel="stylesheet" type="text/css" href="components/jquery-tree/src/css/jquery.tree.css"/>
    <!-- Javascript -->
    <script>var baseUrl = "<?php echo Yii::app()->baseUrl; ?>";</script>
    <!-- NOTE: Yii uses this title element for its asset manager, so keep it last -->
    <title><?php echo CHtml::encode(Yii::app()->name); ?></title>
</head>

<?php if(!Yii::app()->user->isGuest) { ?>

<script type="text/javascript">

$(function() {
  //funcion para cargar y mostrar las opciones de menu
  $.ajax({ 
    type: "POST",
    url: "<?php echo Yii::app()->createUrl('menu/loadmenu'); ?>", 
    dataType: 'json',
    success: function(data){
      if (data.length > 0) {
          $.each(data, function(indice0) {
            //nivel 1
            id0 = data[indice0]['id'];
            text0 = data[indice0]['text'];
            children0 = data[indice0]['children'];
            link0 = data[indice0]['link'];
            icon0 = data[indice0]['icon'];
            $("#sidebar-menu").append('<li id="me_li_'+id0+'"><a href="'+link0+'" id="me_a_'+id0+'"><i class="'+icon0+'"></i> <span>'+text0+'</span></a></li>');
            if (children0.length > 0) {
              //nivel 2
              $("#me_li_"+id0+"").addClass("treeview");
              $("#me_a_"+id0+"").append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>');
              $("#me_li_"+id0+"").append('<ul class="treeview-menu" id="me_ul_'+id0+'"></ul>');
              $.each(children0, function(indice1) {
                id1 = children0[indice1]['id'];
                text1 = children0[indice1]['text'];
                children1 = children0[indice1]['children'];
                link1 = children0[indice1]['link'];
                icon1 = children0[indice1]['icon'];
                $("#me_ul_"+id0+"").append('<li id="me_li_'+id1+'"><a href="'+link1+'" id="me_a_'+id1+'"><i class="'+icon1+'"></i> <span>'+text1+'</span></a></li>');
                if (children1.length > 0) {
                  //nivel 3
                  $("#me_li_"+id1+"").addClass("treeview");
                  $("#me_a_"+id1+"").append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>');
                  $("#me_li_"+id1+"").append('<ul class="treeview-menu" id="me_ul_'+id1+'"></ul>');
                  $.each(children1, function(indice2) {
                    id2 = children1[indice2]['id'];
                    text2 = children1[indice2]['text'];
                    children2 = children1[indice2]['children'];
                    link2 = children1[indice2]['link'];
                    icon2 = children1[indice2]['icon'];
                    $("#me_ul_"+id1+"").append('<li id="me_li_'+id2+'"><a href="'+link2+'" id="me_a_'+id2+'"><i class="'+icon2+'"></i> <span>'+text2+'</span></a></li>'); 
                  });
                } 
              });
            }
          });
        $("#sidebar-menu").fadeIn();
      } 
    }
  });
});

</script>

<body class="hold-transition skin-green fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo Yii::app()->baseUrl."/images/logo_simonizco_small.png"; ?>"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo Yii::app()->baseUrl."/images/logo_simonizco_medium.png"; ?>"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo Yii::app()->user->getState('name_user'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user.jpg" class="img-circle" alt="User Image">
                <p>
                  <small><?php echo Yii::app()->user->getState('name_user'); ?></small>
                  <small><?php echo Yii::app()->user->getState('username_user'); ?></small>
                  <small><?php echo Yii::app()->user->getState('email_user'); ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <button type="button" class="btn btn-block btn-success btn-sm" onclick="location.href='<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=usuario/profile'; ?>';"><i class="fa fa-gears"></i> Configuración de cuenta</button>

                </div>
                <div class="pull-right">
                  <button type="button" class="btn btn-block btn-danger btn-sm" onclick="location.href='<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=site/logout'; ?>';"><i class="fa fa-sign-out"></i> Salir</button>

                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree" id="sidebar-menu" style="display: none;">
        <li class="header"><b class="name_app"><?php echo Yii::app()->name; ?></b></li>
        <!-- se carga el menu via ajax -->       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="ajax-loader" style="display: none">
    </div>
   <div class="container-fluid">
      <section class="content">
            <?php if (!$this->menu): ?>

                <div class="row">
                    <div class="col-lg-12">
                        <?php echo $content; ?>
                    </div>
                </div>

            <?php else: ?>

                <div class="row">
                    <div class="col-lg-10">
                        <?php echo $content; ?>
                    </div>
                    <div class="col-lg-2">
                        <div class="panel panel-info">
                            <div class="panel-heading">Operations</div>
                                <?php
                                $this->widget('zii.widgets.CMenu', array(
                                    'items'=>$this->menu,
                                    'htmlOptions'=>array('class'=>'nav nav-pills nav-stacked'),
                                ));
                                ?>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        <hr>
        <footer>
            <p>© <?php echo CHtml::encode(Yii::app()->name); ?> - Simoniz <?php echo date('Y'); ?></p>
        </footer>

      </section>
    </div> <!-- /.container --> 
  </div>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

</body>

<?php } else { ?>

<body class="hold-transition login-page">

    <?php echo $content; ?>

</body>

<?php } ?>

<!-- date-range-picker -->
<script src="components/moment/min/moment.min.js"></script>
<script src="components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Jquery tree -->
<script type="text/javascript" src="components/jquery-tree/src/js/jquery.tree.js"></script>
<!-- Scroll menu -->
<script src="components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- PDF.js -->
<script src="components/pdf.js/pdf.js"></script>
<script src="components/pdf.js/pdf.worker.js"></script>

<style type="text/css">

/*Modificación botones de la grid yii*/
.actions{
  padding-left: 5%;
  padding-right: 5%; 
}

/*Fin modificación botones de la grid yii*/

.table-responsive {
  font-size: 12px !important;
}

.badge {
    font-size: 10px !important;
}

.pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover {
    text-decoration: underline;
    color: #666 !important;
}

.summary{
      padding: 8px;
}

.dataTables_paginate.paging_bootstrap {
    padding: 8px;
}

/*Fin modificación header sort de la grid yii*/

/*Estilos ventana loader*/

.ajax-loader {
  position:   fixed;
  z-index:    1000;
  top:        0;
  left:       0;
  height:     100%;
  width:      100%;
  background: rgba( 255, 255, 255, 1 ) 
  url('<?php echo Yii::app()->getBaseUrl(true); ?>/images/loading.gif') 
  50% 50% 
  no-repeat;
}

/*Estilos ventana loader*/

/*Estilos tree*/

.ui-widget {
    font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif !important;
}

.input_tree {
    width: 60px;
    height: 20px;
    padding: 10px;
    border-radius: 5px;
}

.pagination>.selected>a, .pagination>.selected>a:hover {
    z-index: 3;
    color: #fafafa !important;
    cursor: default;
    background-color: #333333;
    border-color: #333333;
}

td.button-column {
  width: 70px !important;
}

b.name_app {
  color: #b8c7cf;
  padding-left: 3px;
  font-weight: 1000;
}

.slimScrollBar{
  background: rgb(255, 255, 255) !important;
  width: 5px !important;
}

/*Estilos tree*/

</style>

<script>

$(function() {

  //variables para el lenguaje del datepicker
  $.fn.datepicker.dates['es'] = {
      days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
      daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
      daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
      months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
      today: "Hoy",
      clear: "Limpiar",
      format: "yyyy-mm-dd",
      titleFormat: "MM yyyy",
      weekStart: 1
  };

  //inicialización de todos los datepicker de bootstrap
  $('.datepicker').datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
  });

});

function convert_may(e) {
  e.value = e.value.toUpperCase();
}

function convert_min(e) {
    e.value = e.value.toLowerCase();
}

</script>

