@extends('layout')
@section('content')

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('preloader')
    @include('navbar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('breadcrumb')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Notification</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <div class="input-group-append">
                  </div>
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <tbody>
                  @foreach($notif as $data)
                  <tr>
                    <td>{{ $index++ }}</td>
                    <td class="mailbox-name">User Name</td>
                    <td class="mailbox-subject"><b>{{ $data->title }}</b> - {{ $data->body }}
                    </td>
                    <td class="mailbox-date">{{ $data->created_at }}</td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


@endsection
