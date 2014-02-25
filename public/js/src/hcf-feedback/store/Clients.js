define([
    'dojo/_base/declare',
    'dojo-common/store/JsonRest',
    'dojo/store/Cache',
    'dojo/store/Memory',
    'dojo/store/Observable',
    'hc-backend/config'
], function (declare, JsonRest, Cache, Memory, Observable, config) {
    return Observable(Cache(JsonRest({
        target: config.get('primaryRoute')+"/clients",
        idProperty: 'id'
    }), Memory()));
});
