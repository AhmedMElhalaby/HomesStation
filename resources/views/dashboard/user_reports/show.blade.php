@extends('dashboard.layout')

@section('script')
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="panel text-center">
            <div class="panel-heading">
                <h5 class="panel-title">صاحب البلاغ</h5>
                <img src="{{ $user_report->User->profile_image }}" class="img-thumbnail" alt="Cinque Terre">
            </div>
            <div class="panel-body">
                <h5 class="user-name">{{ $user_report->User->username }}</h5>
                <a class="btn" href="{{ route('user.show', $user_report->user_id) }}">عرض البيانات</a>
            </div>
        </div>
        <div class="panel text-center">
            <div class="panel-heading">
                <h5 class="panel-title">المبلغ عنه</h5>
                @if($user_report->KeyData)
                    @if($user_report->key == 'provider')
                        <img src="{{ $user_report->KeyData->profile_image }}" class="img-thumbnail" alt="Cinque Terre">
                    @else
                        <img src="{{ $user_report->KeyData->Images[0]->image400 }}" class="img-thumbnail" alt="Cinque Terre">
                    @endif
                @endif
            </div>
            <div class="panel-body">
                @if($user_report->KeyData)
                    @if($user_report->key == 'provider')
                        <h5 class="user-name">{{ $user_report->KeyData->username }}</h5>
                        <a class="btn" href="{{ route('provider.show', $user_report->key_id) }}">عرض البيانات</a>
                    @else
                        <h5 class="user-name">{{ $user_report->KeyData->name }}</h5>
                    @endif
                @else
                    <h5 class="user-name">بيانات محذوفة</h5>
                @endif
                
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-flat">
            <div class="panel-body">
                <h5 class="panel-title">سبب البلاغ<h5>
                <p>{{ $user_report->reason }}</p>
            </div>
        </div>
    </div>
</div>
@endsection