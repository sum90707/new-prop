

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
                    <div class="row">
                        <div class="ui two column grid">
                            <div class="five wide column middle aligned center aligned">
                                @lang('paper.paper_select')
                            </div>
                            <div class="ten wide column">
                                {{ Form::select('Paper[id]', [], null, array(
                                    'class' => 'ui fluid search dropdown papers-select-multi',
                                    'id' => 'papers-select-multi'
                                )) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'create-multi')) }}
            
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
                                    {{ Form::number('Import[tf]', '0',[
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
                                    {{ Form::number('Import[mutltiple]', '0',[
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
                                <button class="ui secondary button" id="multi-save">
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


<script>

$(function() {

    let route = {
            dropdown : "{{ route('paper.dropdwon') }}",
            formSave :  "{{ route('paper.multiSave', ['paper' => '__DATA__']) }}",
    };

    let save = {
        $btn : $('#multi-save'),
        $form : $('#create-multi'),
        url : route.formSave,
        token : "{{ csrf_token() }}",
        method : 'POST',
        before : function() {
            this.url = stringReplace(route.formSave, {
                '__DATA__' : $('.papers-select-multi').find('.selected').data('value')
            });
        },
        callback : function(){
            $('#create-multi').trigger("reset");
        }
    },
    dropdwonConfig = {
        url : route.dropdown,
        token : "{{ csrf_token() }}",
        callback : function(json, config) {
            $('.papers-select-multi').dropdown('setup menu', json);
            $('.papers-select-multi').dropdown('set selected', json.values[0].value);  
        }
    };

    new FormSave(save);
    triggerAJAX(dropdwonConfig);
})
</script>



