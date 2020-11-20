<div class="table_report_daily_data">
    <table class="table table-bordered table-hover">
        <tr>
            <th> {{ trans('dash.day') }} </th>
            <th> {{ trans('dash.price') }} </th>
        </tr>
        @foreach($days as $day)
            <tr>
                <td> {{ $day }} </td>
                <td> {{ total_confirmed_orders_on_day($day) }} {{ trans('dash.sr') }} </td>
            </tr>
        @endforeach
    </table>
</div>