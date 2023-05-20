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
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">STTP</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">BPM</a></li>
                  </ul>
                </div><!-- /.card-header -->

                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">

                      <div class="row card-body">
                            <label class="col-sm-2">Project</label>
                            <div class="col-sm-10">
                                <select class="select2bs4 form-control" name="project" id="project_form">
                                    <option>-- Pilih Project --</option>
                                    @foreach($data_project as $item)
                                    <option value={{ $item->project_code }}>{{ $item->project_desc }} : {{ $item->project_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row card-body">
                            <label class="col-sm-2">WBS</label>
                            <div class="col-sm-10">
                                <select class="select2bs4 form-control" style="width: 100%;" name="wbs">
                                    <option value="">-- Pilih Project --</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-between ">
                        {{-- Start of Left Section --}}
                        <div class="w-50">
                            <form action="#">
                              <!-- start -->
                              <div>
                                <label>Material</label>
                                 <select class="select2bs4 form-control" style="width: 100%;" name="material" id="material">
                                    <option>-- Pilih Material --</option>
                                    @foreach($data_material as $item)
                                    <option value="{{ $item->material_code }}">{{ $item->material_desc }} : {{ $item->material_code }}</option>
                                    @endforeach
                                </select>
                               </div>
                              <!-- end -->
                               <div>
                                <label>UOM</label>
                                <select class="select2bs4 form-control" @readonly(true) style="width: 30%;" name="uom" id="uom" disabled>
                                    <option>-- Pilih Material --</option>
                                </select>
                              </div>
                              <div>
                                <label>Quantity PO</label>
                                <input type="number" name="qtypo" class="form-control" style="width: 30%;">
                              </div>
                              <div>
                                <label>Quantity ACTUAL</label>
                                <input type="number" name="qtylppb" class="form-control" style="width: 30%;">
                              </div>
                              <div>
                                <label>Quantity RETURN</label>
                                <input type="number" name="qtyncr" class="form-control" style="width: 30%;">
                              </div>
                            <div class="my-4" style="float: right;">
                                <button class="btn btn-primary" id='add-sttp'>Add</button>
                            </div>
                        </form>
                        </div>
                        {{-- end of left section --}}
                        {{-- start of right section --}}
                        <div style="width: 40%; margin-left: auto">
                                <div>
                                    <table class="table table-bordered table-responsive table-hover display" style="width:100%" id="sttp-table">
                                        <thead>
                                            <tr>
                                            <!-- <th>No.</th> -->
                                            <th>Material</th>
                                            <th>QTY PO</th>
                                            <th>QTY ACTUAL</th>
                                            <th>QTY RETURN</th>
                                            <th>UOM</th>
                                            </tr>
                                        </thead>
                                        <tbody id='sttp-tbody'>
                                        </tbody>
                                    </table>
                            </div>
                        </div>


                      </div>
                      <div>
                        <button class="btn btn-success float-right" id='submit-sttp'>Submit</button>
                      </div>
                    </div>

                    <div class="tab-pane" id="settings">
                            <div class="card-body row">
                            {{-- ADD BPM --}}
                            <label class="col-sm-2">Project</label>
                            <div class="col-sm-10">
                                <select class="select2bs4 form-control" name="project_bpm" id="project_form_bpm">
                                    <option>-- Pilih Project --</option>
                                    @foreach($data_project as $item)
                                    <option value={{ $item->project_code }}>{{ $item->project_desc }} : {{ $item->project_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row card-body">
                            <label class="col-sm-2">WBS</label>
                            <div class="col-sm-10">
                                <select class="select2bs4 form-control" style="width: 100%;" name="wbs_bpm" id="wbs_bpm">
                                    <option value="">-- Pilih Project --</option>
                                </select>
                            </div>
                        </div>

                    <div class="d-flex card-body justify-between">
                        <div class="w-50">
                            <form action="#">
                              <!-- start -->
                              <div>
                                <label>Material</label>
                                 <select class="select2bs4 form-control" style="width: 100%;" name="material_bpm" id="material_bpm">
                                    <option>-- Pilih Material --</option>
                                </select>
                               </div>
                              <!-- end -->
                               <div>
                                <label>UOM</label>
                                <select class="select2bs4 form-control" @readonly(true) style="width: 30%;" name="uom_bpm" id="uom_bpm" disabled>
                                    <option>-- Pilih Material --</option>
                                </select>
                              </div>
                              <div>
                                <label>Quantity Requirement</label>
                                <input type="number" name="qtypo_bpm" class="form-control" style="width: 30%;">
                              </div>
                              <div>
                                <label>Requirement Date</label>
                                <input type="date" name="date_bpm" class="form-control" style="width: 30%;" id="date_bpm">
                              </div>
                            <div class="my-4" style="float: right;">
                                <button class="btn btn-primary" id='add-bpm'>Add</button>
                            </div>
                        </form>
                        </div>
                        {{-- end of left section --}}
                        {{-- start of right section --}}
                        <div style="width: 40%; margin-left: auto">
                                <div>
                                    <table class="table table-bordered table-responsive table-hover display" style="width:100%" id="bpm-table">
                                        <thead>
                                            <tr>
                                            <!-- <th>No.</th> -->
                                            <th>Material</th>
                                            <th>QTY Requirement</th>
                                            <th>UoM</th>
                                            <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id='sttp-tbody'>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                        <div>
                        <button class="btn btn-success float-right" id='submit-bpm'>Submit</button>
                      </div>
                      </div>

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





    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
$(document).ready(function() {
     $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })



    let items = [];
    let itemsBpm = [];
    $('#sttp-table').dataTable( {
        "searching": false,
        "paging": false,
        "data": items,
        "columns": [

            { "data": "material_code" },
            { "data": "qtypo" },
            { "data": "qtylppb" },
            { "data": "qtyncr" },
            { "data": "uom" },
        ]
    } );

    $('#bpm-table').dataTable( {
        "searching": false,
        "paging": false,
        "data": itemsBpm,
        "columns": [

            { "data": "material_code" },
            { "data": "qtypo" },
            { "data": "uom" },
            { "data": "date" },

        ]
    } );
    const rendertbodysttp = () => {
        let html = '';
        items.forEach((item, index) => {
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.material_code}</td>
                    <td>${item.qtypo}</td>
                    <td>${item.qtylppb}</td>
                    <td>${item.qtyncr}</td>
                    <td>${item.uom}</td>
                    <td><button class="btn btn-danger" id='sttp-${index}'>Delete</button></td>
                </tr>
            `;
        });

        return html;
    }

    //listener to delete sttp
    $('#sttp-tbody').on('click', 'button', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        const index = id.split('-')[1];
        items.splice(index, 1);
        $('#sttp-tbody').html(rendertbodysttp());
    });


     const clearMaterialForm = () => {
        $('input[name="qtypo"]').val('');
        $('input[name="qtylppb"]').val('');
        $('input[name="qtyncr"]').val('');
        $('select[name="uom"]').val('');
    }

    var uom;
    var uomBPM;

    const clearBpmMaterialForm = () => {
        $('input[name="qtypo_bpm"]').val('');
        $('input[name="date_bpm"]').val('');
        $('select[name="uom_bpm"]').val('');
        $('select[name="material_bpm"]').val('');
    }

    $('#add-bpm').on(
        'click', function(e) {
            e.preventDefault();
            var material = $('select[name="material_bpm"]').val();
            var qtypo = $('input[name="qtypo_bpm"]').val();
            var date = $('input[name="date_bpm"]').val();

            itemsBpm.push({
                material_code: material,
                qtypo : qtypo,
                date : date,
                uom : uomBPM
            });

            clearBpmMaterialForm();

            $('#bpm-table').dataTable().fnClearTable();
            $('#bpm-table').dataTable().fnAddData(itemsBpm);
        });

    $('#add-sttp').on(
        'click', function(e) {
            e.preventDefault();
            var material = $('select[name="material"]').val();
            var qtypo = $('input[name="qtypo"]').val();
            var qtylppb = $('input[name="qtylppb"]').val();
            var qtyncr = $('input[name="qtyncr"]').val();
            console.log(uom);


            items.push({
                material_code: material,
                qtypo : qtypo,
                qtylppb : qtylppb,
                qtyncr : qtyncr,
                uom : uom
            });

            clearMaterialForm();

            $('#sttp-table').dataTable().fnClearTable();
            $('#sttp-table').dataTable().fnAddData(items);


            // console.log(items);

            // $('#sttp-tbody').html(rendertbodysttp());

            // console.log(items);
        }
    )


    const clearAllForm = () => {
        $('input[name="qtypo"]').val('');
        $('input[name="qtylppb"]').val('');
        $('input[name="qtyncr"]').val('');
        items = [];
        $('#sttp-table').dataTable().fnClearTable();


      }

$('#project_form_bpm').on('change', function(e) {
        e.preventDefault();
        var project = $(this).val();
        $.ajax({
            url:'/get-wbs/'+ project,
            type:'GET',
            success:function(data){
                console.log(data+project);
                $('select[name="wbs_bpm"]').empty();
                $('select[name="wbs_bpm"]').append('<option value="">-- Pilih WBS --</option>');
                $.each(data.data, function(key, value){
                    $('select[name="wbs_bpm"]').append('<option value="'+ value.wbs_code +'">'+ value.wbs_desc + ' : ' + value.wbs_code +'</option>');
                });
            },
            error:function(){
                Swal.fire('Data Gagal Tidak Ditemukan ').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/new-transaksi';
                    }
                });
            }
        });
        });

$('#project_form').on('change', function(e) {
        e.preventDefault();
        var project = $(this).val();
        $.ajax({
            url:'/get-wbs/'+ project,
            type:'GET',
            success:function(data){
                console.log(data+project);
                $('select[name="wbs"]').empty();
                $('select[name="wbs"]').append('<option value="">-- Pilih WBS --</option>');
                $.each(data.data, function(key, value){
                    $('select[name="wbs"]').append('<option value="'+ value.wbs_code +'">'+ value.wbs_desc + ' : ' + value.wbs_code +'</option>');
                });
            },
            error:function(){
                Swal.fire('Data Gagal Tidak Ditemukan ').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/new-transaksi';
                    }
                });
            }
        });
        });


        $('#material').on('change', function (e) {
    e.preventDefault();
    var material = $(this).val();

    $.ajax({
        url: '/get-uom/' + material,
        type: 'GET',
        success: function (data) {
            uom =  data.data.uom_name + ' : ' + data.data.uom_code;
            $('select[name="uom"]').empty();
            $('select[name="uom"]').append('<option value="' + data.data.id + '">' + data.data.uom_name + ' : ' + data.data.uom_code + '</option>');
        },
        error: function () {
            Swal.fire('Data Gagal Tidak Ditemukan ').then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/new-transaksi';
                }
            });
        }
    })
 });

    $('#wbs_bpm').on('change', function(e) {
        e.preventDefault();
        var wbs = $(this).val();
        $.ajax({
            url:'/material-stock/'+ wbs,
            type:'GET',
            success:function(data){
                console.log(data);
                $('#material_bpm').empty();
                $('#material_bpm').append('<option value="">-- Pilih Material --</option>');
                $.each(data.data, function(key, value){
                    $('select[name="material_bpm"]').append('<option value="'+ value.material_code +'">'+ value.material_desc + ' : ' + value.material_code +'</option>');
                });
            },
            error:function(){
                Swal.fire('Data Gagal Tidak Ditemukan ').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/new-transaksi';
                    }
                });
            }
        });
        });

         $('#material_bpm').on('change', function (e) {
    e.preventDefault();
    var material = $(this).val();

    $.ajax({
        url: '/get-uom/' + material,
        type: 'GET',
        success: function (data) {
            uomBPM =  data.data.uom_name + ' : ' + data.data.uom_code;
            $('select[name="uom_bpm"]').empty();
            $('select[name="uom_bpm"]').append('<option value="' + data.data.id + '">' + data.data.uom_name + ' : ' + data.data.uom_code + '</option>');
        },
        error: function () {
            Swal.fire('Data Gagal Tidak Ditemukan ').then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/new-transaksi';
                }
            });
        }
    })
 });

 //ajax submit bpm
    $('#submit-bpm').on('click', function(e) {
        e.preventDefault();
        var project = $('select[name="project_bpm"]').val();
        var wbs = $('select[name="wbs_bpm"]').val();
        var data = {
            project: project,
            wbs:wbs,
            items: itemsBpm

        };
        console.log(data);
        $.ajax({
            url: '/new-transaksi-bpm',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                Swal.fire('Data Berhasil Ditambahkan').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/transaksi';
                    }
                });
                clearAllForm();
            },
            error: function(data) {
                Swal.fire('Data Gagal Ditambahkan').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/transaksi';
                    }
                });
            }
        });
    });


    //ajax submit sttp
    $('#submit-sttp').on('click', function(e) {
        e.preventDefault();
        var project = $('select[name="project"]').val();
        var wbs = $('select[name="wbs"]').val();
        var data = {
            project: project,
            wbs:wbs,
            items: items

        };
        console.log(data);
        $.ajax({
            url: '/new-transaksi',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                Swal.fire('Data Berhasil Ditambahkan').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/transaksi';
                    }
                });
                clearAllForm();
            },
            error: function(data) {
                Swal.fire('Data Gagal Ditambahkan').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/transaksi';
                    }
                });
            }
        });
    });
  });

</script>


    @endsection
