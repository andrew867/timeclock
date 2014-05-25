/*
 * Select text ranges - cross browser
 * Based on a post by Yann-Erwan Perio in the comp.lang.javascript (9/15/2004)
 */

var Utils = {
    NOT_SUPPORTED: {},
    DOM: {
        getElementWithId: function (id) {
            var func = function () {
                return Utils.NOT_SUPPORTED;
            }
            if (document.getElementById) {
                func = function (id) {
                    return document.getElementById(id);
                }
            } else if (document.all) {
                func = function (id) {
                    return document.all[id];
                }
            }
            return ( this.getElementWithId = func )();
        }
    },
    Ranges: {
        create: function () {
            var func = function () {
                return Utils.NOT_SUPPORTED
            };
            if (document.body && document.body.createTextRange) {
                func = function () {
                    return document.body.createTextRange();
                }
            } else if (document.createRange) {
                func = function () {
                    return document.createRange();
                }
            }
            return (this.create = func)();
        },
        selectNode: function (node, originalRng) {
            var func = function () {
                return Utils.NOT_SUPPORTED;
            };
            var rng = this.create(), method = '';
            if (rng.moveToElementText) {
                method = 'moveToElementText';
            }
            else if (rng.selectNode) {
                method = 'selectNode';
            }
            if (method)
                func = function (node, rng) {
                    rng = rng || Utils.Ranges.create();
                    rng[method](node);
                    return rng;
                }
            return rng = null, (this.selectNode = func)(node, originalRng);
        }
    },
    Selection: {
        clear: function () {
            var func = function () {
                return Utils.NOT_SUPPORTED
            };
            if (typeof document.selection !== 'undefined') {
                func = function () {
                    if (document.selection && document.selection.empty) {
                        return (Utils.Selection.clear = function () {
                            if (document.selection) {
                                document.selection.empty();
                            }
                        })();
                    }
                }
            } else if (window.getSelection) {
                var sel = window.getSelection();
                if (sel.removeAllRanges) {
                    func = function () {
                        window.getSelection().removeAllRanges();
                    }
                }
                sel = null;
            }
            return (this.clear = func)();
        },
        add: function (originalRng) {
            var func = function () {
                return Utils.NOT_SUPPORTED
            };
            var rng = Utils.Ranges.create();
            if (rng.select) {
                func = function (rng) {
                    rng.select();
                }
            } else if (window.getSelection) {
                var sel = window.getSelection();
                if (sel.addRange) {
                    func = function (rng) {
                        window.getSelection().addRange(rng);
                    }
                }
                sel = null;
            }
            return (this.add = func)(originalRng);
        }
    }
};
