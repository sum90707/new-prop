<div class="ui container fluid">
    <div class="ui one column grid flow">
        <div class="column">

            <div class="select ui card fluid">
                <div class="content center aligned">
                    <div class="header">
                        @lang('quiz.start_quiz')
                    </div>
                </div> 

                <div class="content">
                    <div class="ui three column grid">
                        <div class="five wide column middle aligned center aligned">
                            @lang('quiz.quiz_select')
                        </div>
                        <div class="seven wide column">
                            <select class="ui fluid search dropdown quizzes" id="quizzes">
                               
                            </select>
                        </div>
                        <div class="three wide column">
                            <div>
                                <button class="ui button right floated" id="quiz-get">
                                    <i class="hand point right icon"></i>
                                    @lang('quiz.start_quiz')
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
                    <button class="ui blue button" id="quiz-save" disabled="disabled">
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
            dropdown : "{{ route('quiz.dropdown') }}",
            getSelected : "{{ route('quiz.get', ['quiz' => '__DATA__']) }}",
            formSave : "{{ route('quiz.grade', ['quiz' => '__DATA__']) }}"
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
        quizDropdwon = {
            url : route.dropdown,
            method : 'GET',
            token : "{{ csrf_token() }}",
            before: function() {
                $('.quizzes').dropdown('clear');
            },
            callback : function(json, config) {
                $('.quizzes').dropdown('setup menu', json);

                $('#quiz-get').unbind('click').bind('click', function () {
                    let value = $('.quizzes').find('.selected').data('value');
                    get.url = stringReplace(route.getSelected, {
                        '__DATA__' : value ? value : '__DATA__'
                    });
                    triggerAJAX(get);
                })

            }
        },
        get = {
            url : '',
            token : "{{ csrf_token() }}",
            method : 'GET',
            template : template,
            callback : function(json, config) {
                $('#test-paper-body').html('');
                $('.flow').addClass('container-scroll');
                $('#quiz-get').attr('disabled', true);
                $('#quiz-save').removeAttr('disabled');
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
            $btn : $('#quiz-save'),
            $form : $('#test-paper'),
            url : route.formSave,
            token : "{{ csrf_token() }}",
            method : 'POST',
            before : function() {
                this.url = stringReplace(route.formSave, {
                    '__DATA__' : $('.quizzes').find('.selected').data('value')
                })
            },
            callback : function(){
                triggerAJAX(quizDropdwon);
                $('#test-paper-body').html('');
                $('#quiz-get').removeAttr('disabled');
                $('#quiz-save').attr('disabled', true);
            }
        }

        triggerAJAX(quizDropdwon);
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