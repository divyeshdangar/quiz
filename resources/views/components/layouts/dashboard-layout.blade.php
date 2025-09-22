<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Links Of CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simplebar.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugin/jkanban/jkanban.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
    <link rel="stylesheet" href="{{ asset('assets/plugin/croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <?php
    $metaData = [
        'title' => '',
        'description' => '',
        'image' => '',
        'url' => '',
    ];
    ?>

    <x-common.meta :metaData="$metaData">
    </x-common.meta>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TWRDGF8');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TWRDGF8" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Start Preloader Area -->
    <div class="preloader" id="preloader">
        <div class="preloader">
            <div class="waviy position-relative">
                <span class="d-inline-block">G</span>
                <span class="d-inline-block">u</span>
                <span class="d-inline-block">j</span>
                <span class="d-inline-block">j</span>
                <span class="d-inline-block">u</span>
                <span class="d-inline-block">T</span>
                <span class="d-inline-block">i</span>
                <span class="d-inline-block">c</span>
                <span class="d-inline-block">k</span>
                <span class="d-inline-block">s</span>
            </div>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start Sidebar Area -->
    <div class="sidebar-area" id="sidebar-area">
        <div class="logo position-relative">
            <a href="{{ route('dashboard') }}" class="d-block text-decoration-none">
                <img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo-icon">
                <span class="logo-text fw-bold text-dark">{{ __('dashboard.sitename') }}</span>
            </a>
            <button
                class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y"
                id="sidebar-burger-menu">
                <i data-feather="x"></i>
            </button>
        </div>

        <aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
            <ul class="menu-inner">
                @use('App\Models\Menu', 'Menu')
                @php
                    $menuList = Menu::where('type', '2')->where('order', '>', 0);
                    
                    // Remove true once complete DB
                    if (true || Auth::user()->user_type == 1) {
                        // All Access
                    } else {
                        $in = [];
                        if (!empty(Auth::user()->menus)) {
                            $in = explode(',', Auth::user()->menus->menuIds);
                        }
                        $menuList = $menuList->whereIn('id', $in);
                    }
                    $menuList = $menuList->orderBy('order', 'ASC')->get();
                    $menu = $menuList;
                @endphp

                @if (isset($menu))
                    @if(count($menu) > 0)                        
                        @foreach ($menu as $m)
                            @if ($m['title_only'] == 1)
                                <li class="menu-title small text-uppercase">
                                    <span class="menu-title-text">{{ __($m['title']) }}</span>
                                </li>
                            @else
                                <li class="menu-item {{ Request::routeIs($m['route']) ? 'open' : '' }}">
                                    <a href="{{ route($m['route']) }}"
                                        class="menu-link {{ Request::routeIs($m['route']) ? 'active' : '' }}">
                                        <i data-feather="{{ $m['icon'] }}" class="menu-icon tf-icons"></i>
                                        <span class="title">{{ __($m['title']) }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @else
                        <li class="menu-item {{ Request::routeIs('home') ? 'open' : '' }}">
                            <a href="{{ route('home') }}"
                                class="menu-link {{ Request::routeIs('home') ? 'active' : '' }}">
                                <i data-feather="lock" class="menu-icon tf-icons"></i>
                                <span class="title">Request access</span>
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </aside>

        <div class="bg-white z-1 admin">
            <div class="d-flex align-items-center admin-info border-top">
                <div class="flex-shrink-0">
                    <a href="#" class="d-block">
                        <img src="{{ auth()->user()->profile() }}" class="rounded-circle wh-54" alt="admin">
                    </a>
                </div>
                <div class="flex-grow-1 ms-3 info">
                    @php
                        $name =
                            strlen(auth()->user()->name) > 10
                                ? substr(auth()->user()->name, 0, 10) . '...'
                                : auth()->user()->name;
                    @endphp
                    <a href="" class="d-block name">{{ $name }}</a>
                    <a href="{{ route('logout') }}">{{ __('dashboard.logout') }}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sidebar Area -->

    <!-- Start Main Content Area -->
    <div class="container-fluid">
        <div class="main-content d-flex flex-column">

            <!-- Start Header Area -->
            <header class="header-area bg-white mb-4 rounded-bottom-10" id="header-area">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-sm-6 col-md-4">
                        <div class="left-header-content">
                            <ul
                                class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-sm-start">
                                <li>
                                    <button class="header-burger-menu bg-transparent p-0 border-0"
                                        id="header-burger-menu">
                                        <i data-feather="menu"></i>
                                    </button>
                                </li>
                                <li>
                                    <form class="src-form position-relative">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="{{ __('dashboard.search_here') }}">
                                        <button type="submit"
                                            class="src-btn position-absolute top-50 end-0 translate-middle-y bg-transparent p-0 border-0">
                                            <i data-feather="search"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-8 col-sm-6 col-md-8">
                        <div class="right-header-content mt-2 mt-sm-0">
                            <ul
                                class="d-flex align-items-center justify-content-center justify-content-sm-end ps-0 mb-0 list-unstyled">
                                <li class="header-right-item">
                                    <div class="dropdown notifications language">
                                        <button class="btn btn-secondary border-0 p-0 position-relative"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="{{ asset('assets/images/india.png') }}"
                                                class="rounded-circle wh-22" alt="English">
                                        </button>
                                        <div class="dropdown-menu dropdown-lg p-0 border-0 p-4">
                                            <div class="notification-menu">
                                                <a href="{{ route('language', ['locale' => 'en']) }}"
                                                    class="dropdown-item p-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/india.png') }}"
                                                                class="wh-22 rounded-circle" alt="English">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4>English</h4>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="notification-menu">
                                                <a href="{{ route('language', ['locale' => 'hi']) }}"
                                                    class="dropdown-item p-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/india.png') }}"
                                                                class="wh-22 rounded-circle" alt="हिंदी">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4>हिंदी</h4>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="notification-menu mb-0">
                                                <a href="{{ route('language', ['locale' => 'gj']) }}"
                                                    class="dropdown-item p-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/india.png') }}"
                                                                class="wh-22 rounded-circle" alt="ગુજરાતી">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4>ગુજરાતી</h4>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                {{-- <li class="header-right-item">
                                    <div class="dropdown notifications email">
                                        <button class="btn btn-secondary border-0 p-0 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="mail"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg p-0 border-0 p-4">
                                            <h5 class="m-0 p-0 fw-bold d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                                                <span>{{ __('dashboard.message') }} </span>
                                                <button class="p-0 m-0 bg-transparent border-0">{{ __('dashboard.clear_all') }}</button>
                                            </h5>

                                            <div class="notification-menu">
                                                <a href="notification.html" class="dropdown-item p-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ asset('assets/images/pdf.svg') }}" alt="pdf">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h4>Help/Support Desk</h4>
                                                            <span>11:47 PM Wednesday</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <a href="notification.html" class="dropdown-item text-center text-primary d-block view-all pt-3 pb-0 fw-semibold">
                                                {{ __('dashboard.view_all') }}
                                                <i data-feather="chevron-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li> --}}
                                <li class="header-right-item">
                                    <div class="dropdown notifications noti">
                                        <a href=""
                                            class="btn btn-secondary border-0 p-0 position-relative badge">
                                            <i data-feather="bell"></i>
                                        </a>
                                    </div>
                                </li>
                                <li class="header-right-item d-none d-md-block">
                                    <div class="today-date">
                                        <span id="digitalDate"></span>
                                        <i data-feather="calendar"></i>
                                    </div>
                                </li>
                                <li class="header-right-item">
                                    <div class="dropdown admin-profile">
                                        <div class="d-xxl-flex align-items-center bg-transparent border-0 text-start p-0 cursor"
                                            data-bs-toggle="dropdown">
                                            <div class="flex-shrink-0">
                                                <img class="rounded-circle wh-54" src="{{ auth()->user()->profile() }}" alt="admin">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-none d-xxl-block">
                                                        <span class="degeneration">{{ __('dashboard.user') }}</span>
                                                        <div class="d-flex align-content-center">
                                                            <h3>{{ $name }}</h3>
                                                            <div class="down">
                                                                <i data-feather="chevron-down"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="dropdown-menu border-0 bg-white w-100 admin-link">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center text-body"
                                                    href="">
                                                    <i data-feather="user"></i>
                                                    <span class="ms-2">{{ __('dashboard.profile') }}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center text-body"
                                                    href="#">
                                                    <i data-feather="settings"></i>
                                                    <span class="ms-2">{{ __('dashboard.setting') }}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center text-body"
                                                    href="{{ route('logout') }}">
                                                    <i data-feather="log-out"></i>
                                                    <span class="ms-2">{{ __('dashboard.logout') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <!-- End Header Area -->

            <!-- Start Body Content Area -->
            {{ $slot }}
            <!-- End Body Content Area -->

            <div class="flex-grow-1"></div>

            <!-- Start Footer Area -->
            <footer class="footer-area bg-white text-center rounded-top-10">
                <p class="fs-14">© <span class="text-primary">{{ __('dashboard.sitename') }}</span> -
                    {{ __('dashboard.made_in') }}</p>
            </footer>
            <!-- End Footer Area -->
        </div>
    </div>
    <!-- Start Main Content Area -->

    <!-- Link Of JS File -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/dragdrop.js') }}"></script>
    <script src="{{ asset('assets/js/rangeslider.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/js/prism.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/amcharts.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/ecommerce-chart.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/profile.js') }}"></script> --}}
    <script src="{{ asset('assets/plugin/jkanban/jkanban.js') }}"></script>
    {{-- <script src="https://unpkg.com/fabric/dist/fabric.min.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/2.3.6/fabric.min.js"></script>

    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
            }
        }
    </script>
    <script type="text/javascript" src="{{ asset('assets/plugin/croppie/croppie.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
    <script>
        <?php 
            if(session('message')){ ?>
        var message = JSON.parse('<?php echo json_encode(session('message')); ?>');
        <?php }
        ?>
    </script>

    <script type="module">
        import {
            ClassicEditor,
            DecoupledEditor,
            Alignment,
            Autoformat,
            Bold,
            Italic,
            Strikethrough,
            Subscript,
            Superscript,
            Underline,
            BlockQuote,
            Base64UploadAdapter,
            CloudServices,
            CKBox,
            Essentials,
            FindAndReplace,
            FontBackgroundColor,
            FontColor,
            FontFamily,
            FontSize,
            Heading,
            HorizontalLine,
            Image,
            ImageCaption,
            ImageResize,
            ImageStyle,
            ImageToolbar,
            ImageUpload,
            PictureEditing,
            Indent,
            IndentBlock,
            Link,
            List,
            ListProperties,
            MediaEmbed,
            Mention,
            PageBreak,
            Paragraph,
            PasteFromOffice,
            RemoveFormat,
            SpecialCharacters,
            SpecialCharactersEssentials,
            Table,
            TableCaption,
            TableCellProperties,
            TableColumnResize,
            TableProperties,
            TableToolbar,
            TextTransformation,

        } from 'ckeditor5';

        if (document.querySelector('.ckeditor5')) {
            
            var cke_list = document.querySelectorAll('.ckeditor5'); // returns NodeList
            var ck_array = [...cke_list]; // converts NodeList to Array
            ck_array.forEach(ck => {
                ClassicEditor
                    .create(ck, {
                        plugins: [DecoupledEditor,
                            Alignment,
                            Autoformat,
                            Bold,
                            Italic,
                            Strikethrough,
                            Subscript,
                            Superscript,
                            Underline,
                            BlockQuote,
                            Base64UploadAdapter,
                            CloudServices,
                            CKBox,
                            Essentials,
                            FindAndReplace,
                            FontBackgroundColor,
                            FontColor,
                            FontFamily,
                            FontSize,
                            Heading,
                            HorizontalLine,
                            Image,
                            ImageCaption,
                            ImageResize,
                            ImageStyle,
                            ImageToolbar,
                            ImageUpload,
                            PictureEditing,
                            Indent,
                            IndentBlock,
                            Link,
                            List,
                            ListProperties,
                            MediaEmbed,
                            Mention,
                            PageBreak,
                            Paragraph,
                            PasteFromOffice,
                            RemoveFormat,
                            SpecialCharacters,
                            SpecialCharactersEssentials,
                            Table,
                            TableCaption,
                            TableCellProperties,
                            TableColumnResize,
                            TableProperties,
                            TableToolbar,
                            TextTransformation,
                        ],
                        toolbar: {
                            items: [
                                'undo', 'redo',
                                '|',
                                'heading',
                                '|',
                                'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                                '|',
                                'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                                '|',
                                'link', 'uploadImage', 'blockQuote', 'codeBlock',
                                '|',
                                'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
                            ],

                        }
                    })
                    .then(editor => {
                        window.editor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });

        }
    </script>
</body>

</html>
