<?php include "views/header.php"; ?>
<nav>
  <div id="wrapper">
    <?php include "menu.php"; ?>
  </div><!-- /.navbar-collapse -->
</nav>
<?php 
$m = 31;
$n = 7;
$prevN = mktime(0, 0, 0, date("m"), date("d") - $n, date("Y"));
$mak   = date("Y-m-d");
$min   = date("Y-m-d", $prevN);

function format_mak($mak)
{
  $bulan = array (1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split = explode('-', $mak);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
function format_min($min)
{
  $bulan = array (1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split = explode('-', $min);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
?>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1>Dashboard <small><?php include "../config/date-time.php";?></small></h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
      </ol>  
      <?php include "../config/welcome.php";?>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <img class="img-responsive" src="../images/bg.jpg" width="100%" alt="">
    </div>
  </div><!-- /.row -->
</div><!-- /#page-wrapper -->
<?php include "views/footer.php"; ?>