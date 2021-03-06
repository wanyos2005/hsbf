/*!
 * Fine Uploader
 *
 * Copyright 2013, Widen Enterprises, Inc. info@fineuploader.com
 *
 * Version: 3.7.0
 *
 * Homepage: http://fineuploader.com
 *
 * Repository: git://github.com/Widen/fine-uploader.git
 *
 * Licensed under GNU GPL v3, see LICENSE
 */
var qq = function(a) {
        "use strict";
        return {
                hide: function() {
                        return a.style.display = "none", this
                },
                attach: function(b, c) {
                        return a.addEventListener ? a.addEventListener(b, c, !1) : a.attachEvent && a.attachEvent("on" + b, c),
                                function() {
                                        qq(a).detach(b, c)
                                }
                },
                detach: function(b, c) {
                        return a.removeEventListener ? a.removeEventListener(b, c, !1) : a.attachEvent && a.detachEvent("on" + b, c), this
                },
                contains: function(b) {
                        return b ? a === b ? !0 : a.contains ? a.contains(b) : !!(8 & b.compareDocumentPosition(a)) : !1
                },
                insertBefore: function(b) {
                        return b.parentNode.insertBefore(a, b), this
                },
                remove: function() {
                        return a.parentNode.removeChild(a), this
                },
                css: function(b) {
                        return null != b.opacity && "string" != typeof a.style.opacity && "undefined" != typeof a.filters && (b.filter = "alpha(opacity=" + Math.round(100 * b.opacity) + ")"), qq.extend(a.style, b), this
                },
                hasClass: function(b) {
                        var c = new RegExp("(^| )" + b + "( |$)");
                        return c.test(a.className)
                },
                addClass: function(b) {
                        return qq(a).hasClass(b) || (a.className += " " + b), this
                },
                removeClass: function(b) {
                        var c = new RegExp("(^| )" + b + "( |$)");
                        return a.className = a.className.replace(c, " ").replace(/^\s+|\s+$/g, ""), this
                },
                getByClass: function(b) {
                        var c, d = [];
                        return a.querySelectorAll ? a.querySelectorAll("." + b) : (c = a.getElementsByTagName("*"), qq.each(c, function(a, c) {
                                qq(c).hasClass(b) && d.push(c)
                        }), d)
                },
                children: function() {
                        for (var b = [], c = a.firstChild; c; )
                                1 === c.nodeType && b.push(c), c = c.nextSibling;
                        return b
                },
                setText: function(b) {
                        return a.innerText = b, a.textContent = b, this
                },
                clearText: function() {
                        return qq(a).setText("")
                }
        }
};
qq.log = function(a, b) {
        "use strict";
        window.console && (b && "info" !== b ? window.console[b] ? window.console[b](a) : window.console.log("<" + b + "> " + a) : window.console.log(a))
}, qq.isObject = function(a) {
        "use strict";
        return a && !a.nodeType && "[object Object]" === Object.prototype.toString.call(a)
}, qq.isFunction = function(a) {
        "use strict";
        return "function" == typeof a
}, qq.isArray = function(a) {
        "use strict";
        return "[object Array]" === Object.prototype.toString.call(a)
}, qq.isString = function(a) {
        "use strict";
        return "[object String]" === Object.prototype.toString.call(a)
}, qq.trimStr = function(a) {
        return String.prototype.trim ? a.trim() : a.replace(/^\s+|\s+$/g, "")
}, qq.format = function(a) {
        "use strict";
        var b = Array.prototype.slice.call(arguments, 1),
                c = a;
        return qq.each(b, function(a, b) {
                c = c.replace(/{}/, b)
        }), c
}, qq.isFile = function(a) {
        "use strict";
        return window.File && "[object File]" === Object.prototype.toString.call(a)
}, qq.isFileList = function(a) {
        return window.FileList && "[object FileList]" === Object.prototype.toString.call(a)
}, qq.isFileOrInput = function(a) {
        "use strict";
        return qq.isFile(a) || qq.isInput(a)
}, qq.isInput = function(a) {
        return window.HTMLInputElement && "[object HTMLInputElement]" === Object.prototype.toString.call(a) && a.type && "file" === a.type.toLowerCase() ? !0 : a.tagName && "input" === a.tagName.toLowerCase() && a.type && "file" === a.type.toLowerCase() ? !0 : !1
}, qq.isBlob = function(a) {
        "use strict";
        return window.Blob && "[object Blob]" === Object.prototype.toString.call(a)
}, qq.isXhrUploadSupported = function() {
        "use strict";
        var a = document.createElement("input");
        return a.type = "file", void 0 !== a.multiple && "undefined" != typeof File && "undefined" != typeof FormData && "undefined" != typeof (new XMLHttpRequest).upload
}, qq.isFolderDropSupported = function(a) {
        "use strict";
        return a.items && a.items[0].webkitGetAsEntry
}, qq.isFileChunkingSupported = function() {
        "use strict";
        return !qq.android() && qq.isXhrUploadSupported() && (void 0 !== File.prototype.slice || void 0 !== File.prototype.webkitSlice || void 0 !== File.prototype.mozSlice)
}, qq.extend = function(a, b, c) {
        "use strict";
        return qq.each(b, function(b, d) {
                c && qq.isObject(d) ? (void 0 === a[b] && (a[b] = {}), qq.extend(a[b], d, !0)) : a[b] = d
        }), a
}, qq.indexOf = function(a, b, c) {
        "use strict";
        if (a.indexOf)
                return a.indexOf(b, c);
        c = c || 0;
        var d = a.length;
        for (0 > c && (c += d); d > c; c += 1)
                if (a.hasOwnProperty(c) && a[c] === b)
                        return c;
        return -1
}, qq.getUniqueId = function() {
        "use strict";
        return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(a) {
                var b = 0 | 16 * Math.random(),
                        c = "x" == a ? b : 8 | 3 & b;
                return c.toString(16)
        })
}, qq.ie = function() {
        "use strict";
        return -1 !== navigator.userAgent.indexOf("MSIE")
}, qq.ie10 = function() {
        "use strict";
        return -1 !== navigator.userAgent.indexOf("MSIE 10")
}, qq.safari = function() {
        "use strict";
        return void 0 !== navigator.vendor && -1 !== navigator.vendor.indexOf("Apple")
}, qq.chrome = function() {
        "use strict";
        return void 0 !== navigator.vendor && -1 !== navigator.vendor.indexOf("Google")
}, qq.firefox = function() {
        "use strict";
        return -1 !== navigator.userAgent.indexOf("Mozilla") && void 0 !== navigator.vendor && "" === navigator.vendor
}, qq.windows = function() {
        "use strict";
        return "Win32" === navigator.platform
}, qq.android = function() {
        "use strict";
        return -1 !== navigator.userAgent.toLowerCase().indexOf("android")
}, qq.ios = function() {
        "use strict";
        return -1 !== navigator.userAgent.indexOf("iPad") || -1 !== navigator.userAgent.indexOf("iPod") || -1 !== navigator.userAgent.indexOf("iPhone")
}, qq.preventDefault = function(a) {
        "use strict";
        a.preventDefault ? a.preventDefault() : a.returnValue = !1
}, qq.toElement = function() {
        "use strict";
        var a = document.createElement("div");
        return function(b) {
                a.innerHTML = b;
                var c = a.firstChild;
                return a.removeChild(c), c
        }
}(), qq.each = function(a, b) {
        "use strict";
        var c, d;
        if (a)
                if (qq.isArray(a))
                        for (c = 0; c < a.length && (d = b(c, a[c]), d !== !1); c++)
                                ;
                else
                        for (c in a)
                                if (Object.prototype.hasOwnProperty.call(a, c) && (d = b(c, a[c]), d === !1))
                                        break
}, qq.bind = function(a, b) {
        if (qq.isFunction(a)) {
                var c = Array.prototype.slice.call(arguments, 2);
                return function() {
                        return arguments.length && (c = c.concat(Array.prototype.slice.call(arguments))), a.apply(b, c)
                }
        }
        throw new Error("first parameter must be a function!")
}, qq.obj2url = function(a, b, c) {
        "use strict";
        var d, e, f = [],
                g = "&",
                h = function(a, c) {
                        var d = b ? /\[\]$/.test(b) ? b : b + "[" + c + "]" : c;
                        "undefined" !== d && "undefined" !== c && f.push("object" == typeof a ? qq.obj2url(a, d, !0) : "[object Function]" === Object.prototype.toString.call(a) ? encodeURIComponent(d) + "=" + encodeURIComponent(a()) : encodeURIComponent(d) + "=" + encodeURIComponent(a))
                };
        if (!c && b)
                g = /\?/.test(b) ? /\?$/.test(b) ? "" : "&" : "?", f.push(b), f.push(qq.obj2url(a));
        else if ("[object Array]" === Object.prototype.toString.call(a) && "undefined" != typeof a)
                for (d = - 1, e = a.length; e > d; d += 1)
                        h(a[d], d);
        else if ("undefined" != typeof a && null !== a && "object" == typeof a)
                for (d in a)
                        a.hasOwnProperty(d) && h(a[d], d);
        else
                f.push(encodeURIComponent(b) + "=" + encodeURIComponent(a));
        return b ? f.join(g) : f.join(g).replace(/^&/, "").replace(/%20/g, "+")
}, qq.obj2FormData = function(a, b, c) {
        "use strict";
        return b || (b = new FormData), qq.each(a, function(a, d) {
                a = c ? c + "[" + a + "]" : a, qq.isObject(d) ? qq.obj2FormData(d, b, a) : qq.isFunction(d) ? b.append(a, d()) : b.append(a, d)
        }), b
}, qq.obj2Inputs = function(a, b) {
        "use strict";
        var c;
        return b || (b = document.createElement("form")), qq.obj2FormData(a, {
                append: function(a, d) {
                        c = document.createElement("input"), c.setAttribute("name", a), c.setAttribute("value", d), b.appendChild(c)
                }
        }), b
}, qq.setCookie = function(a, b, c) {
        var d = new Date,
                e = "";
        c && (d.setTime(d.getTime() + 1e3 * 60 * 60 * 24 * c), e = "; expires=" + d.toGMTString()), document.cookie = a + "=" + b + e + "; path=/"
}, qq.getCookie = function(a) {
        var b, c = a + "=",
                d = document.cookie.split(";");
        return qq.each(d, function(a, d) {
                for (var e = d;
                        " " == e.charAt(0); )
                        e = e.substring(1, e.length);
                return 0 === e.indexOf(c) ? (b = e.substring(c.length, e.length), !1) : void 0
        }), b
}, qq.getCookieNames = function(a) {
        var b = document.cookie.split(";"),
                c = [];
        return qq.each(b, function(b, d) {
                d = qq.trimStr(d);
                var e = d.indexOf("=");
                d.match(a) && c.push(d.substr(0, e))
        }), c
}, qq.deleteCookie = function(a) {
        qq.setCookie(a, "", -1)
}, qq.areCookiesEnabled = function() {
        var a = 1e5 * Math.random(),
                b = "qqCookieTest:" + a;
        return qq.setCookie(b, 1), qq.getCookie(b) ? (qq.deleteCookie(b), !0) : !1
}, qq.parseJson = function(json) {
        return window.JSON && qq.isFunction(JSON.parse) ? JSON.parse(json) : eval("(" + json + ")")
}, qq.DisposeSupport = function() {
        "use strict";
        var a = [];
        return {
                dispose: function() {
                        var b;
                        do
                                b = a.shift(), b && b();
                        while (b)
                },
                attach: function() {
                        var a = arguments;
                        this.addDisposer(qq(a[0]).attach.apply(this, Array.prototype.slice.call(arguments, 1)))
                },
                addDisposer: function(b) {
                        a.push(b)
                }
        }
}, qq.version = "3.7.0", qq.supportedFeatures = function() {
        function a() {
                var a, b = !0;
                try {
                        a = document.createElement("input"), a.type = "file", qq(a).hide(), a.disabled && (b = !1)
                } catch (c) {
                        b = !1
                }
                return b
        }

        function b() {
                return qq.chrome() && void 0 !== navigator.userAgent.match(/Chrome\/[2][1-9]|Chrome\/[3-9][0-9]/)
        }

        function c() {
                return qq.chrome() && void 0 !== navigator.userAgent.match(/Chrome\/[1][4-9]|Chrome\/[2-9][0-9]/)
        }

        function d() {
                if (window.XMLHttpRequest) {
                        var a = new XMLHttpRequest;
                        return void 0 !== a.withCredentials
                }
                return !1
        }

        function e() {
                return void 0 !== window.XDomainRequest
        }

        function f() {
                return d() ? !0 : e()
        }
        var g, h, i, j, k, l, m, n, o, p;
        return g = a(), h = g && qq.isXhrUploadSupported(), i = h && b(), j = h && qq.isFileChunkingSupported(), k = h && j && qq.areCookiesEnabled(), l = h && c(), m = g && (void 0 !== window.postMessage || h), o = d(), n = e(), p = f(), {
                uploading: g,
                ajaxUploading: h,
                fileDrop: h,
                folderDrop: i,
                chunking: j,
                resume: k,
                uploadCustomHeaders: h,
                uploadNonMultipart: h,
                itemSizeValidation: h,
                uploadViaPaste: l,
                progressBar: h,
                uploadCors: m,
                deleteFileCorsXhr: o,
                deleteFileCorsXdr: n,
                deleteFileCors: p,
                canDetermineSize: h
        }
}(), qq.Promise = function() {
        "use strict";
        var a, b, c = [],
                d = [],
                e = [],
                f = 0;
        return {
                then: function(e, g) {
                        return 0 === f ? (e && c.push(e), g && d.push(g)) : -1 === f && g ? g(b) : e && e(a), this
                },
                done: function(a) {
                        return 0 === f ? e.push(a) : a(), this
                },
                success: function(b) {
                        return f = 1, a = b, c.length && qq.each(c, function(a, c) {
                                c(b)
                        }), e.length && qq.each(e, function(a, b) {
                                b()
                        }), this
                },
                failure: function(a) {
                        return f = -1, b = a, d.length && qq.each(d, function(b, c) {
                                c(a)
                        }), e.length && qq.each(e, function(a, b) {
                                b()
                        }), this
                }
        }
}, qq.isPromise = function(a) {
        return a && a.then && a.done
}, qq.UploadButton = function(a) {
        "use strict";

        function b() {
                var a = document.createElement("input");
                return e.multiple && a.setAttribute("multiple", "multiple"), e.acceptFiles && a.setAttribute("accept", e.acceptFiles), a.setAttribute("type", "file"), a.setAttribute("name", e.name), qq(a).css({
                        position: "absolute",
                        right: 0,
                        top: 0,
                        fontFamily: "Arial",
                        fontSize: "118px",
                        margin: 0,
                        padding: 0,
                        cursor: "pointer",
                        opacity: 0
                }), e.element.appendChild(a), d.attach(a, "change", function() {
                        e.onChange(a)
                }), d.attach(a, "mouseover", function() {
                        qq(e.element).addClass(e.hoverClass)
                }), d.attach(a, "mouseout", function() {
                        qq(e.element).removeClass(e.hoverClass)
                }), d.attach(a, "focus", function() {
                        qq(e.element).addClass(e.focusClass)
                }), d.attach(a, "blur", function() {
                        qq(e.element).removeClass(e.focusClass)
                }), window.attachEvent && a.setAttribute("tabIndex", "-1"), a
        }
        var c, d = new qq.DisposeSupport,
                e = {
                        element: null,
                        multiple: !1,
                        acceptFiles: null,
                        name: "qqfile",
                        onChange: function() {
                        },
                        hoverClass: "qq-upload-button-hover",
                        focusClass: "qq-upload-button-focus"
                };
        return qq.extend(e, a), qq(e.element).css({
                position: "relative",
                overflow: "hidden",
                direction: "ltr"
        }), c = b(), {
                getInput: function() {
                        return c
                },
                reset: function() {
                        c.parentNode && qq(c).remove(), qq(e.element).removeClass(e.focusClass), c = b()
                }
        }
}, qq.PasteSupport = function(a) {
        "use strict";

        function b(a) {
                return a.type && 0 === a.type.indexOf("image/")
        }

        function c() {
                qq(e.targetElement).attach("paste", function(a) {
                        var c = a.clipboardData;
                        c && qq.each(c.items, function(a, c) {
                                if (b(c)) {
                                        var d = c.getAsFile();
                                        e.callbacks.pasteReceived(d)
                                }
                        })
                })
        }

        function d() {
                f && f()
        }
        var e, f;
        return e = {
                targetElement: null,
                callbacks: {
                        log: function() {
                        },
                        pasteReceived: function() {
                        }
                }
        }, qq.extend(e, a), c(), {
                reset: function() {
                        d()
                }
        }
}, qq.UploadData = function(a) {
        function b(a) {
                if (qq.isArray(a)) {
                        var b = [];
                        return qq.each(a, function(a, c) {
                                b.push(f[g[c]])
                        }), b
                }
                return f[g[a]]
        }

        function c(a) {
                if (qq.isArray(a)) {
                        var b = [];
                        return qq.each(a, function(a, c) {
                                b.push(f[h[c]])
                        }), b
                }
                return f[h[a]]
        }

        function d(a) {
                var b = [],
                        c = [].concat(a);
                return qq.each(c, function(a, c) {
                        var d = i[c];
                        void 0 !== d && qq.each(d, function(a, c) {
                                b.push(f[c])
                        })
                }), b
        }
        var e, f = [],
                g = {}, h = {}, i = {};
        return e = {
                added: function(b) {
                        var c = a.getUuid(b),
                                d = a.getName(b),
                                e = a.getSize(b),
                                j = qq.status.SUBMITTING,
                                k = f.push({
                                        id: b,
                                        name: d,
                                        originalName: d,
                                        uuid: c,
                                        size: e,
                                        status: j
                                }) - 1;
                        g[b] = k, h[c] = k, void 0 === i[j] && (i[j] = []), i[j].push(k), a.onStatusChange(b, void 0, j)
                },
                retrieve: function(a) {
                        return qq.isObject(a) && f.length ? void 0 !== a.id ? b(a.id) : void 0 !== a.uuid ? c(a.uuid) : a.status ? d(a.status) : void 0 : qq.extend([], f, !0)
                },
                reset: function() {
                        f = [], g = {}, h = {}, i = {}
                },
                setStatus: function(b, c) {
                        var d = g[b],
                                e = f[d].status,
                                h = qq.indexOf(i[e], d);
                        i[e].splice(h, 1), f[d].status = c, void 0 === i[c] && (i[c] = []), i[c].push(d), a.onStatusChange(b, e, c)
                },
                uuidChanged: function(a, b) {
                        var c = g[a],
                                d = f[c].uuid;
                        f[c].uuid = b, h[b] = c, delete h[d]
                },
                nameChanged: function(a, b) {
                        var c = g[a];
                        f[c].name = b
                }
        }
}, qq.status = {
        SUBMITTING: "submitting",
        SUBMITTED: "submitted",
        REJECTED: "rejected",
        QUEUED: "queued",
        CANCELED: "canceled",
        UPLOADING: "uploading",
        UPLOAD_RETRYING: "retrying upload",
        UPLOAD_SUCCESSFUL: "upload successful",
        UPLOAD_FAILED: "upload failed",
        DELETE_FAILED: "delete failed",
        DELETING: "deleting",
        DELETED: "deleted"
}, qq.FineUploaderBasic = function(a) {
        this._options = {
                debug: !1,
                button: null,
                multiple: !0,
                maxConnections: 3,
                disableCancelForFormUploads: !1,
                autoUpload: !0,
                request: {
                        endpoint: "/server/upload",
                        params: {},
                        paramsInBody: !0,
                        customHeaders: {},
                        forceMultipart: !0,
                        inputName: "qqfile",
                        uuidName: "qquuid",
                        totalFileSizeName: "qqtotalfilesize",
                        filenameParam: "qqfilename"
                },
                validation: {
                        allowedExtensions: [],
                        sizeLimit: 0,
                        minSizeLimit: 0,
                        itemLimit: 0,
                        stopOnFirstInvalidFile: !0,
                        acceptFiles: null
                },
                callbacks: {
                        onSubmit: function() {
                        },
                        onSubmitted: function() {
                        },
                        onComplete: function() {
                        },
                        onCancel: function() {
                        },
                        onUpload: function() {
                        },
                        onUploadChunk: function() {
                        },
                        onResume: function() {
                        },
                        onProgress: function() {
                        },
                        onError: function() {
                        },
                        onAutoRetry: function() {
                        },
                        onManualRetry: function() {
                        },
                        onValidateBatch: function() {
                        },
                        onValidate: function() {
                        },
                        onSubmitDelete: function() {
                        },
                        onDelete: function() {
                        },
                        onDeleteComplete: function() {
                        },
                        onPasteReceived: function() {
                        },
                        onStatusChange: function() {
                        }
                },
                messages: {
                        typeError: "{file} has an invalid extension. Valid extension(s): {extensions}.",
                        sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
                        minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
                        emptyError: "{file} is empty, please select files again without it.",
                        noFilesError: "No files to upload.",
                        tooManyItemsError: "Too many items ({netItems}) would be uploaded.  Item limit is {itemLimit}.",
                        retryFailTooManyItems: "Retry failed - you have reached your file limit.",
                        onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
                },
                retry: {
                        enableAuto: !1,
                        maxAutoAttempts: 3,
                        autoAttemptDelay: 5,
                        preventRetryResponseProperty: "preventRetry"
                },
                classes: {
                        buttonHover: "qq-upload-button-hover",
                        buttonFocus: "qq-upload-button-focus"
                },
                chunking: {
                        enabled: !1,
                        partSize: 2e6,
                        paramNames: {
                                partIndex: "qqpartindex",
                                partByteOffset: "qqpartbyteoffset",
                                chunkSize: "qqchunksize",
                                totalFileSize: "qqtotalfilesize",
                                totalParts: "qqtotalparts"
                        }
                },
                resume: {
                        enabled: !1,
                        id: null,
                        cookiesExpireIn: 7,
                        paramNames: {
                                resuming: "qqresume"
                        }
                },
                formatFileName: function(a) {
                        return void 0 !== a && a.length > 33 && (a = a.slice(0, 19) + "..." + a.slice(-14)), a
                },
                text: {
                        defaultResponseError: "Upload failure reason unknown",
                        sizeSymbols: ["kB", "MB", "GB", "TB", "PB", "EB"]
                },
                deleteFile: {
                        enabled: !1,
                        method: "DELETE",
                        endpoint: "/server/upload",
                        customHeaders: {},
                        params: {}
                },
                cors: {
                        expected: !1,
                        sendCredentials: !1,
                        allowXdr: !1
                },
                blobs: {
                        defaultName: "misc_data"
                },
                paste: {
                        targetElement: null,
                        defaultName: "pasted_image"
                },
                camera: {
                        ios: !1
                }
        }, qq.extend(this._options, a, !0), this._handleCameraAccess(), this._wrapCallbacks(), this._disposeSupport = new qq.DisposeSupport, this._filesInProgress = [], this._storedIds = [], this._autoRetries = [], this._retryTimeouts = [], this._preventRetries = [], this._netUploadedOrQueued = 0, this._netUploaded = 0, this._uploadData = this._createUploadDataTracker(), this._paramsStore = this._createParamsStore("request"), this._deleteFileParamsStore = this._createParamsStore("deleteFile"), this._endpointStore = this._createEndpointStore("request"), this._deleteFileEndpointStore = this._createEndpointStore("deleteFile"), this._handler = this._createUploadHandler(), this._deleteHandler = this._createDeleteHandler(), this._options.button && (this._button = this._createUploadButton(this._options.button)), this._options.paste.targetElement && (this._pasteHandler = this._createPasteHandler()), this._preventLeaveInProgress()
}, qq.FineUploaderBasic.prototype = {
        log: function(a, b) {
                !this._options.debug || b && "info" !== b ? b && "info" !== b && qq.log("[FineUploader " + qq.version + "] " + a, b) : qq.log("[FineUploader " + qq.version + "] " + a)
        },
        setParams: function(a, b) {
                null == b ? this._options.request.params = a : this._paramsStore.setParams(a, b)
        },
        setDeleteFileParams: function(a, b) {
                null == b ? this._options.deleteFile.params = a : this._deleteFileParamsStore.setParams(a, b)
        },
        setEndpoint: function(a, b) {
                null == b ? this._options.request.endpoint = a : this._endpointStore.setEndpoint(a, b)
        },
        getInProgress: function() {
                return this._filesInProgress.length
        },
        getNetUploads: function() {
                return this._netUploaded
        },
        uploadStoredFiles: function() {
                var a;
                if (0 === this._storedIds.length)
                        this._itemError("noFilesError");
                else
                        for (; this._storedIds.length; )
                                a = this._storedIds.shift(), this._filesInProgress.push(a), this._handler.upload(a)
        },
        clearStoredFiles: function() {
                this._storedIds = []
        },
        retry: function(a) {
                return this._onBeforeManualRetry(a) ? (this._netUploadedOrQueued++, this._uploadData.setStatus(a, qq.status.UPLOAD_RETRYING), this._handler.retry(a), !0) : !1
        },
        cancel: function(a) {
                this._handler.cancel(a)
        },
        cancelAll: function() {
                var a = [],
                        b = this;
                qq.extend(a, this._storedIds), qq.each(a, function(a, c) {
                        b.cancel(c)
                }), this._handler.cancelAll()
        },
        reset: function() {
                this.log("Resetting uploader..."), this._handler.reset(), this._filesInProgress = [], this._storedIds = [], this._autoRetries = [], this._retryTimeouts = [], this._preventRetries = [], this._button.reset(), this._paramsStore.reset(), this._endpointStore.reset(), this._netUploadedOrQueued = 0, this._netUploaded = 0, this._uploadData.reset(), this._pasteHandler && this._pasteHandler.reset()
        },
        addFiles: function(a, b, c) {
                var d, e, f, g = this,
                        h = [];
                if (a) {
                        for (qq.isFileList(a) || (a = [].concat(a)), d = 0; d < a.length; d += 1)
                                if (e = a[d], qq.isFileOrInput(e))
                                        if (qq.isInput(e) && qq.supportedFeatures.ajaxUploading)
                                                for (f = 0; f < e.files.length; f++)
                                                        h.push(e.files[f]);
                                        else
                                                h.push(e);
                                else
                                        g.log(e + " is not a File or INPUT element!  Ignoring!", "warn");
                        this.log("Received " + h.length + " files or inputs."), this._prepareItemsForUpload(h, b, c)
                }
        },
        addBlobs: function(a, b, c) {
                if (a) {
                        var d = [].concat(a),
                                e = [],
                                f = this;
                        qq.each(d, function(a, b) {
                                qq.isBlob(b) && !qq.isFileOrInput(b) ? e.push({
                                        blob: b,
                                        name: f._options.blobs.defaultName
                                }) : qq.isObject(b) && b.blob && b.name ? e.push(b) : f.log("addBlobs: entry at index " + a + " is not a Blob or a BlobData object", "error")
                        }), this._prepareItemsForUpload(e, b, c)
                } else
                        this.log("undefined or non-array parameter passed into addBlobs", "error")
        },
        getUuid: function(a) {
                return this._handler.getUuid(a)
        },
        getResumableFilesData: function() {
                return this._handler.getResumableFilesData()
        },
        getSize: function(a) {
                return this._handler.getSize(a)
        },
        getName: function(a) {
                return this._handler.getName(a)
        },
        setName: function(a, b) {
                this._handler.setName(a, b), this._uploadData.nameChanged(a, b)
        },
        getFile: function(a) {
                return this._handler.getFile(a)
        },
        deleteFile: function(a) {
                this._onSubmitDelete(a)
        },
        setDeleteFileEndpoint: function(a, b) {
                null == b ? this._options.deleteFile.endpoint = a : this._deleteFileEndpointStore.setEndpoint(a, b)
        },
        doesExist: function(a) {
                return this._handler.isValid(a)
        },
        getUploads: function(a) {
                return this._uploadData.retrieve(a)
        },
        _handleCheckedCallback: function(a) {
                var b = this,
                        c = a.callback();
                return qq.isPromise(c) ? (this.log(a.name + " - waiting for " + a.name + " promise to be fulfilled for " + a.identifier), c.then(function(c) {
                        b.log(a.name + " promise success for " + a.identifier), a.onSuccess(c)
                }, function() {
                        a.onFailure ? (b.log(a.name + " promise failure for " + a.identifier), a.onFailure()) : b.log(a.name + " promise failure for " + a.identifier)
                })) : (c !== !1 ? a.onSuccess(c) : a.onFailure ? (this.log(a.name + " - return value was 'false' for " + a.identifier + ".  Invoking failure callback."), a.onFailure()) : this.log(a.name + " - return value was 'false' for " + a.identifier + ".  Will not proceed."), c)
        },
        _createUploadButton: function(a) {
                var b = this,
                        c = new qq.UploadButton({
                                element: a,
                                multiple: this._options.multiple && qq.supportedFeatures.ajaxUploading,
                                acceptFiles: this._options.validation.acceptFiles,
                                onChange: function(a) {
                                        b._onInputChange(a)
                                },
                                hoverClass: this._options.classes.buttonHover,
                                focusClass: this._options.classes.buttonFocus
                        });
                return this._disposeSupport.addDisposer(function() {
                        c.dispose()
                }), c
        },
        _createUploadHandler: function() {
                var a = this;
                return new qq.UploadHandler({
                        debug: this._options.debug,
                        forceMultipart: this._options.request.forceMultipart,
                        maxConnections: this._options.maxConnections,
                        customHeaders: this._options.request.customHeaders,
                        inputName: this._options.request.inputName,
                        uuidParamName: this._options.request.uuidName,
                        filenameParam: this._options.request.filenameParam,
                        totalFileSizeParamName: this._options.request.totalFileSizeName,
                        cors: this._options.cors,
                        demoMode: this._options.demoMode,
                        paramsInBody: this._options.request.paramsInBody,
                        paramsStore: this._paramsStore,
                        endpointStore: this._endpointStore,
                        chunking: this._options.chunking,
                        resume: this._options.resume,
                        blobs: this._options.blobs,
                        log: function(b, c) {
                                a.log(b, c)
                        },
                        onProgress: function(b, c, d, e) {
                                a._onProgress(b, c, d, e), a._options.callbacks.onProgress(b, c, d, e)
                        },
                        onComplete: function(b, c, d, e) {
                                a._onComplete(b, c, d, e), a._options.callbacks.onComplete(b, c, d, e)
                        },
                        onCancel: function(b, c) {
                                return a._handleCheckedCallback({
                                        name: "onCancel",
                                        callback: qq.bind(a._options.callbacks.onCancel, a, b, c),
                                        onSuccess: qq.bind(a._onCancel, a, b, c),
                                        identifier: b
                                })
                        },
                        onUpload: function(b, c) {
                                a._onUpload(b, c), a._options.callbacks.onUpload(b, c)
                        },
                        onUploadChunk: function(b, c, d) {
                                a._options.callbacks.onUploadChunk(b, c, d)
                        },
                        onResume: function(b, c, d) {
                                return a._options.callbacks.onResume(b, c, d)
                        },
                        onAutoRetry: function(b, c, d, e) {
                                return a._preventRetries[b] = d[a._options.retry.preventRetryResponseProperty], a._shouldAutoRetry(b, c, d) ? (a._maybeParseAndSendUploadError(b, c, d, e), a._options.callbacks.onAutoRetry(b, c, a._autoRetries[b] + 1), a._onBeforeAutoRetry(b, c), a._retryTimeouts[b] = setTimeout(function() {
                                        a._onAutoRetry(b, c, d)
                                }, 1e3 * a._options.retry.autoAttemptDelay), !0) : !1
                        },
                        onUuidChanged: function(b, c) {
                                a._uploadData.uuidChanged(b, c)
                        }
                })
        },
        _createDeleteHandler: function() {
                var a = this;
                return new qq.DeleteFileAjaxRequestor({
                        method: this._options.deleteFile.method,
                        maxConnections: this._options.maxConnections,
                        uuidParamName: this._options.request.uuidName,
                        customHeaders: this._options.deleteFile.customHeaders,
                        paramsStore: this._deleteFileParamsStore,
                        endpointStore: this._deleteFileEndpointStore,
                        demoMode: this._options.demoMode,
                        cors: this._options.cors,
                        log: function(b, c) {
                                a.log(b, c)
                        },
                        onDelete: function(b) {
                                a._onDelete(b), a._options.callbacks.onDelete(b)
                        },
                        onDeleteComplete: function(b, c, d) {
                                a._onDeleteComplete(b, c, d), a._options.callbacks.onDeleteComplete(b, c, d)
                        }
                })
        },
        _createPasteHandler: function() {
                var a = this;
                return new qq.PasteSupport({
                        targetElement: this._options.paste.targetElement,
                        callbacks: {
                                log: function(b, c) {
                                        a.log(b, c)
                                },
                                pasteReceived: function(b) {
                                        a._handleCheckedCallback({
                                                name: "onPasteReceived",
                                                callback: qq.bind(a._options.callbacks.onPasteReceived, a, b),
                                                onSuccess: qq.bind(a._handlePasteSuccess, a, b),
                                                identifier: "pasted image"
                                        })
                                }
                        }
                })
        },
        _createUploadDataTracker: function() {
                var a = this;
                return new qq.UploadData({
                        getName: function(b) {
                                return a.getName(b)
                        },
                        getUuid: function(b) {
                                return a.getUuid(b)
                        },
                        getSize: function(b) {
                                return a.getSize(b)
                        },
                        onStatusChange: function(b, c, d) {
                                a._onUploadStatusChange(b, c, d), a._options.callbacks.onStatusChange(b, c, d)
                        }
                })
        },
        _onUploadStatusChange: function() {
        },
        _handlePasteSuccess: function(a, b) {
                var c = a.type.split("/")[1],
                        d = b;
                null == d && (d = this._options.paste.defaultName), d += "." + c, this.addBlobs({
                        name: d,
                        blob: a
                })
        },
        _preventLeaveInProgress: function() {
                var a = this;
                this._disposeSupport.attach(window, "beforeunload", function(b) {
                        if (a._filesInProgress.length) {
                                var b = b || window.event;
                                return b.returnValue = a._options.messages.onLeave, a._options.messages.onLeave
                        }
                })
        },
        _onSubmit: function(a) {
                this._netUploadedOrQueued++, this._options.autoUpload && this._filesInProgress.push(a)
        },
        _onProgress: function() {
        },
        _onComplete: function(a, b, c, d) {
                c.success ? (this._netUploaded++, this._uploadData.setStatus(a, qq.status.UPLOAD_SUCCESSFUL)) : (this._netUploadedOrQueued--, this._uploadData.setStatus(a, qq.status.UPLOAD_FAILED)), this._removeFromFilesInProgress(a), this._maybeParseAndSendUploadError(a, b, c, d)
        },
        _onCancel: function(a) {
                this._netUploadedOrQueued--, this._removeFromFilesInProgress(a), clearTimeout(this._retryTimeouts[a]);
                var b = qq.indexOf(this._storedIds, a);
                !this._options.autoUpload && b >= 0 && this._storedIds.splice(b, 1), this._uploadData.setStatus(a, qq.status.CANCELED)
        },
        _isDeletePossible: function() {
                return this._options.deleteFile.enabled ? this._options.cors.expected ? qq.supportedFeatures.deleteFileCorsXhr ? !0 : qq.supportedFeatures.deleteFileCorsXdr && this._options.cors.allowXdr ? !0 : !1 : !0 : !1
        },
        _onSubmitDelete: function(a, b) {
                return this._isDeletePossible() ? this._handleCheckedCallback({
                        name: "onSubmitDelete",
                        callback: qq.bind(this._options.callbacks.onSubmitDelete, this, a),
                        onSuccess: b || qq.bind(this._deleteHandler.sendDelete, this, a, this.getUuid(a)),
                        identifier: a
                }) : (this.log("Delete request ignored for ID " + a + ", delete feature is disabled or request not possible " + "due to CORS on a user agent that does not support pre-flighting.", "warn"), !1)
        },
        _onDelete: function(a) {
                this._uploadData.setStatus(a, qq.status.DELETING)
        },
        _onDeleteComplete: function(a, b, c) {
                var d = this._handler.getName(a);
                c ? (this._uploadData.setStatus(a, qq.status.DELETE_FAILED), this.log("Delete request for '" + d + "' has failed.", "error"), void 0 === b.withCredentials ? this._options.callbacks.onError(a, d, "Delete request failed", b) : this._options.callbacks.onError(a, d, "Delete request failed with response code " + b.status, b)) : (this._netUploadedOrQueued--, this._netUploaded--, this._handler.expunge(a), this._uploadData.setStatus(a, qq.status.DELETED), this.log("Delete request for '" + d + "' has succeeded."))
        },
        _removeFromFilesInProgress: function(a) {
                var b = qq.indexOf(this._filesInProgress, a);
                b >= 0 && this._filesInProgress.splice(b, 1)
        },
        _onUpload: function(a) {
                this._uploadData.setStatus(a, qq.status.UPLOADING)
        },
        _onInputChange: function(a) {
                qq.supportedFeatures.ajaxUploading ? this.addFiles(a.files) : this.addFiles(a), this._button.reset()
        },
        _onBeforeAutoRetry: function(a, b) {
                this.log("Waiting " + this._options.retry.autoAttemptDelay + " seconds before retrying " + b + "...")
        },
        _onAutoRetry: function(a, b) {
                this.log("Retrying " + b + "..."), this._autoRetries[a]++, this._uploadData.setStatus(a, qq.status.UPLOAD_RETRYING), this._handler.retry(a)
        },
        _shouldAutoRetry: function(a) {
                return !this._preventRetries[a] && this._options.retry.enableAuto ? (void 0 === this._autoRetries[a] && (this._autoRetries[a] = 0), this._autoRetries[a] < this._options.retry.maxAutoAttempts) : !1
        },
        _onBeforeManualRetry: function(a) {
                var b = this._options.validation.itemLimit;
                if (this._preventRetries[a])
                        return this.log("Retries are forbidden for id " + a, "warn"), !1;
                if (this._handler.isValid(a)) {
                        var c = this._handler.getName(a);
                        return this._options.callbacks.onManualRetry(a, c) === !1 ? !1 : b > 0 && this._netUploadedOrQueued + 1 > b ? (this._itemError("retryFailTooManyItems"), !1) : (this.log("Retrying upload for '" + c + "' (id: " + a + ")..."), this._filesInProgress.push(a), !0)
                }
                return this.log("'" + a + "' is not a valid file ID", "error"), !1
        },
        _maybeParseAndSendUploadError: function(a, b, c, d) {
                if (!c.success)
                        if (d && 200 !== d.status && !c.error)
                                this._options.callbacks.onError(a, b, "XHR returned response code " + d.status, d);
                        else {
                                var e = c.error ? c.error : this._options.text.defaultResponseError;
                                this._options.callbacks.onError(a, b, e, d)
                        }
        },
        _prepareItemsForUpload: function(a, b, c) {
                var d = this._getValidationDescriptors(a);
                this._handleCheckedCallback({
                        name: "onValidateBatch",
                        callback: qq.bind(this._options.callbacks.onValidateBatch, this, d),
                        onSuccess: qq.bind(this._onValidateBatchCallbackSuccess, this, d, a, b, c),
                        identifier: "batch validation"
                })
        },
        _upload: function(a, b, c) {
                var d = this._handler.add(a),
                        e = this._handler.getName(d);
                this._uploadData.added(d), b && this.setParams(b, d), c && this.setEndpoint(c, d), this._handleCheckedCallback({
                        name: "onSubmit",
                        callback: qq.bind(this._options.callbacks.onSubmit, this, d, e),
                        onSuccess: qq.bind(this._onSubmitCallbackSuccess, this, d, e),
                        onFailure: qq.bind(this._fileOrBlobRejected, this, d, e),
                        identifier: d
                })
        },
        _onSubmitCallbackSuccess: function(a) {
                this._uploadData.setStatus(a, qq.status.SUBMITTED), this._onSubmit.apply(this, arguments), this._onSubmitted.apply(this, arguments), this._options.callbacks.onSubmitted.apply(this, arguments), this._options.autoUpload ? this._handler.upload(a) || this._uploadData.setStatus(a, qq.status.QUEUED) : this._storeForLater(a)
        },
        _onSubmitted: function() {
        },
        _storeForLater: function(a) {
                this._storedIds.push(a)
        },
        _onValidateBatchCallbackSuccess: function(a, b, c, d) {
                var e, f = this._options.validation.itemLimit,
                        g = this._netUploadedOrQueued + a.length;
                0 === f || f >= g ? b.length > 0 ? this._handleCheckedCallback({
                        name: "onValidate",
                        callback: qq.bind(this._options.callbacks.onValidate, this, b[0]),
                        onSuccess: qq.bind(this._onValidateCallbackSuccess, this, b, 0, c, d),
                        onFailure: qq.bind(this._onValidateCallbackFailure, this, b, 0, c, d),
                        identifier: "Item '" + b[0].name + "', size: " + b[0].size
                }) : this._itemError("noFilesError") : (e = this._options.messages.tooManyItemsError.replace(/\{netItems\}/g, g).replace(/\{itemLimit\}/g, f), this._batchError(e))
        },
        _onValidateCallbackSuccess: function(a, b, c, d) {
                var e = b + 1,
                        f = this._getValidationDescriptor(a[b]),
                        g = !1;
                this._validateFileOrBlobData(a[b], f) && (g = !0, this._upload(a[b], c, d)), this._maybeProcessNextItemAfterOnValidateCallback(g, a, e, c, d)
        },
        _onValidateCallbackFailure: function(a, b, c, d) {
                var e = b + 1;
                this._fileOrBlobRejected(void 0, a[0].name), this._maybeProcessNextItemAfterOnValidateCallback(!1, a, e, c, d)
        },
        _maybeProcessNextItemAfterOnValidateCallback: function(a, b, c, d, e) {
                var f = this;
                b.length > c && (a || !this._options.validation.stopOnFirstInvalidFile) && setTimeout(function() {
                        var a = f._getValidationDescriptor(b[c]);
                        f._handleCheckedCallback({
                                name: "onValidate",
                                callback: qq.bind(f._options.callbacks.onValidate, f, b[c]),
                                onSuccess: qq.bind(f._onValidateCallbackSuccess, f, b, c, d, e),
                                onFailure: qq.bind(f._onValidateCallbackFailure, f, b, c, d, e),
                                identifier: "Item '" + a.name + "', size: " + a.size
                        })
                }, 0)
        },
        _validateFileOrBlobData: function(a, b) {
                var c = b.name,
                        d = b.size,
                        e = !0;
                return this._options.callbacks.onValidate(b) === !1 && (e = !1), qq.isFileOrInput(a) && !this._isAllowedExtension(c) ? (this._itemError("typeError", c), e = !1) : 0 === d ? (this._itemError("emptyError", c), e = !1) : d && this._options.validation.sizeLimit && d > this._options.validation.sizeLimit ? (this._itemError("sizeError", c), e = !1) : d && d < this._options.validation.minSizeLimit && (this._itemError("minSizeError", c), e = !1), e || this._fileOrBlobRejected(void 0, c), e
        },
        _fileOrBlobRejected: function(a) {
                void 0 !== a && this._uploadData.setStatus(a, qq.status.REJECTED)
        },
        _itemError: function(a, b) {
                function c(a, b) {
                        f = f.replace(a, b)
                }
                var d, e, f = this._options.messages[a],
                        g = [],
                        h = [].concat(b),
                        i = h[0];
                return qq.each(this._options.validation.allowedExtensions, function(a, b) {
                        qq.isString(b) && g.push(b)
                }), d = g.join(", ").toLowerCase(), c("{file}", this._options.formatFileName(i)), c("{extensions}", d), c("{sizeLimit}", this._formatSize(this._options.validation.sizeLimit)), c("{minSizeLimit}", this._formatSize(this._options.validation.minSizeLimit)), e = f.match(/(\{\w+\})/g), null !== e && qq.each(e, function(a, b) {
                        c(b, h[a])
                }), this._options.callbacks.onError(null, i, f, void 0), f
        },
        _batchError: function(a) {
                this._options.callbacks.onError(null, null, a, void 0)
        },
        _isAllowedExtension: function(a) {
                var b = this._options.validation.allowedExtensions,
                        c = !1;
                return b.length ? (qq.each(b, function(b, d) {
                        if (qq.isString(d)) {
                                var e = new RegExp("\\." + d + "$", "i");
                                if (null != a.match(e))
                                        return c = !0, !1
                        }
                }), c) : !0
        },
        _formatSize: function(a) {
                var b = -1;
                do
                        a /= 1e3, b++;
                while (a > 999);
                return Math.max(a, .1).toFixed(1) + this._options.text.sizeSymbols[b]
        },
        _wrapCallbacks: function() {
                var a, b;
                a = this, b = function(b, c, d) {
                        try {
                                return c.apply(a, d)
                        } catch (e) {
                                a.log("Caught exception in '" + b + "' callback - " + e.message, "error")
                        }
                };
                for (var c in this._options.callbacks)
                        !function() {
                                var d, e;
                                d = c, e = a._options.callbacks[d], a._options.callbacks[d] = function() {
                                        return b(d, e, arguments)
                                }
                        }()
        },
        _parseFileOrBlobDataName: function(a) {
                var b;
                return b = qq.isFileOrInput(a) ? a.value ? a.value.replace(/.*(\/|\\)/, "") : null !== a.fileName && void 0 !== a.fileName ? a.fileName : a.name : a.name
        },
        _parseFileOrBlobDataSize: function(a) {
                var b;
                return qq.isFileOrInput(a) ? a.value || (b = null !== a.fileSize && void 0 !== a.fileSize ? a.fileSize : a.size) : b = a.blob.size, b
        },
        _getValidationDescriptor: function(a) {
                var b, c, d;
                return d = {}, b = this._parseFileOrBlobDataName(a), c = this._parseFileOrBlobDataSize(a), d.name = b, void 0 !== c && (d.size = c), d
        },
        _getValidationDescriptors: function(a) {
                var b = this,
                        c = [];
                return qq.each(a, function(a, d) {
                        c.push(b._getValidationDescriptor(d))
                }), c
        },
        _createParamsStore: function(a) {
                var b = {}, c = this;
                return {
                        setParams: function(a, c) {
                                var d = {};
                                qq.extend(d, a), b[c] = d
                        },
                        getParams: function(d) {
                                var e = {};
                                return null != d && b[d] ? qq.extend(e, b[d]) : qq.extend(e, c._options[a].params), e
                        },
                        remove: function(a) {
                                return delete b[a]
                        },
                        reset: function() {
                                b = {}
                        }
                }
        },
        _createEndpointStore: function(a) {
                var b = {}, c = this;
                return {
                        setEndpoint: function(a, c) {
                                b[c] = a
                        },
                        getEndpoint: function(d) {
                                return null != d && b[d] ? b[d] : c._options[a].endpoint
                        },
                        remove: function(a) {
                                return delete b[a]
                        },
                        reset: function() {
                                b = {}
                        }
                }
        },
        _handleCameraAccess: function() {
                this._options.camera.ios && qq.ios() && (this._options.multiple = !1, null === this._options.validation.acceptFiles ? this._options.validation.acceptFiles = "image/*;capture=camera" : this._options.validation.acceptFiles += ",image/*;capture=camera")
        }
}, qq.DragAndDrop = function(a) {
        "use strict";

        function b(a) {
                h.callbacks.dropLog("Grabbed " + a.length + " dropped files."), i.dropDisabled(!1), h.callbacks.processingDroppedFilesComplete(a)
        }

        function c(a) {
                var b, d, e = new qq.Promise;
                return a.isFile ? a.file(function(a) {
                        j.push(a), e.success()
                }, function(b) {
                        h.callbacks.dropLog("Problem parsing '" + a.fullPath + "'.  FileError code " + b.code + ".", "error"), e.failure()
                }) : a.isDirectory && (b = a.createReader(), b.readEntries(function(a) {
                        var b = a.length;
                        for (d = 0; d < a.length; d += 1)
                                c(a[d]).done(function() {
                                        b -= 1, 0 === b && e.success()
                                });
                        a.length || e.success()
                }, function(b) {
                        h.callbacks.dropLog("Problem parsing '" + a.fullPath + "'.  FileError code " + b.code + ".", "error"), e.failure()
                })), e
        }

        function d(a) {
                var b, d, e, f = [],
                        g = new qq.Promise;
                if (h.callbacks.processingDroppedFiles(), i.dropDisabled(!0), a.files.length > 1 && !h.allowMultipleItems)
                        h.callbacks.processingDroppedFilesComplete([]), h.callbacks.dropError("tooManyFilesError", ""), i.dropDisabled(!1), g.failure();
                else {
                        if (j = [], qq.isFolderDropSupported(a))
                                for (d = a.items, b = 0; b < d.length; b += 1)
                                        e = d[b].webkitGetAsEntry(), e && (e.isFile ? j.push(d[b].getAsFile()) : f.push(c(e).done(function() {
                                                f.pop(), 0 === f.length && g.success()
                                        })));
                        else
                                j = a.files;
                        0 === f.length && g.success()
                }
                return g
        }

        function e(a) {
                i = new qq.UploadDropZone({
                        element: a,
                        onEnter: function(b) {
                                qq(a).addClass(h.classes.dropActive), b.stopPropagation()
                        },
                        onLeaveNotDescendants: function() {
                                qq(a).removeClass(h.classes.dropActive)
                        },
                        onDrop: function(c) {
                                h.hideDropZonesBeforeEnter && qq(a).hide(), qq(a).removeClass(h.classes.dropActive), d(c.dataTransfer).done(function() {
                                        b(j)
                                })
                        }
                }), k.addDisposer(function() {
                        i.dispose()
                }), h.hideDropZonesBeforeEnter && qq(a).hide()
        }

        function f(a) {
                var b;
                return qq.each(a.dataTransfer.types, function(a, c) {
                        return "Files" === c ? (b = !0, !1) : void 0
                }), b
        }

        function g() {
                var a = h.dropZoneElements;
                qq.each(a, function(a, b) {
                        e(b)
                }), !a.length || qq.ie() && !qq.ie10() || k.attach(document, "dragenter", function(b) {
                        !i.dropDisabled() && f(b) && qq.each(a, function(a, b) {
                                qq(b).css({
                                        display: "block"
                                })
                        })
                }), k.attach(document, "dragleave", function(b) {
                        h.hideDropZonesBeforeEnter && qq.FineUploader.prototype._leaving_document_out(b) && qq.each(a, function(a, b) {
                                qq(b).hide()
                        })
                }), k.attach(document, "drop", function(b) {
                        h.hideDropZonesBeforeEnter && qq.each(a, function(a, b) {
                                qq(b).hide()
                        }), b.preventDefault()
                })
        }
        var h, i, j = [],
                k = new qq.DisposeSupport;
        return h = {
                dropZoneElements: [],
                hideDropZonesBeforeEnter: !1,
                allowMultipleItems: !0,
                classes: {
                        dropActive: null
                },
                callbacks: new qq.DragAndDrop.callbacks
        }, qq.extend(h, a, !0), g(), {
                setupExtraDropzone: function(a) {
                        h.dropZoneElements.push(a), e(a)
                },
                removeDropzone: function(a) {
                        var b, c = h.dropZoneElements;
                        for (b in c)
                                if (c[b] === a)
                                        return c.splice(b, 1)
                },
                dispose: function() {
                        k.dispose(), i.dispose()
                }
        }
}, qq.DragAndDrop.callbacks = function() {
        return {
                processingDroppedFiles: function() {
                },
                processingDroppedFilesComplete: function() {
                },
                dropError: function(a, b) {
                        qq.log("Drag & drop error code '" + a + " with these specifics: '" + b + "'", "error")
                },
                dropLog: function(a, b) {
                        qq.log(a, b)
                }
        }
}, qq.UploadDropZone = function(a) {
        "use strict";

        function b() {
                return qq.safari() || qq.firefox() && qq.windows()
        }

        function c() {
                j || (b ? k.attach(document, "dragover", function(a) {
                        a.preventDefault()
                }) : k.attach(document, "dragover", function(a) {
                        a.dataTransfer && (a.dataTransfer.dropEffect = "none", a.preventDefault())
                }), j = !0)
        }

        function d(a) {
                if (qq.ie() && !qq.ie10())
                        return !1;
                var b, c = a.dataTransfer,
                        d = qq.safari();
                return b = qq.ie10() ? !0 : "none" !== c.effectAllowed, c && b && (c.files || !d && c.types.contains && c.types.contains("Files"))
        }

        function e(a) {
                return void 0 !== a && (i = a), i
        }

        function f() {
                k.attach(h, "dragover", function(a) {
                        if (d(a)) {
                                var b = qq.ie() ? null : a.dataTransfer.effectAllowed;
                                a.dataTransfer.dropEffect = "move" === b || "linkMove" === b ? "move" : "copy", a.stopPropagation(), a.preventDefault()
                        }
                }), k.attach(h, "dragenter", function(a) {
                        if (!e()) {
                                if (!d(a))
                                        return;
                                g.onEnter(a)
                        }
                }), k.attach(h, "dragleave", function(a) {
                        if (d(a)) {
                                g.onLeave(a);
                                var b = document.elementFromPoint(a.clientX, a.clientY);
                                qq(this).contains(b) || g.onLeaveNotDescendants(a)
                        }
                }), k.attach(h, "drop", function(a) {
                        if (!e()) {
                                if (!d(a))
                                        return;
                                a.preventDefault(), g.onDrop(a)
                        }
                })
        }
        var g, h, i, j, k = new qq.DisposeSupport;
        return g = {
                element: null,
                onEnter: function() {
                },
                onLeave: function() {
                },
                onLeaveNotDescendants: function() {
                },
                onDrop: function() {
                }
        }, qq.extend(g, a), h = g.element, c(), f(), {
                dropDisabled: function(a) {
                        return e(a)
                },
                dispose: function() {
                        k.dispose()
                }
        }
}, qq.FineUploader = function(a) {
        qq.FineUploaderBasic.apply(this, arguments), qq.extend(this._options, {
                element: null,
                listElement: null,
                dragAndDrop: {
                        extraDropzones: [],
                        hideDropzones: !0,
                        disableDefaultDropzone: !1
                },
                text: {
                        uploadButton: "Upload a file",
                        cancelButton: "Cancel",
                        retryButton: "Retry",
                        deleteButton: "Delete",
                        failUpload: "Upload failed",
                        dragZone: "Drop files here to upload",
                        dropProcessing: "Processing dropped files...",
                        formatProgress: "{percent}% of {total_size}",
                        waitingForResponse: "Processing..."
                },
                template: '<div class="qq-uploader">' + (this._options.dragAndDrop && this._options.dragAndDrop.disableDefaultDropzone ? "" : '<div class="qq-upload-drop-area"><span>{dragZoneText}</span></div>') + (this._options.button ? "" : '<div class="qq-upload-button"><div>{uploadButtonText}</div></div>') + '<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' + (this._options.listElement ? "" : '<ul class="qq-upload-list"></ul>') + "</div>",
                fileTemplate: '<li><div class="qq-progress-bar"></div><span class="qq-upload-spinner"></span><span class="qq-upload-finished"></span>' + (this._options.editFilename && this._options.editFilename.enabled ? '<span class="qq-edit-filename-icon"></span>' : "") + '<span class="qq-upload-file"></span>' + (this._options.editFilename && this._options.editFilename.enabled ? '<input class="qq-edit-filename" tabindex="0" type="text">' : "") + '<span class="qq-upload-size"></span>' + '<a class="qq-upload-cancel" href="#">{cancelButtonText}</a>' + '<a class="qq-upload-retry" href="#">{retryButtonText}</a>' + '<a class="qq-upload-delete" href="#">{deleteButtonText}</a>' + '<span class="qq-upload-status-text">{statusText}</span>' + "</li>",
                classes: {
                        button: "qq-upload-button",
                        drop: "qq-upload-drop-area",
                        dropActive: "qq-upload-drop-area-active",
                        list: "qq-upload-list",
                        progressBar: "qq-progress-bar",
                        file: "qq-upload-file",
                        spinner: "qq-upload-spinner",
                        finished: "qq-upload-finished",
                        retrying: "qq-upload-retrying",
                        retryable: "qq-upload-retryable",
                        size: "qq-upload-size",
                        cancel: "qq-upload-cancel",
                        deleteButton: "qq-upload-delete",
                        retry: "qq-upload-retry",
                        statusText: "qq-upload-status-text",
                        editFilenameInput: "qq-edit-filename",
                        success: "qq-upload-success",
                        fail: "qq-upload-fail",
                        successIcon: null,
                        failIcon: null,
                        editNameIcon: "qq-edit-filename-icon",
                        editable: "qq-editable",
                        dropProcessing: "qq-drop-processing",
                        dropProcessingSpinner: "qq-drop-processing-spinner"
                },
                failedUploadTextDisplay: {
                        mode: "default",
                        maxChars: 50,
                        responseProperty: "error",
                        enableTooltip: !0
                },
                messages: {
                        tooManyFilesError: "You may only drop one file",
                        unsupportedBrowser: "Unrecoverable error - this browser does not permit file uploading of any kind."
                },
                retry: {
                        showAutoRetryNote: !0,
                        autoRetryNote: "Retrying {retryNum}/{maxAuto}...",
                        showButton: !1
                },
                deleteFile: {
                        forceConfirm: !1,
                        confirmMessage: "Are you sure you want to delete {filename}?",
                        deletingStatusText: "Deleting...",
                        deletingFailedText: "Delete failed"
                },
                display: {
                        fileSizeOnSubmit: !1,
                        prependFiles: !1
                },
                paste: {
                        promptForName: !1,
                        namePromptMessage: "Please name this image"
                },
                editFilename: {
                        enabled: !1
                },
                showMessage: function(a) {
                        setTimeout(function() {
                                window.alert(a)
                        }, 0)
                },
                showConfirm: function(a, b, c) {
                        setTimeout(function() {
                                var d = window.confirm(a);
                                d ? b() : c && c()
                        }, 0)
                },
                showPrompt: function(a, b) {
                        var c = new qq.Promise,
                                d = window.prompt(a, b);
                        return null != d && qq.trimStr(d).length > 0 ? c.success(d) : c.failure("Undefined or invalid user-supplied value."), c
                }
        }, !0), qq.extend(this._options, a, !0), !qq.supportedFeatures.uploading || this._options.cors.expected && !qq.supportedFeatures.uploadCors ? this._options.element.innerHTML = "<div>" + this._options.messages.unsupportedBrowser + "</div>" : (this._wrapCallbacks(), this._options.template = this._options.template.replace(/\{dragZoneText\}/g, this._options.text.dragZone), this._options.template = this._options.template.replace(/\{uploadButtonText\}/g, this._options.text.uploadButton), this._options.template = this._options.template.replace(/\{dropProcessingText\}/g, this._options.text.dropProcessing), this._options.fileTemplate = this._options.fileTemplate.replace(/\{cancelButtonText\}/g, this._options.text.cancelButton), this._options.fileTemplate = this._options.fileTemplate.replace(/\{retryButtonText\}/g, this._options.text.retryButton), this._options.fileTemplate = this._options.fileTemplate.replace(/\{deleteButtonText\}/g, this._options.text.deleteButton), this._options.fileTemplate = this._options.fileTemplate.replace(/\{statusText\}/g, ""), this._element = this._options.element, this._element.innerHTML = this._options.template, this._listElement = this._options.listElement || this._find(this._element, "list"), this._classes = this._options.classes, this._button || (this._button = this._createUploadButton(this._find(this._element, "button"))), this._deleteRetryOrCancelClickHandler = this._bindDeleteRetryOrCancelClickEvent(), this._focusinEventSupported = !qq.firefox(), this._isEditFilenameEnabled() && (this._filenameClickHandler = this._bindFilenameClickEvent(), this._filenameInputFocusInHandler = this._bindFilenameInputFocusInEvent(), this._filenameInputFocusHandler = this._bindFilenameInputFocusEvent()), this._dnd = this._setupDragAndDrop(), this._options.paste.targetElement && this._options.paste.promptForName && this._setupPastePrompt(), this._totalFilesInBatch = 0, this._filesInBatchAddedToUi = 0)
}, qq.extend(qq.FineUploader.prototype, qq.FineUploaderBasic.prototype), qq.extend(qq.FineUploader.prototype, {
        clearStoredFiles: function() {
                qq.FineUploaderBasic.prototype.clearStoredFiles.apply(this, arguments), this._listElement.innerHTML = ""
        },
        addExtraDropzone: function(a) {
                this._dnd.setupExtraDropzone(a)
        },
        removeExtraDropzone: function(a) {
                return this._dnd.removeDropzone(a)
        },
        getItemByFileId: function(a) {
                for (var b = this._listElement.firstChild; b; ) {
                        if (b.qqFileId == a)
                                return b;
                        b = b.nextSibling
                }
        },
        reset: function() {
                qq.FineUploaderBasic.prototype.reset.apply(this, arguments), this._element.innerHTML = this._options.template, this._listElement = this._options.listElement || this._find(this._element, "list"), this._options.button || (this._button = this._createUploadButton(this._find(this._element, "button"))), this._dnd.dispose(), this._dnd = this._setupDragAndDrop(), this._totalFilesInBatch = 0, this._filesInBatchAddedToUi = 0
        },
        _removeFileItem: function(a) {
                var b = this.getItemByFileId(a);
                qq(b).remove()
        },
        _setupDragAndDrop: function() {
                var a, b = this,
                        c = this._find(this._element, "dropProcessing"),
                        d = this._options.dragAndDrop.extraDropzones;
                return a = function(a) {
                        a.preventDefault()
                }, this._options.dragAndDrop.disableDefaultDropzone || d.push(this._find(this._options.element, "drop")), new qq.DragAndDrop({
                        dropZoneElements: d,
                        hideDropZonesBeforeEnter: this._options.dragAndDrop.hideDropzones,
                        allowMultipleItems: this._options.multiple,
                        classes: {
                                dropActive: this._options.classes.dropActive
                        },
                        callbacks: {
                                processingDroppedFiles: function() {
                                        var d = b._button.getInput();
                                        qq(c).css({
                                                display: "block"
                                        }), qq(d).attach("click", a)
                                },
                                processingDroppedFilesComplete: function(d) {
                                        var e = b._button.getInput();
                                        qq(c).hide(), qq(e).detach("click", a), d && b.addFiles(d)
                                },
                                dropError: function(a, c) {
                                        b._itemError(a, c)
                                },
                                dropLog: function(a, c) {
                                        b.log(a, c)
                                }
                        }
                })
        },
        _bindDeleteRetryOrCancelClickEvent: function() {
                var a = this;
                return new qq.DeleteRetryOrCancelClickHandler({
                        listElement: this._listElement,
                        classes: this._classes,
                        log: function(b, c) {
                                a.log(b, c)
                        },
                        onDeleteFile: function(b) {
                                a.deleteFile(b)
                        },
                        onCancel: function(b) {
                                a.cancel(b)
                        },
                        onRetry: function(b) {
                                var c = a.getItemByFileId(b);
                                qq(c).removeClass(a._classes.retryable), a.retry(b)
                        },
                        onGetName: function(b) {
                                return a.getName(b)
                        }
                })
        },
        _isEditFilenameEnabled: function() {
                return this._options.editFilename.enabled && !this._options.autoUpload
        },
        _filenameEditHandler: function() {
                var a = this;
                return {
                        listElement: this._listElement,
                        classes: this._classes,
                        log: function(b, c) {
                                a.log(b, c)
                        },
                        onGetUploadStatus: function(b) {
                                return a.getUploads({
                                        id: b
                                }).status
                        },
                        onGetName: function(b) {
                                return a.getName(b)
                        },
                        onSetName: function(b, c) {
                                var d = a.getItemByFileId(b),
                                        e = qq(a._find(d, "file")),
                                        f = a._options.formatFileName(c);
                                e.setText(f), a.setName(b, c)
                        },
                        onGetInput: function(b) {
                                return a._find(b, "editFilenameInput")
                        },
                        onEditingStatusChange: function(b, c) {
                                var d = a.getItemByFileId(b),
                                        e = qq(a._find(d, "editFilenameInput")),
                                        f = qq(a._find(d, "file")),
                                        g = qq(a._find(d, "editNameIcon")),
                                        h = a._classes.editable;
                                c ? (e.addClass("qq-editing"), f.hide(), g.removeClass(h)) : (e.removeClass("qq-editing"), f.css({
                                        display: ""
                                }), g.addClass(h)), qq(d).addClass("qq-temp").removeClass("qq-temp")
                        }
                }
        },
        _onUploadStatusChange: function(a, b, c) {
                if (this._isEditFilenameEnabled()) {
                        var d, e, f = this.getItemByFileId(a),
                                g = this._classes.editable;
                        f && c !== qq.status.SUBMITTED && (d = qq(this._find(f, "file")), e = qq(this._find(f, "editNameIcon")), d.removeClass(g), e.removeClass(g))
                }
        },
        _bindFilenameInputFocusInEvent: function() {
                var a = qq.extend({}, this._filenameEditHandler());
                return new qq.FilenameInputFocusInHandler(a)
        },
        _bindFilenameInputFocusEvent: function() {
                var a = qq.extend({}, this._filenameEditHandler());
                return new qq.FilenameInputFocusHandler(a)
        },
        _bindFilenameClickEvent: function() {
                var a = qq.extend({}, this._filenameEditHandler());
                return new qq.FilenameClickHandler(a)
        },
        _leaving_document_out: function(a) {
                return (qq.chrome() || qq.safari() && qq.windows()) && 0 == a.clientX && 0 == a.clientY || qq.firefox() && !a.relatedTarget
        },
        _storeForLater: function(a) {
                qq.FineUploaderBasic.prototype._storeForLater.apply(this, arguments);
                var b = this.getItemByFileId(a);
                qq(this._find(b, "spinner")).hide()
        },
        _find: function(a, b) {
                var c = qq(a).getByClass(this._options.classes[b])[0];
                if (!c)
                        throw new Error("element not found " + b);
                return c
        },
        _onSubmit: function(a, b) {
                qq.FineUploaderBasic.prototype._onSubmit.apply(this, arguments), this._addToList(a, b)
        },
        _onSubmitted: function(a) {
                if (this._isEditFilenameEnabled()) {
                        var b = this.getItemByFileId(a),
                                c = qq(this._find(b, "file")),
                                d = qq(this._find(b, "editNameIcon")),
                                e = this._classes.editable;
                        c.addClass(e), d.addClass(e), this._focusinEventSupported || this._filenameInputFocusHandler.addHandler(this._find(b, "editFilenameInput"))
                }
        },
        _onProgress: function(a, b, c, d) {
                qq.FineUploaderBasic.prototype._onProgress.apply(this, arguments);
                var e, f, g, h;
                e = this.getItemByFileId(a), f = this._find(e, "progressBar"), g = Math.round(100 * (c / d)), c === d ? (h = this._find(e, "cancel"), qq(h).hide(), qq(f).hide(), qq(this._find(e, "statusText")).setText(this._options.text.waitingForResponse), this._displayFileSize(a)) : (this._displayFileSize(a, c, d), qq(f).css({
                        display: "block"
                })), qq(f).css({
                        width: g + "%"
                })
        },
        _onComplete: function(a, b, c) {
                qq.FineUploaderBasic.prototype._onComplete.apply(this, arguments);
                var d = this.getItemByFileId(a);
                qq(this._find(d, "statusText")).clearText(), qq(d).removeClass(this._classes.retrying), qq(this._find(d, "progressBar")).hide(), (!this._options.disableCancelForFormUploads || qq.supportedFeatures.ajaxUploading) && qq(this._find(d, "cancel")).hide(), qq(this._find(d, "spinner")).hide(), c.success ? (this._isDeletePossible() && this._showDeleteLink(a), qq(d).addClass(this._classes.success), this._classes.successIcon && (this._find(d, "finished").style.display = "inline-block", qq(d).addClass(this._classes.successIcon))) : (qq(d).addClass(this._classes.fail), this._classes.failIcon && (this._find(d, "finished").style.display = "inline-block", qq(d).addClass(this._classes.failIcon)), this._options.retry.showButton && !this._preventRetries[a] && qq(d).addClass(this._classes.retryable), this._controlFailureTextDisplay(d, c))
        },
        _onUpload: function(a) {
                qq.FineUploaderBasic.prototype._onUpload.apply(this, arguments), this._showSpinner(a)
        },
        _onCancel: function(a) {
                qq.FineUploaderBasic.prototype._onCancel.apply(this, arguments), this._removeFileItem(a)
        },
        _onBeforeAutoRetry: function(a) {
                var b, c, d, e, f, g;
                qq.FineUploaderBasic.prototype._onBeforeAutoRetry.apply(this, arguments), b = this.getItemByFileId(a), c = this._find(b, "progressBar"), this._showCancelLink(b), c.style.width = 0, qq(c).hide(), this._options.retry.showAutoRetryNote && (d = this._find(b, "statusText"), e = this._autoRetries[a] + 1, f = this._options.retry.maxAutoAttempts, g = this._options.retry.autoRetryNote.replace(/\{retryNum\}/g, e), g = g.replace(/\{maxAuto\}/g, f), qq(d).setText(g), 1 === e && qq(b).addClass(this._classes.retrying))
        },
        _onBeforeManualRetry: function(a) {
                var b = this.getItemByFileId(a);
                return qq.FineUploaderBasic.prototype._onBeforeManualRetry.apply(this, arguments) ? (this._find(b, "progressBar").style.width = 0, qq(b).removeClass(this._classes.fail), qq(this._find(b, "statusText")).clearText(), this._showSpinner(a), this._showCancelLink(b), !0) : (qq(b).addClass(this._classes.retryable), !1)
        },
        _onSubmitDelete: function(a) {
                var b = qq.bind(this._onSubmitDeleteSuccess, this, a);
                qq.FineUploaderBasic.prototype._onSubmitDelete.call(this, a, b)
        },
        _onSubmitDeleteSuccess: function(a) {
                this._options.deleteFile.forceConfirm ? this._showDeleteConfirm(a) : this._sendDeleteRequest(a)
        },
        _onDeleteComplete: function(a, b, c) {
                qq.FineUploaderBasic.prototype._onDeleteComplete.apply(this, arguments);
                var d = this.getItemByFileId(a),
                        e = this._find(d, "spinner"),
                        f = this._find(d, "statusText");
                qq(e).hide(), c ? (qq(f).setText(this._options.deleteFile.deletingFailedText), this._showDeleteLink(a)) : this._removeFileItem(a)
        },
        _sendDeleteRequest: function(a) {
                var b = this.getItemByFileId(a),
                        c = this._find(b, "deleteButton"),
                        d = this._find(b, "statusText");
                qq(c).hide(), this._showSpinner(a), qq(d).setText(this._options.deleteFile.deletingStatusText), this._deleteHandler.sendDelete(a, this.getUuid(a))
        },
        _showDeleteConfirm: function(a) {
                var b = this._handler.getName(a),
                        c = this._options.deleteFile.confirmMessage.replace(/\{filename\}/g, b),
                        d = (this.getUuid(a), this);
                this._options.showConfirm(c, function() {
                        d._sendDeleteRequest(a)
                })
        },
        _addToList: function(a, b) {
                var c = qq.toElement(this._options.fileTemplate);
                if (this._options.disableCancelForFormUploads && !qq.supportedFeatures.ajaxUploading) {
                        var d = this._find(c, "cancel");
                        qq(d).remove()
                }
                c.qqFileId = a;
                var e = this._find(c, "file");
                qq(e).setText(this._options.formatFileName(b)), qq(this._find(c, "size")).hide(), this._options.multiple || (this._handler.cancelAll(), this._clearList()), this._options.display.prependFiles ? this._prependItem(c) : this._listElement.appendChild(c), this._filesInBatchAddedToUi += 1, this._options.display.fileSizeOnSubmit && qq.supportedFeatures.ajaxUploading && this._displayFileSize(a)
        },
        _prependItem: function(a) {
                var b = this._listElement,
                        c = b.firstChild;
                this._totalFilesInBatch > 1 && this._filesInBatchAddedToUi > 0 && (c = qq(b).children()[this._filesInBatchAddedToUi - 1].nextSibling), b.insertBefore(a, c)
        },
        _clearList: function() {
                this._listElement.innerHTML = "", this.clearStoredFiles()
        },
        _displayFileSize: function(a, b, c) {
                var d = this.getItemByFileId(a),
                        e = this.getSize(a),
                        f = this._formatSize(e),
                        g = this._find(d, "size");
                void 0 !== b && void 0 !== c && (f = this._formatProgress(b, c)), qq(g).css({
                        display: "inline"
                }), qq(g).setText(f)
        },
        _formatProgress: function(a, b) {
                function c(a, b) {
                        d = d.replace(a, b)
                }
                var d = this._options.text.formatProgress;
                return c("{percent}", Math.round(100 * (a / b))), c("{total_size}", this._formatSize(b)), d
        },
        _controlFailureTextDisplay: function(a, b) {
                var c, d, e, f, g;
                c = this._options.failedUploadTextDisplay.mode, d = this._options.failedUploadTextDisplay.maxChars, e = this._options.failedUploadTextDisplay.responseProperty, "custom" === c ? (f = b[e], f ? f.length > d && (g = f.substring(0, d) + "...") : (f = this._options.text.failUpload, this.log("'" + e + "' is not a valid property on the server response.", "warn")), qq(this._find(a, "statusText")).setText(g || f), this._options.failedUploadTextDisplay.enableTooltip && this._showTooltip(a, f)) : "default" === c ? qq(this._find(a, "statusText")).setText(this._options.text.failUpload) : "none" !== c && this.log("failedUploadTextDisplay.mode value of '" + c + "' is not valid", "warn")
        },
        _showTooltip: function(a, b) {
                a.title = b
        },
        _showSpinner: function(a) {
                var b = this.getItemByFileId(a),
                        c = this._find(b, "spinner");
                c.style.display = "inline-block"
        },
        _showCancelLink: function(a) {
                if (!this._options.disableCancelForFormUploads || qq.supportedFeatures.ajaxUploading) {
                        var b = this._find(a, "cancel");
                        qq(b).css({
                                display: "block"
                        })
                }
        },
        _showDeleteLink: function(a) {
                var b = this.getItemByFileId(a),
                        c = this._find(b, "deleteButton");
                qq(c).css({
                        display: "block"
                })
        },
        _itemError: function() {
                var a = qq.FineUploaderBasic.prototype._itemError.apply(this, arguments);
                this._options.showMessage(a)
        },
        _batchError: function(a) {
                qq.FineUploaderBasic.prototype._batchError.apply(this, arguments), this._options.showMessage(a)
        },
        _setupPastePrompt: function() {
                var a = this;
                this._options.callbacks.onPasteReceived = function() {
                        var b = a._options.paste.namePromptMessage,
                                c = a._options.paste.defaultName;
                        return a._options.showPrompt(b, c)
                }
        },
        _fileOrBlobRejected: function() {
                this._totalFilesInBatch -= 1, qq.FineUploaderBasic.prototype._fileOrBlobRejected.apply(this, arguments)
        },
        _prepareItemsForUpload: function(a) {
                this._totalFilesInBatch = a.length, this._filesInBatchAddedToUi = 0, qq.FineUploaderBasic.prototype._prepareItemsForUpload.apply(this, arguments)
        }
}), qq.AjaxRequestor = function(a) {
        "use strict";

        function b() {
                return qq.indexOf(["GET", "POST", "HEAD"], v.method) >= 0
        }

        function c() {
                var a = !1;
                return qq.each(a, function(b, c) {
                        return qq.indexOf(["Accept", "Accept-Language", "Content-Language", "Content-Type"], c) < 0 ? (a = !0, !1) : void 0
                }), a
        }

        function d(a) {
                return v.cors.expected && void 0 === a.withCredentials
        }

        function e() {
                var a;
                return window.XMLHttpRequest && (a = new XMLHttpRequest, void 0 === a.withCredentials && (a = new XDomainRequest)), a
        }

        function f(a, b) {
                var c = u[a].xhr;
                return c || b || (c = v.cors.expected ? e() : new XMLHttpRequest, u[a].xhr = c), c
        }

        function g(a) {
                var b, c = qq.indexOf(t, a),
                        d = v.maxConnections;
                delete u[a], t.splice(c, 1), t.length >= d && d > c && (b = t[d - 1], j(b))
        }

        function h(a, b) {
                var c = f(a),
                        e = v.method,
                        h = b === !1;
                g(a), h ? r(e + " request for " + a + " has failed", "error") : d(c) || q(c.status) || (h = !0, r(e + " request for " + a + " has failed - response code " + c.status, "error")), v.onComplete(a, c, h)
        }

        function i(a) {
                var b = {}, c = u[a].additionalParams,
                        d = v.mandatedParams;
                return v.paramsStore.getParams && (b = v.paramsStore.getParams(a)), c && qq.each(c, function(a, c) {
                        b[a] = c
                }), d && qq.each(d, function(a, c) {
                        b[a] = c
                }), b
        }

        function j(a) {
                var b, c = f(a),
                        e = v.method,
                        g = i(a);
                v.onSend(a), b = k(a, g), d(c) ? (c.onload = m(a), c.onerror = n(a)) : c.onreadystatechange = l(a), c.open(e, b, !0), v.cors.expected && v.cors.sendCredentials && !d(c) && (c.withCredentials = !0), o(a), r("Sending " + e + " request for " + a), !s && g ? c.send(qq.obj2url(g, "")) : c.send()
        }

        function k(a, b) {
                var c = v.endpointStore.getEndpoint(a),
                        d = u[a].addToPath;
                return void 0 != d && (c += "/" + d), s && b ? qq.obj2url(b, c) : c
        }

        function l(a) {
                return function() {
                        4 === f(a).readyState && h(a)
                }
        }

        function m(a) {
                return function() {
                        h(a)
                }
        }

        function n(a) {
                return function() {
                        h(a, !0)
                }
        }

        function o(a) {
                var e = f(a),
                        g = v.customHeaders;
                d(e) && (v.cors.expected && b() && !c(g) || (e.setRequestHeader("X-Requested-With", "XMLHttpRequest"), e.setRequestHeader("Cache-Control", "no-cache"))), "POST" !== v.method && "PUT" !== v.method || d(e) || e.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), d(e) || qq.each(g, function(a, b) {
                        e.setRequestHeader(a, b)
                })
        }

        function p(a) {
                var b = f(a, !0),
                        c = v.method;
                return b ? (d(b) ? (b.onerror = null, b.onload = null) : b.onreadystatechange = null, b.abort(), g(a), r("Cancelled " + c + " for " + a), v.onCancel(a), !0) : !1
        }

        function q(a) {
                return qq.indexOf(v.successfulResponseCodes[v.method], a) >= 0
        }
        var r, s, t = [],
                u = [],
                v = {
                        method: "POST",
                        maxConnections: 3,
                        customHeaders: {},
                        endpointStore: {},
                        paramsStore: {},
                        mandatedParams: {},
                        successfulResponseCodes: {
                                DELETE: [200, 202, 204],
                                POST: [200, 204]
                        },
                        cors: {
                                expected: !1,
                                sendCredentials: !1
                        },
                        log: function() {
                        },
                        onSend: function() {
                        },
                        onComplete: function() {
                        },
                        onCancel: function() {
                        }
                };
        return qq.extend(v, a), r = v.log, s = "GET" === v.method || "DELETE" === v.method, {
                send: function(a, b, c) {
                        u[a] = {
                                addToPath: b,
                                additionalParams: c
                        };
                        var d = t.push(a);
                        d <= v.maxConnections && j(a)
                },
                cancel: function(a) {
                        return p(a)
                }
        }
}, qq.DeleteFileAjaxRequestor = function(a) {
        "use strict";

        function b() {
                return f.method.toUpperCase()
        }

        function c() {
                return "POST" === b() ? {
                        _method: "DELETE"
                } : {}
        }
        var d, e = ["POST", "DELETE"],
                f = {
                        method: "DELETE",
                        uuidParamName: "qquuid",
                        endpointStore: {},
                        maxConnections: 3,
                        customHeaders: {},
                        paramsStore: {},
                        demoMode: !1,
                        cors: {
                                expected: !1,
                                sendCredentials: !1
                        },
                        log: function() {
                        },
                        onDelete: function() {
                        },
                        onDeleteComplete: function() {
                        }
                };
        if (qq.extend(f, a), qq.indexOf(e, b()) < 0)
                throw new Error("'" + b() + "' is not a supported method for delete file requests!");
        return d = new qq.AjaxRequestor({
                method: b(),
                endpointStore: f.endpointStore,
                paramsStore: f.paramsStore,
                mandatedParams: c(),
                maxConnections: f.maxConnections,
                customHeaders: f.customHeaders,
                demoMode: f.demoMode,
                log: f.log,
                onSend: f.onDelete,
                onComplete: f.onDeleteComplete,
                cors: f.cors
        }), {
                sendDelete: function(a, c) {
                        var e = {};
                        f.log("Submitting delete file request for " + a), "DELETE" === b() ? d.send(a, c) : (e[f.uuidParamName] = c, d.send(a, null, e))
                }
        }
}, qq.WindowReceiveMessage = function(a) {
        var b = {
                log: function() {
                }
        }, c = {};
        return qq.extend(b, a), {
                receiveMessage: function(a, b) {
                        var d = function(a) {
                                b(a.data)
                        };
                        window.postMessage ? c[a] = qq(window).attach("message", d) : log("iframe message passing not supported in this browser!", "error")
                },
                stopReceivingMessages: function(a) {
                        if (window.postMessage) {
                                var b = c[a];
                                b && b()
                        }
                }
        }
}, qq.UploadHandler = function(a) {
        "use strict";

        function b(a) {
                var b, c = qq.indexOf(h, a),
                        e = d.maxConnections;
                c >= 0 && (h.splice(c, 1), h.length >= e && e > c && (b = h[e - 1], f.upload(b)))
        }

        function c(a) {
                e("Cancelling " + a), d.paramsStore.remove(a), b(a)
        }
        var d, e, f, g, h = [];
        return d = {
                debug: !1,
                forceMultipart: !0,
                paramsInBody: !1,
                paramsStore: {},
                endpointStore: {},
                filenameParam: "qqfilename",
                cors: {
                        expected: !1,
                        sendCredentials: !1
                },
                maxConnections: 3,
                uuidParamName: "qquuid",
                totalFileSizeParamName: "qqtotalfilesize",
                chunking: {
                        enabled: !1,
                        partSize: 2e6,
                        paramNames: {
                                partIndex: "qqpartindex",
                                partByteOffset: "qqpartbyteoffset",
                                chunkSize: "qqchunksize",
                                totalParts: "qqtotalparts",
                                filename: "qqfilename"
                        }
                },
                resume: {
                        enabled: !1,
                        id: null,
                        cookiesExpireIn: 7,
                        paramNames: {
                                resuming: "qqresume"
                        }
                },
                log: function() {
                },
                onProgress: function() {
                },
                onComplete: function() {
                },
                onCancel: function() {
                },
                onUpload: function() {
                },
                onUploadChunk: function() {
                },
                onAutoRetry: function() {
                },
                onResume: function() {
                },
                onUuidChanged: function() {
                }
        }, qq.extend(d, a), e = d.log, f = qq.supportedFeatures.ajaxUploading ? new qq.UploadHandlerXhr(d, b, d.onUuidChanged, e) : new qq.UploadHandlerForm(d, b, d.onUuidChanged, e), g = {
                add: function(a) {
                        return f.add(a)
                },
                upload: function(a) {
                        var b = h.push(a);
                        return b <= d.maxConnections ? (f.upload(a), !0) : !1
                },
                retry: function(a) {
                        var b = qq.indexOf(h, a);
                        return b >= 0 ? f.upload(a, !0) : this.upload(a)
                },
                cancel: function(a) {
                        var b = f.cancel(a);
                        qq.isPromise(b) ? b.then(function() {
                                c(a)
                        }) : b !== !1 && c(a)
                },
                cancelAll: function() {
                        var a = this,
                                b = [];
                        qq.extend(b, h), qq.each(b, function(b, c) {
                                a.cancel(c)
                        }), h = []
                },
                getName: function(a) {
                        return f.getName(a)
                },
                setName: function(a, b) {
                        f.setName(a, b)
                },
                getSize: function(a) {
                        return f.getSize ? f.getSize(a) : void 0
                },
                getFile: function(a) {
                        return f.getFile ? f.getFile(a) : void 0
                },
                reset: function() {
                        e("Resetting upload handler"), g.cancelAll(), h = [], f.reset()
                },
                expunge: function(a) {
                        return f.expunge(a)
                },
                getUuid: function(a) {
                        return f.getUuid(a)
                },
                isValid: function(a) {
                        return f.isValid(a)
                },
                getResumableFilesData: function() {
                        return f.getResumableFilesData ? f.getResumableFilesData() : []
                }
        }
}, qq.UploadHandlerForm = function(a, b, c, d) {
        "use strict";

        function e(a) {
                void 0 !== t[a] && (t[a](), delete t[a])
        }

        function f(a, b) {
                var c = a.id,
                        d = m(c);
                y[r[d]] = b, t[d] = qq(a).attach("load", function() {
                        q[d] && (w("Received iframe load event for CORS upload request (iframe name " + c + ")"), u[c] = setTimeout(function() {
                                var a = "No valid message received from loaded iframe for iframe name " + c;
                                w(a, "error"), b({
                                        error: a
                                })
                        }, 1e3))
                }), x.receiveMessage(c, function(a) {
                        w("Received the following window message: '" + a + "'");
                        var b, d = i(m(c), a),
                                f = d.uuid;
                        f && y[f] ? (w("Handling response for iframe name " + c), clearTimeout(u[c]), delete u[c], e(c), b = y[f], delete y[f], x.stopReceivingMessages(c), b(d)) : f || w("'" + a + "' does not contain a UUID - ignoring.")
                })
        }

        function g(a, b) {
                p.cors.expected ? f(a, b) : t[a.id] = qq(a).attach("load", function() {
                        if (w("Received response for " + a.id), a.parentNode) {
                                try {
                                        if (a.contentDocument && a.contentDocument.body && "false" == a.contentDocument.body.innerHTML)
                                                return
                                } catch (c) {
                                        w("Error when attempting to access iframe during handling of upload response (" + c + ")", "error")
                                }
                                b()
                        }
                })
        }

        function h(a, b) {
                var c;
                try {
                        var d = b.contentDocument || b.contentWindow.document,
                                e = d.body.innerHTML;
                        w("converting iframe's innerHTML to JSON"), w("innerHTML = " + e), e && e.match(/^<pre/i) && (e = d.body.firstChild.firstChild.nodeValue), c = i(a, e)
                } catch (f) {
                        w("Error when attempting to parse form upload response (" + f + ")", "error"), c = {
                                success: !1
                        }
                }
                return c
        }

        function i(a, b) {
                var d;
                try {
                        d = qq.parseJson(b), void 0 !== d.newUuid && (w("Server requested UUID change from '" + r[a] + "' to '" + d.newUuid + "'"), r[a] = d.newUuid, c(a, d.newUuid))
                } catch (e) {
                        w("Error when attempting to parse iframe upload response (" + e + ")", "error"), d = {}
                }
                return d
        }

        function j(a) {
                var b = n(a),
                        c = qq.toElement('<iframe src="javascript:false;" name="' + b + '" />');
                return c.setAttribute("id", b), c.style.display = "none", document.body.appendChild(c), c
        }

        function k(a, b) {
                var c = p.paramsStore.getParams(a),
                        d = p.demoMode ? "GET" : "POST",
                        e = qq.toElement('<form method="' + d + '" enctype="multipart/form-data"></form>'),
                        f = p.endpointStore.getEndpoint(a),
                        g = f;
                return c[p.uuidParamName] = r[a], void 0 !== s[a] && (c[p.filenameParam] = s[a]), p.paramsInBody ? qq.obj2Inputs(c, e) : g = qq.obj2url(c, f), e.setAttribute("action", g), e.setAttribute("target", b.name), e.style.display = "none", document.body.appendChild(e), e
        }

        function l(a) {
                delete q[a], delete r[a], delete t[a], p.cors.expected && (clearTimeout(u[a]), delete u[a], x.stopReceivingMessages(a));
                var b = document.getElementById(n(a));
                b && (b.setAttribute("src", "java" + String.fromCharCode(115) + "cript:false;"), qq(b).remove())
        }

        function m(a) {
                return a.split("_")[0]
        }

        function n(a) {
                return a + "_" + z
        }
        var o, p = a,
                q = [],
                r = [],
                s = [],
                t = {}, u = {}, v = b,
                w = d,
                x = new qq.WindowReceiveMessage({
                        log: w
                }),
        y = {}, z = qq.getUniqueId();
        return o = {
                add: function(a) {
                        a.setAttribute("name", p.inputName);
                        var b = q.push(a) - 1;
                        return r[b] = qq.getUniqueId(), a.parentNode && qq(a).remove(), b
                },
                getName: function(a) {
                        return void 0 !== s[a] ? s[a] : o.isValid(a) ? q[a].value.replace(/.*(\/|\\)/, "") : (w(a + " is not a valid item ID.", "error"), void 0)
                },
                setName: function(a, b) {
                        s[a] = b
                },
                isValid: function(a) {
                        return void 0 !== q[a]
                },
                reset: function() {
                        q = [], r = [], s = [], t = {}, z = qq.getUniqueId()
                },
                expunge: function(a) {
                        return l(a)
                },
                getUuid: function(a) {
                        return r[a]
                },
                cancel: function(a) {
                        var b = p.onCancel(a, o.getName(a));
                        return qq.isPromise(b) ? b.then(function() {
                                l(a)
                        }) : b !== !1 ? (l(a), !0) : !1
                },
                upload: function(a) {
                        var b, c = q[a],
                                d = o.getName(a),
                                f = j(a);
                        if (!c)
                                throw new Error("file with passed id was not added, or already uploaded or cancelled");
                        p.onUpload(a, o.getName(a)), b = k(a, f), b.appendChild(c), g(f, function(b) {
                                w("iframe loaded");
                                var c = b ? b : h(a, f);
                                e(a), p.cors.expected || qq(f).remove(), (c.success || !p.onAutoRetry(a, d, c)) && (p.onComplete(a, d, c), v(a))
                        }), w("Sending upload request for " + a), b.submit(), qq(b).remove()
                }
        }
}, qq.UploadHandlerXhr = function(a, b, c, d) {
        "use strict";

        function e(a, b, c) {
                var d = K.getSize(a),
                        e = K.getName(a);
                b[L.chunking.paramNames.partIndex] = c.part, b[L.chunking.paramNames.partByteOffset] = c.start, b[L.chunking.paramNames.chunkSize] = c.size, b[L.chunking.paramNames.totalParts] = c.count, b[L.totalFileSizeParamName] = d, T && (b[L.filenameParam] = e)
        }

        function f(a) {
                a[L.resume.paramNames.resuming] = !0
        }

        function g(a, b, c) {
                return a.slice ? a.slice(b, c) : a.mozSlice ? a.mozSlice(b, c) : a.webkitSlice ? a.webkitSlice(b, c) : void 0
        }

        function h(a, b) {
                var c = L.chunking.partSize,
                        d = K.getSize(a),
                        e = O[a].file || O[a].blobData.blob,
                        f = c * b,
                        h = f + c >= d ? d : f + c,
                        j = i(a);
                return {
                        part: b,
                        start: f,
                        end: h,
                        count: j,
                        blob: g(e, f, h),
                        size: h - f
                }
        }

        function i(a) {
                var b = K.getSize(a),
                        c = L.chunking.partSize;
                return Math.ceil(b / c)
        }

        function j(a) {
                var b = new XMLHttpRequest;
                return O[a].xhr = b, b
        }

        function k(a, b, c, d) {
                var e = new FormData,
                        f = L.demoMode ? "GET" : "POST",
                        g = L.endpointStore.getEndpoint(d),
                        h = g,
                        i = K.getName(d),
                        j = K.getSize(d),
                        k = O[d].blobData,
                        l = O[d].newName;
                return a[L.uuidParamName] = O[d].uuid, T && (a[L.totalFileSizeParamName] = j, k && (a[L.filenameParam] = k.name)), void 0 !== l && (a[L.filenameParam] = l), L.paramsInBody || (T || (a[L.inputName] = l || i), h = qq.obj2url(a, g)), b.open(f, h, !0), L.cors.expected && L.cors.sendCredentials && (b.withCredentials = !0), T ? (L.paramsInBody && qq.obj2FormData(a, e), e.append(L.inputName, c), e) : c
        }

        function l(a, b) {
                var c = L.customHeaders,
                        d = O[a].file || O[a].blobData.blob;
                b.setRequestHeader("X-Requested-With", "XMLHttpRequest"), b.setRequestHeader("Cache-Control", "no-cache"), T || (b.setRequestHeader("Content-Type", "application/octet-stream"), b.setRequestHeader("X-Mime-Type", d.type)), qq.each(c, function(a, c) {
                        b.setRequestHeader(a, c)
                })
        }

        function m(a, b, c) {
                var d = K.getName(a),
                        e = K.getSize(a);
                O[a].attemptingResume = !1, L.onProgress(a, d, e, e), L.onComplete(a, d, b, c), O[a] && delete O[a].xhr, M(a)
        }

        function n(a) {
                var b, c, d = O[a].remainingChunkIdxs[0],
                        g = h(a, d),
                        i = j(a),
                        m = K.getSize(a),
                        n = K.getName(a);
                void 0 === O[a].loaded && (O[a].loaded = 0), R && O[a].file && z(a, g), i.onreadystatechange = y(a, i), i.upload.onprogress = function(b) {
                        if (b.lengthComputable) {
                                var c = b.loaded + O[a].loaded,
                                        e = o(a, d, b.total);
                                L.onProgress(a, n, c, e)
                        }
                }, L.onUploadChunk(a, n, x(g)), c = L.paramsStore.getParams(a), e(a, c, g), O[a].attemptingResume && f(c), b = k(c, i, g.blob, a), l(a, i), N("Sending chunked upload request for item " + a + ": bytes " + (g.start + 1) + "-" + g.end + " of " + m), i.send(b)
        }

        function o(a, b, c) {
                var d = h(a, b),
                        e = d.size,
                        f = c - e,
                        g = K.getSize(a),
                        i = d.count,
                        j = O[a].initialRequestOverhead,
                        k = f - j;
                return O[a].lastRequestOverhead = f, 0 === b ? (O[a].lastChunkIdxProgress = 0, O[a].initialRequestOverhead = f, O[a].estTotalRequestsSize = g + i * f) : O[a].lastChunkIdxProgress !== b && (O[a].lastChunkIdxProgress = b, O[a].estTotalRequestsSize += k), O[a].estTotalRequestsSize
        }

        function p(a) {
                return T ? O[a].lastRequestOverhead : 0
        }

        function q(a, b, c) {
                var d = O[a].remainingChunkIdxs.shift(),
                        e = h(a, d);
                O[a].attemptingResume = !1, O[a].loaded += e.size + p(a), O[a].remainingChunkIdxs.length > 0 ? n(a) : (R && A(a), m(a, b, c))
        }

        function r(a, b) {
                return 200 !== a.status || !b.success || b.reset
        }

        function s(a, b) {
                var d;
                try {
                        d = qq.parseJson(b.responseText), void 0 !== d.newUuid && (N("Server requested UUID change from '" + O[a].uuid + "' to '" + d.newUuid + "'"), O[a].uuid = d.newUuid, c(a, d.newUuid))
                } catch (e) {
                        N("Error when attempting to parse xhr response text (" + e + ")", "error"), d = {}
                }
                return d
        }

        function t(a) {
                N("Server has ordered chunking effort to be restarted on next attempt for item ID " + a, "error"), R && (A(a), O[a].attemptingResume = !1), O[a].remainingChunkIdxs = [], delete O[a].loaded, delete O[a].estTotalRequestsSize, delete O[a].initialRequestOverhead
        }

        function u(a) {
                O[a].attemptingResume = !1, N("Server has declared that it cannot handle resume for item ID " + a + " - starting from the first chunk", "error"), t(a), K.upload(a, !0)
        }

        function v(a, b, c) {
                var d = K.getName(a);
                L.onAutoRetry(a, d, b, c) || m(a, b, c)
        }

        function w(a, b) {
                var c;
                O[a] && (N("xhr - server response received for " + a), N("responseText = " + b.responseText), c = s(a, b), r(b, c) ? (c.reset && t(a), O[a].attemptingResume && c.reset ? u(a) : v(a, c, b)) : Q ? q(a, c, b) : m(a, c, b))
        }

        function x(a) {
                return {
                        partIndex: a.part,
                        startByte: a.start + 1,
                        endByte: a.end,
                        totalParts: a.count
                }
        }

        function y(a, b) {
                return function() {
                        4 === b.readyState && w(a, b)
                }
        }

        function z(a, b) {
                var c = K.getUuid(a),
                        d = O[a].loaded,
                        e = O[a].initialRequestOverhead,
                        f = O[a].estTotalRequestsSize,
                        g = C(a),
                        h = c + P + b.part + P + d + P + e + P + f,
                        i = L.resume.cookiesExpireIn;
                qq.setCookie(g, h, i)
        }

        function A(a) {
                if (O[a].file) {
                        var b = C(a);
                        qq.deleteCookie(b)
                }
        }

        function B(a) {
                var b, c, d, e, f, g, h = qq.getCookie(C(a)),
                        i = K.getName(a);
                if (h) {
                        if (b = h.split(P), 5 === b.length)
                                return c = b[0], d = parseInt(b[1], 10), e = parseInt(b[2], 10), f = parseInt(b[3], 10), g = parseInt(b[4], 10), {
                                        uuid: c,
                                        part: d,
                                        lastByteSent: e,
                                        initialRequestOverhead: f,
                                        estTotalRequestsSize: g
                                };
                        N("Ignoring previously stored resume/chunk cookie for " + i + " - old cookie format", "warn")
                }
        }

        function C(a) {
                var b, c = K.getName(a),
                        d = K.getSize(a),
                        e = L.chunking.partSize;
                return b = "qqfilechunk" + P + encodeURIComponent(c) + P + d + P + e, void 0 !== S && (b += P + S), b
        }

        function D() {
                return null === L.resume.id || void 0 === L.resume.id || qq.isFunction(L.resume.id) || qq.isObject(L.resume.id) ? void 0 : L.resume.id
        }

        function E(a, b) {
                var c;
                for (c = i(a) - 1; c >= b; c -= 1)
                        O[a].remainingChunkIdxs.unshift(c);
                n(a)
        }

        function F(a, b, c, d) {
                c = d.part, O[a].loaded = d.lastByteSent, O[a].estTotalRequestsSize = d.estTotalRequestsSize, O[a].initialRequestOverhead = d.initialRequestOverhead, O[a].attemptingResume = !0, N("Resuming " + b + " at partition index " + c), E(a, c)
        }

        function G(a, b, c) {
                var d, e = K.getName(a),
                        f = h(a, b.part);
                d = L.onResume(a, e, x(f)), qq.isPromise(d) ? (N("Waiting for onResume promise to be fulfilled for " + a), d.then(function() {
                        F(a, e, c, b)
                }, function() {
                        N("onResume promise fulfilled - failure indicated.  Will not resume."), E(a, c)
                })) : d !== !1 ? F(a, e, c, b) : (N("onResume callback returned false.  Will not resume."), E(a, c))
        }

        function H(a, b) {
                var c, d = 0;
                O[a].remainingChunkIdxs && 0 !== O[a].remainingChunkIdxs.length ? n(a) : (O[a].remainingChunkIdxs = [], R && !b && O[a].file ? (c = B(a), c ? G(a, c, d) : E(a, d)) : E(a, d))
        }

        function I(a) {
                var b, c, d, e = O[a].file || O[a].blobData.blob,
                        f = K.getName(a);
                O[a].loaded = 0, b = j(a), b.upload.onprogress = function(b) {
                        b.lengthComputable && (O[a].loaded = b.loaded, L.onProgress(a, f, b.loaded, b.total))
                }, b.onreadystatechange = y(a, b), c = L.paramsStore.getParams(a), d = k(c, b, e, a), l(a, b), N("Sending upload request for " + a), b.send(d)
        }

        function J(a) {
                var b = O[a].xhr;
                b && (b.onreadystatechange = null, b.abort()), R && A(a), delete O[a]
        }
        var K, L = a,
                M = b,
                N = d,
                O = [],
                P = "|",
                Q = L.chunking.enabled && qq.supportedFeatures.chunking,
                R = L.resume.enabled && Q && qq.supportedFeatures.resume,
                S = D(),
                T = L.forceMultipart || L.paramsInBody;
        return K = {
                add: function(a) {
                        var b, c, d = qq.getUniqueId();
                        if (qq.isFile(a))
                                b = O.push({
                                        file: a
                                }) - 1;
                        else {
                                if (!qq.isBlob(a.blob))
                                        throw new Error("Passed obj in not a File or BlobData (in qq.UploadHandlerXhr)");
                                b = O.push({
                                        blobData: a
                                }) - 1
                        }
                        return R && (c = B(b), c && (d = c.uuid)), O[b].uuid = d, b
                },
                getName: function(a) {
                        if (K.isValid(a)) {
                                var b = O[a].file,
                                        c = O[a].blobData,
                                        d = O[a].newName;
                                return void 0 !== d ? d : b ? null !== b.fileName && void 0 !== b.fileName ? b.fileName : b.name : c.name
                        }
                        N(a + " is not a valid item ID.", "error")
                },
                setName: function(a, b) {
                        O[a].newName = b
                },
                getSize: function(a) {
                        var b = O[a].file || O[a].blobData.blob;
                        return qq.isFileOrInput(b) ? null != b.fileSize ? b.fileSize : b.size : b.size
                },
                getFile: function(a) {
                        return O[a] ? O[a].file || O[a].blobData.blob : void 0
                },
                isValid: function(a) {
                        return void 0 !== O[a]
                },
                reset: function() {
                        O = []
                },
                expunge: function(a) {
                        return J(a)
                },
                getUuid: function(a) {
                        return O[a].uuid
                },
                upload: function(a, b) {
                        var c = this.getName(a);
                        this.isValid(a) && (L.onUpload(a, c), Q ? H(a, b) : I(a))
                },
                cancel: function(a) {
                        var b = L.onCancel(a, this.getName(a));
                        return qq.isPromise(b) ? b.then(function() {
                                J(a)
                        }) : b !== !1 ? (J(a), !0) : !1
                },
                getResumableFilesData: function() {
                        var a = [],
                                b = [];
                        return Q && R ? (a = void 0 === S ? qq.getCookieNames(new RegExp("^qqfilechunk\\" + P + ".+\\" + P + "\\d+\\" + P + L.chunking.partSize + "=")) : qq.getCookieNames(new RegExp("^qqfilechunk\\" + P + ".+\\" + P + "\\d+\\" + P + L.chunking.partSize + "\\" + P + S + "=")), qq.each(a, function(a, c) {
                                var d = c.split(P),
                                        e = qq.getCookie(c).split(P);
                                b.push({
                                        name: decodeURIComponent(d[1]),
                                        size: d[2],
                                        uuid: e[0],
                                        partIdx: e[1]
                                })
                        }), b) : []
                }
        }
}, qq.UiEventHandler = function(a, b) {
        "use strict";

        function c(a) {
                d.attach(a, e.eventType, function(a) {
                        a = a || window.event;
                        var b = a.target || a.srcElement;
                        e.onHandled(b, a)
                })
        }
        var d = new qq.DisposeSupport,
                e = {
                        eventType: "click",
                        attachTo: null,
                        onHandled: function() {
                        }
                }, f = {
                addHandler: function(a) {
                        c(a)
                },
                dispose: function() {
                        d.dispose()
                }
        };
        return qq.extend(b, {
                getItemFromEventTarget: function(a) {
                        for (var b = a.parentNode; void 0 === b.qqFileId; )
                                b = b.parentNode;
                        return b
                },
                getFileIdFromItem: function(a) {
                        return a.qqFileId
                },
                getDisposeSupport: function() {
                        return d
                }
        }), qq.extend(e, a), e.attachTo && c(e.attachTo), f
}, qq.DeleteRetryOrCancelClickHandler = function(a) {
        "use strict";

        function b(a, b) {
                if (qq(a).hasClass(e.classes.cancel) || qq(a).hasClass(e.classes.retry) || qq(a).hasClass(e.classes.deleteButton)) {
                        var f = d.getItemFromEventTarget(a),
                                g = d.getFileIdFromItem(f);
                        qq.preventDefault(b), e.log(qq.format("Detected valid cancel, retry, or delete click event on file '{}', ID: {}.", e.onGetName(g), g)), c(a, g)
                }
        }

        function c(a, b) {
                qq(a).hasClass(e.classes.deleteButton) ? e.onDeleteFile(b) : qq(a).hasClass(e.classes.cancel) ? e.onCancel(b) : e.onRetry(b)
        }
        var d = {}, e = {
                listElement: document,
                log: function() {
                },
                classes: {
                        cancel: "qq-upload-cancel",
                        deleteButton: "qq-upload-delete",
                        retry: "qq-upload-retry"
                },
                onDeleteFile: function() {
                },
                onCancel: function() {
                },
                onRetry: function() {
                },
                onGetName: function() {
                }
        };
        qq.extend(e, a), e.eventType = "click", e.onHandled = b, e.attachTo = e.listElement, qq.extend(this, new qq.UiEventHandler(e, d))
}, qq.FilenameEditHandler = function(a, b) {
        "use strict";

        function c(a) {
                var b = i.onGetName(a),
                        c = b.lastIndexOf(".");
                return c > 0 && (b = b.substr(0, c)), b
        }

        function d(a) {
                var b = i.onGetName(a),
                        c = b.lastIndexOf(".");
                return c > 0 ? b.substr(c, b.length - c) : void 0
        }

        function e(a, b) {
                var c, e = a.value;
                void 0 !== e && qq.trimStr(e).length > 0 && (c = d(b), void 0 !== c && (e += d(b)), i.onSetName(b, e)), i.onEditingStatusChange(b, !1)
        }

        function f(a, c) {
                b.getDisposeSupport().attach(a, "blur", function() {
                        e(a, c)
                })
        }

        function g(a, c) {
                b.getDisposeSupport().attach(a, "keyup", function(b) {
                        var d = b.keyCode || b.which;
                        13 === d && e(a, c)
                })
        }
        var h, i = {
                listElement: null,
                log: function() {
                },
                classes: {
                        file: "qq-upload-file"
                },
                onGetUploadStatus: function() {
                },
                onGetName: function() {
                },
                onSetName: function() {
                },
                onGetInput: function() {
                },
                onEditingStatusChange: function() {
                }
        };
        return qq.extend(i, a), i.attachTo = i.listElement, h = qq.extend(this, new qq.UiEventHandler(i, b)), qq.extend(b, {
                handleFilenameEdit: function(a, b, d, e) {
                        var h = i.onGetInput(d);
                        i.onEditingStatusChange(a, !0), h.value = c(a), e && h.focus(), f(h, a), g(h, a)
                }
        }), h
}, qq.FilenameClickHandler = function(a) {
        "use strict";

        function b(a, b) {
                if (qq(a).hasClass(d.classes.file) || qq(a).hasClass(d.classes.editNameIcon)) {
                        var e = c.getItemFromEventTarget(a),
                                f = c.getFileIdFromItem(e),
                                g = d.onGetUploadStatus(f);
                        g === qq.status.SUBMITTED && (d.log(qq.format("Detected valid filename click event on file '{}', ID: {}.", d.onGetName(f), f)), qq.preventDefault(b), c.handleFilenameEdit(f, a, e, !0))
                }
        }
        var c = {}, d = {
                log: function() {
                },
                classes: {
                        file: "qq-upload-file",
                        editNameIcon: "qq-edit-filename-icon"
                },
                onGetUploadStatus: function() {
                },
                onGetName: function() {
                }
        };
        return qq.extend(d, a), d.eventType = "click", d.onHandled = b, qq.extend(this, new qq.FilenameEditHandler(d, c))
}, qq.FilenameInputFocusInHandler = function(a, b) {
        "use strict";

        function c(a) {
                if (qq(a).hasClass(d.classes.editFilenameInput)) {
                        var c = b.getItemFromEventTarget(a),
                                e = b.getFileIdFromItem(c),
                                f = d.onGetUploadStatus(e);
                        f === qq.status.SUBMITTED && (d.log(qq.format("Detected valid filename input focus event on file '{}', ID: {}.", d.onGetName(e), e)), b.handleFilenameEdit(e, a, c))
                }
        }
        var d = {
                listElement: null,
                classes: {
                        editFilenameInput: "qq-edit-filename"
                },
                onGetUploadStatus: function() {
                },
                log: function() {
                }
        };
        return b || (b = {}), d.eventType = "focusin", d.onHandled = c, qq.extend(d, a), qq.extend(this, new qq.FilenameEditHandler(d, b))
}, qq.FilenameInputFocusHandler = function(a) {
        "use strict";
        return a.eventType = "focus", a.attachTo = null, qq.extend(this, new qq.FilenameInputFocusInHandler(a, {}))
},
        function(a) {
                "use strict";
                var b, c, d, e, f, g, h, i, j, k;
                g = ["uploaderType"], d = function(a) {
                        if (a) {
                                var d = i(a);
                                h(d), "basic" === f("uploaderType") ? b(new qq.FineUploaderBasic(d)) : b(new qq.FineUploader(d))
                        }
                        return c
                }, e = function(a, b) {
                        var d = c.data("fineuploader");
                        return b ? (void 0 === d && (d = {}), d[a] = b, c.data("fineuploader", d), void 0) : void 0 === d ? null : d[a]
                }, b = function(a) {
                        return e("uploader", a)
                }, f = function(a, b) {
                        return e(a, b)
                }, h = function(b) {
                        var d = b.callbacks = {}, e = new qq.FineUploaderBasic;
                        a.each(e._options.callbacks, function(a) {
                                var b, e;
                                b = /^on(\w+)/.exec(a)[1], b = b.substring(0, 1).toLowerCase() + b.substring(1), e = c, d[a] = function() {
                                        var a = Array.prototype.slice.call(arguments);
                                        return e.triggerHandler(b, a)
                                }
                        })
                }, i = function(b, d) {
                        var e, h;
                        return e = void 0 === d ? "basic" !== b.uploaderType ? {
                                element: c[0]
                        } : {} : d, a.each(b, function(b, c) {
                                a.inArray(b, g) >= 0 ? f(b, c) : c instanceof a ? e[b] = c[0] : a.isPlainObject(c) ? (e[b] = {}, i(c, e[b])) : a.isArray(c) ? (h = [], a.each(c, function(b, c) {
                                        c instanceof a ? a.merge(h, c) : h.push(c)
                                }), e[b] = h) : e[b] = c
                        }), void 0 === d ? e : void 0
                }, j = function(c) {
                        return "string" === a.type(c) && !c.match(/^_/) && void 0 !== b()[c]
                }, k = function(c) {
                        var d, e = [],
                                f = Array.prototype.slice.call(arguments, 1);
                        return i(f, e), d = b()[c].apply(b(), e), "object" != typeof d || 1 !== d.nodeType && 9 !== d.nodeType || !d.cloneNode || (d = a(d)), d
                }, a.fn.fineUploader = function(e) {
                        var f = this,
                                g = arguments,
                                h = [];
                        return this.each(function(i, l) {
                                if (c = a(l), b() && j(e)) {
                                        if (h.push(k.apply(f, g)), 1 === f.length)
                                                return !1
                                } else
                                        "object" != typeof e && e ? a.error("Method " + e + " does not exist on jQuery.fineUploader") : d.apply(f, g)
                        }), 1 === h.length ? h[0] : h.length > 1 ? h : this
                }
        }(jQuery),
        function(a) {
                "use strict";

                function b(a) {
                        a || (a = {}), a.dropZoneElements = [i];
                        var b = f(a);
                        return e(b), d(new qq.DragAndDrop(b)), i
                }

                function c(a, b) {
                        var c = i.data(j);
                        return b ? (void 0 === c && (c = {}), c[a] = b, i.data(j, c), void 0) : void 0 === c ? null : c[a]
                }

                function d(a) {
                        return c("dndInstance", a)
                }

                function e(b) {
                        var c = b.callbacks = {};
                        new qq.FineUploaderBasic, a.each(new qq.DragAndDrop.callbacks, function(a) {
                                var b, d = a;
                                b = i, c[a] = function() {
                                        var a = Array.prototype.slice.call(arguments),
                                                c = b.triggerHandler(d, a);
                                        return c
                                }
                        })
                }

                function f(b, c) {
                        var d, e;
                        return d = void 0 === c ? {} : c, a.each(b, function(b, c) {
                                c instanceof a ? d[b] = c[0] : a.isPlainObject(c) ? (d[b] = {}, f(c, d[b])) : a.isArray(c) ? (e = [], a.each(c, function(b, c) {
                                        c instanceof a ? a.merge(e, c) : e.push(c)
                                }), d[b] = e) : d[b] = c
                        }), void 0 === c ? d : void 0
                }

                function g(b) {
                        return "string" === a.type(b) && "dispose" === b && void 0 !== d()[b]
                }

                function h(a) {
                        var b = [],
                                c = Array.prototype.slice.call(arguments, 1);
                        return f(c, b), d()[a].apply(d(), b)
                }
                var i, j = "fineUploaderDnd";
                a.fn.fineUploaderDnd = function(c) {
                        var e = this,
                                f = arguments,
                                j = [];
                        return this.each(function(k, l) {
                                if (i = a(l), d() && g(c)) {
                                        if (j.push(h.apply(e, f)), 1 === e.length)
                                                return !1
                                } else
                                        "object" != typeof c && c ? a.error("Method " + c + " does not exist in Fine Uploader's DnD module.") : b.apply(e, f)
                        }), 1 === j.length ? j[0] : j.length > 1 ? j : this
                }
        }(jQuery);
/*! 2013-06-28 */
