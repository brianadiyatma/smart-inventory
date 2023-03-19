
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
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Bin Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Add Bin Management</a></li>
                  </ul>
                </div><!-- /.card-header -->

                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <div class="card-body">
                        <table class="table table-bordered table-responsive table-hover display" id="exampl">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Plant</th>
                              <th>Location</th>
                              <th>Type</th>
                              <th>Bin</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>No.</th>
                              <th>Plant</th>
                              <th>Location</th>
                              <th>Type</th>
                              <th>Bin</th>
                              <th>Action</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>

                    <div class="tab-pane" id="settings">
                      <form class="form-horizontal" method="POST" action="/addpivot">
                        @csrf
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Bin Code</label>
                          <div class="col-sm-10">
                            <input class="form-control" id="" name="bin" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Plant</label>
                          <div class="col-sm-10">
                            <select class="select2bs4 form-control" style="width: 100%;" name="plant">
                              @foreach($data_plant as $item)
                              <option value="{{ $item->plant_code }}">{{ $item->plant_code }} : {{ $item->plant_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Location</label>
                          <div class="col-sm-10">
                            <select class="select2bs4 form-control" style="width: 100%;" name="loc">
                              @foreach($data_location as $item)
                              <option value="{{ $item->storage_location_code }}">{{ $item->storage_location_code }} : {{ $item->storage_location_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-sm-2 col-form-label">Type</label>
                          <div class="col-sm-10">
                            <select class="select2bs4 form-control" style="width: 100%;" name="type">
                              @foreach($data_type as $item)
                              <option value="{{ $item->storage_type_code }}">{{ $item->storage_type_code }} : {{ $item->storage_type_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Add Bin</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>

          </div>
        </div>
        <!-- /.row -->
      </section>
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">QR Code</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
              <img src="" class="qr-code img-thumbnail img-responsive" />
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <a href="" class="qr-code" id="downloadQR" download="Qr.png">
                <button type="button" class="btn btn-outline-success">Download</button>
              </a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


<script type="text/javascript">
  $(function () {
    
    var table = $('#exampl').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('data.bin') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'plant_code', name: 'plant'},
            {data: 'storage_loc_code', name: 'loc'},
            {data: 'storage_type_code', name: 'type'},
            {data: 'storage_bin_code', name: 'bin'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>

<script type="text/javascript">
  $('.qrcode').click(function(){
    
    var qr = $(this).attr('data-qr')

    $.ajax({
      type: 'GET',
      url: "{{url('/qr_code')}}"+'?qr='+qr,
    })
    .done(function(data){

      $('.qr-code').attr('src', data.qr);
      $('.qr-code').attr('download', 'value'+'.png');
      $('#downloadQR').attr('href', data.qr);

      // console.log(data.qr);

    })
  })

</script>

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