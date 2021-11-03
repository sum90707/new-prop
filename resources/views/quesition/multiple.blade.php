
<style>
    .numberCircle {
        border-radius: 50%;
        width: 20px;
        height: 20px;
        padding: 1px;

        background: #fff;
        border: 2px solid #666;
        color: #666;
        text-align: center;

        font: 3px Arial, sans-serif;
    }
</style>

<div class="ui two column grid ">
    <div class="three wide column middle aligned">
        <i class="newspaper icon"></i>
        @lang('quesition.options')
    </div>
    <div class="one wide column"></div>
    <div class="twelve wide column">
        <div class="row">
            <div class="ui two column grid">
                <div class="one wide column middle aligned">
                    <div class="numberCircle">1</div>
                </div>
                <div class="fifteen wide column left aligned">
                    {{ Form::text('Options[1][introduce]', null, [
                        'id' => 'option-value-one',
                        'placeholder' => 'option 1'
                    ])}}
                    {{ Form::hidden('Options[1][order]', 1) }}
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="ui two column grid">
                <div class="one wide column middle aligned">
                    <div class="numberCircle">2</div>
                </div>
                <div class="fifteen wide column left aligned">
                    {{ Form::text('Options[2][introduce]', null, [
                        'id' => 'option-value-two',
                        'placeholder' => 'option 2'
                    ])}}
                    {{ Form::hidden('Options[2][order]', 2) }}
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="ui two column grid">
                <div class="one wide column middle aligned">
                    <div class="numberCircle">3</div>
                </div>
                <div class="fifteen wide column left aligned">
                    {{ Form::text('Options[3][introduce]', null, [
                        'id' => 'option-value-three',
                        'placeholder' => 'option 3'
                    ])}}
                    {{ Form::hidden('Options[3][order]', 3) }}
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="ui two column grid">
                <div class="one wide column middle aligned">
                    <div class="numberCircle">4</div>
                </div>
                <div class="fifteen wide column left aligned">
                    {{ Form::text('Options[4][introduce]', null, [
                        'id' => 'option-value-four',
                        'placeholder' => 'option 4'
                    ])}}
                    {{ Form::hidden('Options[4][order]', 4) }}
                </div>
            </div>
        </div><br>

        <div class="row">
            <div class="ui two column grid">
                <div class="four wide column middle aligned">
                    @lang('quesition.answer')
                </div>
                <div class="twelve wide column left aligned">
                    {{ Form::select('Quesition[answer]]', [
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4'
                    ], 
                    '', 
                    [
                        'id' => 'quesition-answer'
                    ])}}
                </div>
            </div>
        </div>
    </div>
</div>