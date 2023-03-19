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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @elseif ($errors->any())
                    <div class="alert alert-danger" role="alert">
                         <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Add User</a></li>
                  </ul>
                </div><!-- /.card-header -->

                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <div class="card-body">
                        <table class="table table-bordered table-responsive table-hover" id="example1">
                          <thead>
                            <tr>
                              <th>No. </th>
                              <th>Email</th>
                              <th>Name</th>
                              <th>NIP</th>
                              <th>Position</th>
                              <th>Division</th>
                              <th>Plant</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $item)
                            <tr>
                              <td>{{ $index++ }}</td>
                              <td>{{ $item->email }}</td>
                              <td>{{ $item->name }}</td>
                              <td>{{ $item->nip }}</td>
                              <td>{{ isset($item->position->position_name)? $item->position->position_name : "-" }}</td>
                              <td>{{ isset($item->division->division_name)? $item->division->division_name : "-" }}</td>
                              <td>{{ isset($item->plant->plant_name)? $item->plant->plant_name : "-" }}</td>
                              <!-- PENTING! TAMBAHKAN ALERT SEBELUM DELETE -->
                              <td><a href="/edituser/{{ $item->id }}"><button class="btn btn-outline-warning">edit</button></a> <a href="/deleteuser/{{ $item->id }}"><button class="btn btn-danger">delete</button></a></td>
                            </tr>
                            @endforeach
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>No. </th>
                              <th>Email</th>
                              <th>Name</th>
                              <th>NIP</th>
                              <th>Position</th>
                              <th>Division</th>
                              <th>Plant</th>
                              <th>Action</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>

                    <div class="tab-pane" id="settings">
                      <form class="form-horizontal" method="POST" action="/addusermanagement" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="inputEmail" value="" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="name" value="" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="foto" class="col-sm-2 col-form-label">Photo</label>
                          <div class="col-sm-10">
                            <input type="file" name="image">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="password" value="" type="password" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">NIP</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="nip" value="" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Position</label>
                          <div class="col-sm-10">
                            <select class="form-control select2" name="position">
                              @foreach($position as $item)
                              <option value="{{ $item->position_code }}">{{ $item->position_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Division</label>
                          <div class="col-sm-10">
                            <select class="form-control select2" name="division">
                              @foreach($division as $item)
                              <option value="{{ $item->division_code }}">{{ $item->division_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Plant</label>
                          <div class="col-sm-10">
                            <select class="form-control select2" name="plant">
                              @foreach($plant as $item)
                              <option value="{{ $item->plant_code }}">{{ $item->plant_name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Role</label>
                          <div class="col-sm-10">
                            <select class="form-control select2" name="role">
                              <option value="Admin">Admin</option>
                              <option value="Operator">Operator</option>
                              <option value="Manager">Manager</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Add User</button>
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

    @endsection