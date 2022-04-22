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
                    <button type="button" class="btn btn-info btn-sm" id="newTask">Add
                        Task</button>
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
                                        <td>{{ $row->fname }} {{ $row->lname }}</td>
                                        <td>{{ $row->task_status }}</td>
                                        <td>{{ $row->tasks_remark }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm EditTask" value="{{ $row->tasks_id  }}">Edit</button>

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
                        <input type="hidden" id="task_id" value="">
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
                            <select name="task_status" type="text" class="form-control form-control-user" id="task_status">
                                <option value="">Select Task Status</option>
                                <option value="Pending">Pending</option>
                                <option value="In Process">In Process</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
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

    $('#newTask').click(function () {
        $("#tasks_name").val('');
        $("#tasks_start").val('');
        $("#tasks_end").val('');
        $("#users_name").val('');
        $("#task_status").val('');
        $("#tasks_remark").val('');

        $('#exampleModal').modal('show');
    });

    $(".btn-submit").click(function (e) {

        e.preventDefault();

        var tasks_name = $("#tasks_name").val();
        var tasks_start = $("#tasks_start").val();
        var tasks_end = $("#tasks_end").val();
        var users_name = $("#users_name").val();
        var tasks_remark = $("#tasks_remark").val();
        var task_status = $("#task_status").val();
        var task_id = $("#task_id").val();


        $.ajax({
            type: 'POST',
            url: "{{ url('/addTask') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                tasks_name: tasks_name,
                tasks_start: tasks_start,
                tasks_end: tasks_end,
                users_name: users_name,
                tasks_remark: tasks_remark,
                task_status:task_status,
                task_id:task_id
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
    $(".EditTask").click(function(e){
        e.preventDefault();
        // console.log('hi');
        var id = $(this).val();
        // alert(id);return false;
        $.ajax({
            type:'POST',
            url:"{{ url('/taskDetails') }}",
            data:{"_token": "{{ csrf_token() }}", id:id},
            success:function(data){
                // console.log(data);

                if($(data.type == 'success')){

                    $("#tasks_name").val(data.tasks[0].tasks_name);
                    $("#tasks_start").val(data.tasks[0].tasks_start);
                    $("#tasks_end").val(data.tasks[0].tasks_end);
                    $("#users_name").val(data.tasks[0].users_id);
                    $("#tasks_remark").val(data.tasks[0].tasks_remark);
                    $("#task_status").val(data.tasks[0].task_status);
                    $("#task_id").val(id);


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
