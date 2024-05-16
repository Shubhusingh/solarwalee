<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'user/css/icon-moon.css') }}" />
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'user/css/main.css') }}" />
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">
    @stack('style-lib')
    @stack('style')
    <link href="{{ asset($activeTemplateTrue . 'user/css/color.php?color=' . $general->base_color . '&secondColor=' . $general->secondary_color) }}" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="loader-p"></div>
    </div>
    <div class="body-overlay"></div>
    <div class="sidebar-overlay"></div>

    <div class="dashboard position-relative">
        <div class="dashboard__inner flex-wrap">
            @include($activeTemplate . 'partials.sidenav')
            <div class="dashboard__right">
                @include($activeTemplate . 'partials.dashboard_header')
                <div class="dashboard-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @stack('modal')

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/jquery.validate.js') }}"></script>
    @stack('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'user/js/main.js') }}"></script>

    @stack('script')
    @include('partials.plugins')
    @include('partials.notify')
    @include('partials.user_activity')

    <script>
        "use strict";
        (function($) {

            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            $('form').on('submit', function() {
                if ($(this).valid()) {
                    $(':submit', this).attr('disabled', 'disabled');
                }
            });

            var inputElements = $('[type=text],[type=password],select,textarea');

            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox' && element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            });

            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });

            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((column, i) => {
                        (column.colSpan == 100) || column.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });

        })(jQuery);
    </script>
</body>

</html>
