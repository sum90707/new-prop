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
    @can('read', 'App\Quiz')
        <a class="item active" data-tab="quiz">@lang('quiz.start_quiz')</a>
    @endcan
</div>
@can('read', 'App\Quiz')
    <div class="ui bottom attached tab segment active" data-tab="quiz">
        @include('quiz.quiz')
    </div>
@endcan

<script>
   $('.tabular.menu.quesition .item').tab();
</script>
@endsection

