@extends('layouts.main')

@section('title',  __('paper.manage'))

@section('content')
<script defer type="text/javascript" src="{{ URL::asset('js/copied.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/toggle.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/upload.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/process-form.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/dynamic.js') }}"></script>
    <div>
        <h2 class="ui icon header aligned">
            <i class="file icon"></i>
            <div class="content">@lang('paper.manage')</div>
        </h2>
    </div>
    
    <div class="ui top attached tabular menu quesition">
        @can('read', 'App\Paper')
            <a class="item active" data-tab="list">@lang('paper.list')</a>
        @endcan
        @can('create', 'App\Paper')
            <a class="item" data-tab="create">@lang('paper.title_create')</a>
        @endcan
        @can('edit', 'App\Paper')
            <a class="item" data-tab="import">@lang('paper.import')</a>
        @endcan
        @can('edit', 'App\Paper')
            <a class="item" data-tab="multi">@lang('paper.multi_import')</a>
        @endcan
        @can('test', 'App\Paper')
            <a class="item" data-tab="test">@lang('paper.start_test')</a>
        @endcan
    </div>
    @can('read', 'App\Paper')
        <div class="ui bottom attached tab segment active" data-tab="list">
            @include('paper.list')
        </div>
    @endcan
    @can('create', 'App\Paper')
        <div class="ui bottom attached tab segment" data-tab="create">
            @include('paper.create')
        </div>
    @endcan
    @can('edit', 'App\Paper')
        <div class="ui bottom attached tab segment " data-tab="import">
            @include('paper.import')
        </div>
    @endcan
    @can('edit', 'App\Paper')
        <div class="ui bottom attached tab segment" data-tab="multi">
            @include('paper.multi')
        </div>
    @endcan
    @can('test', 'App\Paper')
        <div class="ui bottom attached tab segment" data-tab="test">
            @include('paper.test')
        </div>
    @endcan
<script>
   $('.tabular.menu.quesition .item').tab();
</script>
@endsection

