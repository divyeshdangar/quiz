<x-layouts.dashboard-layout :showHeader="true" :metaData="$metaData">

    <div class="d-sm-flex text-center justify-content-between align-items-center mb-4">
        <h3 class="mb-sm-0 mb-1 fs-18">{{ __('dashboard.profile') }}</h3>
        <ul class="ps-0 mb-0 list-unstyled d-flex justify-content-center">
            <li>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                    <i class="ri-home-2-line" style="position: relative; top: -1px;"></i>
                    <span>{{ __('dashboard.home') }}</span>
                </a>
            </li>
            <li>
                <span class="fw-semibold fs-14 heading-font text-dark dot ms-2">{{ __('dashboard.profile') }}</span>
            </li>
        </ul>
    </div>

    <div class="row justify-content-center">


        <div class="col-xxl-4 col-sm-12">
            <div class="welcome-farol card bg-primary border-0 rounded-0 rounded-top-3 position-relative">
                <div class="card-body p-4 pb-5 my-2">
                    <div class="mw-350">
                        <h3 class="text-white fw-semibold fs-20 mb-2">{{ __('dashboard.welcome') }}</h3>
                        <p class="text-white fs-15">{{ __('dashboard.welcome_desc') }}</p>
                    </div>
                </div>

                <img src="{{ asset('assets/images/welcome-shape.png') }}" class="position-absolute bottom-0 end-0" style="right: 10px !important; bottom: 10px !important;" alt="welcome-shape">
            </div>
            <div class="stats-box style-eight bg-white card border-0 rounded-0 rounded-bottom-3 mb-4">
                <div class="card-body p-4 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="profile-img">
                            <img src="{{ auth()->user()->profile() }}" class="rounded-circle border border-2 border-white wh-57 mb-4" alt="user">
                            <h4 class="fs-16 fw-semibold mb-1">{{ ucwords(auth()->user()->name) }}</h4>
                            <span class="fs-14">{{ __('dashboard.user') }}</span>
                        </div>
                        <div class="text-end">
                            <div id="impression_share"></div>
                            <span class="fs-14 fw-semibold mt-minus d-block">{{ __('dashboard.profile_pending') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                        <h4 class="fw-semibold fs-18 mb-0">{{ __('dashboard.personal_information') }}</h4>
                        <div class="dropdown action-opt">
                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="more-horizontal"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.profile.edit') }}">
                                        <i data-feather="edit"></i>
                                        {{ __('dashboard.edit') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <h4 class="fs-15 fw-semibold">{{ __('dashboard.about_me') }} :</h4>
                    <p class="mb-4">
                        {{ auth()->user()->bio }}
                    </p>
                    <ul class="ps-0 mb-0 list-unstyled">
                        <li class="border-bottom border-color-gray mb-3 pb-3">
                            <span class="fw-semibold text-dark w-130 d-inline-block">{{ __('dashboard.full_name') }} :</span>
                            <span>{{ auth()->user()->name }}</span>
                        </li>
                        <li class="border-bottom border-color-gray mb-3 pb-3">
                            <span class="fw-semibold text-dark w-130 d-inline-block">{{ __('dashboard.mobile') }} :</span>
                            <a href="tel:{{ auth()->user()->phone }}" class="text-decoration-none">{{ auth()->user()->phone }}</a>
                        </li>
                        <li class="border-bottom border-color-gray mb-3 pb-3">
                            <span class="fw-semibold text-dark w-130 d-inline-block">{{ __('dashboard.email') }} :</span>
                            <a href="mailto:{{ auth()->user()->email }}" class="text-decoration-none">{{ auth()->user()->email }}</a>
                        </li>
                        <li class="border-bottom border-color-gray mb-3 pb-3">
                            <span class="fw-semibold text-dark w-130 d-inline-block">{{ __('dashboard.username') }} :</span>
                            <span class="text-success">{{ auth()->user()->username }}</span>
                        </li>
                        <li>
                            <span class="fw-semibold text-dark w-130 d-inline-block">{{ __('dashboard.joined') }} :</span>
                            <span>{{ auth()->user()->created_at }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



   </div>

</x-layouts.dashboard>