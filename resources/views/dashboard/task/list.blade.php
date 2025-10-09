<x-layouts.dashboard-layout :showHeader="true" :metaData="$metaData">

    @if ($metaData['breadCrumb'])
        <x-common.breadcrumb :metaData="$metaData"></x-common.breadcrumb>
    @endif

    <div class="card bg-white border-0 rounded-10 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                <h4 class="fw-semibold fs-18 mb-0">{{ $dataDetail->title }}</h4>
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
                
            </div>
        </div>
    </div>

</x-layouts.dashboard>
