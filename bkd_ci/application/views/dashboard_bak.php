<div class="row">
	<div class="col-xl-3 col-md-6">
<div class="card bg-c-yellow update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">0</h4>
<h6 class="text-white m-b-0">Ajuan Kenaikan Pangkat</h6>
 </div>
<div class="col-4 text-right" style="font-size: 40px"><b><i class="ti-stats-up"></i></b>
</div>
</div>
</div>
<div class="card-footer">
<p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p>
</div>
</div>
</div>
<div class="col-xl-3 col-md-6">
<div class="card bg-c-green update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">0</h4>
<h6 class="text-white m-b-0">Ajuan Pensiun</h6>
</div>
<div class="col-4 text-right" style="font-size: 40px"><b><i class="ti-medall"></i></b>
</div>
</div>
</div>
<div class="card-footer">
<p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p>
</div>
</div>
</div>
<div class="col-xl-3 col-md-6">
<div class="card bg-c-pink update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">0</h4>
<h6 class="text-white m-b-0">Usulan Mutasi</h6>
</div>
<div class="col-4 text-right"  style="font-size: 40px"><b><i class="ti-direction-alt"></i></b>
</div>
</div>
</div>
<div class="card-footer">
<p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p>
</div>
</div>
</div>
<div class="col-xl-3 col-md-6">
<div class="card bg-c-lite-green update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">0</h4>
<h6 class="text-white m-b-0">Ulang Tahun Minggu ini</h6>
</div>
<div class="col-4 text-right"  style="font-size: 40px"><b><i class="ti-gift"></i></b>
</div>
</div>
</div>
<div class="card-footer">
<p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p>
</div>
</div>
</div>


<div class="col-xl-8 col-md-12">
<div class="card">
<div class="card-header">
<h5>Pegawai Berdasarkan Golongan Ruang</h5>
<span class="text-muted">Grafik Analisa Pegawai PNS berdasarkan golongan ruang </span>
 
</div>
<div class="card-block">
<div id="visitor" style="height:300px"></div>
</div>
</div>
</div>


<div class="col-xl-4 col-md-12">
<div class="card">
<div class="card-block bg-c-white">
  <select onchange="gantikelamin(this.value)" id="aktifpegawaikelamin">
    <option value="1">AKTIF</option>
    <option value="0">NON AKTIF</option>
    <option value="2">SEMUA</option>
  </select>
<div id="jnskelamin" style="height: 235px"></div>
</div>
<div class="card-footer">
<h6 class="text-muted m-b-30 m-t-15">Berdasarkan Jenis Kelamin</h6>
<div class="row text-center">
<div class="col-6 b-r-default">
<h6 class="text-muted m-b-10">Laki-Laki</h6>
<h4 class="m-b-0 f-w-600 "><i class="fa fa-male"></i> <span id="L">0</span></h4>
</div>
<div class="col-6">
<h6 class="text-muted m-b-10">Perempuan</h6>
<h4 class="m-b-0 f-w-600 "><i class="fa fa-female"></i> <span id="P">0</span></h4>
</div>
<div class="col-12">

<h6 class="text-muted m-b-10">Total</h6>
<h4 class="m-b-0 f-w-600 "><i class="fa fa-user"></i> <span id="T">0</span></h4>
  </div>
</div>
</div>
</div>
</div>

</div>

<!--script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/widget/amchart/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/widget/amchart/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/widget/amchart/light.js" type="text/javascript"></script-->

	<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script>
var chartx = am4core.create("visitor", am4charts.XYChart);
chartx.paddingBottom = 30;
chartx.angle = 35;

  function gantikelamin(a){
    chart.dataSource.url = "<?=site_url('dashboard/byjeniskelamin');?>/"+a;
    chart.dataSource.parser = new am4core.JSONParser();
    chart.dataSource.load();
    var ttl = 0;
    $.ajax({
      url: "<?=site_url('dashboard/byjeniskelamin');?>/"+a,
      type: "POST",
      dataType:"json",
      success: function(data) {
        $.each(data, function(i, item) {
          ttl += parseInt(data[i].JML);
            if(data[i].JENIS_KELAMIN == 'L'){
              $("#L").html(data[i].JML);
            }else{
              $("#P").html(data[i].JML);
            }
        });
        $("#T").html(ttl);
      }
      });
  }


  function getdatagol()
  {
    $.ajax({
      url: "<?=site_url('dashboard/pangkatstat');?>",
      type: "POST",
      dataType:"json",
      success: function(data) {
       chartx.data = data;
  }
});
  }

  $(document).ready(function(){
      gantikelamin($('#aktifpegawaikelamin').val());
      getdatagol();

  });
// Themes begin
//am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
am4core.useTheme(am4themes_dataviz);
am4core.useTheme(am4themes_material);
am4core.useTheme(am4themes_animated);
var chart = am4core.create("jnskelamin", am4charts.PieChart);




var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "JML";
series.dataFields.radiusValue = "JML";
series.dataFields.category = "JENIS_KELAMIN";
series.slices.template.cornerRadius = 6;
series.colors.step = 3;

series.hiddenState.properties.endAngle = -90;

//chart.legend = new am4charts.Legend();



// Create chart instance



// Add data
// Add data




// Create axes
var categoryAxis = chartx.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "golongan";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.inside = true;
categoryAxis.renderer.grid.template.disabled = true;

let labelTemplate = categoryAxis.renderer.labels.template;
labelTemplate.rotation = -90;
labelTemplate.horizontalCenter = "left";
labelTemplate.verticalCenter = "middle";
labelTemplate.dy = 10; // moves it a bit down;
labelTemplate.inside = false; // this is done to avoid settings which are not suitable when label is rotated

var valueAxis = chartx.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.grid.template.disabled = true;

// Create series
var series = chartx.series.push(new am4charts.ConeSeries());
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "golongan";

var columnTemplate = series.columns.template;
columnTemplate.adapter.add("fill", (fill, target) => {
  return chartx.colors.getIndex(target.dataItem.index);
})

columnTemplate.adapter.add("stroke", (stroke, target) => {
  return chartx.colors.getIndex(target.dataItem.index);
})
</script>