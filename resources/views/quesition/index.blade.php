@extends('layouts.main')

@section('title',  __('quesition.manage'))

@section('content')

    <div>
        <h2 class="ui icon header aligned">
            <i class="settings icon"></i>
            <div class="content">@lang('quesition.manage')</div>
        </h2>
    </div>
    
    <div class="ui top attached tabular menu quesition">
        @can('create', 'App\Quesition')
            <a class="item active" data-tab="create">@lang('quesition.title_create')</a>
        @endcan
    </div>
    @can('create', 'App\Quesition')
        <div class="ui bottom attached tab segment active" data-tab="create">
            @include('quesition.create')
        </div>
    @endcan
<script>
   $('.tabular.menu.quesition .item').tab();
</script>
@endsection

