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
                  <h3 class="card-title"><b>Material</b></h3>
                </div>

                <div class="card-body">
                  <table class="table table-bordered table-responsive table-hover display" id="example1">
                    <thead>
                      <tr>
                        <th></th>
                        <th>No. </th>
                        <th>Material Code</th>
                        <th>Stock</th>
                        <th>Material Name</th>
                        <th>Specification</th>
                        <th>Plant</th>
                        <th>Location</th>
                        <th>type</th>
                        <th>Bin</th>
                        <th>Project</th>
                        <th>GR Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $item)
                      <tr>
                        <td><a href="/materialstockdetail/{{ $item->id }}"><img src="{{asset('eyeicon.png')}}" width="30px"></a></td>
                        <td>{{ $index++ }}</td>
                        <td>{{ $item->Rmaterial->material_code }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->Rmaterial->material_desc }}</td>
                        <td>{{ $item->Rmaterial->specification }}</td>
                        <td>{{ $item->plant_code }}</td>
                        <td>{{ $item->storloc_code }}</td>
                        <td>{{ $item->storage_type_code }}</td>
                        <td>{{ $item->bin_code }}</td>
                        <td>{{ $item->special_stock_number }}</td>
                        <td>{{ isset($item->gr_date)? $item->gr_date : "-" }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th>No. </th>
                        <th>Material Code</th>
                        <th>Stock</th>
                        <th>Material Name</th>
                        <th>Specification</th>
                        <th>Plant</th>
                        <th>Location</th>
                        <th>type</th>
                        <th>Bin</th>
                        <th>Project</th>
                        <th>GR Date</th>
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