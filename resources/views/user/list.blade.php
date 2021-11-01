
<script defer type="text/javascript" src="{{ URL::asset('js/copied.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/toggle.js') }}"></script>
<table class="ui celled striped table center aligned user-list" width="100%" >        
    <thead>
        <tr>
            <th class="button">@lang('user.status') </th>
            <th>
                @lang('user.name')
            </th>
            <th>
                @lang('user.auth')
            </th>
            <th>
                @lang('user.email')
            </th>
            <th>
                @lang('user.language') 
            </th>
            <th>
                API TOKEN
            </th>
        </tr>
    </thead>
</table>

<script> 
    $(function() {

        let route = {
            list : "{{ route('users.list') }}",
            toggleStatus : "{{ route('users.status', ['user' => '__USER__']) }}",
            toggleAuth : "{{ route('users.auth', ['user' => '__USER__']) }}",
        }


        let $dataTable = $('.user-list').DataTable({
            autoWidth: true,
            info: false,
            lengthChange: false,
            serverSide: true,
            pageLength: 20,
            ajax: {
                'url': route.list,
                'type': 'GET',
            },
            order: [[ 1, 'asc' ]],
            columns: [
                { 
                    data: 'deleted_at',
                    render: function (data, type, row) {
                        

                        return `
                            <div class="ui toggle checkbox status-checkbox" 
                                data-status="${data ? 0 : 1}" 
                                data-id=${row.id}
                                data-route="${stringReplace(route.toggleStatus, {'__USER__' : row.id})}">
                                <input type="checkbox" name="public">
                                <label></label>
                            </div>`
                    }
                },
                { 
                    data: 'name'
                },
                {
                    data: 'role_name',
                    render: function (data, type, row) {

                        let options = String();
                        
                        $.each(row.auth_group, function(index, auth) {
                            options += `
                                <option value="${auth.id}" 
                                    ${data == auth.name ? 'selected' : ''} >
                                    ${auth.name}
                                </option>`;
                        });
                        
                        return `
                            <select class="ui dropdown auth-select" 
                                    data-route="${stringReplace(route.toggleAuth, {'__USER__' : row.id})}"
                                    data-method="PUT">
                                ${options}
                            </select>
                        `
                    }
                },
                {
                    data: 'email'
                },
                {
                    data: 'language'
                },
                {
                    data: 'api_token',
                    render: function (data, type, row) {
                        return `
                                <div class="ui action input copied-token">
                                <input type="text" value="${data}">
                                <button class="ui teal right icon button">
                                    <i class="copy icon"></i>
                                </button>
                                </div>
                            `;
                    }
                },
            ],
            drawCallback: function() {
                CopiedBoard.bindCopiedElement($('.copied-token'));
                Toggle.setCheckboxs($('.status-checkbox'), 'status');
                Toggle.statusToggle($('.status-checkbox'), function() {
                    $dataTable.draw();
                });
                Toggle.selectToggle($('.auth-select'), function() {
                    $dataTable.draw();
                });
            }
        });

    })
     
</script>