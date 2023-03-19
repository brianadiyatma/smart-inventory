@extends('layout')
@section('content')

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('preloader')
    @include('navbar')

    <div class="content-wrapper">
      @include('breadcrumb')
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- Custom Tabs -->
              <!-- Main content -->
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title"><b>Transaction</b></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Doc Type</th>
                                <th>Doc No</th>
                                <th>Date Created</th>
                                <th>User</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($transaction as $item)
                              <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->doc_number }}</td>
                                <td>{{ $item->doc_date }}</td>
                                <td>{{ $item->pembuat }}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                          <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="/report1"><b>More Details</b></a></li>
                          </ul>
                        </div>
                      </div>
                      <!-- /.card -->

                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title"><b>Material Moved</b></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Material Code</th>
                                <th>Bin From</th>
                                <th>Bin Now</th>
                                <th>Moved Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>B011U030011</td>
                                <td>100090784</td>
                                <td>00000001</td>
                                <td>October 11, 2022</td>
                              </tr>
                              <tr>
                                <td>B011U030011</td>
                                <td>100090757</td>
                                <td>00000002</td>
                                <td>October 11, 2022</td>
                              </tr>
                              <tr>
                                <td>B011U030011</td>
                                <td>100090781</td>
                                <td>00000003</td>
                                <td>October 11, 2022</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                          <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="/material"><b>More Details</b></a></li>
                          </ul>
                        </div>
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title"><b>Material IN / OUT</b></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Material Code</th>
                                <th>Doc</th>
                                <th>GR Date</th>
                                <th>User</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($inout as $item)
                              <tr>
                                <td>{{ $index2++ }}</td>
                                <td>{{ $item->material_code }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->posting_date }}</td>
                                <td>{{ $item->pembuat }}</td>                                
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                          <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="/report2"><b>More Details</b></a></li>
                          </ul>
                        </div>
                      </div>
                      <!-- /.card -->

                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title"><b>User</b></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Name</th>
                                <th>Doc type?</th>
                                <th>Completed In</th>
                                <th>Week</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>[img]Nilou</td>
                                <td>STTP</td>
                                <td>24H, 5M</td>
                                <td>1</td>
                                <td>Done</td>
                              </tr>
                              <tr>
                                <td>[img]Cyno</td>
                                <td>STTP</td>
                                <td>24H, 5M</td>
                                <td>1</td>
                                <td>Pending</td>
                              </tr>
                              <tr>
                                <td>[img]Nahida</td>
                                <td>BPM</td>
                                <td>24H, 5M</td>
                                <td>1</td>
                                <td>In Progress</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                          <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="/material"><b>More Details</b></a></li>
                          </ul>
                        </div>
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- ./card -->
            </div>
            <!-- /.col -->
          </div>
        </div>
      </section>
    </div>

    @endsection