require('./alertmsg.js');

class DynamicHTML extends AlertMsg { 
    constructor(config) {
        super();
        this.$triggerDom = config.$triggerDom;
        this.$fillDom = config.$fillDom;
        this.url = config.url;
        this.token = config.token;
        this.method = config.method;
        this.tiggerEvent = config.event ? config.event : 'change';

        this.$triggerDom.on(this.tiggerEvent, function() {
            this.trigger();
        }.bind(this));
    }

    trigger() {
        $.ajax({
			url: this.url,
			type: this.method ? this.method : 'POST',
			headers: {
				'X-CSRF-TOKEN': this.token
			},
			data: {'trigger' : this.$triggerDom.val()},
			success: function success(json, status, xhr) {
                this.fill(json);
                this.sussMsg(xhr);
			}.bind(this)
		}).fail(
            function (e) {
                this.ajaxErrors(e);
            }.bind(this)
        );
    }

    fill(html) {
        this.$fillDom.html('');
        this.$fillDom.html(html);
    }
}

window.DynamicHTML = DynamicHTML;