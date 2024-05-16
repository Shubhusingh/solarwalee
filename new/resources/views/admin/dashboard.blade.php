@extends('admin.layouts.app')
@section('panel')
 
   

    <div class="row gy-4">
   
      

        {{-- Deposit Widgets --}}

      

    

        {{-- Withdraw Widgets --}}

        

     

        {{-- Loan Widgets --}}

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_running_loan'] }}" title="Total Revenue" style=2 bg="white" color="indigo" icon="las la-hand-holding-usd" link="admin.loan.running" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_pending_loan'] }}" title="Pending Leads" style=2 bg="white" color="2" icon="las la-hand-holding-usd" link="admin.loan.pending" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_due_loan'] }}" title="Won Leads" style=2 bg="white" color="5" icon="las la-hand-holding-usd" link="admin.loan.due" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_paid_loan'] }}" title="Poorfit and Dead Leads
            " style=2 bg="white" color="success" icon="las la-hand-holding-usd" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- DPS Widgets --}}


    </div>


    

    @php
        $lastCron = Carbon\Carbon::parse($general->last_cron)->diffInSeconds();
    @endphp

    @if ($lastCron >= 900)
        @include('admin.partials.cron_instruction')
    @endif
    
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        barChart(
            document.querySelector("#monthly-dw-report"),
            `{{ __($general->cur_text) }}`,
            [{
                    name: 'Deposited',
                    data: @json(@$chartData['deposits'])
                },
                {
                    name: 'Withdraw',
                    data: @json(@$chartData['withdrawals'])
                }
            ],
            @json($months)
        );

        lineChart(
            document.querySelector("#transaction-report"),
            [{
                    name: "Plus Transactions",
                    data: @json(@$chartData['plus_trx'])
                },
                {
                    name: "Minus Transactions",
                    data: @json(@$chartData['minus_trx'])
                }
            ],
            @json(@$chartData['trx_dates'])
        );

        piChart(
            document.getElementById('userBrowserChart'),
            @json(@$chartData['user_browser_counter']->keys()),
            @json(@$chartData['user_browser_counter']->flatten())
        );

        piChart(
            document.getElementById('userOsChart'),
            @json(@$chartData['user_os_counter']->keys()),
            @json(@$chartData['user_os_counter']->flatten())
        );

        piChart(
            document.getElementById('userCountryChart'),
            @json(@$chartData['user_country_counter']->keys()),
            @json(@$chartData['user_country_counter']->flatten())
        );
    </script>
@endpush
