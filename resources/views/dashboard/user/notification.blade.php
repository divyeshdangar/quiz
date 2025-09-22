<x-layouts.dashboard-layout :showHeader="true" :metaData="$metaData">

    @if ($metaData['breadCrumb'])
        <x-common.breadcrumb :metaData="$metaData"></x-common.breadcrumb>
    @endif

    <div class="card bg-white border-0 rounded-10 mb-4">
        <div class="card-body p-4">
            <div class="d-sm-flex text-center justify-content-between align-items-center border-bottom pb-20 mb-20">
                <h4 class="fw-semibold fs-18 mb-sm-0">{{ __('dashboard.notification') }}</h4>
            </div>
           
            @if (count($dataList) > 0)
                <ul class="ps-0 mb-5 list-unstyled vertical-timeline">
                    @foreach ($dataList as $data)
                        <li>
                            <div class="d-flex align-items-start gap-3">
                                <img src="{{ asset('assets/images/arrow-right.svg') }}" class="bg-white py-1" alt="arrow-right">
                                <div>
                                    <h4 class="fs-18 fw-semibold mb-2">{!! $data->msg !!}</h4>
                                    <span class="text-gray-light d-block mb-2">{{ $data->created_at }}</span>
                                    <x-common.notification :detail="$data"></x-common.notification>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            {{ $dataList->links('vendor.pagination.bootstrap-5') }}
            @if (count($dataList) == 0)
                <x-common.empty></x-common.empty>
            @endif
        </div>
    </div>


</x-layouts.dashboard>