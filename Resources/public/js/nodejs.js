(function ($) {
    "use strict";

    var Nodejs = function (authToken, settings) {
        this.authToken = authToken;
        this.settings = {
            secure:false,
            host:'localhost',
            port:8080,
            resource:'/socket.io',
            connectTimeout:5000
        };
        this.contentChannelNotificationCallbacks = {};
        this.presenceCallbacks = {};
        this.callbacks = {};
        this.socket = false;
        this.socketId = false;
        this.connectionSetupHandlers = {};
        $.extend(this.settings, settings);
    };

    Nodejs.prototype.connect = function () {
        var nodejs = this;
        this.scheme = this.settings.secure ? 'https' : 'http';
        this.url = this.scheme + '://' + this.settings.host + ':' + this.settings.port;
        this.resource = this.url + this.resource + '/socket.io.js';
        if (typeof window.io === 'undefined') {
            throw "IO isn't defined.";
        }
        this.socket = window.io.connect(this.url, {'connect timeout':this.settings.connectTimeout});
        this.socket.on('connect', function () {
            nodejs.socket.emit('authenticate', {
                authToken:nodejs.authToken
            });
            nodejs.socketId = nodejs.socket.socket.sessionid;
            nodejs.runSetupHandlers('connect');
            nodejs.socket.on('message', function (message) {
                // It's possible that this message originated from an ajax request from the client associated with this socket.
                if (message.clientSocketId === nodejs.socket.socket.sessionid) {
                    window.console.log('This message originated from an ajax request from the client associated with this socket.');
                }

                if (message.callback && nodejs.callbacks[message.callback] && $.isFunction(nodejs.callbacks[message.callback])) {
                    try {
                        nodejs.callbacks[message.callback](message);
                    }
                    catch (exception) {
                        window.console.log(exception);
                    }
                }
                else if (typeof message.presenceNotification !== 'undefined') {
                    $.each(nodejs.presenceCallbacks, function () {
                        if ($.isFunction(this)) {
                            try {
                                this(message);
                            }
                            catch (exception) {
                                window.console.log(exception);
                            }
                        }
                    });
                }
                else if (typeof message.contentChannelNotification !== 'undefined') {
                    $.each(nodejs.contentChannelNotificationCallbacks, function () {
                        if ($.isFunction(this)) {
                            try {
                                this(message);
                            }
                            catch (exception) {
                                window.console.log(exception);
                            }
                        }
                    });
                }
            });

            // nodejs.socket.socket.sessionid;
        });
        this.socket.on('disconnect', function () {
            nodejs.runSetupHandlers('disconnect');
        });

        setTimeout(function () {
            if (!nodejs.socket.socket.connected) {
                nodejs.runSetupHandlers('connectionFailure');
            }
        }, this.settings.connectTimeout + 250);
    };

    Nodejs.prototype.runSetupHandlers = function (type) {
        $.each(this.connectionSetupHandlers, function () {
            if ($.isFunction(this[type])) {
                try {
                    this[type]();
                }
                catch (exception) {
                    throw exception;
                }
            }
        });
    };

    Nodejs.prototype.disconnect = function () {
        this.socket.emit('disconnect');
        this.socket.disconnect();
        delete window.io.sockets[this.url];
    };

    window.Nodejs = Nodejs;
})
    (jQuery);