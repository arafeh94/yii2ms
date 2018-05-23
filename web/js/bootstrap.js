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

window.addEventListener('load', function (ev) {
    window.toastr.options.positionClass = "toast-bottom-right";
});

function copy(text) {
    var textArea = document.createElement("textarea");
    textArea.style.position = 'fixed';
    textArea.style.top = 0;
    textArea.style.left = 0;
    textArea.style.width = '2em';
    textArea.style.height = '2em';
    textArea.style.padding = 0;
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';
    textArea.style.background = 'transparent';
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        toastr.info('Copied');
    } catch (err) {
        toastr.info('Oops, unable to copy');
    }

    document.body.removeChild(textArea);
}

function send(email, content) {

}

