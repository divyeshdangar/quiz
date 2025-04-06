<x-layouts.simple-layout :showHeader="false" :metaData="$metaData">
    <div class="container-fluid">
        <div class="main-content d-flex flex-column px-0">
            <!-- Start Authentication Area -->
            <div class="m-auto mw-510 py-5">
                <form method="post" id="formToValidate" action="{{ route('login.post') }}">
                    {{ csrf_field() }}
                    <div class="d-flex align-items-center text-center gap-4 mb-3">
                        <h4 class="fs-3 mb-0 d-none">Login</h4>
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/logo/taxi-logo.png') }}" class="w-75" alt="logo">
                        </a>
                    </div>
                    <p class="fs-18 mb-5 text-center">Don’t have an account? Don't worry it will be created!</p>
                    <div class="d-sm-flex gap-3 mb-4">
                        <a href="" class="d-none btn btn-outline-primary fs-16 fw-semibold text-dark heading-fornt py-2 py-md-3 px-4 hover-white w-sm-100">
                            <img src="{{ asset('assets/images/google.svg') }}" alt="google">
                            <span class="ms-2">Sign In With Google</span>
                        </a>
                        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="It will be available soon!" class="d-none btn btn-primary fs-16 fw-semibold text-dark heading-fornt py-2 py-md-3 px-4 text-white w-sm-100 mt-3 mt-sm-0">
                            <img src="{{ asset('assets/images/facebook.svg') }}" alt="google">
                            <span class="ms-2">Sign In With Facebook</span>
                        </button>
                    </div>
                    <span class="d-none fs-18 fw-semibold text-center or mb-4">
                        <span class="bg-body-bg d-inline-block py-1 px-3">or</span>
                    </span>
                    <div class="card bg-white border-0 rounded-10 mb-4">
                        <div class="card-body p-4">
                            <div class="form-group mb-4">
                                <label class="label">Email</label>
                                <input type="email" name="email" class="form-control h-58" required placeholder="anything@info.com">
                            </div>
                            <div class="form-group mb-0">
                                <label class="label">Password</label>
                                <div class="form-group">
                                    <div class="password-wrapper position-relative">
                                        <input type="password" name="password" id="password" required class="form-control h-58 text-dark">
                                        <i style="color: #A9A9C8; font-size: 16px; right: 15px !important;" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 end-0 position-absolute" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-sm-flex justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input position-relative" style="top: 1.1px;" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label fs-16 text-gray-light" for="flexCheckDefault">
                                Remember me
                            </label>
                        </div>
                        <a href="" class="fs-16 text-primary text-decoration-none mt-2 mt-sm-0 d-block">
                            Forgot your password?
                        </a>
                    </div>
                    <button type="submit" class="btn btn-primary fs-16 fw-semibold text-dark heading-fornt py-2 py-md-3 px-4 text-white w-100">
                        Login
                    </button>
                </form>
            </div>
            <!-- End Authentication Area -->
        </div>
    </div>
</x-layouts.simple-layout>