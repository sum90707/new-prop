require('./alertmsg.js');

class CopiedBoard extends AlertMsg {
    constructor(){
        super();
    }

    static bindCopiedElement($element) {
        $element.bind('click', function() {
            try {
                $element.find('input').first().select();
                document.execCommand("copy");
                this.alertMsg('copied succeeded');
            } catch (error) {
                this.alertMsg(error, 'fail');
            }
                
        }.bind(this))
    }
}


window.CopiedBoard = CopiedBoard;
