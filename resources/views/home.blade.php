@extends('layouts.main')

@section('content')
  
    <div class="ui vertical stripe segment">
      <div class="banner-group" >
        <div class="row" id="img-group">
            <img  src="{{ URL::asset('upload/systemImage/testBanner.png') }}" width="100%" id="%%index%%">
        </div>
      </div>
    </div>


    


  <div class="ui two column centered grid" style="margin-top: 5%">

    <div class="ten wide column">
      @include('home.comment')
    </div>


    <div class="right floated middle aligned five wide column">
      <div class="ui card">
        <div class="image">
          <img src="{{ URL::asset('upload/1/shot.png') }}">
        </div>
        <div class="content">
          <div class="header">開發者</div>
        </div>
        <div class="content">
          <div class="meta">
            <span class="date"> Henry Lin</span><br>
            <span class="date"> Birthday :  06/03 </span><br>
            <span class="date"> Job :  Full-stack Developer </span><br>
          </div>
          <div class="description">
            <span>期望這個網站</span><br>
            <span>能夠變成一個能夠幫助教師們</span><br>
            <span>解決出試題困難的一個工具</span>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/home.css') }}">

@endsection