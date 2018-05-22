if (!String.prototype.format) {
    String.prototype.format = function () {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number) {
            return typeof args[number] !== 'undefined' ? args[number] : match;
        });
    };
}

function attribute(of) {
    var reg = "(?<=\\[).+?(?=\\])";
    return (of.name.match(reg) || [false])[0];
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
                break;
            default:
                break;
        }
    }

    $('.help-block-error').text('');
    $('.form-group').removeClass('has-error');
}

window.addEventListener('load',function (ev) {
    window.toastr.options.positionClass = "toast-bottom-right";
});