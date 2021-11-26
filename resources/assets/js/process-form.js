const { fill } = require('lodash');

require('./alertmsg.js');

class FormFill extends AlertMsg {
    constructor(config) {
        super();
        this.$form = config.$form;
        this.url = config.url;
        this.method = config.method ? config.method : 'get';
        this.token = config.token;
        this.data = config.data;
        this.mapList = config.mapList;
        this.path = config.path;
    };

    getData() {
        $.ajax({
			url: this.url,
			type: this.method,
			headers: {
				'X-CSRF-TOKEN': this.token
			},
			data: this.data,
			success: function success(json, status, xhr) {
                this.fillForm(json);
			}.bind(this)
		}).fail(
            function (e) {
                this.ajaxErrors(e);
            }.bind(this)
        );
    }

    fillForm(json) {
        $.each( this.mapList, 
            function( name, $elemet ) {
                if($elemet && json[name]) {
                    this.fill(json[name] , $elemet);
                };
            }.bind(this)
        );
    }

    fill(value, $elemet) {

        switch(true) {
            case $elemet.is("div") :
                $elemet.text(value);
                break;

            case $elemet.is("input") :
                $elemet.val(value);
                break;

            case $elemet.is("select") :
                $elemet.val(value);
                break;
            
            case $elemet.is("img") :
                $elemet.attr('src', this.imagePath(value));
                break;
            case $elemet.is("textarea") :
                $elemet.val(value);
                break;
            default :
                console.log($elemet, value);
        }
    }

    imagePath(image) {
        if(this.path.image) { 
            return `${this.path.image}/${image}`
        } 
        return image
    }

}

class FormSave extends AlertMsg { 
    constructor(config) {
        super();
        this.$btn = config.$btn;
        this.$form = config.$form;
        this.url = config.url;
        this.method = config.method ? config.method : 'GET';
        this.token = config.token;
        this.errorFields = config.errorFields ? config.errorFields : null;
        this.callback = config.callback ? config.callback : function() {};
        this.before = config.before ? config.before : function() {};

        this.$btn.bind('click', function() {
            this.saveForm();
        }.bind(this))
    }

    saveForm() {
        this.before();
        $.ajax({
			url: this.url,
			type: this.method,
			headers: {
				'X-CSRF-TOKEN': this.token
			},
			data: this.$form.serializeArray(),
			success: function success(json, status, xhr) {
                this.ajaxSussMsg(xhr);
                this.callback();
			}.bind(this)
		}).fail(
            function (xhr) {
                this.errorAlert(xhr, this.errorFields);
            }.bind(this)
        );
    }
}

window.FormFill = FormFill;
window.FormSave = FormSave;