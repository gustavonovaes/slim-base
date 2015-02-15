(function() {

    window.alert = function(title, content) {
        $('<div class="modal fade"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">'+title+'</h4></div><div class="modal-body"><p>'+content+'</p></div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button></div></div></div></div>').modal({
            "show": true
        }).on('hidden.bs.modal', function (e) {
            $(this).remove();
        });
    };

    window.confirm = function(title, content, callback) {
        $('<div class="modal fade"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">'+title+'</h4></div><div class="modal-body"><p>'+content+'</p></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button id="modal-ok" type="button" class="btn btn-primary">Ok</button></div></div></div></div>').modal({
            "show": true
        }).on('shown.bs.modal', function (event) {
            var modal = $(this);
            if (callback != undefined) {
                modal.find("#modal-ok").click( function () {
                    callback();
                    modal.modal('hide');
                });
            }
        }).on('hidden.bs.modal', function (e) {
            $(this).remove();
        });
    };

    window.confirmYN = function(title, content, callback) {
        $('<div class="modal fade"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">'+title+'</h4></div><div class="modal-body"><p>'+content+'</p></div><div class="modal-footer"><button id="modal-N" type="button" class="btn btn-default" data-dismiss="modal">No</button><button id="modal-Y" type="button" class="btn btn-primary">Yes</button></div></div></div></div>').modal({
            "show": true,
            "backdrop": 'static'
        }).on('shown.bs.modal', function (event) {
            var modal = $(this);
            if (callback != undefined) {
                modal.find("#modal-N").click( function () {
                    callback(false);
                    modal.modal('hide');
                });

                modal.find("#modal-Y").click( function () {
                    callback(true);
                    modal.modal('hide');
                });
            }
        }).on('hidden.bs.modal', function (e) {
            $(this).remove();
        });
    };

    window.popup = function(url, width, height, callbackClose) {

        if (width == undefined && height == undefined) {
            width = window.screen.width;
            height = window.screen.height;
        }

        var win = window.open(url, "",'width='+width+',height='+height+',status=0,toolbar=0,location=0');
        win.moveTo(0,0);

        var timer = setInterval(function() {
            if (win.closed || win == undefined) {
                clearInterval(timer);

                if (callbackClose != undefined)
                    callbackClose();
            }
        }, 250);

        return false;
    };

})();
