function setCookie(name, value, expires, path, domain, secure) {
    var today = new Date();
    today.setTime(today.getTime());

    if (expires !== undefined) {
        expires = expires * 1000 * 60 * 60 * 24;
    } else {
        expires = 1000 * 60 * 60 * 24;
    }

    var expiresDate = new Date(today.getTime() + (expires));
    document.cookie = name + "=" + escape(value) +
        ( ( expires ) ? ";expires=" + expiresDate.toGMTString() : "" ) +
        ( ( path ) ? ";path=" + path : "" ) +
        ( ( domain ) ? ";domain=" + domain : "" ) +
        ( ( secure ) ? ";secure" : "" );
}

function getCookie(name) {
    var start = document.cookie.indexOf(name + "=");
    var len = start + name.length + 1;
    if (( !start ) &&
        ( name != document.cookie.substring(0, name.length) )) {
        return null;
    }
    if (start == -1) return null;
    var end = document.cookie.indexOf(";", len);
    if (end == -1) end = document.cookie.length;
    return unescape(document.cookie.substring(len, end));
}

function getCoockieArray(name) {
    var arrStr = '' + getCookie(name);
    var arr = arrStr.split(",");
    var arrRes = [];

    arr.forEach(function (entry) {
        if (entry != 'null' && entry != '') {
            arrRes.push(entry);
        }
    });

    return arrRes;
}

function addCoockieArray(name, id) {
    var arrRes = getCoockieArray(name);

    arrRes.push(id);

    setCookie(name, arrRes.join(','), 1000, '/');

    return arrRes;
}

function removeCoockieArray(name, id) {
    var arr = getCoockieArray(name);
    var arrRes = removeValue(arr, id);

    setCookie(name, arrRes.join(','), 1000, '/');

    return arrRes;
}

function removeValue(arr, value) {
    var arrRes = [];

    arr.forEach(function (entry) {
        if (value != entry) {
            arrRes.push(entry);
        }
    });

    return arrRes;
}