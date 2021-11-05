class AlertMsg {

    static alertMsg(message, fail = false) {
        console.log(fail);
        $.uiAlert({
            textHead: fail ? "Error" : '',
            text: message,
            bgcolor: fail ? '#DB2828' : '#19c3aa',
            textcolor: '#fff',
            position: 'bottom-right',
            icon: fail ? 'remove circle' : 'checkmark box',
            time: 5,
        });
    }

    ajaxErrors(xhr) {
        $.uiAlert({
            textHead: "Error " + xhr.status,
            text: xhr.responseJSON.message ? xhr.responseJSON.message : '',
            bgcolor: '#DB2828',
            textcolor: '#fff',
            position: 'bottom-right',
            icon: 'remove circle',
            time: 5,
        });
    };


    ajaxSussMsg(xhr){
        $.uiAlert({
            textHead: '',
            text:  xhr.responseJSON.message ? xhr.responseJSON.message : 'Operation succeeded',
            bgcolor: '#19c3aa',
            textcolor: '#fff',
            position: 'bottom-right',
            icon: 'checkmark box',
            time: 5,	
        });	
    };

    sussMsg(){
        $.uiAlert({
            textHead: '',
            text: 'Operation succeeded',
            bgcolor: '#19c3aa',
            textcolor: '#fff',
            position: 'bottom-right',
            icon: 'checkmark box',
            time: 5,	
        });	
    };


    errorsMsg(status, msg = null) {
        $.uiAlert({
            textHead: "Error " + (status ? status : ''),
            text: msg ? msg : 'Operation fail',
            bgcolor: '#DB2828',
            textcolor: '#fff',
            position: 'bottom-right',
            icon: 'remove circle',
            time: 5,
        });
    };

    errorAlert(xhr, errorFields) {
        if(xhr.responseJSON.errors) {
            this.processErrorsMsg(xhr, errorFields)
        } else {
            this.ajaxErrors(xhr)
        }
    }

    processErrorsMsg(xhr, errorFields) {
        $.each(xhr.responseJSON.errors , function(label, msg) {
            label = label.toLowerCase();
            this.errorsMsg(
                xhr.status, 
                msg.shift().replace(label, errorFields[label])
            );
        }.bind(this));
    }
}

window.AlertMsg = AlertMsg;