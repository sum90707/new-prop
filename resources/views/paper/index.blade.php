@extends('layouts.main')

@section('title',  __('paper.manage'))

@section('content')

    <div>
        <h2 class="ui icon header aligned">
            <i class="file icon"></i>
            <div class="content">@lang('paper.manage')</div>
        </h2>
    </div>
    
    <div class="ui top attached tabular menu quesition">
        @can('create', 'App\Paper')
            <a class="item active" data-tab="create">@lang('paper.title_create')</a>
        @endcan
        @can('read', 'App\Paper')
            <a class="item" data-tab="list">@lang('paper.list')</a>
        @endcan
    </div>
    @can('create', 'App\Paper')
        <div class="ui bottom attached tab segment active" data-tab="create">
            @include('paper.create')
        </div>
    @endcan
    @can('read', 'App\Paper')
        <div class="ui bottom attached tab segment" data-tab="list">
            @include('paper.list')
        </div>
    @endcan
<script>
   $('.tabular.menu.quesition .item').tab();
</script>
@endsection

