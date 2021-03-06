!(function (t, e) {
    "object" == typeof exports && "undefined" != typeof module
        ? e(exports, require("echarts"))
        : "function" == typeof define && define.amd
        ? define(["exports", "echarts"], e)
        : e(((t = t || self)["@chartisan/echarts"] = {}), t.echarts);
})(this, function (t, e) {
    "use strict";
    /*! *****************************************************************************
    Copyright (c) Microsoft Corporation. All rights reserved.
    Licensed under the Apache License, Version 2.0 (the "License"); you may not use
    this file except in compliance with the License. You may obtain a copy of the
    License at http://www.apache.org/licenses/LICENSE-2.0

    THIS CODE IS PROVIDED ON AN *AS IS* BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
    KIND, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED
    WARRANTIES OR CONDITIONS OF TITLE, FITNESS FOR A PARTICULAR PURPOSE,
    MERCHANTABLITY OR NON-INFRINGEMENT.

    See the Apache Version 2.0 License for specific language governing permissions
    and limitations under the License.
    ***************************************************************************** */ var n =
        function (t, e) {
            return (n =
                Object.setPrototypeOf ||
                ({ __proto__: [] } instanceof Array &&
                    function (t, e) {
                        t.__proto__ = e;
                    }) ||
                function (t, e) {
                    for (var n in e) e.hasOwnProperty(n) && (t[n] = e[n]);
                })(t, e);
        };
    function r(t, e) {
        function r() {
            this.constructor = t;
        }
        n(t, e),
            (t.prototype =
                null === e
                    ? Object.create(e)
                    : ((r.prototype = e.prototype), new r()));
    }
    var o = function () {
        return (o =
            Object.assign ||
            function (t) {
                for (var e, n = 1, r = arguments.length; n < r; n++)
                    for (var o in (e = arguments[n]))
                        Object.prototype.hasOwnProperty.call(e, o) &&
                            (t[o] = e[o]);
                return t;
            }).apply(this, arguments);
    };
    function i(t) {
        return (
            "chart" in t &&
            "datasets" in t &&
            (function (t) {
                return "labels" in t;
            })(t.chart) &&
            t.datasets.every(function (t) {
                return (function (t) {
                    return "name" in t && "values" in t;
                })(t);
            })
        );
    }
    /*! *****************************************************************************
    Copyright (c) Microsoft Corporation. All rights reserved.
    Licensed under the Apache License, Version 2.0 (the "License"); you may not use
    this file except in compliance with the License. You may obtain a copy of the
    License at http://www.apache.org/licenses/LICENSE-2.0

    THIS CODE IS PROVIDED ON AN *AS IS* BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
    KIND, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED
    WARRANTIES OR CONDITIONS OF TITLE, FITNESS FOR A PARTICULAR PURPOSE,
    MERCHANTABLITY OR NON-INFRINGEMENT.

    See the Apache Version 2.0 License for specific language governing permissions
    and limitations under the License.
    ***************************************************************************** */ !(function (
        t,
        e
    ) {
        void 0 === e && (e = {});
        var n = e.insertAt;
        if ("undefined" != typeof document) {
            var r = document.head || document.getElementsByTagName("head")[0],
                o = document.createElement("style");
            (o.type = "text/css"),
                "top" === n && r.firstChild
                    ? r.insertBefore(o, r.firstChild)
                    : r.appendChild(o),
                o.styleSheet
                    ? (o.styleSheet.cssText = t)
                    : o.appendChild(document.createTextNode(t));
        }
    })(
        ".chartisan-controller,\n.chartisan-body {\n  position: relative;\n  height: 100%;\n  width: 100%;\n  display: flex;\n  justify-content: center;\n  align-items: center;\n}\n.chartisan-modal {\n  position: absolute;\n  width: 100%;\n  height: 100%;\n  justify-content: center;\n  align-items: center;\n}\n.chartisan-help-block {\n  display: flex;\n  flex-direction: column;\n  justify-content: center;\n  align-items: center;\n}\n.chartisan-help-text {\n  margin-top: 1.5rem;\n  text-transform: uppercase;\n  letter-spacing: 0.2em;\n  font-size: 0.75rem;\n}\n.chartisan-help-text-error {\n  margin-top: 1.5rem;\n  text-transform: uppercase;\n  letter-spacing: 0.2em;\n  font-size: 0.6rem;\n  color: #f56565;\n}\n.chartisan-refresh-chart {\n  cursor: pointer;\n}\n"
    );
    var a = function () {
        return (a =
            Object.assign ||
            function (t) {
                for (var e, n = 1, r = arguments.length; n < r; n++)
                    for (var o in (e = arguments[n]))
                        Object.prototype.hasOwnProperty.call(e, o) &&
                            (t[o] = e[o]);
                return t;
            }).apply(this, arguments);
    };
    function s(t, e) {
        var n = "function" == typeof Symbol && t[Symbol.iterator];
        if (!n) return t;
        var r,
            o,
            i = n.call(t),
            a = [];
        try {
            for (; (void 0 === e || e-- > 0) && !(r = i.next()).done; )
                a.push(r.value);
        } catch (t) {
            o = { error: t };
        } finally {
            try {
                r && !r.done && (n = i.return) && n.call(i);
            } finally {
                if (o) throw o.error;
            }
        }
        return a;
    }
    var c = (function () {
            function t() {
                this.hooks = [];
            }
            return (
                (t.prototype.custom = function (t) {
                    return this.hooks.push(t), this;
                }),
                (t.prototype.options = function (t) {
                    return this.custom(function (e) {
                        var n = e.data;
                        return (0, e.merge)(n, t);
                    });
                }),
                (t.prototype.merge = function (t) {
                    return (
                        (this.hooks = (function () {
                            for (var t = [], e = 0; e < arguments.length; e++)
                                t = t.concat(s(arguments[e]));
                            return t;
                        })(this.hooks, t.hooks)),
                        this
                    );
                }),
                t
            );
        })(),
        u = function (t) {
            return (
                (function (t) {
                    return !!t && "object" == typeof t;
                })(t) &&
                !(function (t) {
                    var e = Object.prototype.toString.call(t);
                    return (
                        "[object RegExp]" === e ||
                        "[object Date]" === e ||
                        (function (t) {
                            return t.$$typeof === l;
                        })(t)
                    );
                })(t)
            );
        },
        l =
            "function" == typeof Symbol && Symbol.for
                ? Symbol.for("react.element")
                : 60103;
    function h(t, e) {
        return !1 !== e.clone && e.isMergeableObject(t)
            ? v(((n = t), Array.isArray(n) ? [] : {}), t, e)
            : t;
        var n;
    }
    function d(t, e, n) {
        return t.concat(e).map(function (t) {
            return h(t, n);
        });
    }
    function p(t) {
        return Object.keys(t).concat(
            (function (t) {
                return Object.getOwnPropertySymbols
                    ? Object.getOwnPropertySymbols(t).filter(function (e) {
                          return t.propertyIsEnumerable(e);
                      })
                    : [];
            })(t)
        );
    }
    function f(t, e) {
        try {
            return e in t;
        } catch (t) {
            return !1;
        }
    }
    function v(t, e, n) {
        ((n = n || {}).arrayMerge = n.arrayMerge || d),
            (n.isMergeableObject = n.isMergeableObject || u),
            (n.cloneUnlessOtherwiseSpecified = h);
        var r = Array.isArray(e);
        return r === Array.isArray(t)
            ? r
                ? n.arrayMerge(t, e, n)
                : (function (t, e, n) {
                      var r = {};
                      return (
                          n.isMergeableObject(t) &&
                              p(t).forEach(function (e) {
                                  r[e] = h(t[e], n);
                              }),
                          p(e).forEach(function (o) {
                              (function (t, e) {
                                  return (
                                      f(t, e) &&
                                      !(
                                          Object.hasOwnProperty.call(t, e) &&
                                          Object.propertyIsEnumerable.call(t, e)
                                      )
                                  );
                              })(t, o) ||
                                  (f(t, o) && n.isMergeableObject(e[o])
                                      ? (r[o] = (function (t, e) {
                                            if (!e.customMerge) return v;
                                            var n = e.customMerge(t);
                                            return "function" == typeof n
                                                ? n
                                                : v;
                                        })(o, n)(t[o], e[o], n))
                                      : (r[o] = h(e[o], n)));
                          }),
                          r
                      );
                  })(t, e, n)
            : h(e, n);
    }
    v.all = function (t, e) {
        if (!Array.isArray(t))
            throw new Error("first argument should be an array");
        return t.reduce(function (t, n) {
            return v(t, n, e);
        }, {});
    };
    var y,
        g,
        b = [
            "#667EEA",
            "#F56565",
            "#48BB78",
            "#ED8936",
            "#9F7AEA",
            "#38B2AC",
            "#ECC94B",
            "#4299E1",
            "#ED64A6",
        ],
        m = v,
        w = {
            general: function (t) {
                var e = t.size,
                    n = t.color;
                return (
                    '\n    <svg\n        role="img"\n        xmlns="http://www.w3.org/2000/svg"\n        width="' +
                    e[0] +
                    '"\n        height="' +
                    e[1] +
                    '"\n        viewBox="0 0 24 24"\n        aria-labelledby="refreshIconTitle"\n        stroke="' +
                    n +
                    '"\n        stroke-width="1"\n        stroke-linecap="square"\n        stroke-linejoin="miter"\n        fill="none"\n        color="' +
                    n +
                    '"\n    >\n        <title id="refreshIconTitle">Refresh</title>\n        <polyline points="22 12 19 15 16 12"/>\n        <path d="M11,20 C6.581722,20 3,16.418278 3,12 C3,7.581722 6.581722,4 11,4 C15.418278,4 19,7.581722 19,12 L19,14"/>\n    </svg>\n'
                );
            },
        },
        x = function (t, e) {
            return (
                '\n    <div class="chartisan-help-block">\n    <div class="chartisan-refresh-chart">\n        ' +
                w[t.type](t) +
                "\n    </div>\n    " +
                ("" == t.text
                    ? ""
                    : '\n            <div class="chartisan-help-text" style="color: ' +
                      t.textColor +
                      ';">\n                ' +
                      t.text +
                      "\n            </div>\n            ") +
                "\n    " +
                (t.debug
                    ? '\n            <div class="chartisan-help-text-error">\n                ' +
                      e.message +
                      "\n            </div>"
                    : "") +
                "\n    </div>\n"
            );
        },
        $ = {
            bar: function (t) {
                var e = t.size,
                    n = t.color;
                return (
                    '\n    <svg width="' +
                    e[0] +
                    '" height="' +
                    e[1] +
                    '" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="' +
                    n +
                    '">\n        <rect y="10" width="15" height="120" rx="6">\n            <animate attributeName="height"\n                begin="0.5s" dur="1s"\n                values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"\n                repeatCount="indefinite" />\n            <animate attributeName="y"\n                begin="0.5s" dur="1s"\n                values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"\n                repeatCount="indefinite" />\n        </rect>\n        <rect x="30" y="10" width="15" height="120" rx="6">\n            <animate attributeName="height"\n                begin="0.25s" dur="1s"\n                values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"\n                repeatCount="indefinite" />\n            <animate attributeName="y"\n                begin="0.25s" dur="1s"\n                values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"\n                repeatCount="indefinite" />\n        </rect>\n        <rect x="60" width="15" height="140" rx="6">\n            <animate attributeName="height"\n                begin="0s" dur="1s"\n                values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"\n                repeatCount="indefinite" />\n            <animate attributeName="y"\n                begin="0s" dur="1s"\n                values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"\n                repeatCount="indefinite" />\n        </rect>\n        <rect x="90" y="10" width="15" height="120" rx="6">\n            <animate attributeName="height"\n                begin="0.25s" dur="1s"\n                values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"\n                repeatCount="indefinite" />\n            <animate attributeName="y"\n                begin="0.25s" dur="1s"\n                values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"\n                repeatCount="indefinite" />\n        </rect>\n        <rect x="120" y="10" width="15" height="120" rx="6">\n            <animate attributeName="height"\n                begin="0.5s" dur="1s"\n                values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"\n                repeatCount="indefinite" />\n            <animate attributeName="y"\n                begin="0.5s" dur="1s"\n                values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"\n                repeatCount="indefinite" />\n        </rect>\n    </svg>\n'
                );
            },
        },
        O = function (t) {
            return (
                '\n    <div class="chartisan-help-block">\n        ' +
                $[t.type](t) +
                "\n        " +
                ("" == t.text
                    ? ""
                    : '\n                <div class="chartisan-help-text" style="color: ' +
                      t.textColor +
                      ';">\n                    ' +
                      t.text +
                      "\n                </div>") +
                "\n    </div>\n"
            );
        };
    ((g = y || (y = {})).Initializing = "initializing"),
        (g.Loading = "loading"),
        (g.Error = "error"),
        (g.Show = "show");
    var E = (function () {
        function t(t) {
            (this.options = {
                el: ".chartisan",
                url: void 0,
                options: void 0,
                data: void 0,
                loader: {
                    type: "bar",
                    size: [35, 35],
                    color: "#000",
                    text: "Loading chart",
                    textColor: "#a0aec0",
                },
                error: {
                    type: "general",
                    size: [50, 50],
                    color: "#f56565",
                    text: "There was an error",
                    textColor: "#a0aec0",
                    debug: !0,
                },
                hooks: void 0,
            }),
                (this.cstate = y.Initializing);
            var e = (this.options = a(a({}, this.options), t)).el;
            if ("string" == typeof e) {
                var n = document.querySelector(e);
                if (!n)
                    throw Error(
                        "[Chartisan] Unable to find an element to bind the chart to a DOM element with the selector: '" +
                            e +
                            "'"
                    );
                this.element = n;
            } else this.element = e;
            if (this.element.querySelector(".chartisan-controller"))
                throw Error(
                    "[Chartisan] There seems to be a chart already at the element selected by: '" +
                        e +
                        "'"
                );
            (this.controller = document.createElement("div")),
                (this.body = document.createElement("div")),
                (this.modal = document.createElement("div")),
                this.bootstrap();
        }
        return (
            (t.prototype.setModal = function (t) {
                var e = t.show,
                    n = void 0 === e || e,
                    r = t.color,
                    o = void 0 === r ? "#FFFFFF" : r,
                    i = t.content;
                (this.modal.style.backgroundColor = o),
                    (this.modal.style.display = n ? "flex" : "none"),
                    i && (this.modal.innerHTML = i);
            }),
            (t.prototype.changeTo = function (t, e) {
                switch (t) {
                    case (y.Initializing, y.Loading):
                        this.setModal({
                            show: !0,
                            content: O(this.options.loader),
                        });
                        break;
                    case y.Show:
                        this.setModal({ show: !1 });
                        break;
                    case y.Error:
                        this.setModal({
                            show: !0,
                            content: x(
                                this.options.error,
                                null != e ? e : new Error("Unknown Error")
                            ),
                        }),
                            this.refreshEvent();
                }
                this.cstate = t;
            }),
            (t.prototype.bootstrap = function () {
                this.element.appendChild(this.controller),
                    this.controller.appendChild(this.body),
                    this.controller.appendChild(this.modal),
                    this.controller.classList.add("chartisan-controller"),
                    this.body.classList.add("chartisan-body"),
                    this.modal.classList.add("chartisan-modal"),
                    this.update(this.options);
            }),
            (t.prototype.request = function (t) {
                var e = this;
                return this.options.url
                    ? void fetch(this.options.url, this.options.options)
                          .then(function (t) {
                              return t.json();
                          })
                          .then(function (n) {
                              return e.onRawUpdate(n, t);
                          })
                          .catch(function (t) {
                              return e.onError(t);
                          })
                    : this.onError(
                          new Error("No URL provided to fetch the data.")
                      );
            }),
            (t.prototype.refreshEvent = function () {
                var t = this;
                this.controller
                    .getElementsByClassName("chartisan-refresh-chart")[0]
                    .addEventListener(
                        "click",
                        function () {
                            return t.update();
                        },
                        { once: !0 }
                    );
            }),
            (t.prototype.update = function (t) {
                var e, n, r, o, a, s, c;
                if (
                    ((null === (e = t) || void 0 === e ? void 0 : e.url) &&
                        (this.options.url = t.url),
                    (null === (n = t) || void 0 === n ? void 0 : n.options) &&
                        (this.options.options = t.options),
                    null === (r = t) || void 0 === r ? void 0 : r.data)
                ) {
                    var u = void 0;
                    i(t.data)
                        ? (u = t.data)
                        : ((null === (o = t) ||
                              void 0 === o ||
                              !o.background) &&
                              this.changeTo(y.Loading),
                          (u = t.data()));
                    var l = this.getDataFrom(u);
                    return (
                        this.changeTo(y.Show),
                        t.background
                            ? this.onBackgroundUpdate(
                                  l,
                                  null === (a = t) || void 0 === a
                                      ? void 0
                                      : a.additional
                              )
                            : this.onUpdate(
                                  l,
                                  null === (s = t) || void 0 === s
                                      ? void 0
                                      : s.additional
                              )
                    );
                }
                (null === (c = t) || void 0 === c ? void 0 : c.background) ||
                    this.changeTo(y.Loading),
                    this.request(t);
            }),
            (t.prototype.destroy = function () {
                this.onDestroy(), this.controller.remove();
            }),
            (t.prototype.getDataFrom = function (t) {
                var e,
                    n,
                    r = this.formatData(t);
                if (this.options.hooks)
                    try {
                        for (
                            var o = (function (t) {
                                    var e =
                                            "function" == typeof Symbol &&
                                            t[Symbol.iterator],
                                        n = 0;
                                    return e
                                        ? e.call(t)
                                        : {
                                              next: function () {
                                                  return (
                                                      t &&
                                                          n >= t.length &&
                                                          (t = void 0),
                                                      {
                                                          value: t && t[n++],
                                                          done: !t,
                                                      }
                                                  );
                                              },
                                          };
                                })(this.options.hooks.hooks),
                                i = o.next();
                            !i.done;
                            i = o.next()
                        )
                            r = (0, i.value)({ data: r, merge: m, server: t });
                    } catch (t) {
                        e = { error: t };
                    } finally {
                        try {
                            i && !i.done && (n = o.return) && n.call(o);
                        } finally {
                            if (e) throw e.error;
                        }
                    }
                return r;
            }),
            (t.prototype.onRawUpdate = function (t, e) {
                var n, r, o;
                if (!i(t))
                    return this.onError(new Error("Invalid server data"));
                var a = this.getDataFrom(t);
                this.changeTo(y.Show),
                    (null === (n = e) || void 0 === n ? void 0 : n.background)
                        ? this.onBackgroundUpdate(
                              a,
                              null === (r = e) || void 0 === r
                                  ? void 0
                                  : r.additional
                          )
                        : this.onUpdate(
                              a,
                              null === (o = e) || void 0 === o
                                  ? void 0
                                  : o.additional
                          );
            }),
            (t.prototype.onError = function (t) {
                this.changeTo(y.Error, t);
            }),
            (t.prototype.state = function () {
                return this.cstate;
            }),
            t
        );
    })();
    function C(t, e) {
        var n, r, o, i;
        return t
            ? Array.isArray(t)
                ? null !=
                  (r = null === (n = t[0].data) || void 0 === n ? void 0 : n[e])
                    ? r
                    : ""
                : null !=
                  (i = null === (o = t.data) || void 0 === o ? void 0 : o[e])
                ? i
                : ""
            : "";
    }
    var T = (function (t) {
        function e() {
            return (null !== t && t.apply(this, arguments)) || this;
        }
        return (
            r(e, t),
            (e.prototype.title = function (t) {
                return this.options({
                    title: "string" == typeof t ? { text: t } : t,
                });
            }),
            (e.prototype.axis = function (t) {
                return (
                    void 0 === t && (t = !0),
                    this.options(
                        o(
                            {},
                            "boolean" == typeof t
                                ? (t = {
                                      xAxis: { show: t },
                                      yAxis: { show: t },
                                  })
                                : t
                        )
                    )
                );
            }),
            (e.prototype.legend = function (t) {
                return (
                    void 0 === t && (t = !0),
                    this.options({
                        legend: "boolean" == typeof t ? { show: t } : t,
                    })
                );
            }),
            (e.prototype.tooltip = function (t) {
                return (
                    void 0 === t && (t = !0),
                    this.options({
                        tooltip: "boolean" == typeof t ? { show: t } : t,
                    })
                );
            }),
            (e.prototype.colors = function (t) {
                return (
                    void 0 === t && (t = b),
                    this.custom(function (e) {
                        var n = e.data;
                        return (n.color = t) && n;
                    })
                );
            }),
            (e.prototype.datasets = function (t) {
                return this.custom(function (e) {
                    var n,
                        r,
                        o = e.data,
                        i = e.merge,
                        a = Array.isArray(t)
                            ? t.map(function (t) {
                                  return "string" == typeof t ? { type: t } : t;
                              })
                            : [{ type: t }];
                    if (o.series)
                        for (var s = 0; s < o.series.length; s++)
                            (o.series[s] = i(o.series[s], a[s % a.length])),
                                "pie" == a[s % a.length].type &&
                                    (o.series[s].data =
                                        null ===
                                            (r =
                                                null === (n = o.series[s]) ||
                                                void 0 === n
                                                    ? void 0
                                                    : n.data) || void 0 === r
                                            ? void 0
                                            : r.map(function (t, e) {
                                                  return {
                                                      value: t,
                                                      name: C(o.xAxis, e),
                                                  };
                                              }));
                    return o;
                });
            }),
            e
        );
    })(c);
    function k(t) {
        return t &&
            t.__esModule &&
            Object.prototype.hasOwnProperty.call(t, "default")
            ? t.default
            : t;
    }
    function j(t, e) {
        return t((e = { exports: {} }), e.exports), e.exports;
    }
    var M = j(function (t, e) {
        Object.defineProperty(e, "__esModule", { value: !0 });
        e.ContentRect = function (t) {
            if ("getBBox" in t) {
                var e = t.getBBox();
                return Object.freeze({
                    height: e.height,
                    left: 0,
                    top: 0,
                    width: e.width,
                });
            }
            var n = window.getComputedStyle(t);
            return Object.freeze({
                height: parseFloat(n.height || "0"),
                left: parseFloat(n.paddingLeft || "0"),
                top: parseFloat(n.paddingTop || "0"),
                width: parseFloat(n.width || "0"),
            });
        };
    });
    k(M);
    M.ContentRect;
    var z = j(function (t, e) {
        Object.defineProperty(e, "__esModule", { value: !0 });
        var n = (function () {
            function t(t) {
                (this.target = t),
                    (this.$$broadcastWidth = this.$$broadcastHeight = 0);
            }
            return (
                Object.defineProperty(t.prototype, "broadcastWidth", {
                    get: function () {
                        return this.$$broadcastWidth;
                    },
                    enumerable: !0,
                    configurable: !0,
                }),
                Object.defineProperty(t.prototype, "broadcastHeight", {
                    get: function () {
                        return this.$$broadcastHeight;
                    },
                    enumerable: !0,
                    configurable: !0,
                }),
                (t.prototype.isActive = function () {
                    var t = M.ContentRect(this.target);
                    return (
                        !!t &&
                        (t.width !== this.broadcastWidth ||
                            t.height !== this.broadcastHeight)
                    );
                }),
                t
            );
        })();
        e.ResizeObservation = n;
    });
    k(z);
    z.ResizeObservation;
    var A = j(function (t, e) {
        Object.defineProperty(e, "__esModule", { value: !0 });
        var n = function (t) {
            (this.target = t), (this.contentRect = M.ContentRect(t));
        };
        e.ResizeObserverEntry = n;
    });
    k(A);
    A.ResizeObserverEntry;
    var R = j(function (t, e) {
        Object.defineProperty(e, "__esModule", { value: !0 });
        var n = [],
            r = (function () {
                function t(t) {
                    (this.$$observationTargets = []),
                        (this.$$activeTargets = []),
                        (this.$$skippedTargets = []);
                    var e = (function (t) {
                        if (void 0 === t)
                            return "Failed to construct 'ResizeObserver': 1 argument required, but only 0 present.";
                        if ("function" != typeof t)
                            return "Failed to construct 'ResizeObserver': The callback provided as parameter 1 is not a function.";
                    })(t);
                    if (e) throw TypeError(e);
                    (this.$$callback = t), n.push(this);
                }
                return (
                    (t.prototype.observe = function (t) {
                        var e = o("observe", t);
                        if (e) throw TypeError(e);
                        i(this.$$observationTargets, t) > 0 ||
                            (this.$$observationTargets.push(
                                new z.ResizeObservation(t)
                            ),
                            h());
                    }),
                    (t.prototype.unobserve = function (t) {
                        var e = o("unobserve", t);
                        if (e) throw TypeError(e);
                        var n = i(this.$$observationTargets, t);
                        n < 0 || (this.$$observationTargets.splice(n, 1), p());
                    }),
                    (t.prototype.disconnect = function () {
                        (this.$$observationTargets = []),
                            (this.$$activeTargets = []);
                    }),
                    t
                );
            })();
        function o(t, e) {
            return void 0 === e
                ? "Failed to execute '" +
                      t +
                      "' on 'ResizeObserver': 1 argument required, but only 0 present."
                : e instanceof window.Element
                ? void 0
                : "Failed to execute '" +
                  t +
                  "' on 'ResizeObserver': parameter 1 is not of type 'Element'.";
        }
        function i(t, e) {
            for (var n = 0; n < t.length; n += 1)
                if (t[n].target === e) return n;
            return -1;
        }
        e.ResizeObserver = r;
        var a,
            s = function (t) {
                n.forEach(function (e) {
                    (e.$$activeTargets = []),
                        (e.$$skippedTargets = []),
                        e.$$observationTargets.forEach(function (n) {
                            n.isActive() &&
                                (u(n.target) > t
                                    ? e.$$activeTargets.push(n)
                                    : e.$$skippedTargets.push(n));
                        });
                });
            },
            c = function () {
                var t = 1 / 0;
                return (
                    n.forEach(function (e) {
                        if (e.$$activeTargets.length) {
                            var n = [];
                            e.$$activeTargets.forEach(function (e) {
                                var r = new A.ResizeObserverEntry(e.target);
                                n.push(r),
                                    (e.$$broadcastWidth = r.contentRect.width),
                                    (e.$$broadcastHeight =
                                        r.contentRect.height);
                                var o = u(e.target);
                                o < t && (t = o);
                            }),
                                e.$$callback(n, e),
                                (e.$$activeTargets = []);
                        }
                    }),
                    t
                );
            },
            u = function (t) {
                for (var e = 0; t.parentNode; ) (t = t.parentNode), (e += 1);
                return e;
            },
            l = function () {
                var t,
                    e = 0;
                for (
                    s(e);
                    n.some(function (t) {
                        return !!t.$$activeTargets.length;
                    });

                )
                    (e = c()), s(e);
                n.some(function (t) {
                    return !!t.$$skippedTargets.length;
                }) &&
                    ((t = new window.ErrorEvent("ResizeLoopError", {
                        message:
                            "ResizeObserver loop completed with undelivered notifications.",
                    })),
                    window.dispatchEvent(t));
            },
            h = function () {
                a || d();
            },
            d = function () {
                a = window.requestAnimationFrame(function () {
                    l(), d();
                });
            },
            p = function () {
                a &&
                    !n.some(function (t) {
                        return !!t.$$observationTargets.length;
                    }) &&
                    (window.cancelAnimationFrame(a), (a = void 0));
            };
        e.install = function () {
            return (window.ResizeObserver = r);
        };
    });
    k(R);
    var F = R.ResizeObserver,
        S = R.install,
        _ = (function (t) {
            function n() {
                return (null !== t && t.apply(this, arguments)) || this;
            }
            return (
                r(n, t),
                (n.prototype.observe = function () {
                    var t = this;
                    this.observer && this.observer.disconnect(),
                        (this.observer = new F(function () {
                            var e;
                            return null === (e = t.chart) || void 0 === e
                                ? void 0
                                : e.resize();
                        })),
                        this.div && this.observer.observe(this.div);
                }),
                (n.prototype.renewDiv = function () {
                    this.div && this.body.removeChild(this.div),
                        (this.div = document.createElement("div")),
                        (this.div.style.width = "100%"),
                        (this.div.style.height = "100%"),
                        this.body.appendChild(this.div),
                        this.observe();
                }),
                (n.prototype.formatData = function (t) {
                    return {
                        xAxis: { data: t.chart.labels },
                        yAxis: {},
                        series: t.datasets.map(function (t) {
                            return {
                                name: t.name,
                                type: "bar",
                                data: t.values,
                            };
                        }),
                    };
                }),
                (n.prototype.onUpdate = function (t) {
                    this.chart && this.chart.dispose(),
                        this.renewDiv(),
                        (this.chart = e.init(this.div)),
                        this.chart.setOption(t);
                }),
                (n.prototype.onBackgroundUpdate = function (t) {
                    this.chart ? this.chart.setOption(t) : this.onUpdate(t);
                }),
                (n.prototype.onDestroy = function () {
                    this.chart && this.chart.dispose();
                }),
                n
            );
        })(E);
    "undefined" != typeof window &&
        (window.hasOwnProperty("ResizeObserver") || S(),
        (window.Chartisan = _),
        (window.ChartisanHooks = T)),
        (t.Chartisan = _),
        (t.ChartisanHooks = T),
        Object.defineProperty(t, "__esModule", { value: !0 });
});
