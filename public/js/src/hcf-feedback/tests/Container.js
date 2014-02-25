define(["doh/main", "require"], function(doh, require){
    if(doh.isBrowser){
        doh.register("tests.Container", require.toUrl("./Container.html"), 30000);
    }
});
