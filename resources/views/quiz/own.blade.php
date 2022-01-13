

<table class="ui celled striped table center aligned quiz-own" width="100%" >        
    <thead>
        <tr>
            <th>@lang('quiz.introduce')</th>
            <th>@lang('quiz.score')</th>
            <th>@lang('quiz.finish_at')</th>
        </tr>
    </thead>
</table>

<script> 
    $(function() {

        let route = {
            own : "{{ route('quiz.own') }}"
        }


        let $dataTable = $('.quiz-own').DataTable({
            autoWidth: false,
            info: true,
            lengthChange: false,
            serverSide: true,
            pageLength: 20,
            ajax: {
                'url': route.own,
                'type': 'GET',
            },
            order: [[ 1, 'asc' ]],
            columns: [
                { 
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            @lang('quiz.id') : ${row.quiz.id}<br>
                            @lang('quiz.name') : ${row.quiz.name}
                        `;
                    }
                },
                { 
                    data: 'score',
                    render: function (data, type, row) {
                        return data ?? '--';
                    }
                },
                { 
                    data: 'score',
                    render: function (data, type, row) {
                        let $btn = `
                            <div class="mini ui gray button have-exam" data-id="${row.quiz.id}">
                                 @lang('quiz.start_quiz') 
                            </div>`
                        return data == null ? $btn : row.updated_at;
                    }
                }
            ],
            drawCallback: function() {
                $('.have-exam').on('click', doExam)
            }
        });

        setInterval(() => {
            $dataTable.ajax.reload();
        }, 30000);

        function doExam() {
            if($('#exam-tab')) {
                $('#exam-tab').click();
                $('#quizzes').dropdown('set selected', $(this).data('id'));
                $('#quiz-get').click();
            }
        }

    })
     
</script>