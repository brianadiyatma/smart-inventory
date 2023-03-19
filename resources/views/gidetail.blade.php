@extends('layout')
@section('content')

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('preloader')
    @include('navbar')

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      @include('breadcrumb')

      <!-- Main content -->
      <section class="content">
        <div class="row">

          <!-- /.col -->
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">BPRM</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm">
                    <div class="input-group-append">
                    </div>
                  </div>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <table class="table table-bordered table-responsive table-hover display" id="example1">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Document Number</th>
                    <th>Order Number</th>
                    <th>Project Number</th>
                    <th>GR Date</th>
                    <th>User</th>
                    <th>Material Code</th>
                    <th>Material Desc</th>
                    <th>Order Qty</th> 
                    <th>Serve Qty</th>
                    <th>Storage Location</th>
                    <th>Note</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($gi as $item)
                    <tr>
                      <td>{{ $index++ }}</td>
                      <td>{{ $item->gi->doc_number }}</td>
                      <td>{{ $item->gi->order_number }}</td>
                      <td>{{ $item->gi->project_code }}</td>
                      <td>{{ $item->gi->doc_date }}</td>
                      <td>{{ $item->gi->pembuat }}</td>
                      <td>{{ $item->material_code }}</td>
                      <td>{{ $item->material_desc }}</td>
                      <td>{{ $item->qty_order }}</td>
                      <td>{{ $item->qty_serve }}</td>
                      <td>{{ $item->storloc_code }}</td>
                      <td>{{ $item->note }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No.</th>
                    <th>Document Number</th>
                    <th>Order Number</th>
                    <th>Project Number</th>
                    <th>GR Date</th>
                    <th>User</th>
                    <th>Material Code</th>
                    <th>Material Desc</th>
                    <th>Order Qty</th> 
                    <th>Serve Qty</th>
                    <th>Storage Location</th>
                    <th>Note</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>

    @endsection