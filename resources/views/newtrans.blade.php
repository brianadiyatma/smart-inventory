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
                            <label class="col-sm-2">WBS</label>
                            <div class="col-sm-10">
                                <select class="select2bs4 form-control" name="wbs">
                                    @foreach($data_wbs as $item)
                                    <option value="{{ $item->wbs_code }}">{{ $item->wbs_desc }} : {{ $item->wbs_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-between ">
                        {{-- Start of Left Section --}}
                        <div class="w-50">
                            <form action="#">
                        <div class="row">
                            <div class="col-md-10">
                                <label>Material</label>
                                 <select class="select2bs4 form-control" style="width: 100%;" name="material">
                                    @foreach($data_material as $item)
                                    <option value="{{ $item->material_code }}">{{ $item->material_desc }} : {{ $item->material_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control">
                            </div>

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
                                            <th>No.</th>
                                            <th>Material</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
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





<script type="text/javascript">
$(document).ready(function() {
     $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $('#sttp-table').dataTable( {
        "searching": false

    } );

    let items = [];

    const rendertbodysttp = () => {
        let html = '';
        items.forEach((item, index) => {
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.material_code}</td>
                    <td>${item.quantity}</td>
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


    $('#add-sttp').on(
        'click', function(e) {
            e.preventDefault();
            var material = $('select[name="material"]').val();
            var quantity = $('input[name="quantity"]').val();

            items.push({
                material_code: material,
                quantity: quantity
            });

            $('#sttp-tbody').html(rendertbodysttp());

            console.log(items);
        }
    )

    //ajax submit sttp
    $('#submit-sttp').on('click', function(e) {
        e.preventDefault();
        var wbs = $('select[name="wbs"]').val();
        var data = {
            wbs: wbs,
            items: items
        };

        $.ajax({
            url: '/new-transaksi',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log(data);
            }
        });
    });
  });

</script>


    @endsection
