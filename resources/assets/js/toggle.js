require('./alertmsg.js');

class Toggle extends AlertMsg { 
    constructor(config) {
        super();
    }

    static setCheckboxs($elements, column) {
        $.each($elements, function(index, $element) {
            if ($($element).data(column)) {
                $($element).checkbox('set checked');
            } else {
                $($element).checkbox('set unchecked');
            }
        })
    }

    static setCheckbox($element, column) {
        if ($($element).data(column)) {
            $($element).checkbox('set checked');
        } else {
            $($element).checkbox('set unchecked');
        }
    }

    static statusToggle($elements, callback) {
        $.each($elements, function (index, $element) {
            $($element).on('click', function () {
                this.toggleRequest(this.takeInfo($element), callback);
            }.bind(this))
        }.bind(this))
    }

    static selectToggle($elements, callback) {
        $.each($elements, function (index, $element) {
            $($element).on('change', function () {
                this.toggleRequest(this.takeInfo($element), callback);
            }.bind(this))
        }.bind(this))
    }


    static takeInfo($element) {
        return {
            url : $($element).data('route'),
            data : $($element).val(),
            method : $($element).data('method') ? $($element).data('method') : 'PUT',
            token : $('meta[name="csrf-token"]').attr('content'),
            element : $($element)
        }
    }

    static toggleRequest(info, callback) {
        $.ajax({
			url: info.url,
			type: info.method,
			headers: {
				'X-CSRF-TOKEN': info.token
			},
			data: {'toggle' : info.data},
			success: function success(json, status, xhr) {
                callback();
                this.alertMsg(json.message);
			}.bind(this)
		}).fail(
            function (e) {
                callback();
                this.alertMsg(e.responseJSON.message, 'fail');
            }.bind(this)
        );
    }
}

window.Toggle = Toggle;