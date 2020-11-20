<div class="table_report_daily_data">
    <table class="table table-bordered table-hover">
        <tr>
            <th> {{ trans('dash.statistics.day') }} </th>
            <th> {{ trans('dash.statistics.total_orders_price') }} </th>
            <th> {{ trans('dash.delivery_price') }} </th>
            <th> {{ trans('dash.app_precentage_from_provider') }} </th>
        </tr>
        @foreach($days as $day)
            <tr>
                <td> {{ $day }} </td>
                <td> {{ total_order_profit($day, 'total_order_price') }} {{ trans('dash.statistics.sr') }} </td>
                <td> {{ total_order_profit($day, 'delivery_price') }} {{ trans('dash.statistics.sr') }} </td>
                <td> {{ total_order_profit($day, 'app_price_from_provider') }} {{ trans('dash.statistics.sr') }} </td>
            </tr>
        @endforeach
    </table>
</div>