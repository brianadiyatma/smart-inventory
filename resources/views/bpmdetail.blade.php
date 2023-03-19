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
                <h3 class="card-title">BPM</h3>

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
                    <th>Reservation Number</th>
                    <th>Document Date</th>
                    <th>User</th>
                    <th>Material Code</th>
                    <th>Material Desc</th>
                    <th>Order Date</th>
                    <th>Require Qty</th>
                    <th>UoM</th>
                    <th>Note</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($bpm as $item)
                    <tr>
                      <td>{{ $index++ }}</td>
                      <td>{{ $item->bpm->doc_number }}</td>
                      <td>{{ $item->reservation_number }}</td>
                      <td>{{ $item->bpm->doc_date }}</td>
                      <td>{{ $item->bpm->pembuat }}</td>
                      <td>{{ $item->material->material_code }}</td>
                      <td>{{ $item->material->material_desc }}</td>
                      <td>{{ $item->created_at }}</td>
                      <td>{{ $item->requirement_qty }}</td>
                      <td>{{ $item->uom_code }}</td>
                      <td>{{ $item->note }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No.</th>
                    <th>Document Number</th>
                    <th>Reservation Number</th>
                    <th>Document Date</th>
                    <th>User</th>
                    <th>Material Code</th>
                    <th>Material Desc</th>
                    <th>Order Date</th>
                    <th>Require Qty</th>
                    <th>UoM</th>
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