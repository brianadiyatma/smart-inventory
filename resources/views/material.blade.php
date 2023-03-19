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
                <table id="examples" class="table table-bordered table-hover display" style="width:100%">
                  <thead>
                      <tr>
                          <th>No. </th>
                          <th>Material code</th>
                          <th>Material desc</th>
                          <th>Spec</th>
                      </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
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

<footer>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$( document ).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    let index = 1
    var table = $('#examples').DataTable({
        processing: true,
        serverSide: true,
        ajax: {url : "{{ url('fetchData') }}",type:'POST',},
        columns: [
            {data: 'id',render: function(data,type,full,meta){return meta.row+1}},
            {data: 'material_code'},
            {data: 'material_desc'},
            {data: 'specification'},
        ]
    });
  });
</script>
</footer>