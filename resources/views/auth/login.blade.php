<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
    <!-- icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    @vite('resources/js/app.js')
</head>
<body class="authentication-bg">
    <div id="app" class="account-pages">
        <div class="container-fluid p-0">
            <div class="row g-0 min-vh-100">
                <!-- Left Side - Introduction -->
                <div class="col-md-5 bg-primary-subtle">
                    <div class="d-flex flex-column h-100 p-5">
                        <div class="my-auto">
                            <img src="/assets/images/logo-dark.png" alt="logo" class="mb-5" height="100" style="max-width: 350px; object-fit: contain;">
                            <h1 class="text-primary fw-bold mb-4">Welcome to Our POS System</h1>
                            <p class="lead text-muted mb-4">
                                Streamline your business operations with our modern point of sale solution.
                                Secure, fast, and efficient.
                            </p>
                            <div class="corporate-features">
                                <div class="feature-item mb-3">
                                    <i class="fas fa-shield-alt text-primary me-2"></i>
                                    <span>Enterprise-grade security</span>
                                </div>
                                <div class="feature-item mb-3">
                                    <i class="fas fa-tachometer-alt text-primary me-2"></i>
                                    <span>Lightning-fast transactions</span>
                                </div>
                                <div class="feature-item mb-3">
                                    <i class="fas fa-chart-line text-primary me-2"></i>
                                    <span>Real-time analytics</span>
                                </div>
                            </div>
                        </div>
                        <footer class="text-muted">
                            <small>&copy; 2024 Your Company. All rights reserved.</small>
                        </footer>
                    </div>
                </div>

                <!-- Right Side - Login Component -->
                <div class="col-md-7 bg-white">
                    <div class="d-flex align-items-center h-100">
                        <div class="w-100 p-4">
                            <pin-login-component></pin-login-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .authentication-bg {
            background-color: #f8f9fa;
        }
        
        .corporate-features .feature-item {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            color: #495057;
        }

        .bg-primary-subtle {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .min-vh-100 {
            min-height: 100vh;
        }
    </style>

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    
    <!-- Toastr -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
