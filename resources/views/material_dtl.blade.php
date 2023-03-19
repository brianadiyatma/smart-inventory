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
            <div class="col-md-12">
              <!-- Main row -->
              <div class="card col-sm-12">
                <div class="card-header">
                  <h3 class="card-title"><a href="/materialstock"><label>Detail Material</label></a>/{{ $id }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  @foreach($data as $item)
                  <form>
                    <div class="row">
                      <div class="col-sm-2">
                          <label>Material Code</label>
                      </div>
                      <div class="col-sm-10">
                          <p>: {{ $item->Rmaterial->material_code }}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                          <label>Material Description</label>
                      </div>
                      <div class="col-sm-10">
                          <p>: {{ $item->Rmaterial->material_desc }}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                          <label>Specification</label>
                      </div>
                      <div class="col-sm-10">
                          <p>: {{ $item->Rmaterial->specification }}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                          <label>GR Date</label>
                      </div>
                      <div class="col-sm-10">
                          <p>: {{ $item->gr_date }}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                          <label>Available Stock</label>
                      </div>
                      <div class="col-sm-2">
                          <p>: {{ $item->qty }}</p>
                      </div>
                    </div>
                  </form>
                  @endforeach

                  <table class="table table-responsive display" id="example1">
                    <thead>
                      <tr>
                        <th>No. </th>
                        <th>Transaction</th>
                        <th>Document Number</th>
                        <th>QTY</th>
                        <th>Date Transaction</th>
                        <th>Image</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($dtltbl as $item)
                      <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->doc_number }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->posting_date }}</td>
                        <td>
                            @if(!isset($item->foto)||$item->foto=='')
                            <i class="fas fa-exclamation"></i> Tidak ada foto <i class="fas fa-exclamation"></i>
                            @else
                            <a href="{{ $item->foto }}" download="{{ $item->photo_url }}" class="btn btn-outline-success">Download</a>
                            @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No. </th>
                        <th>Transaction</th>
                        <th>Document Number</th>
                        <th>QTY</th>
                        <th>Date Transaction</th>
                        <th>Image</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <div class="modal fade" id="pict">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">pict</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
              <p>a</p>
              <img src="" class="pict img-thumbnail img-responsive" />
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    @endsection


    