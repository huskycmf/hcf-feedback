define(['dojo/_base/declare',
        'dijit/_Widget',
        'dojo/dom-style',
        'dojo/dom-construct'],
    function(declare, _Widget, domStyle, domConstruct) {
        return declare([ _Widget ], {
            errorClass: 'error',
            errorElement: 'div',
            errors: [],

            buildRendering: function () {
                try {
                    this.inherited(arguments);
                    domStyle.set(this.domNode, 'display', 'none');
                } catch (e) {
                     console.error(this.declaredClass, arguments, e);
                     throw e;
                }
            },

            _setErrorsAttr: function (errors) {
                try {
                   if (errors instanceof Array) {
                        this.errors = errors;
                   } else {
                       this.errors = [errors];
                   }

                   for ( var key in this.errors) {
                       domConstruct.create(this.errorElement,
                                           {'class': this.errorClass,
                                            'innerHTML': this.errors[key]},
                                           this.domNode);
                   }
                } catch (e) {
                     console.error(this.declaredClass, arguments, e);
                     throw e;
                }
            }
        });
    });
