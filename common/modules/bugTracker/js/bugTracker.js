/**
 * Created by zabachok on 08.05.17.
 */
String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10);
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    var result = hours + ':' + minutes + ':' + seconds;
    if(hours == "00")
    {
        result = minutes + ':' + seconds;
        if(minutes == "00")
        {
            result = seconds;
        }
    }
    return result;
}
function Timer() {
    offset = 0;
    var self = this;
    time = 0;
    start = 0;
    fullLength = 0;

    this.init = function () {
        if ($('#task-duration').length == 0) return;
        setInterval(tick, 1000);
        time = Number($('#task-duration').attr('data-time'));
        start = Number($('#task-duration').attr('data-start'));
        fullLength = Number($('#task-full-duration').attr('data-length'));
        print();
    };

    function tick() {
        offset++;
        print();
    }

    function print() {
        var duration = (time - start) + offset;
        $('#task-duration').text((duration + "").toHHMMSS());
        $('#task-full-duration').text(((duration + fullLength) + "").toHHMMSS());
    }
};
$(function () {
    var timer = new Timer();
    timer.init();
})