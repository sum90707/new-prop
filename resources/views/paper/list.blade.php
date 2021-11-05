
<script defer type="text/javascript" src="{{ URL::asset('js/copied.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/toggle.js') }}"></script>
<table class="ui celled striped table center aligned paper-list" width="100%" >        
    <thead>
        <tr>
            <th class="button">@lang('paper.status') </th>
            <th>@lang('paper.id')</th>
            <th>@lang('paper.name')</th>
            <th>@lang('paper.introduce')</th>
            <th>@lang('paper.create_by')</th>
        </tr>
    </thead>
</table>

<script> 
    $(function() {

        let route = {
            list : "{{ route('paper.list') }}",
            toggleStatus : "{{ route('paper.status', ['paper' => '__PAPER__']) }}",
        }


        let $dataTable = $('.paper-list').DataTable({
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
                { "width": "50%", "targets": 3},
                { "width": "25%", "targets": 4},
            ],
            columns: [
                {
                    data: 'deleted_at',
                    render: function (data, type, row) {

                        return `
                            <div class="ui toggle checkbox status-checkbox" 
                                data-status="${data ? 0 : 1}" 
                                data-id=${row.id}
                                data-route="${stringReplace(route.toggleStatus, {'__PAPER__' : row.id})}">
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
            }
        });

        // setInterval(() => {
        //     $dataTable.ajax.reload();
        // }, 10000);

    })
     
</script>