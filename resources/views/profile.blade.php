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
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Change Password</a></li>
                  </ul>
                </div><!-- /.card-header -->

                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <div class="row align-item-center">
                        @foreach($data as $item)
                        <div class="col-sm-4">
                          <div class="text-center">
                            @if(!isset($item->foto)||$item->foto=='')
                            <img src="{{asset('pp/blank.jpg')}}" class="my-3" width="200px" alt="" title="" />
                            @else
                            <img src="{{ $item->foto }}" class="my-3" width="200px" alt="" title="" />
                            @endif
                          </div>
                        </div>

                        <div class="col-sm-8">
                          <form class="form-horizontal" method="POST" action="#">
                            <div class="form-group row">
                              <label for="inputName" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                                <p>{{ $item->email }}</p>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                              <div class="col-sm-10">
                                <p>{{ $item->name }}</p>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputEmail" class="col-sm-2 col-form-label">NIP</label>
                              <div class="col-sm-10">
                                <p>{{ $item->nip }}</p>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputEmail" class="col-sm-2 col-form-label">Position</label>
                              <div class="col-sm-10">
                                <p>{{ isset($item->position->position_name)? $item->position->position_name : "-" }}</p>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputName2" class="col-sm-2 col-form-label">Division</label>
                              <div class="col-sm-10">
                                <p>{{ isset($item->division->division_name)? $item->division->division_name : "-" }}</p>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputExperience" class="col-sm-2 col-form-label">Plant</label>
                              <div class="col-sm-10">
                                <p>{{ isset($item->plant->plant_name)? $item->plant->plant_name : "-" }}</p>
                              </div>
                            </div>
                            @endforeach
                          </form>
                        </div>

                      </div>
                    </div>

                    <div class="tab-pane" id="settings">
                      <form class="form-horizontal" method="POST" action="/editprofile" enctype="multipart/form-data">
                        @csrf
                        @foreach($data as $item)
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="inputEmail" value="{{ $item->email }}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input class="form-control" id="inputName" name="name" value="{{ $item->name }}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="foto" class="col-sm-2 col-form-label">Photo</label>
                          <div class="col-sm-10">
                            <input name="image" type="file">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">NIP</label>
                          <div class="col-sm-10">
                            <input class="form-control" id="inputEmail" name="nip" value="{{ $item->nip }}" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Position</label>
                          <div class="col-sm-10">
                            <input class="form-control" id="inputEmail" 
                            value="{{ isset($item->position->position_name)? $item->position->position_name : '-' }}" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Division</label>
                          <div class="col-sm-10">
                            <input class="form-control" id="inputEmail" 
                            value="{{ isset($item->division->division_name)? $item->division->division_name : '-' }}" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Plant</label>
                          <div class="col-sm-10">
                            <input class="form-control" id="inputEmail" 
                            value="{{ isset($item->plant->plant_name)? $item->plant->plant_name : '-' }}" readonly>
                          </div>
                        </div>
                        <input class="form-control" id="inputEmail" name="id" value="{{ $item->id }}" hidden>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                        @endforeach
                      </form>
                    </div>

                    <div class="tab-pane" id="password">
                      <form class="form-horizontal" method="POST" action="/editpassword">
                      <input type="" class="form-control" name="id" id="id" value="{{ $item->id }}" hidden>
                        @csrf
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Old Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" name="old_password" id="password" placeholder="Type Old Password">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">New Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" name="new_password" id="newpassword" placeholder="Type New Password">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Re-type New Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" placeholder="Re-type New Password">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
      <!-- /.content -->
    </div>


    @endsection