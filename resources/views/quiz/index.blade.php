@extends('layouts.main')

@section('title',  __('quiz.title'))

@section('content')

<script defer type="text/javascript" src="{{ URL::asset('js/copied.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/toggle.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/upload.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/process-form.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/dynamic.js') }}"></script>

<div>
    <h2 class="ui icon header aligned">
        <i class="settings icon"></i>
        <div class="content">@lang('quiz.title')</div>
    </h2>
</div>

<div class="ui top attached tabular menu quesition">
    @can('edit', 'App\Quiz')
        <a class="item" data-tab="list">@lang('quiz.list')</a>
    @endcan
    @can('read', 'App\Quiz')
        <a class="item active" data-tab="own">@lang('quiz.own_exam')</a>
    @endcan
    @can('read', 'App\Quiz')
        <a class="item" data-tab="quiz" id="exam-tab">@lang('quiz.start_quiz')</a>
    @endcan
</div>
@can('read', 'App\Quiz')
    <div class="ui bottom attached tab segment" data-tab="list">
        @include('quiz.list')
    </div>
@endcan
@can('read', 'App\Quiz')
    <div class="ui bottom attached tab segment active" data-tab="own">
        @include('quiz.own')
    </div>
@endcan
@can('edit', 'App\Quiz')
    <div class="ui bottom attached tab segment" data-tab="quiz">
        @include('quiz.quiz')
    </div>
@endcan

<script>
   $('.tabular.menu.quesition .item').tab();
</script>
@endsection

