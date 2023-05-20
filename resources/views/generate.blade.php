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
                <div class="card-body">
                  <form class="form-horizontal" method="get" action="/generated-report" target="_blank">
                    <div class="form-group row">
                      <label for="" class="col-sm-2 col-form-label">Date</label>
                      <div class="col-sm-3">
                        <input class="form-control" type="date" id="" name="date" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="col-sm-2 col-form-label">To</label>
                      <div class="col-sm-3">
                        <input class="form-control" type="date" id="" name="date1" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="col-sm-2 col-form-label">Pemeriksa</label>
                      <div class="col-sm-5">
                      <select class="select2bs4 form-control" style="width: 100%;" required  name="pemeriksa" id="pemeriksa">
                                    @foreach($data as $item)
                                    <option value="{{ $item->id }}">{{ $item->name}}</option>
                                    @endforeach
                                </select>
                      </div>
                      <div class="col-sm-5">
                      <input class="form-control" type="" name="jabatan_pemeriksa" placeholder="Jabatan" required disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="col-sm-2 col-form-label">Pengesah</label>
                      <div class="col-sm-5">
                      <select class="select2bs4 form-control" style="width: 100%;"required name="pengesah" id="pengesah">
                                    @foreach($data as $item)
                                    <option value="{{ $item->id }}">{{ $item->name}}</option>
                                    @endforeach
                                </select>
                      </div>
                      <div class="col-sm-5">
                      <input class="form-control" type="" name="jabatan_pengesah" placeholder="Jabatan" required disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                      </div>
                    </div>
                  </form>
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
  $('.qrcode').click(function(){

    var qr = $(this).attr('data-qr')

    $.ajax({
      type: 'GET',
      url: "{{url('/qr_code')}}"+'?qr='+qr,
    })
    .done(function(data){

      $('.qr-code').attr('src', data.qr);
      $('.qr-code').attr('download', qr+'.png');
      $('#downloadQR').attr('href', data.qr);

      // console.log(qr);

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

    $('#pemeriksa').on('change', function (e) {
        e.preventDefault();
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/get-jabatan/"+id,
            success: function (data) {
                console.log(data);
                $('input[name="jabatan_pemeriksa"]').val(data.data.position_name);
            }
        });
     })
    $('#pengesah').on('change', function (e) {
        e.preventDefault();
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/get-jabatan/"+id,
            success: function (data) {
                console.log(data);
                $('input[name="jabatan_pengesah"]').val(data.data.position_name);
            }
        });
     })

});



</script>


    @endsection
