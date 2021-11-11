

<div class="ui text container">
    <div class="ui one column grid">
        <div class="column">
            <div class="create ui card ">
                <div class="content">
                    <h3 class="ui icon header aligned">
                        <i class="edit outline icon"></i>
                        <div class="content">@lang('paper.multi_import')</div>
                    </h3>
                </div>
                <div class="content">
                    {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'create-quesition')) }}
            
                        <div class="row">
                            <div class="ui three column grid middle aligned center aligned">
                                <div class="three wide column middle aligned center aligned">
                                    <i class="newspaper icon"></i>
                                    @lang('quesition.type') : @lang('quesition.types.0')
                                </div>
                                <div class="two wide column middle aligned center aligned">
                                    @lang('paper.amount') : 
                                </div>
                                <div class="three wide column middle aligned center aligned">
                                    {{ Form::number('Import[tf]', '',[
                                        'id' => 'tf-amount',
                                        'max' => 50,
                                        'min' => 0
                                    ]) }}
                                </div>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="ui three column grid middle aligned center aligned">
                                <div class="three wide column middle aligned center aligned">
                                    <i class="newspaper icon"></i>
                                    @lang('quesition.type') : @lang('quesition.types.1')
                                </div>
                                <div class="two wide column middle aligned center aligned">
                                    @lang('paper.amount') : 
                                </div>
                                <div class="three wide column middle aligned center aligned">
                                    {{ Form::number('Import[mutltiple]', '',[
                                        'id' => 'mutltiple-amount',
                                        'max' => 50,
                                        'min' => 0
                                    ]) }}
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                    
                    
                    @can('edit', 'App\User')
                        <div class="row button-row">
                            <div class="column middle aligned center aligned">
                                <button class="ui secondary button" id="quesition-save">
                                    <i class="save icon icon"></i>
                                    @lang('paper.import')
                                </button>
                            </div>
                        </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>
</div>






