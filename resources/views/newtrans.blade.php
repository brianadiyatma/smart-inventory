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
                                <select class="select2bs4 form-control" name="project">
                                    @foreach($data_project as $item)
                                    <option value={{ $item->project_code }}>{{ $item->project_desc }} : {{ $item->project_code }}</option>
                                    @endforeach
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
                                 <select class="select2bs4 form-control" style="width: 100%;" name="material">
                                    @foreach($data_material as $item)
                                    <option value="{{ $item->material_code }}">{{ $item->material_desc }} : {{ $item->material_code }}</option>
                                    @endforeach
                                </select>
                               </div>
                              <!-- end -->
                              <div>
                                <label>WBS</label>
                                <select class="select2bs4 form-control" style="width: 100%;" name="wbs">
                                    @foreach($data_wbs as $item)
                                    <option value="{{ $item->wbs_code }}">{{ $item->wbs_desc }} : {{ $item->wbs_code }}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div>
                                <label>Quantity PO</label>
                                <input type="number" name="qtypo" class="form-control">
                              </div>
                              <div>
                                <label>Quantity LPPB</label>
                                <input type="number" name="qtylppb" class="form-control">
                              </div>
                              <div>
                                <label>Quantity NCR</label>
                                <input type="number" name="qtyncr" class="form-control">
                              </div>

                              <div>
                                <label>UOM</label>
                                <select class="select2bs4 form-control" style="width: 100%;" name="uom">
                                    @foreach($data_UOM as $item)
                                    <option value="{{ $item->id }}">{{ $item->uom_name}} : {{ $item->uom_code }}</option>
                                    @endforeach
                                </select>
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
                                    <table class="table table-bordered table-responsive table-hover display" id="sttp-table">
                                        <thead>
                                            <tr>
                                            <!-- <th>No.</th> -->
                                            <th>Material</th>
                                            <th>WBS</th>
                                            <th>QTY PO</th>
                                            <th>QTY LPPB</th>
                                            <th>QTY NCR</th>
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
                        <div class="card-body">
                            <h1>This is BPM</h1>
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
    $('#sttp-table').dataTable( {
        "searching": false,
        "paging": false,
        "data": items,
        "columns": [
            
            { "data": "material_code" },
            { "data": "wbs_code" },
            { "data": "qtypo" },
            { "data": "qtylppb" },
            { "data": "qtyncr" },
            { "data": "uom" },
               
        ]
        
        
       
    } );
    const rendertbodysttp = () => {
        let html = '';
        items.forEach((item, index) => {
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.material_code}</td>
                    <td>${item.wbs_code}</td>
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
    }

    $('#add-sttp').on(
        'click', function(e) {
            e.preventDefault();
            var material = $('select[name="material"]').val();
            var wbs = $('select[name="wbs"]').val();
            var qtypo = $('input[name="qtypo"]').val();
            var qtylppb = $('input[name="qtylppb"]').val();
            var qtyncr = $('input[name="qtyncr"]').val();
            var uom = $('select[name="uom"]').val();
            

            items.push({
                material_code: material,
                wbs_code: wbs,
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

    
    //ajax submit sttp
    $('#submit-sttp').on('click', function(e) {
        e.preventDefault();
        var project = $('select[name="project"]').val();
        var data = {
            project: project,
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
                console.log(data);
            }
        });
    });
  });

</script>


    @endsection