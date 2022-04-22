<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Users</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

@include('../layout/sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

        @include('../layout/nav')

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-flex justify-content-between p-2 align-items-center">
                    <h1 class="h3 mb-2 text-gray-800">Users</h1>
                    <button type="button" class="btn btn-info btn-sm" id="newUser" >Add New</button>
                </div>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($user as $row)
                                    <tr>
                                        <td>{{ $row->fname }}</td>
                                        <td>{{ $row->lname }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->designation }}</td>
                                        <td>
                                            @if($row->user_status ==0)
                                                <a href="{{ url('/statusUpdate/'. $row->user_id.'/'.$row->user_status) }}" class="btn btn-warning btn-sm">Inactive</a>
                                            @else
                                                <a href="{{ url('/statusUpdate/'. $row->user_id.'/'.$row->user_status) }}" class="btn btn-success btn-sm">Active</a>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm EditUser" value="{{ $row->user_id  }}">Edit</button>
                                            <a href="{{ url('/delete/'. $row->user_id) }}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <p>No users</p>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add/Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="msg-success" ></div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <input type="hidden" id="user_id" value="">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input name="fname" type="text" class="form-control form-control-user" id="fname"
                                       placeholder="First Name">
                            </div>
                            <div class="col-sm-6">
                                <input name="lname" type="text" class="form-control form-control-user" id="lname"
                                       placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <input name="email" type="email" class="form-control form-control-user" id="email"
                                   placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <select name="desi" type="text" class="form-control form-control-user" id="desi">
                                <option value="">Select Designation</option>
                                <option value="PHP Developer">PHP Developer</option>
                                <option value="Desginer">Desginer</option>
                                <option value="SEO">SEO </option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input name="pass" type="password" class="form-control form-control-user"
                                       id="pass" placeholder="Password">
                            </div>
                            <div class="col-sm-6">
                                <input name="cpass" type="password" class="form-control form-control-user"
                                       id="cpass" placeholder="Repeat Password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-submit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        @include('../layout/footer')

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#newUser').click(function () {
        $("#fname").val('');
        $("#lname").val('');
        $("#email").val('');
        $("#desi").val('');
        $("#user_id").val('');
        $("#pass").val('');
        $("#cpass").val('');

        $('#exampleModal').modal('show');
    });


    //New User
    $(".btn-submit").click(function(e){
        e.preventDefault();

        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var desi = $("#desi").val();
        var pass = $("#pass").val();
        var cpass = $("#cpass").val();
        var user_id = $("#user_id").val();

        $.ajax({
            type:'POST',
            url:"{{ url('/addUser') }}",
            data:{"_token": "{{ csrf_token() }}",fname:fname, lname:lname, email:email, desi:desi, pass:pass, cpass:cpass, user_id:user_id},
            success:function(data){
                // console.log(data);
                // return false;

                if($.isEmptyObject(data.error)){
                    $('.msg-success').html('<div class="alert alert-success">' +data.success+ '</div>');
                    location.reload();
                }else{
                    printErrorMsg(data.error);
                }
            }
        });

    });


    //Edit User
    $(".btn-edit").click(function(e){
        e.preventDefault();

        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var desi = $("#desi").val();
        var pass = $("#pass").val();
        var cpass = $("#cpass").val();
        var user_id = $("#user_id").val();


        $.ajax({
            type:'POST',
            url:"{{ url('/addEdit') }}",
            data:{"_token": "{{ csrf_token() }}",fname:fname, lname:lname, email:email, desi:desi, pass:pass, cpass:cpass, user_id:user_id },
            success:function(data){
                if($.isEmptyObject(data.error)){
                    // alert(data.success);
                    $('.msg-success').html('<div class="alert alert-success">' +data.success+ '</div>');
                    location.reload();
                }else{
                    printErrorMsg(data.error);
                }
            }
        });

    });

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }


    //User Details
    $(".EditUser").click(function(e){
        e.preventDefault();
        var id = $(this).val();
        $.ajax({
            type:'POST',
            url:"{{ url('/UserDetails') }}",
            data:{"_token": "{{ csrf_token() }}", id:id},
            success:function(data){
                console.log(data);

                if($(data.type == 'success')){


                    $("#fname").val(data.users[0].fname);
                    $("#lname").val(data.users[0].lname);
                    $("#email").val(data.users[0].email);
                    $("#desi").val(data.users[0].designation);
                    $("#user_id").val(id);

                    $('#exampleModal').modal('show');

                }else{
                    alert(data.msg);
                }
            }
        });

    });

</script>

</body>

</html>
