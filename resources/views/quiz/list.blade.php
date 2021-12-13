

<table class="ui celled striped table center aligned quiz-list" width="100%" >        
    <thead>
        <tr>
            <th class="button">@lang('quiz.status') </th>
            <th>@lang('quiz.id')</th>
            <th>@lang('quiz.name')</th>
            <th>@lang('quiz.introduce')</th>
            <th>@lang('quiz.paper')</th>
            <th>@lang('quiz.create_by')</th>
        </tr>
    </thead>
</table>

<script> 
    $(function() {

        let route = {
            list : "{{ route('quiz.list') }}",
            toggleStatus : "{{ route('quiz.status', ['quiz' => '__ID__']) }}",
            download : "",
        }


        let $dataTable = $('.quiz-list').DataTable({
            autoWidth: false,
            info: true,
            lengthChange: false,
            serverSide: true,
            pageLength: 20,
            ajax: {
                'url': route.list,
                'type': 'GET',
            },
            order: [[ 1, 'asc' ]],
            columnDefs: [
                { "width": "5%", "targets": 0},
                { "width": "5%", "targets": 1},
                { "width": "15%", "targets": 2},
                { "width": "40%", "targets": 3},
                { "width": "20%", "targets": 4},
                { "width": "15%", "targets": 5},
            ],
            columns: [
                {
                    data: 'deleted_at',
                    render: function (data, type, row) {

                        return `
                            <div class="ui toggle checkbox status-checkbox" 
                                data-status="${data ? 0 : 1}" 
                                data-id=${row.id}
                                data-route="${stringReplace(route.toggleStatus, {'__ID__' : row.id})}">
                                <input type="checkbox" name="public">
                                <label></label>
                            </div>`
                    }
                },
                { 
                    data: 'id'
                },
                { 
                    data: 'name'
                },
                {
                    data: 'introduce'
                },
                {
                    data: 'paper',
                    render: function (data, type, row) {
                        return `
                            @lang('paper.id') : ${data.id}<br>
                            @lang('paper.name') : ${data.name}
                        `;
                    }
                },
                {
                    data: 'create_by',
                    render: function (data, type, row) {
                        return data.name;
                    }
                },
            ],
            drawCallback: function() {
                Toggle.setCheckboxs($('.status-checkbox'), 'status');
                Toggle.statusToggle($('.status-checkbox'), function() {
                    $dataTable.draw();
                });
                // $('.dropdown.button.operate').dropdown({on: 'hover'});
            }
        });

        // setInterval(() => {
        //     $dataTable.ajax.reload();
        // }, 30000);

    })
     
</script>