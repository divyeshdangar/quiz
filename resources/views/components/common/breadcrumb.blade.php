<div class="d-sm-flex text-center justify-content-between align-items-center mb-4">
    @if (!isset($metaData['no_title']))
        <h3 class="mb-sm-0 mb-1 fs-18">{{ $metaData['title'] }}</h3>
    @endif
    <ul class="ps-0 mb-0 list-unstyled d-flex justify-content-center">
        <li>
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <i class="ri-home-2-line" style="position: relative; top: -1px;"></i>
                <span>{{ __('dashboard.home') }}</span>
            </a>
        </li>
        @if ($metaData['breadCrumb'])
            @foreach ($metaData['breadCrumb'] as $bc)
                @if (trim($bc['route']) != '')
                    <li>
                        <span class="fw-semibold fs-14 heading-font text-dark dot ms-2">
                            <a href="{{ route($bc['route']) }}" class="text-decoration-none">
                                {{ $bc['title'] }}
                            </a>
                        </span>
                    </li>
                @else
                    <li>
                        <span class="fw-semibold fs-14 heading-font text-dark dot ms-2">{{ $bc['title'] }}</span>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
