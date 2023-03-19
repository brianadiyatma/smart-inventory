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
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                  <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"><b>STTP</b></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><b>BPM</b></a>
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false"><b>BPRM</b></a>
                    </li> -->
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel">
                      <table class="table table-bordered table-responsive table-hover display" id="example">
                        <thead>
                          <tr>
                            <th></th>
                            <th>No.</th>
                            <th>Document Number</th>
                            <th>Status</th>
                            <th>Total Detail</th>
                            <th>Document Date</th>
                            <th>User</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($sttp as $data)
                          <tr>
                            <td width="10px"><a href="/detailsttp/{{ $data->id }}"><img src="{{asset('eyeicon.png')}}" width="30px"></a></td>
                            <td width="10px">{{ $indexsttp++ }}</td>
                            <td>{{ $data->doc_number }}</td>
                            @if($data->status == 'PROCESSED')
                            <td><span class="badge badge-pill badge-success">{{ $data->status }}</span></td>
                            @elseif($data->status == 'ON PROCESS')
                            <td><span class="badge badge-pill badge-primary">{{ $data->status }}</span></td>
                            @elseif($data->status == 'UNPROCESSED')
                            <td><span class="badge badge-pill badge-danger">{{ $data->status }}</span></td>
                            @else
                            <td>{{ $data->status }}</td>
                            @endif
                            <!-- <td>{{ $data->status }}</td> -->
                            <td>{{ $data->details_count }}</td>
                            <td>{{ $data->doc_date }}</td>
                            <td>{{ $data->pembuat }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th>No.</th>
                            <th>Document Number</th>
                            <th>Status</th>
                            <th>Total Detail</th>
                            <th>Document Date</th>
                            <th>User</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel">
                      <table class="table table-bordered table-responsive table-hover display" id="example1">
                        <thead>
                          <tr>
                            <th></th>
                            <th>No.</th>
                            <th>Document Number</th>
                            <th>Status</th>
                            <th>Total Detail</th>
                            <th>Destination</th>
                            <th>Document Date</th>
                            <th>User</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($bpm as $data)
                          <tr>
                            <td><a href="/detailbpm/{{ $data->id }}"><img src="{{asset('eyeicon.png')}}" width="30px"></a></td>
                            <td>{{ $indexbpm++ }}</td>
                            <td>{{ $data->doc_number }}</td>
                            @if($data->status == 'PROCESSED')
                            <td><span class="badge badge-pill badge-success">{{ $data->status }}</span></td>
                            @elseif($data->status == 'ON PROCESS')
                            <td><span class="badge badge-pill badge-primary">{{ $data->status }}</span></td>
                            @elseif($data->status == 'UNPROCESSED')
                            <td><span class="badge badge-pill badge-danger">{{ $data->status }}</span></td>
                            @else
                            <td>{{ $data->status }}</td>
                            @endif
                            <!-- <td>{{ $data->status }}</td> -->
                            <td>{{ $data->details_count }}</td>
                            <td>{{ isset($data->destination->storage_location_name)? $data->destination->storage_location_name : "-"}}</td>
                            <td>{{ $data->doc_date }}</td>
                            <td>{{ $data->pembuat }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th>No.</th>
                            <th>Document Number</th>
                            <th>Status</th>
                            <th>Total Detail</th>
                            <th>Destination</th>
                            <th>Document Date</th>
                            <th>User</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel">
                      <table class="table table-bordered table-responsive table-hover display" id="example2">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Document Number</th>
                            <th>Material Code</th>
                            <th>GR Date</th>
                            <th>User</th>
                            <th>Order Qty</th>
                            <th>Serve Qty</th>
                            <th>Storage Location</th>
                            <th>Detail</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($gi as $data)
                          <tr>
                            <td>{{ $indexbprm++ }}</td>
                            <td>{{ $data->gi->doc_number }}</td>
                            <td>{{ $data->material_code }}</td>
                            <td>{{ $data->gi->doc_date }}</td>
                            <td>{{ $data->gi->pembuat }}</td>
                            <td>{{ $data->qty_order }}</td>
                            <td>{{ $data->qty_serve }}</td>
                            <td>{{ $data->storloc_code }}</td>
                            <td><a href="/detailgi/{{ $data->id }}"><img src="{{asset('eyeicon.png')}}" width="30px"></a></td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>No.</th>
                            <th>Document Number</th>
                            <th>Material Code</th>
                            <th>GR Date</th>
                            <th>User</th>
                            <th>Order Qty</th>
                            <th>Serve Qty</th>
                            <th>Storage Location</th>
                            <th>Detail</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.card -->
              </div>
            </div>
            <!-- /.col -->
          </div>
        </div>
      </section>
    </div>

    @endsection
