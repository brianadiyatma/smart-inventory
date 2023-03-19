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
                <h3 class="card-title">STTP</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm">
                    <div class="input-group-append">
                    </div>
                  </div>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover table-responsive display" id="example1">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Document Number</th>
                    <th>PO Number</th>
                    <th>Project Number</th>
                    <th>GR Date</th>
                    <th>User</th>
                    <th>Material Code</th>
                    <th>Material Desc</th>
                    <th>UoM</th>
                    <th>PO Qty</th>
                    <th>LPPB Qty</th>
                    <th>NCR</th>
                    <th>Qty Warehouse</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($sttp as $item)
                    <tr>
                      <td>{{ $index++ }}</td>
                      <td>{{ $item->sttp->doc_number }}</td>
                      <td>{{ $item->sttp->po_number }}</td>
                      <td>{{ $item->sttp->project_code }}</td>
                      <td>{{ $item->sttp->doc_date }}</td>
                      <td>{{ $item->sttp->pembuat }}</td>
                      <td>{{ $item->material->material_code }}</td>
                      <td>{{ $item->material_desc }}</td>
                      <td>{{ $item->uom }}</td>
                      <td>{{ $item->qty_po }}</td>
                      <td>{{ $item->qty_gr_105 }}</td>
                      <td>{{ $item->qty_ncr }}</td>
                      <td>{{ $item->qty_warehouse }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No.</th>
                    <th>Document Number</th>
                    <th>PO Number</th>
                    <th>Project Number</th>
                    <th>GR Date</th>
                    <th>User</th>
                    <th>Material Code</th>
                    <th>Material Desc</th>
                    <th>UoM</th>
                    <th>PO Qty</th>
                    <th>LPPB Qty</th>
                    <th>NCR</th>
                    <th>Qty Warehouse</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
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