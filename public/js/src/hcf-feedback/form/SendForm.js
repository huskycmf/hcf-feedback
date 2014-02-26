define(['dojo/_base/declare',
        'dojo/_base/lang',
        'dojo/_base/array',
        'dijit/form/_FormMixin',
        './ErrorContainer',
        './_StatefulFormMixin',
        'dijit/registry',
        'dojo/query',
        'dojo/request',
        'dojo-common/response/Status',
        'dojo-common/response/Message',
        'dijit/_Widget',
        'dijit/_Container'],
    function(declare, lang, array, _FormMixin,
             ErrorContainer, _StatefulFormMixin,
             registry, query, request, StatusResponse, MessageResponse,
             _Widget, _Container) {
        return declare([ _Widget, _Container ], {
            formWidget: null,
            errorContainerWidget: null,
            sendMethod: null,
            actionUrl: null,

            startup: function () {
                try {
                    array.forEach(this.getChildren(), function (child){
                        if (child.isInstanceOf(_FormMixin)) {
                            this.formWidget = child;
                        }
                        if (child.isInstanceOf(ErrorContainer)) {
                            this.errorContainerWidget = child;
                        }
                    }, this);

                    if (!this.formWidget) {
                        throw "Could not found form widget";
                    }

                    this.formWidget.on('submit', lang.hitch(this, 'send'));
                } catch (e) {
                     console.error(this.declaredClass, arguments, e);
                     throw e;
                }
            },

            send: function () {
                try {
                    if (this.formWidget.isInstanceOf(_StatefulFormMixin)) {
                        this.formWidget.busy();
                    }

                    var req = request[this.sendMethod || this.formWidget.get('method')](
                        this.actionUrl || this.formWidget.get('action'),
                        {

                            handleAs: 'json'
                        }
                    );

                    req.then(lang.hitch(this, function (resp) {
                        try {
                            var result = (new declare([StatusResponse,
                                                       MessageResponse]))(resp);
                            if (result.isSuccess()) {
                                this.emit('success', {result: result});
                                return;
                            }

                            if (this.errorContainerWidget) {
                                this.errorContainerWidget
                                    .set('errors', result.getMessage());
                            }
                        } catch (e) {
                             console.error(this.declaredClass, arguments, e);
                             throw e;
                        }
                    }), function (err) {
                        try {
                            var result = (new declare([MessageResponse]))(err);

                            if (this.errorContainerWidget) {
                                this.errorContainerWidget
                                    .set('errors', result.getMessage());
                            }
                        } catch (e) {
                            console.error("Error in asynchronous call",
                                           err, e, arguments);
                            throw e;
                        }
                    }).always(lang.hitch(this, function (){
                            this.formWidget.cancel();
                    }));
                } catch (e) {
                     console.error(this.declaredClass, arguments, e);
                     throw e;
                }
            }
        });
    });
