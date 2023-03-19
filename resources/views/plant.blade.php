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
                        <th>Plant Code</th>
                        <th>Plant Name</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $item)
                      <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $item->plant_code }}</td>
                        <td>{{ $item->plant_name }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No.</th>
                        <th>Plant Code</th>
                        <th>Plant Name</th>
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