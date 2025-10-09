<x-layouts.dashboard-layout :showHeader="true" :metaData="$metaData">

    <style>
        .cr-boundary {
            border-radius: 15px;
        }
    </style>

    <div class="d-sm-flex text-center justify-content-between align-items-center mb-4">
        <h3 class="mb-sm-0 mb-1 fs-18">{{ __('dashboard.task') }}</h3>
        <ul class="ps-0 mb-0 list-unstyled d-flex justify-content-center">
            <li>
                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                    <i class="ri-home-2-line" style="position: relative; top: -1px;"></i>
                    <span>{{ __('dashboard.home') }}</span>
                </a>
            </li>
            <li>
                <span class="fw-semibold fs-14 heading-font text-dark dot ms-2">{{ __('dashboard.task') }}</span>
            </li>
        </ul>
    </div>

    <form method="post" id="formToValidate"
        action="{{ route('dashboard.task.edit.post', ['id' => encrypt($dataDetail->id)]) }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-8">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card bg-white border-0 rounded-10 mb-4">
                            <div class="card-body p-4">
                                <h4 class="fw-semibold fs-18 border-bottom pb-20 mb-20">{{ __('dashboard.task') }}</h4>
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

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label
                                                class="label @error('title') text-danger @enderror">{{ __('dashboard.title') }}</label>
                                            <div class="form-group position-relative">
                                                <input type="text" name="title"
                                                    class="form-control text-dark ps-5 h-58 @error('title') border border-danger rounded-3 border-3 @enderror"
                                                    value="{{ old('title', $dataDetail->title) }}"
                                                    placeholder="{{ __('dashboard.title') }}" required>
                                                <i
                                                    class="ri-pencil-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                            </div>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <label
                                                class="label @error('code') text-danger @enderror">{{ __('dashboard.code') }}</label>
                                            <div class="form-group position-relative">
                                                <input type="text" name="code"
                                                    class="form-control text-dark ps-5 h-58 @error('code') border border-danger rounded-3 border-3 @enderror"
                                                    value="{{ old('code', $dataDetail->code) }}"
                                                    placeholder="{{ __('dashboard.code') }}" required>
                                                <i
                                                    class="ri-pencil-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                            </div>
                                            @error('code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <label
                                                class="label @error('task_category_id') text-danger @enderror">{{ __('dashboard.task_category') }}</label>
                                            <div class="form-group position-relative">
                                                <select class="form-select form-control ps-5 h-58"
                                                    name="task_category_id" required
                                                    aria-label="Parent category selection">
                                                    <option class="text-dark">{{ __('dashboard.select') }}
                                                        {{ __('dashboard.task_category') }}</option>
                                                    @foreach ($categoryData as $data)
                                                        <option value="{{ $data->id }}" class="text-dark"
                                                            @if ($data->id == old('task_category_id', $dataDetail->task_category_id)) selected="selected" @endif>
                                                            {{ $data->title }}</option>
                                                    @endforeach
                                                </select>
                                                <i
                                                    class="ri-article-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                            </div>
                                            @error('task_category_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4" id="imageFormGroup">
                                            <label
                                                class="label @error('slug') text-danger @enderror">{{ __('dashboard.image') }}</label>
                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*">
                                            <input type="hidden" id="croppedImage" name="croppedImage" value="">
                                        </div>
                                        <div id="upload-image-image"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="label">{{ __('dashboard.is_timebase') }}</label>
                                            <div class="form-group position-relative ps-5 d-flex align-items-center border rounded-3"
                                                style="height: 58px;">
                                                <input type="checkbox" name="is_timebase" id="is_timebase"
                                                    class="form-check-input position-absolute start-0 ms-3"
                                                    {{ old('is_timebase', $dataDetail->is_timebase) ? 'checked' : '' }}>
                                                <label for="is_timebase" class="form-check-label ms-5 text-dark mb-0">
                                                    {{ __('dashboard.is_timebase') }}
                                                </label>
                                            </div>
                                            @error('is_timebase')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label
                                                class="label @error('total_time') text-danger @enderror">{{ __('dashboard.total_time') . ' (' . __('dashboard.in_minutes') . ')' }}</label>
                                            <div class="form-group position-relative">
                                                <input type="number" name="total_time"
                                                    class="form-control text-dark ps-5 h-58 @error('total_time') border border-danger rounded-3 border-3 @enderror"
                                                    value="{{ old('total_time', $dataDetail->total_time) }}"
                                                    placeholder="{{ __('dashboard.total_time') }}" required>
                                                <i
                                                    class="ri-pencil-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                            </div>
                                            @error('total_time')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-4">
                                            <label class="label">{{ __('dashboard.is_individual') }}</label>
                                            <div class="form-group position-relative ps-5 d-flex align-items-center border rounded-3"
                                                style="height: 58px;">
                                                <input type="checkbox" name="is_individual" id="is_individual"
                                                    class="form-check-input position-absolute start-0 ms-3"
                                                    {{ old('is_individual', $dataDetail->is_individual) ? 'checked' : '' }}>
                                                <label for="is_individual" class="form-check-label ms-5 text-dark mb-0">
                                                    {{ __('dashboard.is_individual') }}
                                                </label>
                                            </div>
                                            @error('is_individual')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-4">
                                            <label
                                                class="label @error('description') text-danger @enderror">{{ __('dashboard.description') }}</label>
                                            <div class="form-group position-relative">
                                                <textarea id="description" name="description"
                                                    class="form-control text-dark ckeditor5  @error('description') border border-danger rounded-3 border-3 @enderror"
                                                    placeholder="{{ __('dashboard.description') }}" cols="30" rows="7">{{ old('description', $dataDetail->description) }}</textarea>
                                            </div>
                                            @error('description')
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-white border-0 rounded-10 mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-semibold fs-18 border-bottom pb-20 mb-20">{{ __('dashboard.location') }}</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label
                                        class="label @error('category_id') text-danger @enderror">{{ __('dashboard.task_category') }}</label>
                                    <div class="form-group position-relative">
                                        <select class="form-select form-control ps-5 h-58" name="category_id" required
                                            aria-label="Parent category selection">
                                            <option class="text-dark">{{ __('dashboard.select') }}
                                                {{ __('dashboard.task_category') }}</option>
                                            @foreach ($categoryData as $data)
                                                <option value="{{ $data->id }}" class="text-dark"
                                                    @if ($data->id == old('category_id', $dataDetail->category_id)) selected="selected" @endif>
                                                    {{ $data->title }}</option>
                                            @endforeach
                                        </select>
                                        <i
                                            class="ri-article-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                    </div>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-white border-0 rounded-10 mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-semibold fs-18 border-bottom pb-20 mb-20">{{ __('dashboard.task') }}
                            {{ __('dashboard.image') }}</h4>
                        <img src="{{ URL::asset('/images/task/' . $dataDetail->image) }}" class="img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        var $image_crop;
        var $banner_crop;
        var isImageSelected = false;
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
                if (resp && isImageSelected) {
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
                    width: 192,
                    height: 108,
                    type: 'square'
                },
                boundary: {
                    width: $("#imageFormGroup").width(),
                    height: $("#imageFormGroup").width() / 2
                },
                //url: '{{ URL::asset('/images/task/' . $dataDetail->image) }}'
            });
            $('#image').on('change', function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $image_crop.croppie('bind', {
                        url: e.target.result
                    }).then(function() {
                        isImageSelected = true;
                    });
                }
                reader.readAsDataURL(this.files[0]);
            });
        }
    </script>

    </x-layouts.dashboard>
