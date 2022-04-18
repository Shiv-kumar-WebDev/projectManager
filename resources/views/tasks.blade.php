<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tasks</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Tasks</h1>
                    <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal">Add
                        Task</a>
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
                                    <th>Task Name</th>
                                    <th>Task Start</th>
                                    <th>Task End</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Task Remark</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($tasks as $row)
                                    <tr>
                                        <td>{{ $row->tasks_name }}</td>
                                        <td>{{ $row->tasks_start }}</td>
                                        <td>{{ $row->tasks_end }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>
                                            @if($row->task_status ==0)
                                                <a href="{{ url('/taskStatusUpdate/'. $row->tasks_id.'/'.$row->task_status) }}"
                                                   class="btn btn-warning btn-sm">Inactive</a>
                                            @else
                                                <a href="{{ url('/taskStatusUpdate/'. $row->tasks_id.'/'.$row->task_status) }}"
                                                   class="btn btn-success btn-sm">Active</a>
                                            @endif
                                        </td>
                                        <td>{{ $row->tasks_remark }}</td>
                                        <td>
                                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                               data-target="#exampleModal">Edit</a>
                                            <a href="{{ url('/deleteTask/'. $row->tasks_id) }}"
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
                        <div class="form-group">
                            <input name="tasks_name" type="text" class="form-control form-control-user"
                                   id="tasks_name"
                                   placeholder="Task Name">
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">Start Date</label>
                                <input name="tasks_start" type="date" class="form-control form-control-user"
                                       id="tasks_start">
                            </div>
                            <div class="col-sm-6">
                                <label for="">End Date</label>
                                <input name="tasks_end" type="date" class="form-control form-control-user"
                                       id="tasks_end">
                            </div>
                        </div>

                        <div class="form-group">
                            <select name="users_id" type="text" class="form-control form-control-user" id="users_name">
                                <option value="">Select User</option>
                                @foreach ($users as $row)
                                    <option value="{{ $row->user_id }}">{{ $row->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="tasks_remark" type="text" class="form-control form-control-user"
                                   id="tasks_remark"
                                      placeholder="Task Remark"></textarea>
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

    $(".btn-submit").click(function (e) {

        e.preventDefault();

        var tasks_name = $("#tasks_name").val();
        var tasks_start = $("#tasks_start").val();
        var tasks_end = $("#tasks_end").val();
        var users_name = $("#users_name").val();
        var tasks_remark = $("#tasks_remark").val();

        $.ajax({
            type: 'POST',
            url: "{{ url('/addTask') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                tasks_name: tasks_name,
                tasks_start: tasks_start,
                tasks_end: tasks_end,
                users_name: users_name,
                tasks_remark: tasks_remark
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

</script>

</body>

</html>