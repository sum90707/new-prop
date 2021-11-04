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
            <a class="item" data-tab="create">@lang('quesition.title_create')</a>
        @endcan
        @can('read', 'App\Quesition')
            <a class="item active" data-tab="list">@lang('quesition.title_view')</a>
        @endcan
    </div>
    @can('create', 'App\Quesition')
        <div class="ui bottom attached tab segment" data-tab="create">
            @include('quesition.create')
        </div>
    @endcan
    @can('read', 'App\Quesition')
        <div class="ui bottom attached tab segment active" data-tab="list">
            @include('quesition.list')
        </div>
    @endcan
<script>
   $('.tabular.menu.quesition .item').tab();
</script>
@endsection

