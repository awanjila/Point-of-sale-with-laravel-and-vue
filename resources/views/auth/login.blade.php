<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Wabe Point" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
    <!-- icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="{{ asset('assets/js/head.js') }}"></script>
    <!-- toastr -->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    <!-- toastr -->
</head>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Left Section for Role Selection -->
            <div class="col-md-4 col-lg-4">
                <div class="card bg-pattern">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="text-dark-50 text-center mt-0 fw-bold">Select Role</h4>
                        </div>

                        <div class="d-grid gap-3">
                            <button class="btn btn-lg btn-primary" onclick="setRole('admin')">
                                <i class="fas fa-user-shield me-2"></i>Admin Login
                            </button>
                            <button class="btn btn-lg btn-info" onclick="setRole('server')">
                                <i class="fas fa-user-tie me-2"></i>Server Login
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted">Currently selected: <span id="selectedRole" class="fw-bold">None</span></p>
                        </div>

                        <div id="adminCredentials" class="credentials-info mt-4" style="display: none;">
                            <div class="alert alert-info" role="alert">
                                <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Admin Access</h5>
                                <p class="mb-0">Please use the username <strong>abemuchikan@gmail.com</strong> and the password <strong>W@njiras870</strong> to access all the features.</p>
                            </div>
                        </div>

                        <div id="serverCredentials" class="credentials-info mt-4" style="display: none;">
                            <div class="alert alert-info" role="alert">
                                <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Server Access</h5>
                                <p class="mb-0">Please use the username <strong>server@gmail.com</strong> and the password <strong>server1234</strong> to access server features.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Login Form -->
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo">
                                <a href="/" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="{{asset('assets/images/logo-dark.png')}}" alt="" height="100">
                                            </span>
                                </a>

                                <a href="/" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="22">
                                            </span>
                                </a>
                            </div>
                            <p class="text-muted mb-4 mt-3">Enter your Email/Phone/Name and password to access admin panel.</p>
                        </div>



                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="login" class="form-label">{{__('Email/Phone/Name')}}</label>
                                <input class="form-control @error('login') is-invalid @enderror" id="login" type="text" name="login" :value="old('login')" required autofocus>
                            @error('login')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>


                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{__('Password')}}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password"/>
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                                @error('login')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked name="remember">
                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>


                            <div class="text-center d-grid">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                                <button class="btn btn-primary" type="submit">  {{ __('Log in') }} </button>
                            </div>

                        </form>

                        

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p> <a href="auth-recoverpw.html" class="text-white-50 ms-1">Forgot your password?</a></p>
                        <p class="text-white-50">Don't have an account? <a href="{{route('register')}}" class="text-white ms-1"><b>Sign Up</b></a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>

<footer class="footer footer-alt">
    2023 - <script>document.write(new Date().getFullYear())</script> &copy; Easy by <a href="" class="text-white-50">Easylearning</a>
</footer>

<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch(type){
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;
        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;
        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;
        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
</script>

<script>
function setRole(role) {
    document.getElementById('selectedRole').textContent = role.charAt(0).toUpperCase() + role.slice(1);
    
    // Auto-fill credentials based on role
    const loginInput = document.getElementById('login');
    const passwordInput = document.getElementById('password');
    const adminCredentials = document.getElementById('adminCredentials');
    const serverCredentials = document.getElementById('serverCredentials');
    
    if (role === 'admin') {
        loginInput.value = 'abemuchikan@gmail.com';
        passwordInput.value = 'W@njiras870';
        adminCredentials.style.display = 'block';
        serverCredentials.style.display = 'none';
    } else if (role === 'server') {
        loginInput.value = 'server@gmail.com';
        passwordInput.value = 'server1234';
        adminCredentials.style.display = 'none';
        serverCredentials.style.display = 'block';
    }
    
    // Visual feedback for selected role
    document.querySelectorAll('.btn-primary, .btn-info').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}
</script>

<style>
/* Add these styles */
.btn-lg {
    padding: 15px 25px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.btn-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.btn.active {
    transform: scale(0.98);
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.card {
    border: none;
    box-shadow: 0 0 35px 0 rgba(154,161,171,.15);
}

/* Adjust spacing for the new layout */
.account-pages {
    margin-top: 3% !important;
}

.credentials-info {
    transition: all 0.3s ease;
}

.alert {
    border-radius: 8px;
    font-size: 0.9rem;
}

.alert-heading {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 8px;
}
</style>

</body>
</html>
