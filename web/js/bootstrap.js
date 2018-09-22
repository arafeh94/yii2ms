if (!String.prototype.format) {
    String.prototype.format = function () {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number) {
            return typeof args[number] !== 'undefined' ? args[number] : match;
        });
    };
}

function attribute(of) {
    var reg = "(\\[(.*?)\\])";
    var matches = of.name.match(reg);
    if (matches) return matches[2];
    return false;
}

function reloadTable() {
    $.pjax({container: '#gridview-pjax'});
}

function clearForm(form) {
    var elements = form.elements;
    form.reset();
    for (var i = 0; i < elements.length; i++) {
        var field_type = elements[i].type.toLowerCase();
        switch (field_type) {
            case "text":
            case "number":
            case "password":
            case "textarea":
            case "hidden":
                elements[i].value = "";
                break;
            case "radio":
            case "checkbox":
                if (elements[i].checked) elements[i].checked = false;
                break;
            case "select-one":
            case "select-multi":
                elements[i].selectedIndex = -1;
                var el = $(elements[i]);
                if (el.data('select2')) {
                    el.trigger('change.select2');
                }
                break;
            default:
                break;
        }
    }

    $('.help-block-error').text('');
    $('.form-group').removeClass('has-error');
}

window.addEventListener('load', function (ev) {
    window.toastr.options.positionClass = "toast-bottom-right";
});

function copy(text) {
    var textarea = document.createElement('textarea');
    textarea.textContent = text;
    document.body.appendChild(textarea);

    var selection = document.getSelection();
    var range = document.createRange();
    range.selectNode(textarea);
    selection.removeAllRanges();
    selection.addRange(range);

    if (document.execCommand('copy')) {
        toastr.success('text copied');
    } else {
        toastr.error("can't copy");
    }
    selection.removeAllRanges();

    document.body.removeChild(textarea);
}

/**
 * @param $data []
 */
function sum($data) {
    return $data.reduce(function (stack, item) {
        return isNaN(item) ? stack : stack + item;
    }, 0);
}

/**
 * @param $data []
 */
function count($data) {
    return $data.reduce(function (stack, item) {
        return isNaN(item) ? stack : stack + 1;
    }, 0);
}

/**
 * @param $data []
 */
function avg($data) {
    return sum($data) / count($data) || 0;
}

function gpa($source, $data) {
    console.log('source', $source);
    console.log('data', $data);
    return 1;
}