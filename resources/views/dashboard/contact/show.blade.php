@extends('dashboard.layout')

@section('script')
    <script type="text/javascript" src="{{ url('../resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="{{ url('../resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ url('../resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ url('../resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>
	<script type="text/javascript" src="{{ url('../resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <form action="" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.show_data') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('dash.contacts.name') }}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" value="{{ $contact->name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('dash.contacts.mobile') }}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" value="{{ $contact->mobile }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('dash.contacts.title') }}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" value="{{ $contact->title }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('dash.contacts.message') }}</label>
                        <div class="col-lg-10">
                            <textarea type="text" rows="5" class="form-control" readonly>
                                {{ $contact->message }}
                            </textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('contact.index') }}"  class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div> 
        </form>       
    </div>
</div>
@if($contact->User != null && $contact->User->email != null)
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <form action="{{ route('contact.reply') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> رد الرسالة </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.contacts.message') }}</label>
                        <div class="col-lg-9">
                            <input type="hidden" name="user_id" class="form-control" value="{{ $contact->user_id }}" readonly>
                            <textarea name="reply_message" rows="5" class="form-control" placeholder="{{ trans('dash.contacts.message') }}" required></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.send') }} " />
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
</div>
@endif
@endsection