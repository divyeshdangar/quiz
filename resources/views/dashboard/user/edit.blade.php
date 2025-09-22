<x-layouts.dashboard-layout :showHeader="true" :metaData="$metaData">

    @if ($metaData['breadCrumb'])
        <x-common.breadcrumb :metaData="$metaData"></x-common.breadcrumb>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-semibold fs-18 border-bottom pb-20 mb-20">{{ __('dashboard.user') }}</h4>
                    @if ($errors->any())
                        <div class="text-danger border border-danger border-4 p-3 rounded-3 mb-3">
                            <b>{{ __('dashboard.error') }}:</b>
                            <hr>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" id="formToValidate" action="{{ route('dashboard.user.edit.post', ['id' => $dataDetail->id]) }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">


                                <div class="form-group mb-4">
                                    <label class="label">{{ __('dashboard.image') }}</label>
                                    <div class="form-group position-relative">
                                        <img src="{{ auth()->user()->profile() }}" class="rounded-4 ms-3 ms-lg-0" alt="product">
                                    </div>
                                </div>

                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label
                                        class="label @error('name') text-danger @enderror">{{ __('dashboard.name') }}</label>
                                    <div class="form-group position-relative">
                                        <input type="text" name="name"
                                            class="form-control text-dark ps-5 h-58 @error('name') border border-danger rounded-3 border-3 @enderror"
                                            value="{{ old('name', $dataDetail->name) }}"
                                            placeholder="{{ __('dashboard.name') }}" readonly>
                                        <i
                                            class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label
                                        class="label @error('email') text-danger @enderror">{{ __('dashboard.email') }}</label>
                                    <div class="form-group position-relative">
                                        <input type="email" name="email"
                                            class="form-control text-dark ps-5 h-58 @error('email') border border-danger rounded-3 border-3 @enderror"
                                            value="{{ old('email', $dataDetail->email) }}"
                                            placeholder="{{ __('dashboard.email') }}" readonly>
                                        <i
                                            class="ri-mail-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                    </div>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label
                                        class="label @error('phone') text-danger @enderror">{{ __('dashboard.phone') }}</label>
                                    <div class="form-group position-relative">
                                        <input type="tel" id="phone" name="phone" maxlength="10"
                                            class="form-control text-dark ps-5 h-58 @error('phone') border border-danger rounded-3 border-3 @enderror"
                                            value="{{ old('phone', $dataDetail->phone) }}"
                                            placeholder="{{ __('dashboard.phone') }}" required>
                                        <i
                                            class="ri-phone-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                    </div>
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group d-flex gap-3">
                                    <button
                                        class="btn btn-primary py-3 px-5 fw-semibold text-white">{{ __('dashboard.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-semibold fs-18 border-bottom pb-20 mb-20">{{ __('dashboard.user') }}</h4>
                    @if ($errors->any())
                        <div class="text-danger border border-danger border-4 p-3 rounded-3 mb-3">
                            <b>{{ __('dashboard.error') }}:</b>
                            <hr>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" id="formToValidate" action="{{ route('dashboard.user.access', ['id' => $dataDetail->id]) }}">
                        {{ csrf_field() }}
                        <ul class="list-group">
                            @php
                                $userMenus = !empty($dataDetail->menus) ? (strlen($dataDetail->menus->menuIds) > 0 ? explode(",", $dataDetail->menus->menuIds) : []) : [];
                            @endphp
                            @foreach ($menuList as $menu)
                                <li class="list-group-item bg-white">
                                    <input class="form-check-input me-1" 
                                        @if(in_array($menu->id, $userMenus)) {{ 'checked' }} @endif
                                        type="checkbox" name="menuIds[]" value="{{ $menu->id }}" id="menu_{{ $menu->id }}">
                                    <label class="form-check-label" for="menu_{{ $menu->id }}">{{ __($menu->title) }}</label>
                                </li>
                            @endforeach
                        </ul>
                        <div class="form-group d-flex gap-3">
                            <button type="submit" class="btn btn-primary fw-semibold w-100 text-white py-2 px-4 mt-3">{{ __('dashboard.save') }} {{ __('dashboard.access') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var $image_crop;
        window.addEventListener('load', function(event) {
            addCropperImage();
            $("#formToValidate").submit(function(eventObj) {
                getImage();
                return true;
            });
        });

        function getImage() {
            $('#upload-image-image').croppie('result', {
                type: 'base64',
                format: 'jpeg',
                quality: 0.7
            }).then(function(resp) {
                if (resp) {
                    $("#croppedImage").val(resp)
                } else {
                    $("#croppedImage").val("")
                }
            });
        }

        function addCropperImage() {
            $image_crop = $('#upload-image-image').croppie({
                //enableExif: true,
                enableResize: true,
                viewport: {
                    width: 240,
                    height: 80,
                    type: 'square'
                },
                boundary: {
                    width: $("#imageFormGroup").width(),
                    height: $("#imageFormGroup").width() / 2
                },
                url: '{{ URL::asset('/images/blog/' . $dataDetail->image) }}'
            });
            $('#image').on('change', function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $image_crop.croppie('bind', {
                        url: e.target.result
                    }).then(function() {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
            });
        }
    </script>

</x-layouts.dashboard>
