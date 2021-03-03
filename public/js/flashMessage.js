(function () {
    var _id = 0, _queue = [], _processing = false;

    var _popup = function (timeout, animation, callbacks) {
        callbacks.show();
        setTimeout(function () {
            callbacks.hide();

            setTimeout(function () {
                callbacks.done();
            }, animation);
        }, timeout);
    };

    var _process = function (message, color, callback) {
        console.log(message);
        _popup(2000, 1000, {
            // show popup
            show: function () {
                $(".flash-modal p").html(message);

                 width = $(".flash-modal p").width();
                $(".flash-modal").css({
                    right: "5px",
                    transition: "1s",
                    "background-color": color,
                });
            },

            // hide popup
            hide: function () {
                $(".flash-modal").css({
                    right: -width - 50,
                    transition: "1s",
                });
            },

            // when process done
            done: function () {
                callback();
                _processQueue();
            },
        });
    };

    var _processQueue = function () {
        if (_processing) {
            return;
        }

        var next = null;
        _queue.forEach(function (item) {
            if (null == next && !item.done) {
                next = item;
                return false;
            }
        });

        if (!next) {
            return;
        }

        _processing = true;
        next.done = true;
        _process(next.message, next.color, function () {
            _processing = false;
        });
    };

    var _iteration = function (message,color) {
        var messages = JSON.parse(JSON.stringify(message));
        if (!Array.isArray(messages)) {
            messages = Object.values(messages);
        }

        for (let i = 0; i < messages.length; ++i) {
            _flashMessage(messages[i],color);
        }
    };

    var _flashMessage = function (message, color) {
        if ("undefined" == typeof color) {
            color = "#ff6f36";
        }

        if (typeof message === "object") {
            return _iteration(message,color);
        }

        _queue.push({
            id: ++_id,
            message: message,
            color: color,
            done: false,
        });

        _processQueue();
    };

    window.flashMessage = _flashMessage;
})();
