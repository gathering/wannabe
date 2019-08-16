$(document).ready(function () {
    $('.moment').each(function() {
        $this = $(this);
        var format = $this.data('formatTo');
        if(!format) format = 'LLLL';
        var from = $this.data('formatFrom');
        if(!from) from = 'X';
        $this.html(function(index, value) {
            var ret = '';
            if($this.hasClass('ago')) {
                if(!value) ret =  moment().fromNow();
                ret =  moment(value, from).fromNow();
            } else if($this.hasClass('format')) {
                if(!value) ret = moment().format(format);
                ret =  moment(value, from).format(format);
            }
            return ret.charAt(0).toUpperCase() + ret.slice(1);
        });


    });
});
