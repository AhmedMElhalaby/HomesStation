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
            <h5 class="panel-title"> {{ trans('dash.statistics.real_yearly_report') }} </h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>

            <br>

            <div class="row" style="font-size:18px">
                <div class="col-md-4">
                    <div class="alert alert-info">
                        <h4>{{ trans('dash.statistics.totaly_profits_this_year_for_provider',['year'=> $current_year],'ar') }} : </h4>
                        <h5>{{ $totaly_total_order_price }} {{ trans('dash.statistics.sr') }} </h5>
                    </div>
                </div>
                <div class="col-md-4">
                   <div class="alert alert-info">
                        <h4>{{ trans('dash.statistics.totaly_profits_this_year_for_delivery_price',['year'=> $current_year],'ar') }} : </h4>
                        <h5>{{ $totaly_delivery_price }} {{ trans('dash.statistics.sr') }} </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-info">
                        <h4>{{ trans('dash.statistics.totaly_profits_this_year_for_app_precentage',['year'=> $current_year],'ar') }} : </h4>
                        <h5>{{ $totaly_app_price_from_provider }} {{ trans('dash.statistics.sr') }} </h5>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-body">
                <div class="row">
                    <div class="col-md-7">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th> # {{ trans('dash.statistics.month') }} </th>
                                <th> {{ trans('dash.statistics.total_orders_price') }} </th>
                                <th> {{ trans('dash.delivery_price') }} </th>
                                <th> {{ trans('dash.app_precentage_from_provider') }} </th>
                                <th> {{ trans('dash.actions') }} </th>
                            </tr>
                            @foreach(array_reverse($yearly_report) as $report)
                                <tr>
                                    <td> #{{ trans('dash.statistics.month') }} {{ $report['month_number'] }} </td>
                                    <td> {{ $report['total_order_price']." ".trans('dash.statistics.sr') }} </td>
                                    <td> {{ $report['delivery_price']." ".trans('dash.statistics.sr') }} </td>
                                    <td> {{ $report['app_price_from_provider']." ".trans('dash.statistics.sr') }} </td>
                                    <td>
                                        <a class="btn btn-info btn_show_report_daily"
                                           data-original-title="{{ trans('dash.report')  }}"
                                           data-month="{{ $report['month_number'] }}" >
                                            <i class="icon-eye4"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        @for($year = date('Y')-10; $year <= date('Y'); $year++)
                        <a @if($current_year == $year) class="btn btn-danger" @else class="btn btn-primary" @endif href="{{ route('statistics.real_yearly') }}?other_year={{ $year }}"> {{ $year }} </a>
                        @endfor
                    </div>
                    <div class="col-md-5" id="report-daily">
                        <div class="table_report_daily_data"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
        $('.btn_show_report_daily').click(function () {
            var month = $(this).data('month');
            $.ajax({
                type: "get",
                url: 'yearly_days',
                data: {month: month},
                beforeSend: function (xhr) {
                    $(".table_report_daily_data").html('<center> <img src="{{ url('resources/assets/dashboard/material/assets/images/loader.gif') }}" /> </center>');
                },
                success: function (data) {
                    $("#report-daily").html(data).fadeIn();
                }
            });
        });
    </script>

@endsection
