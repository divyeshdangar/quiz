<x-layouts.dashboard-layout :showHeader="true" :metaData="$metaData">

    @if ($metaData['breadCrumb'])
        <x-common.breadcrumb :metaData="$metaData"></x-common.breadcrumb>
    @endif

    <div class="card bg-white border-0 rounded-10 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                <h4 class="fw-semibold fs-18 mb-0">{{ __('dashboard.basic_info') }}</h4>
                <div class="dropdown action-opt">
                    <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-feather="more-horizontal"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('dashboard.task.edit', ['id' => $dataDetail->id]) }}">
                                <i data-feather="edit-3"></i>
                                {{ __('dashboard.edit') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <a target="_blank" href="{{ URL::asset('/images/task/' . $dataDetail->image) }}">
                        <img src="{{ URL::asset('/images/task/' . $dataDetail->image) }}" class="img-fluid rounded-10 mb-4">
                    </a>
                    <h4 class="fs-15 fw-semibold">{{ __('dashboard.meta_description') }}:</h4>
                    <p class="mb-4">{!! $dataDetail->meta_description !!}</p>
                    <ul class="ps-0 mb-0 list-unstyled">
                        <li class="border-bottom border-color-gray mb-3 pb-3">
                            <span class="fw-semibold text-dark w-130 d-inline-block">{{ __('dashboard.date') }}:</span>
                            <span>{{ $dataDetail->created_at->format('j F, Y') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-7">
                    <h4 class="fs-15 fw-semibold">{{ __('dashboard.description') }}:</h4>
                    <p class="mb-4">{!! $dataDetail->description !!}</p>
                </div>
            </div>
        </div>
    </div>

</x-layouts.dashboard>
