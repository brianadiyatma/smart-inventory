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
              <div class="card">

                <div class="card-header">
                  <h3 class="card-title"><b>{{ $title }}</b></h3>
                </div>

                <div class="card-body">
                  <table class="table table-bordered table-responsive table-hover display" id="example1">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Type</th>
                        <th>Requester</th>
                        <th>Doc. Number</th>
                        <th>Doc. Date</th>
                        <th>Fiscal Year</th>
                        <th>Doc. Start</th>
                        <th>Doc. Finish</th>
                        <th>Status</th>
                        <th>Line Item</th>
                        <th>WBS Code</th>
                        <th>PO/Reservation Number</th>
                        <th>QTY IN/OUT</th>
                        <th>UoM</th>
                        <th>Material Code</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $item)
                      <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->pembuat }}</td>
                        <td>{{ $item->doc_number }}</td>
                        <td>{{ $item->doc_date }}</td>
                        <td>{{ $item->fiscal_year }}</td>
                        <td>{{ isset($item->started_at)? $item->started_at : "-" }}</td>
                        <td>{{ $item->finished_at }}</td>
                        @if($item->status == 'PROCESSED')
                        <td><span class="badge badge-pill badge-success">{{ $item->status }}</span></td>
                        @elseif($item->status == 'ON PROCESS')
                        <td><span class="badge badge-pill badge-primary">{{ $item->status }}</span></td>
                        @elseif($item->status == 'UNPROCESSED')
                        <td><span class="badge badge-pill badge-danger">{{ $item->status }}</span></td>
                        @else
                        <td>{{ $item->status }}</td>
                        @endif
                        <td>{{ $item->line }}</td>
                        <td>{{ $item->wbs_code }}</td>
                        <td>{{ $item->number }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->uom_code }}</td>
                        <td>{{ $item->material_code }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No.</th>
                        <th>Type</th>
                        <th>Requester</th>
                        <th>Doc. Number</th>
                        <th>Doc. Date</th>
                        <th>Fiscal Year</th>
                        <th>Doc. Start</th>
                        <th>Doc. Finish</th>
                        <th>Status</th>
                        <th>Line Item</th>
                        <th>WBS Code</th>
                        <th>PO/Reservation Number</th>
                        <th>QTY IN/OUT</th>
                        <th>UoM</th>
                        <th>Material Code</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
        </div>
      </section>
    </div>

    @endsection