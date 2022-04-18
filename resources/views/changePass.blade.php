<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Change Password</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

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
                <div class="row">
                    <div class="col-md-7 m-auto">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Change password</h1>
                            </div>
                            <form class="user" action="{{ url('/changePasword') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ $id }}" name="id">
                                <div class="form-group">
                                    <input name="pass" type="password" class="form-control form-control-user" id="exampleInputEmail"
                                           placeholder="Enter Last Passowrd" value="">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="npass" type="password" class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="New Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="cpass" type="password" class="form-control form-control-user"
                                               id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
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
                                    <div class="alert alert-warning">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <button class="btn btn-primary btn-user btn-block">
                                    Change
                                </button>
                                <hr>
                                {{--                                <a href="index.html" class="btn btn-google btn-user btn-block">--}}
                                {{--                                    <i class="fab fa-google fa-fw"></i> Register with Google--}}
                                {{--                                </a>--}}
                                {{--                                <a href="index.html" class="btn btn-facebook btn-user btn-block">--}}
                                {{--                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook--}}
                                {{--                                </a>--}}
                            </form>
{{--                            <hr>--}}
{{--                            <div class="text-center">--}}
{{--                                <a class="small" href="{{ url('/changePass') }}">Change Password!</a>--}}
{{--                            </div>--}}
                            {{--                            <div class="text-center">--}}
                            {{--                                <a class="small" href="login.html">Already have an account? Login!</a>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

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
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>
