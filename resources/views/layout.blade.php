<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Icon -->
  <link rel ="icon" href ="{{asset('img/Group1.png')}}" type = "image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">

  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->


  <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>  

  <!-- AXIOS -->
  <script src="{{asset('assets/dist/js/axios.min.js')}}"></script>  
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/axios.min.js" integrity="sha512-0qU9M9jfqPw6FKkPafM3gy2CBAvUWnYVOfNPDYKVuRTel1PrciTj+a9P3loJB+j0QmN2Y0JYQmkBBS8W+mbezg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> -->

  <style type="text/css">
    .fa-stack[data-count]:after{
      position:absolute;
      right:0%;
      top:1%;
      content: attr(data-count);
      font-size:50%;
      padding:.6em;
      border-radius:999px;
      line-height:.75em;
      color: white;
      background:rgba(255,0,0,.85);
      text-align:center;
      min-width:15px;
      font-weight:bold;
    }
    .dataTables_filter {
     width: 50%;
     float: right;
     text-align: right;
    }
    .dataTables_paginate{
     float: right;
     text-align: right; 
    }
    tr td:last-child {
    width: 1%;
    white-space: nowrap;
    }
  </style>
</head>


@yield('content')


<!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>&copy; 2022, <a href="#" style="text-decoration: none; color: grey;">PT Industri Kereta Api (Persero)</a>.</strong>
  </footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>





<!-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
  
<!-- <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script> -->
<!-- jQuery UI 1.11.4 -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<!-- <script src="{{asset('assets/plugins/sparklines/sparkline.js')}}"></script> -->
<!-- JQVMap -->
<!-- <script src="{{asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script> -->
<!-- jQuery Knob Chart -->
<script src="{{asset('assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{asset('assets/dist/js/pages/dashboard.js')}}"></script> -->


 <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

<script>

  
    var firebaseConfig = {
            apiKey: "AIzaSyA9vhAa9jqHxdze0lP59lR7PQde18HHxhk",
            authDomain: "laravelfcm-74fff.firebaseapp.com",
            projectId: "laravelfcm-74fff",
            storageBucket: "laravelfcm-74fff.appspot.com",
            messagingSenderId: "245859545840",
            appId: "1:245859545840:web:dbb68b5ec4d9ad67618835",
            measurementId: "G-CJ4E5P6737"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function () {
                return messaging.getToken()
            }).then(function(token) {
                
                axios.post("{{ route('fcmToken') }}",{
                    _method:"POST",
                    token
                }).then(({data})=>{
                    console.log(data)
                }).catch(({response:{data}})=>{
                    console.error(data)
                })

            }).catch(function (err) {
                console.log(`Token Error :: ${err}`);
            });
        }

        initFirebaseMessagingRegistration();
      
        // messaging.onMessage(function({data:{body,title}}){
        //     new Notification(title, {body});
        // });

        messaging.onMessage(function (payload) {
            console.log(payload);
        const notificationTitle = payload.data.title;
        const notificationOptions = {
            body: payload.data.body,
            icon: payload.data.icon,
            image: payload.data.image,
        };        
        if (!("Notification" in window)) {
            console.log("This browser does not support system notifications");
        }
        // Let's check whether notification permissions have already been granted
        else if (Notification.permission === "granted") {
            // If it's okay let's create a notification
            var notification = new Notification(
                notificationTitle,
                notificationOptions
            );
            notification.onclick = function (event) {
                event.preventDefault(); // prevent the browser from focusing the Notification's tab
                window.open('/');
                notification.close();
              
            };
        }
    });  
  
  
</script>

@yield('js')

      <script type="text/javascript">
          $(document).ready(function () {
          // Setup - add a text input to each footer cell
          $('#example tfoot th').each(function () {
              var title = $(this).text();
              $(this).html('<input style="width:100%;" type="text" placeholder="Search ' + title + '" />');
          });
       
          // DataTable
          var table = $('#example').DataTable({
              initComplete: function () {
                  // Apply the search
                  this.api()
                      .columns()
                      .every(function () {
                          var that = this;
       
                          $('input', this.footer()).on('keyup change clear', function () {
                              if (that.search() !== this.value) {
                                  that.search(this.value).draw();
                              }
                          });
                      });
              },
              dom: 'Bfrtip',
              buttons: [
                  'copy', 'excel'
              ]
          });
      }); 

          $(document).ready(function () {
          // Setup - add a text input to each footer cell
          $('#example1 tfoot th').each(function () {
              var title = $(this).text();
              $(this).html('<input style="width:100%;" type="text" placeholder="Search ' + title + '" />');
          });
       
          // DataTable
          var table = $('#example1').DataTable({
              initComplete: function () {
                  // Apply the search
                  this.api()
                      .columns()
                      .every(function () {
                          var that = this;
       
                          $('input', this.footer()).on('keyup change clear', function () {
                              if (that.search() !== this.value) {
                                  that.search(this.value).draw();
                              }
                          });
                      });
              },
              dom: 'Bfrtip',
              buttons: [
                  'copy', 'excel'
              ]
          });
      }); 

          $(document).ready(function () {
          // Setup - add a text input to each footer cell
          $('#example2 tfoot th').each(function () {
              var title = $(this).text();
              $(this).html('<input style="width:100%;" type="text" placeholder="Search ' + title + '" />');
          });
       
          // DataTable
          var table = $('#example2').DataTable({
              initComplete: function () {
                  // Apply the search
                  this.api()
                      .columns()
                      .every(function () {
                          var that = this;
       
                          $('input', this.footer()).on('keyup change clear', function () {
                              if (that.search() !== this.value) {
                                  that.search(this.value).draw();
                              }
                          });
                      });
              },
              dom: 'Bfrtip',
              buttons: [
                  'copy', 'excel'
              ]
          });
      }); 
      </script>


</body>
</html>