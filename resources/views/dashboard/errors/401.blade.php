@extends('dashboard.layout')
@section('script')
	<script type="text/javascript" src="{{ url('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
@endsection
@section('content')

<br> <br> 
<div class="text-center content-group">
    <h1 class="error-title">401</h1>
    <h5> {{ trans('dash.401') }}  </h5>
</div>


@endsection