define(['dojo/_base/declare',
        'dijit/form/Form',
        'dijit/_WidgetsInTemplateMixin',
        'dojo/text!./templates/Form.html',
        'dojo/dom-attr',
        './_StatefulFormMixin',
        'dijit/form/ValidationTextBox',
        'dijit/form/Textarea',
        'dojo-common/form/BusyButton'],
    function(declare, Form, _WidgetsInTemplateMixin,
             template, domAttr, _StatefulFormMixin) {
        return declare([ Form, _WidgetsInTemplateMixin, _StatefulFormMixin ], {

            templateString: template,

            nameFieldText: 'Name',
            emailFieldText: 'Email',
            phoneFieldText: 'Phone',
            messageFieldText: 'Message',
            buttonText: 'Submit',

            postMixInProperties: function () {
                try {
                    if (this.srcNodeRef) {
                        domAttr.set(this.srcNodeRef, 'innerHTML', '');
                    }
                    this.inherited(arguments);
                } catch (e) {
                     console.error(this.declaredClass, arguments, e);
                     throw e;
                }
            },

            busy: function () {
                try {
                    this.buttonWidget && this.buttonWidget.makeBusy();
                } catch (e) {
                     console.error(this.declaredClass, arguments, e);
                     throw e;
                }
            },

            cancel: function () {
                try {
                    this.buttonWidget && this.buttonWidget.cancel();
                } catch (e) {
                     console.error(this.declaredClass, arguments, e);
                     throw e;
                }
            }
        });
    });
