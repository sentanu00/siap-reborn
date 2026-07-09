<div class="row">
  <!-- <div class="col-xl-3 col-md-6">
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
</div> -->
</div>
<!-- <div class="col-xl-3 col-md-6">
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
</div>
<hr>
<br> -->

<div class="row">
  <div class="col-xl-8 col-md-12">
    <div class="row">
      <div class="card col-md-9">
        <div class="card-header">
          <h5>Pegawai Berdasarkan Golongan Ruang</h5>
          <span class="text-muted">Grafik Analisa Pegawai PNS berdasarkan golongan ruang </span>

        </div>
        <div class="card-block ">
          <div id="pangkat" style="height:300px"></div>
        </div>

      </div>
      <div class="card col-md-3" style="max-height:480px;overflow-x: hidden;overflow-y: scroll;">
        <table class="table">
          <thead>
            <th>Pangkat</th>
            <th>Total</th>
            <thead>
            <tbody id="bodpangkat">
            </tbody>
        </table>
      </div>
    </div>
  </div>


  <div class="col-xl-4 col-md-12" style="max-height:500px;">
    <div class="card">
      <div class="card-block bg-c-white">
        <h5>Pegawai Berdasarkan Jenis Kelamin</h5>
        <select onchange="gantikelamin(this.value)" id="aktifpegawaikelamin" hidden>
          <option value="1">AKTIF</option>
          <!-- <option value="0">NON AKTIF</option>
    <option value="2">SEMUA</option> -->
        </select>
        <div id="jnskelamin" style="height: 235px"></div>
      </div>
      <div class="card-footer">
        <h6 class="text-muted m-b-30 m-t-15">Berdasarkan Jenis Kelamin (PNS, CPNS, PPPK dan PPPK PW)</h6>
        <div class="row text-center">
          <div class="col-6 b-r-default">
            <h6 class="text-muted m-b-10">Perempuan</h6>
            <h4 class="m-b-0 f-w-600 "><i class="fa fa-female"></i> <span id="P">0</span></h4>
          </div>
          <div class="col-6">
            <h6 class="text-muted m-b-10">Laki-Laki</h6>
            <h4 class="m-b-0 f-w-600 "><i class="fa fa-male"></i> <span id="L">0</span></h4>
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

<div class="row">

  <div class="col-xl-6 col-md-12">

    <div class="row">
      <div class="card col-md-7">
        <div class="card-header">
          <h5>Status Pegawai</h5>
          <span class="text-muted">Grafik Analisa Pegawai berdasarkan status </span>

        </div>
        <div class="card-block col-md-12">
          <div id="statusPegawai" style="height:300px"></div>
        </div>

      </div>

      <div class="card col-md-5" style="height:450px;overflow-x: hidden;overflow-y: scroll;">
        <table class="table">
          <thead>
            <th>Status</th>
            <th>Total</th>
            <thead>
            <tbody id="bodStatus">
            </tbody>
        </table>
      </div>

    </div>
  </div>



  <div class="col-xl-6 col-md-12">
    <div class="row">
      <div class="card col-md-9">
        <div class="card-header">
          <h5>Pegawai Berdasarkan Pendidikan</h5>
          <span class="text-muted">Grafik Analisa Pegawai berdasarkan Pendidikan </span>

        </div>

        <div class="card-block col-md-12">
          <div id="pendidikanPegawai" style="height:300px"></div>
        </div>

      </div>

      <div class="card col-md-3" style="height:450px;overflow-x: hidden;overflow-y: scroll;">
        <table class="table">
          <thead>
            <th>Status</th>
            <th>Total</th>
            <thead>
            <tbody id="bodPendidikan">
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</div>

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script>
  var chartx = am4core.create("pangkat", am4charts.XYChart);
  chartx.paddingBottom = 30;
  chartx.angle = 35;
  chartx.cursor = new am4charts.XYCursor();
  chartx.cursor.lineY.disabled = true;
  chartx.cursor.lineX.disabled = true;

  var chartx1 = am4core.create("statusPegawai", am4charts.XYChart);
  chartx1.paddingBottom = 30;
  chartx1.angle = 35;
  chartx1.cursor = new am4charts.XYCursor();
  chartx1.cursor.lineY.disabled = true;
  chartx1.cursor.lineX.disabled = true;

  var chartx2 = am4core.create("pendidikanPegawai", am4charts.XYChart);
  chartx2.paddingBottom = 30;
  chartx2.angle = 35;
  chartx2.cursor = new am4charts.XYCursor();
  chartx2.cursor.lineY.disabled = true;
  chartx2.cursor.lineX.disabled = true;


  function gantikelamin(a) {
    chart.dataSource.url = "<?= site_url('dashboard/byjeniskelamin'); ?>/" + a;
    chart.dataSource.parser = new am4core.JSONParser();
    chart.dataSource.load();
    var ttl = 0;
    $.ajax({
      url: "<?= site_url('dashboard/byjeniskelamin'); ?>/" + a,
      type: "POST",
      dataType: "json",
      success: function(data) {
        $.each(data, function(i, item) {
          ttl += parseInt(data[i].JML);
          if (data[i].JENIS_KELAMIN == 'L') {
            $("#L").html(data[i].JML);
          } else {
            $("#P").html(data[i].JML);
          }
        });
        $("#T").html(ttl);
      }
    });
  }


  function getdatapendidikan() {
    $.ajax({
      url: "<?= site_url('dashboard/bypendidikan'); ?>",
      type: "POST",
      dataType: "json",
      success: function(data) {
        var htm = '';
        var totaldata = 0;
        chartx2.data = data;
        $.each(data, function(index, val) {
          totaldata += parseInt(val.total);
          htm += '<tr><td>' + val.NAMA + '</td><td style="text-align:right">' + val.total + '</td></tr>';
        });

        htm += '<tr><td>Total</td><td style="text-align:right">' + totaldata + '</td></tr>';
        $('#bodPendidikan').html(htm);
      }
    });
  }

  function getdatastatus() {
    $.ajax({
      url: "<?= site_url('dashboard/bystatuspegawai'); ?>",
      type: "POST",
      dataType: "json",
      success: function(data) {
        var htm = '';
        var totaldata = 0;
        chartx1.data = data;
        $.each(data, function(index, val) {
          totaldata += parseInt(val.total);
          htm += '<tr><td>' + val.NAMA + '</td><td style="text-align:right">' + val.total + '</td></tr>';
        });

        htm += '<tr><td>Total</td><td style="text-align:right">' + totaldata + '</td></tr>';
        $('#bodStatus').html(htm);
        getdatapendidikan();
      }
    });
  }


  function getdatagol() {
    $.ajax({
      url: "<?= site_url('dashboard/pangkatstat'); ?>",
      type: "POST",
      dataType: "json",
      success: function(data) {
        var htm = '';
        var totaldata = 0;
        chartx.data = data;
        $.each(data, function(index, val) {
          totaldata += parseInt(val.visits);
          htm += '<tr><td>' + val.golongan + '</td><td style="text-align:right">' + val.visits + '</td></tr>';
        });

        htm += '<tr><td>Total</td><td style="text-align:right">' + totaldata + '</td></tr>';
        $('#bodpangkat').html(htm);
        getdatastatus();
      }
    });
  }

  $(document).ready(function() {
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
  series.tooltipText = "{valueY.value}";
  series.columns.template.strokeOpacity = 0;
  series.columns.template.column.cornerRadiusTopRight = 10;
  series.columns.template.column.cornerRadiusTopLeft = 10;

  var columnTemplate = series.columns.template;
  columnTemplate.adapter.add("fill", (fill, target) => {
    return chartx.colors.getIndex(target.dataItem.index);
  })

  columnTemplate.adapter.add("stroke", (stroke, target) => {
    return chartx.colors.getIndex(target.dataItem.index);
  })




  // Create axes
  var categoryAxis1 = chartx1.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis1.dataFields.category = "NAMA";
  categoryAxis1.renderer.grid.template.location = 0;
  categoryAxis1.renderer.minGridDistance = 20;
  categoryAxis1.renderer.inside = true;
  categoryAxis1.renderer.grid.template.disabled = true;

  let labelTemplate1 = categoryAxis1.renderer.labels.template;
  labelTemplate1.rotation = -90;
  labelTemplate1.horizontalCenter = "left";
  labelTemplate1.verticalCenter = "middle";
  labelTemplate1.dy = 10; // moves it a bit down;
  labelTemplate1.inside = false; // this is done to avoid settings which are not suitable when label is rotated

  var valueAxis1 = chartx1.yAxes.push(new am4charts.ValueAxis());
  valueAxis1.renderer.grid.template.disabled = true;

  // Create series
  var series1 = chartx1.series.push(new am4charts.ConeSeries());
  series1.dataFields.valueY = "total";
  series1.dataFields.categoryX = "NAMA";
  series1.tooltipText = "{valueY.value}";
  series1.columns.template.strokeOpacity = 0;
  series1.columns.template.column.cornerRadiusTopRight = 10;
  series1.columns.template.column.cornerRadiusTopLeft = 10;

  var columnTemplate1 = series1.columns.template;
  columnTemplate1.adapter.add("fill", (fill, target) => {
    return chartx1.colors.getIndex(target.dataItem.index);
  })

  columnTemplate1.adapter.add("stroke", (stroke, target) => {
    return chartx1.colors.getIndex(target.dataItem.index);
  })



  // Create axes
  var categoryAxis2 = chartx2.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis2.dataFields.category = "NAMA";
  categoryAxis2.renderer.grid.template.location = 0;
  categoryAxis2.renderer.minGridDistance = 20;
  categoryAxis2.renderer.inside = true;
  categoryAxis2.renderer.grid.template.disabled = true;

  let labelTemplate2 = categoryAxis2.renderer.labels.template;
  labelTemplate2.rotation = -90;
  labelTemplate2.horizontalCenter = "left";
  labelTemplate2.verticalCenter = "middle";
  labelTemplate2.dy = 10; // moves it a bit down;
  labelTemplate2.inside = false; // this is done to avoid settings which are not suitable when label is rotated

  var valueAxis2 = chartx2.yAxes.push(new am4charts.ValueAxis());
  valueAxis2.renderer.grid.template.disabled = true;

  // Create series
  var series2 = chartx2.series.push(new am4charts.ConeSeries());
  series2.dataFields.valueY = "total";
  series2.dataFields.categoryX = "NAMA";
  series2.tooltipText = "{valueY.value}";
  series2.columns.template.strokeOpacity = 0;
  series2.columns.template.column.cornerRadiusTopRight = 10;
  series2.columns.template.column.cornerRadiusTopLeft = 10;

  var columnTemplate2 = series2.columns.template;
  columnTemplate2.adapter.add("fill", (fill, target) => {
    return chartx2.colors.getIndex(target.dataItem.index);
  })

  columnTemplate2.adapter.add("stroke", (stroke, target) => {
    return chartx2.colors.getIndex(target.dataItem.index);
  })
</script>