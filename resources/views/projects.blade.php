<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Projects</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Projects</h1>
                    <button type="button" class="btn btn-info btn-sm" id="newProject">Add
                        Project</button>
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
                                    <th>Project Name</th>
                                    <th>Project Start</th>
                                    <th>Project End</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($projects as $row)
                                    <tr>
                                        <td>{{ $row->projects_name }}</td>
                                        <td>{{ $row->project_start }}</td>
                                        <td>{{ $row->project_end }}</td>
                                        <td>{{ $row->fname }} ({{  $row->email }})</td>
                                        <td>{{ $row->project_status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm EditProject" value="{{ $row->project_id  }}">Edit</button>
{{--                                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal"--}}
{{--                                               data-target="#exampleModal">Edit</a>--}}
                                            <a href="{{ url('/deleteProject/'. $row->project_id) }}"
                                               class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <p>No projects</p>
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

                    <div class="msg-success"></div>
                    <div class="modal-body">
                        <input type="hidden" id="project_id" value="">
                        <div class="form-group">
                            <input name="projects_name" type="text" class="form-control form-control-user"
                                   id="projects_name"
                                   placeholder="Project Name">
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">Start Date</label>
                                <input name="projects_start" type="date" class="form-control form-control-user"
                                       id="projects_start">
                            </div>
                            <div class="col-sm-6">
                                <label for="">End Date</label>
                                <input name="projects_end" type="date" class="form-control form-control-user"
                                       id="projects_end">
                            </div>
                        </div>

                        <div class="form-group">
                            <select name="user_name" type="text" class="form-control form-control-user" id="user_name">
                                <option value="">Select User</option>
                                @foreach ($users as $row)
                                    <option value="{{ $row->user_id }}">{{ $row->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="project_status" type="text" class="form-control form-control-user" id="project_status">
                                <option value="">Select Project Status</option>
                                <option value="Pending">Pending</option>
                                <option value="In Process">In Process</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
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

    $('#newProject').click(function () {
        $("#projects_name").val('');
        $("#projects_start").val('');
        $("#projects_end").val('');
        $("#user_name").val('');
        $("#property_id").val('');

        $('#exampleModal').modal('show');
    });

    $(".btn-submit").click(function (e) {

        e.preventDefault();

        var projects_name = $("#projects_name").val();
        var projects_start = $("#projects_start").val();
        var projects_end = $("#projects_end").val();
        var user_name = $("#user_name").val();
        var project_status = $("#project_status").val();
        var project_id = $("#project_id").val();


        $.ajax({
            type: 'POST',
            url: "{{ url('/addProject') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                projects_name: projects_name,
                projects_start: projects_start,
                projects_end: projects_end,
                user_name: user_name,
                project_status: project_status,
                project_id:project_id
            },
            success: function (data) {

                if ($.isEmptyObject(data.error)) {
                    // alert(data.success);
                    $('.msg-success').html('<div class="alert alert-success">' + data.success + '</div>');
                    location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        });

    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function (key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

    $(".EditProject").click(function(e){
        e.preventDefault();
        // console.log('hi');
        var id = $(this).val();
        // alert(id);return false;
        $.ajax({
            type:'POST',
            url:"{{ url('/projectDetails') }}",
            data:{"_token": "{{ csrf_token() }}", id:id},
            success:function(data){
                // console.log(data);

                if($(data.type == 'success')){

                    $("#projects_name").val(data.projects[0].projects_name);
                    $("#projects_start").val(data.projects[0].project_start);
                    $("#projects_end").val(data.projects[0].project_end);
                    $("#user_name").val(data.projects[0].user_id);
                    $("#project_status").val(data.projects[0].project_status);
                    $("#project_id").val(id);


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
