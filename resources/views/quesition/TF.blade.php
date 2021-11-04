<div class="ui two column grid ">
    <div class="three wide column middle aligned">
        <i class="newspaper icon"></i>
        @lang('quesition.options')
    </div>
    <div class="one wide column"></div>
    <div class="twelve wide column">
        <div class="row">
            <div class="twelve wide column left aligned">
                {{ Form::text('Options[1][introduce]', 'O', [
                    'id' => 'option-value-one',
                    'readOnly' => true
                ])}}
                {{ Form::hidden('Options[1][order]', 1) }}
            </div>
        </div><br>
        <div class="row">
            <div class="twelve wide column left aligned">
                {{ Form::text('Options[2][introduce]', 'X', [
                    'id' => 'option-value-two',
                    'readOnly' => true
                ])}}
                {{ Form::hidden('Options[2][order]', 2) }}
            </div>
        </div><br>

        <div class="row">
            <div class="ui two column grid">
                <div class="four wide column middle aligned">
                    @lang('quesition.answer')
                </div>
                <div class="twelve wide column left aligned">
                    {{ Form::select('Quesition[answer]', [
                            1 => 'O',
                            2 => 'X'
                        ], 2, ['id' => 'quesition-answer']
                    )}}
                </div>
            </div>
        </div>
    </div>
</div>