/***************************************************************************************************
 LoadingOverlay - A flexible loading overlay jQuery plugin
 Author            : Gaspare Sganga
 Version            : 1.0
 License            : MIT
 Documentation    : http://gasparesganga.com/labs/jquery-loading-overlay
 ****************************************************************************************************/
!function (a, b) {
    function d(c, d, e) {
        c = a(c);
        var g = c.data("LoadingOverlayCount");
        if (g === b && (g = 0), 0 == g) {
            var h = a("<div>", {
                "class": "loadingoverlay",
                css: {
                    "background-color": d.color,
                    "background-image": d.image ? "url(" + d.image + ")" : "none",
                    "background-position": "center center",
                    "background-repeat": "no-repeat"
                }
            });
            if (e)h.css({
                position: "fixed",
                top: 0,
                left: 0,
                width: "100%",
                height: "100%"
            }); else if (h.css({
                    position: "absolute",
                    top: 0,
                    left: 0
                }), f(c, h, d), "static" == c.css("position") && h.css({
                    top: c.position().top + parseInt(c.css("margin-top")) + parseInt(c.css("border-top-width")),
                    left: c.position().left + parseInt(c.css("margin-left")) + parseInt(c.css("border-left-width"))
                }), d.resizeInterval > 0) {
                var i = setInterval(function () {
                    f(c, h, d)
                }, d.resizeInterval);
                c.data("LoadingOverlayResizeIntervalId", i)
            }
            h.appendTo(c)
        }
        g++, c.data("LoadingOverlayCount", g)
    }

    function e(c, d) {
        c = a(c);
        var e = c.data("LoadingOverlayCount");
        if (e !== b)if (e--, d || 0 >= e) {
            var f = c.data("LoadingOverlayResizeIntervalId");
            f && clearInterval(f), c.removeData("LoadingOverlayCount").removeData("LoadingOverlayResizeIntervalId"), c.children(".loadingoverlay").remove()
        } else c.data("LoadingOverlayCount", e)
    }

    function f(b, c, d) {
        var e = "auto";
        if (d.size && "auto" != d.size) {
            var e = Math.min(b.innerWidth(), b.innerHeight()) * parseFloat(d.size) / 100;
            d.maxSize && e > parseInt(d.maxSize) && (e = parseInt(d.maxSize) + "px"), d.minSize && e < parseInt(d.minSize) && (e = parseInt(d.minSize) + "px")
        }
        a(c).css({width: b.innerWidth(), height: b.innerHeight(), "background-size": e})
    }

    var c = {
        color: "rgba(255, 255, 255, 0.8)",
        image: "images/loading.gif",
        maxSize: "100px",
        minSize: "20px",
        resizeInterval: 0,
        size: "50%"
    };
    a.LoadingOverlaySetup = function (b) {
        a.extend(!0, c, b)
    }, a.LoadingOverlay = function (b, f) {
        switch (b.toLowerCase()) {
            case"show":
                var g = a.extend(!0, {}, c, f);
                d("body", g, !0);
                break;
            case"hide":
                e("body", f)
        }
    }, a.fn.LoadingOverlay = function (b, f) {
        switch (b.toLowerCase()) {
            case"show":
                var g = a.extend(!0, {}, c, f);
                return this.each(function () {
                    d(this, g, !1)
                });
            case"hide":
                return this.each(function () {
                    e(this, f)
                })
        }
    }
}(jQuery);