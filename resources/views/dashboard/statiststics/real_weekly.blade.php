{{-- Created by Programmer : Mohamed Elsherbiny --}}
{{-- Nickname: elsherbiny28 --}}
{{-- Email: elsherbiny28@icloud.com --}}
{{-- Whatsapp 00201008414435 --}}

@extends('dashboard.layout')

@section('script')
    <script type="text/javascript" src="{{ url('resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="{{ url('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="{{ url('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
    <script type="text/javascript" src="{{ url('resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>
    <script type="text/javascript" src="{{ url('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
@endsection

@section('content')
    <div class="panel panel-flat tb_padd">
        <div class="panel-heading">
            <h5 class="panel-title"> {{ trans('dash.statistics.real_weakly_report') }} </h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
            <br>
            <div class="panel panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th> # {{ trans('dash.statistics.week') }} </th>
                                <th> {{ trans('dash.statistics.from') }} </th>
                                <th> {{ trans('dash.statistics.to') }} </th>
                                <th> {{ trans('dash.statistics.total_orders_price') }} </th>
                                <th> {{ trans('dash.delivery_price') }} </th>
                                <th> {{ trans('dash.app_precentage_from_provider') }} </th>
                                <th> {{ trans('dash.actions') }} </th>
                            </tr>
                            @foreach(array_reverse($weekly_report) as $report)
                                <tr>
                                    <td> #{{ trans('dash.statistics.week') }} {{ $report['week_number'] }} </td>
                                    <td> {{ $report['start_day_of_week'] }} </td>
                                    <td> {{ $report['end_day_of_week'] }} </td>
                                    <td> {{ $report['total_order_price']." ".trans('dash.statistics.sr') }} </td>
                                    <td> {{ $report['delivery_price']." ".trans('dash.statistics.sr') }} </td>
                                    <td> {{ $report['app_precentage_from_provider']." ".trans('dash.statistics.sr') }} </td>
                                    <td>
                                        <a class="btn btn-info btn_show_report_daily"
                                           data-original-title="{{ trans('dash.statistics.report')  }}"
                                           data-from="{{ $report['start_day_of_week'] }}"
                                           data-to="{{ $report['end_day_of_week'] }}">
                                            <i class="icon-eye4"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-4" id="report-daily">
                        <div class="table_report_daily_data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.btn_show_report_daily').click(function () {
            var from = $(this).data('from');
            var to = $(this).data('to');
            $.ajax({
                type: "get",
                url: 'weekly_days',
                data: {from: from, to: to},
                beforeSend: function (xhr) {
                    $(".table_report_daily_data").html('<center> <img src="{{ url('resources/assets/dashboard/material') }}/assets/images/loader.gif" /> </center>');
                },
                success: function (data) {
                    $("#report-daily").html(data).fadeIn();
                }
            });
        });
    </script>
@endsection
