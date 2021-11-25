<div class="ui container fluid">
    <div class="ui one column grid" style="height: 100vh;overflow: auto;">
        <div class="column">

            <div class="select ui card fluid">
                <div class="content center aligned">
                    <div class="header">
                        @lang('paper.start_test')
                    </div>
                </div> 

                <div class="content">
                    <div class="ui three column grid">
                        <div class="five wide column middle aligned center aligned">
                            @lang('paper.paper_select')
                        </div>
                        <div class="seven wide column">
                            <select class="ui fluid search dropdown papers-select-test" id="papers-select-test">
                               
                            </select>
                        </div>
                        <div class="three wide column">
                            <div>
                                <button class="ui button right floated" id="paper-get">
                                    <i class="hand point right icon"></i>
                                    @lang('paper.start_test')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'test-paper')) }}
                        <table class="ui celled striped table center aligned" id="test-paper" width="100%" >        
                            <thead>
                                <tr>
                                    <th class="four wide">@lang('quesition.info')</th>
                                    <th class="eight wide">@lang('quesition.introduce')</th>
                                    <th class="four wide">@lang('quesition.options')</th>
                                </tr>
                            </thead>
                            <tbody id="test-paper-body">
                            </tbody>
                        </table>
                    {{ Form::close() }}
                </div>
                <div class="content center aligned">
                    <button class="ui greed button" id="test-save">
                        <i class="hand point right icon"></i>
                        @lang('paper.send_answer')
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>


<script> 
    $(function() {
        let route = {
            dropdown : "{{ route('paper.dropdwon') }}",
            getSelected : "{{ route('paper.getSelected', ['paper' => '__DATA__']) }}",
            formSave : "{{ route('paper.correct') }}"
        },
        template = `
            <tr><td class=" left aligned">
                @lang('quesition.name') : __NAME__<br>
                @lang('quesition.year') : __YEAR__<br>
                <td class="sorting_1">
                    __INTRODUCE__
                </td>
                <td>
                    <select class="ui dropdown" name="Answer[__ID__]">
                        __OPTIONS__
                    </select>
                </td>
                
            </tr>
        `,
        dropdwonConfig = {
            url : route.dropdown,
            token : "{{ csrf_token() }}",
            callback : function(json, config) {
                $('.papers-select-test').dropdown('setup menu', json);
                $('.papers-select-test').dropdown('set selected', json.values[0].value);
                $('#paper-get').bind('click', function () {

                    let value = $('.papers-select-test').find('.selected').data('value')
                    get.url = stringReplace(route.getSelected, {
                        '__DATA__' : value
                    });
                    triggerAJAX(get);
                    $(this).attr('disabled', true);
                })

            }
        },
        get = {
            url : '',
            token : "{{ csrf_token() }}",
            method : 'GET',
            template : template,
            before : function() {
                
            },
            callback : function(json, config) {
                $('#test-paper-body').html('');
                $.each(json.data, function(index, quesition) {
                    let options = makeOptions(quesition.options);
                    $('#test-paper-body').append(
                        stringReplace(config.template, {
                            '__ID__' : quesition.id,
                            '__NAME__' : quesition.name,
                            '__YEAR__' : quesition.year,
                            '__INTRODUCE__' : quesition.introduce,
                            '__OPTIONS__' : options
                        })
                    );
                });
            }
        },
        save = {
            $btn : $('#test-save'),
            $form : $('#test-paper'),
            url : route.formSave,
            token : "{{ csrf_token() }}",
            method : 'POST',
            before : function() {
                
            },
            callback : function(){
                
            }
        }

        triggerAJAX(dropdwonConfig);
        new FormSave(save);


        function makeOptions(options)
        {
            let $option = String();
            $.each(options, function(index, option) {
                $option += `<option value="${option.order}">${option.introduce}</option>`
            });

            return $option;
        }
    })
</script>