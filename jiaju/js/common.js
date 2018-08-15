function getUrl(strs) {//获取参数
    var url = $("#SITE_URL").val() + "/" + strs;
    return url;
}

function getMinInt(obj, val) {
    if (isNaN(obj.val()) == true || parseInt(obj.val()) < val) {
        obj.val(val);
    }
}
function getMinInt2(obj, val) {
    if ((isNaN(obj.val()) == true || obj.val() < val) && obj.val() != 0) {
        obj.val(val);
    }
}
function clickInput(obj, word) {
    if (obj.val() == word) {
        obj.val('');
    }
}
function blurInput(obj, word) {
    if (obj.val() == '') {
        obj.val(word);
    }
}

function hideBlur(obj) {
    setTimeout("goHide('" + obj + "')", 100)
}
function goHide(obj) {
    $(obj).hide()
}
function goShow(obj) {
    $(obj).show()
}
function showCheckbox(obj, id) {
    var checked = obj.prop("checked");
    if (checked == true) {
        $(id).show();
    } else {
        $(id).hide();
    }
}
function showCheckbox2(obj, id) {
    var checked = obj.prop("checked");
    if (checked == false) {
        $(id).show();
    } else {
        $(id).hide();
    }
}
function goUrl(url) {
    if (url == -1) {
        history.go(-1);
    } else {
        document.location.href = url;
    }
}
function toTaskObject(obj) {
    var top = $(obj).offset().top - 100;
    $('html').animate({
        scrollTop: top
    }, 'slow');
}