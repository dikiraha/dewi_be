<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>DEWI &mdash; Login</title>

    <meta name="description" content="" />

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-dewi.png') }}" />
    <link href="{{ asset('img/logo-dewi.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('fonts/inter/fonts.css') }}" />

    <link rel="stylesheet" href="{{ asset('vendor/materio/assets/vendor/fonts/materialdesignicons.css') }}">

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('vendor/materio/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/materio/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('vendor/materio/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('vendor/materio/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('vendor/materio/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('vendor/materio/assets/vendor/css/pages/page-auth.css') }}" />

    <style>
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- Helpers -->
    <script src="{{ asset('vendor/materio/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('vendor/materio/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-4">
                        <a href="{{ route('website.auth.login') }}" class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-heading fw-semibold"
                                style="color: #3f51b5 !important; font-size: 36px;">DEWI</span>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <div class="card-body mt-2">
                        <h4 class="mb-5 text-center">Digital E-Procurement With Integrity</h4>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="formAuthentication" class="mb-3" method="post"
                            action="{{ route('website.auth.login') }}">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email anda" autofocus required />
                                <label for="email">Email</label>
                            </div>
                            <div class="mb-5">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                            <label for="password">Password</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i
                                                class="mdi mdi-eye-off-outline"></i></span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="mb-3 d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                                <a href="auth-forgot-password-basic.html" class="float-end mb-1">
                                    <span>Forgot Password?</span>
                                </a>
                            </div> --}}
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" id="loginButton" type="submit">Sign
                                    in</button>
                            </div>
                        </form>

                        {{-- <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="auth-register-basic.html">
                                <span>Create an account</span>
                            </a>
                        </p> --}}
                    </div>
                </div>
                <!-- /Login -->
                <img src="{{ asset('vendor/materio/assets/img/illustrations/tree-3.png') }}" alt="auth-tree"
                    class="authentication-image-object-left d-none d-lg-block" />
                <img src="{{ asset('vendor/materio/assets/img/illustrations/auth-basic-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block" alt="triangle-bg"
                    data-app-light-img="illustrations/auth-basic-mask-light.png"
                    data-app-dark-img="illustrations/auth-basic-mask-dark.png" />
                <img src="{{ asset('vendor/materio/assets/img/illustrations/tree.png') }}" alt="auth-tree"
                    class="authentication-image-object-right d-none d-lg-block" />
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('vendor/materio/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/materio/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendor/materio/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendor/materio/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('vendor/materio/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendor/materio/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('vendor/materio/assets/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="{{ asset('vendor/github/buttons.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('formAuthentication');
            var loginButton = document.getElementById('loginButton');
            var spinner = '<i class="mdi mdi-loading spin"></i>';

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    event.preventDefault();
                } else {
                    loginButton.setAttribute('disabled', 'true');
                    loginButton.innerHTML = spinner;
                }
            });

            form.addEventListener('input', function() {
                if (form.checkValidity()) {
                    loginButton.removeAttribute('disabled');
                }
            });
        });
    </script>
</body>

</html>
