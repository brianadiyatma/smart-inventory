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
                @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                <div class="card-header">
                  <h3 class="card-title"><a href="/materialmove"><label>Material</label></a> / <b>{{ $material_code }}</b> </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  @foreach($data as $datas)
                  <form class="form-horizontal" method="POST" action="/materialmovedprocess">
                    @csrf
                    <div class="form-group row">
                      <label for="" class="col-sm-2 col-form-label">Bin Code</label>
                      <div class="col-sm-10">
                        <p>{{ $bin_code }}</p>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="col-sm-2 col-form-label">Bin Code Destination</label>
                      <div class="col-sm-10">
                        <select class="select2bs4 form-control" style="width: 100%;" name="bin">
                          @foreach($data_bin as $item)
                          <option value="{{ $item->storage_bin_code }}">{{ $item->storage_bin_code }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>                    
                    <div class="form-group row">
                      <label for="" class="col-sm-2 col-form-label">QTY</label>
                      <div class="col-sm-10">
                        <input type="" placeholder="{{ $datas->qty }}" class="form-control" name="qty">
                      </div>
                    </div>
                    <input type="" value="{{ $datas->id }}" name="id" hidden>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Move Material</button>
                      </div>
                    </div>
                  </form>
                  @endforeach
                  <table class="table table-responsive display" id="">
                    <thead>
                      <tr>
                        <th width="15%">No. </th>
                        <th>From</th>
                        <th>To</th>
                        <th>QTY Moved</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($movement as $data)
                      <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $data->bin_origin_code }}</td>
                        <td>{{ $data->bin_destination_code }}</td>
                        <td>{{ $data->qty }}</td>
                      </tr>
                      @endforeach
                    </tbody>
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

    <script type="text/javascript">
      $(document).ready(function() {
       $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
</script>

@endsection


