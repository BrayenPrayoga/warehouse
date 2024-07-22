<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5" style="text-align:center;">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/images/logo.png') }}" style="width:200px;">
                            </div>
                            <h6 class="font-weight-light">Reset Password.</h6>
                            <div id="alert-div">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible" style="max-width:100%!important">
                                        <strong>Error!</strong> {{ $error }}
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <form class="pt-3" method="POST" action="{{ route('update-password') }}">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{ $user->id }}">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="email" name="email"
                                        autocomplete="off" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="password" name="password" autocomplete="off" placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="confirm_password" name="confirm_password" autocomplete="off" placeholder="Confirm Password">
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">RESET</button>
                                </div>
                                {{-- <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                    </div>
                                    <a href="#" class="auth-link text-black">Lupa Password?</a>
                                </div> --}}
                                {{-- <div class="text-center mt-4 font-weight-light"> Tidak Punya Akun? <a
                                        href="register.html" class="text-primary">Buat</a>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script>
        setTimeout(function() {document.getElementById('alert-div').innerHTML='';},5000);
    </script>
    <!-- endinject -->
</body>

</html>