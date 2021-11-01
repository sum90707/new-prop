require('./alertmsg.js');

class UploadImage extends AlertMsg { 
    constructor(config) {
        super();
        this.data;
        this.url = config.url;
        this.token = config.token;
        this.$image = config.$image;
        this.$input = config.$input;
        this.$uploadBtn = config.$uploadBtn;
        this.allowExtension = config.allowExtension;
        this.method = config.method ? config.method : 'POST';
        this.errorFields = config.errorFields ? config.errorFields : null;

        this.errorMsg  = {
            verification : 'verification failed',
        }

        this.registerEvent();
    }

    registerEvent() { 
        this.$uploadBtn.on('click', function() {
            this.$input.click();
        }.bind(this));

        this.$input.on('change', function(event) {
            this.uploadImage(this.$input.prop('files')[0]);
        }.bind(this));

    }

    uploadImage(file) {
        if(!($.inArray(file.type, this.allowExtension) == -1)) {
            this.addFile(file);
            this.ajaxImg();

            return;
        }

        this.errorsMsg(487, this.errorMsg.verification);
    }

    addFile(file) {
       this.data = new FormData();
       this.data.append('image', file);
    }

    setPreview(json) {
        try {
            this.$image.attr('src', json.image);
        } catch (error) {
            this.errorsMsg(`Set image preview fail. ${error}`);
        }
    }

    ajaxImg() {
        
        $.ajax({
			url: this.url,
			type: this.method,
			headers: {
				'X-CSRF-TOKEN': this.token
			},
			data: this.data,
            contentType: false,
            cache: false,
            processData:false,
			success: function success(json, status, xhr) {
                this.ajaxSussMsg(xhr);
                this.setPreview(json);
			}.bind(this)
		}).fail(
            function (xhr) {
                this.errorAlert(xhr, this.errorFields);
            }.bind(this)
        );
    
    }

}

window.UploadImage = UploadImage;