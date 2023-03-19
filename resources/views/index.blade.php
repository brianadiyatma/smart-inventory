@extends('layout')
@section('content')

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('preloader')
    @include('navbar')

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h4><b>{{ $title }}</b></h4>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Home</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><b>Document Stats</b></h3>
                </div>
                <div class="card-body">
                  <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#sttptab" role="tab" aria-controls="sttptab" aria-selected="true"><b>STTP</b></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#bpmtab" role="tab" aria-controls="bpmtab" aria-selected="false"><b>BPM</b></a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="sttptab" role="tabpanel1" aria-labelledby="custom-tabs-four-home-tab">
                          <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#sttptabdays" role="tab" aria-controls="sttptabdays" aria-selected="true"><b>Days</b></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#sttptabmonths" role="tab" aria-controls="sttptabmonths" aria-selected="false"><b>Month</b></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#sttptabyears" role="tab" aria-controls="sttptabyears" aria-selected="false"><b>Years</b></a>
                              </li>
                            </ul>
                          </div>
                          <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                              <div class="tab-pane fade show active" id="sttptabdays" role="tabpanel1" aria-labelledby="custom-tabs-four-home-tab">
                              <div class="chart">
                            <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                              </div>
                            </div>
                            <canvas id="ChartSTTPdays" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                          </div>
                              </div>
                              <div class="tab-pane fade " id="sttptabmonths" role="tabpanel1" aria-labelledby="custom-tabs-four-profile-tab">
                          <div class="chart">
                            <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                              </div>
                            </div>
                            <canvas id="ChartSTTPmonths" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                          </div>
                              </div>
                              <div class="tab-pane fade " id="sttptabyears" role="tabpanel1" aria-labelledby="custom-tabs-four-profile-tab">
                              <div class="chart">
                            <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                              </div>
                            </div>
                            <canvas id="ChartSTTPyears" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                          </div>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class="tab-pane fade " id="bpmtab" role="tabpanel1" aria-labelledby="custom-tabs-four-profile-tab">
                          <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link " id="custom-tabs-four-home-tab" data-toggle="pill" href="#bpmtabdays" role="tab" aria-controls="bpmtabdays" aria-selected="true"><b>Days</b></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#bpmtabmonths" role="tab" aria-controls="bpmtabmonths" aria-selected="false"><b>Month</b></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#bpmtabyears" role="tab" aria-controls="bpmtabyears" aria-selected="false"><b>Years</b></a>
                              </li>
                            </ul>
                          </div>
                          <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                              
                              <div class="tab-pane fade show " id="bpmtabdays" role="tabpanel1" aria-labelledby="custom-tabs-four-home-tab">
                                <div class="chart">
                                  <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                      <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                      <div class=""></div>
                                    </div>
                                  </div>
                                  <canvas id="ChartBPMdays" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                                </div>
                              </div>

                              <div class="tab-pane fade " id="bpmtabmonths" role="tabpanel1" aria-labelledby="custom-tabs-four-profile-tab">
                                <div class="chart">
                                  <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                      <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                      <div class=""></div>
                                    </div>
                                  </div>
                                  <canvas id="ChartBPMmonths" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                                </div>
                              </div>
                              <div class="tab-pane fade " id="bpmtabyears" role="tabpanel1" aria-labelledby="custom-tabs-four-profile-tab">
                                <div class="chart">
                                  <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                      <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                      <div class=""></div>
                                    </div>
                                  </div>
                                  <canvas id="ChartBPMyears" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- /.card -->
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>



            <div class="col-md-4">
              <div class="card card-default color-palette-box">
                <div class="card-header">
                  <h3 class="card-title">
                    <b>Total Document Per Status</b>
                  </h3>
                </div>
                <div class="card-body">
                  <div class="col">
                    <div class="col">
                      <div class="col-12">
                        <h5><b>STTP</b></h5>
                      </div>
                      <!-- /.col -->
                      <div class="card bg-danger">
                        <div class="row">
                          <div class="col-md-3 p-2 text-center" style="font-size: 20px;"><b>{{ $sttpcountundone }}</b></div>
                          <div class="col-md-7 p-2 text-center" style="font-size: 20px;">UNPROCESSED</div>
                        </div>
                      </div>
                      <div class="card bg-primary">
                        <div class="row">
                          <div class="col-md-3 p-2 text-center" style="font-size: 20px;"><b>{{ $sttpcountonproses }}</b></div>
                          <div class="col-md-7 p-2 text-center" style="font-size: 20px;">ON PROCESSED</div>
                        </div>
                      </div>
                      <div class="card bg-success">
                        <div class="row">
                          <div class="col-md-3 p-2 text-center" style="font-size: 20px;"><b>{{ $sttpcountdone }}</b></div>
                          <div class="col-md-7 p-2 text-center" style="font-size: 20px;">PROCESSED</div>
                        </div>
                      </div>
                      <!-- /.col -->
                    </div>
                    <div class="col">
                      <div class="col-12">
                        <h5><b>BPM</b></h5>
                      </div>
                      <!-- /.col -->
                      <div class="card bg-danger">
                        <div class="row">
                          <div class="col-md-3 p-2 text-center" style="font-size: 20px;"><b>{{ $bpmcountundone }}</b></div>
                          <div class="col-md-7 p-2 text-center" style="font-size: 20px;">UNPROCESSED</div>
                        </div>
                      </div>
                      <div class="card bg-primary">
                        <div class="row">
                          <div class="col-md-3 p-2 text-center" style="font-size: 20px;"><b>{{ $bpmcountonproses }}</b></div>
                          <div class="col-md-7 p-2 text-center" style="font-size: 20px;">ON PROCESSED</div>
                        </div>
                      </div>
                      <div class="card bg-success">
                        <div class="row">
                          <div class="col-md-3 p-2 text-center" style="font-size: 20px;"><b>{{ $bpmcountdone }}</b></div>
                          <div class="col-md-7 p-2 text-center" style="font-size: 20px;">PROCESSED</div>
                        </div>
                      </div>
                      <!-- /.col -->
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- 
            
          </div><!-- /.container-fluid -->
        </div>
      </section>



      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <!-- BAR CHART -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><b>User Stats</b></h3>
                </div>
                <div class="card-body">
                  <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#a" role="tab" aria-controls="a" aria-selected="true"><b>Days</b></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#b" role="tab" aria-controls="b" aria-selected="false"><b>Month</b></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#c" role="tab" aria-controls="c" aria-selected="false"><b>Years</b></a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="a" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                          <div class="chart">
                            <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                              </div>
                            </div>
                            <canvas id="userchartharian" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                          </div>
                        </div>

                        <div class="tab-pane fade" id="b" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                          <div class="chart">
                            <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                              </div>
                            </div>
                            <canvas id="userchartbulanan" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                          </div>
                        </div>

                        <div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                          <div class="chart">
                            <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                              </div>
                            </div>
                            <canvas id="usercharttahunan" style="min-height: 440px; height: 440px; max-height: 440px; max-width: 100%; display: block; width: 350px;" width="700" height="500" class="chartjs-render-monitor"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>




    @endsection
    @section('js')
    <script type="text/javascript">
      var ctx = document.getElementById("ChartSTTPdays").getContext('2d');

      var chart = new Chart(ctx, {
         type: 'bar',
         data: {
            // labels: {{json_encode($data_tanggal)}}, 
            labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31], 
            datasets: [{
               label: 'UNPROCESSED',
               data: {{json_encode($sttpdayundone)}},
               backgroundColor: '#DC3545'
            }, {
               label: 'ON PROCESS',
               data: {{json_encode($sttpdayonproses)}},
               backgroundColor: '#007BFF'
            }, {
               label: 'PROCESSED',
               data: {{json_encode($sttpdaydone)}},
               backgroundColor: '#28A745'
            }]
         },
         options: {
            responsive: true,
            scales: {
               xAxes: [{
                  stacked: true 
               }],
               yAxes: [{
                stacked: true,
                tick:{
                  precision: 0
                }
              }]
            }
         }
      });
    </script>
    <script type="text/javascript">
      var ctx = document.getElementById("ChartSTTPmonths").getContext('2d');

      var chart = new Chart(ctx, {
         type: 'bar',
         data: {
            // labels: {{json_encode($data_tanggal)}}, 
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'], 
            datasets: [{
               label: 'UNPROCESSED',
               data: {{json_encode($sttpmonthundone)}},
               backgroundColor: '#DC3545'
            }, {
               label: 'ON PROCESS',
               data: {{json_encode($sttpmonthonproses)}},
               backgroundColor: '#007BFF'
            }, {
               label: 'PROCESSED',
               data: {{json_encode($sttpmonthdone)}},
               backgroundColor: '#28A745'
            }]
         },
         options: {
            responsive: true,
            scales: {
               xAxes: [{
                  stacked: true 
               }],
               yAxes: [{
                stacked: true,
                tick:{
                  precision: 0
                }
              }]
            }
         }
      });
    </script>
    <script type="text/javascript">
      var ctx = document.getElementById("ChartSTTPyears").getContext('2d');

      var chart = new Chart(ctx, {
         type: 'bar',
         data: {
            // labels: {{json_encode($data_tanggal)}}, 
            labels: {{json_encode($data_tahun)}}, 
            datasets: [{
               label: 'UNPROCESSED',
               data: {{json_encode($sttpyearundone)}},
               backgroundColor: '#DC3545'
            }, {
               label: 'ON PROCESS',
               data: {{json_encode($sttpyearonproses)}},
               backgroundColor: '#007BFF'
            }, {
               label: 'PROCESSED',
               data: {{json_encode($sttpyeardone)}},
               backgroundColor: '#28A745'
            }]
         },
         options: {
            responsive: true,
            scales: {
               xAxes: [{
                  stacked: true 
               }],
               yAxes: [{
                stacked: true,
                tick:{
                  precision: 0
                }
              }]
            }
         }
      });
    </script>

    <script type="text/javascript">
      var ctx = document.getElementById("ChartBPMdays").getContext('2d');

      var chart = new Chart(ctx, {
         type: 'bar',
         data: {
            // labels: {{json_encode($data_tanggal)}}, 
            labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31], 
            datasets: [{
               label: 'UNPROCESSED',
               data: {{json_encode($bpmdayundone)}},
               backgroundColor: '#DC3545'
            }, {
               label: 'ON PROCESS',
               data: {{json_encode($bpmdayonproses)}},
               backgroundColor: '#007BFF'
            }, {
               label: 'PROCESSED',
               data: {{json_encode($bpmdaydone)}},
               backgroundColor: '#28A745'
            }]
         },
         options: {
            responsive: true,
            scales: {
               xAxes: [{
                  stacked: true 
               }],
               yAxes: [{
                stacked: true,
                tick:{
                  precision: 0
                }
              }]
            }
         }
      });
    </script>
    <script type="text/javascript">
      var ctx = document.getElementById("ChartBPMmonths").getContext('2d');

      var chart = new Chart(ctx, {
         type: 'bar',
         data: {
            // labels: {{json_encode($data_tanggal)}}, 
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
               label: 'UNPROCESSED',
               data: {{json_encode($bpmmonthundone)}},
               backgroundColor: '#DC3545'
            }, {
               label: 'ON PROCESS',
               data: {{json_encode($bpmmonthonproses)}},
               backgroundColor: '#007BFF'
            }, {
               label: 'PROCESSED',
               data: {{json_encode($bpmmonthdone)}},
               backgroundColor: '#28A745'
            }]
         },
         options: {
            responsive: true,
            scales: {
               xAxes: [{
                  stacked: true 
               }],
               yAxes: [{
                stacked: true,
                tick:{
                  precision: 0
                }
              }]
            }
         }
      });
    </script>
    <script type="text/javascript">
      var ctx = document.getElementById("ChartBPMyears").getContext('2d');

      var chart = new Chart(ctx, {
         type: 'bar',
         data: {
            // labels: {{json_encode($data_tanggal)}}, 
            labels: {{json_encode($data_tahun)}}, 
            datasets: [{
               label: 'UNPROCESSED',
               data: {{json_encode($bpmyearundone)}},
               backgroundColor: '#DC3545'
            }, {
               label: 'ON PROCESS',
               data: {{json_encode($bpmyearonproses)}},
               backgroundColor: '#007BFF'
            }, {
               label: 'PROCESSED',
               data: {{json_encode($bpmyeardone)}},
               backgroundColor: '#28A745'
            }]
         },
         options: {
            responsive: true,
            scales: {
               xAxes: [{
                  stacked: true 
               }],
               yAxes: [{
                stacked: true,
                tick:{
                  precision: 0
                }
              }]
            }
         }
      });
    </script>



    <script type="text/javascript">
      var areaChartData = {
        labels: [
                @foreach($userperformanceday as $data)
                '{{ $data->nip }}',
                @endforeach
                ]
        ,
        datasets: [{
          label: 'User avg Time (Hours)',
          data: [
                @foreach($userperformanceday as $data)
                '{{ $data->Labor/3600 }}',
                @endforeach
                ],
          backgroundColor: 'rgba(80, 80, 225, 1)'
        },
        ],
      }

      var barChartCanvas = $('#userchartharian').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]

      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }
      
      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
    </script>
    <script type="text/javascript">
      var areaChartData = {
        labels: [
                @foreach($userperformancemonth as $data)
                '{{ $data->nip }}',
                @endforeach
                ]
        ,
        datasets: [{
          label: 'User avg Time (Hours)',
          data: [
                @foreach($userperformancemonth as $data)
                '{{ $data->Labor/3600 }}',
                @endforeach
                ],
          backgroundColor: 'rgba(80, 80, 225, 1)'
        },
        ],
      }

      var barChartCanvas = $('#userchartbulanan').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]

      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }
      
      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
    </script>
    <script type="text/javascript">
      var areaChartData = {
        labels: [
                @foreach($userperformanceyear as $data)
                '{{ $data->nip }}',
                @endforeach
                ]
        ,
        datasets: [{
          label: 'User avg Time (Hours)',
          data: [
                @foreach($userperformanceyear as $data)
                '{{ $data->Labor/3600 }}',
                @endforeach
                ],
          backgroundColor: 'rgba(80, 80, 225, 1)'
        },
        ],
      }

      var barChartCanvas = $('#usercharttahunan').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]

      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }
      
      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
    </script>
    @endsection