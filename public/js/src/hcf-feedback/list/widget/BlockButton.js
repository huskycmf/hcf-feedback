define([
    "dojo/_base/declare",
    "dojo/_base/lang",
    "dijit/form/Button",
    "hc-backend/form/_DgridEventedButtonMixin",
    "hc-backend/router",
    "dojo/request",
    "dojo-common/response/Status",
    "dojo-common/response/Message",
    "dojo/i18n!../../nls/List"
], function(declare, lang, Button, _DgridEventedButtonMixin,
            router, request, _StatusMixin, _MessageMixin,
            translation) {
    return declare([ Button, _DgridEventedButtonMixin ], {

        label: translation['blockSelectedButton'],
        disabled: true,

        _success: function (resp) {
            try {
                var response = new declare([_StatusMixin, _MessageMixin])(resp);

                if (response.isSuccess()) {
                    this.emit('success');
                }
            } catch (e) {
                console.error(this.declaredClass, arguments, e);
                throw e;
            }
        },

        _error: function () {
            try {
                var response = new declare([_StatusMixin, _MessageMixin])(resp);
                this.emit('error');
            } catch (e) {
                console.error(this.declaredClass, arguments, e);
                throw e;
            }
        },

        onClick: function () {
            try {
                var ids = [];
                for (var id in this.grid.getSelected()) ids.push(id);
                if (!ids.length) { return; }
                request.post(router.assemble('/block', {}, true), {
                    data: { 'clients[]': ids },
                    handleAs: 'json'
                }).then(lang.hitch(this, '_success'),
                        lang.hitch(this, '_error'));

                return false;
            } catch (e) {
                console.error(this.declaredClass, arguments, e);
                throw e;
            }
        }
    });
});
