(window).modalForm = function (element, url) {
    function update() {
        $('#form-state-alert').remove();
        start();
        $('#dialog-form').modal('show');
        var form = document.getElementById('model-form');
        clearForm(form);
        if (!url) {
            onAdd();
            end();
        } else {
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                success: function (data) {
                    load(data);
                    end();
                }
            });
        }
    }

    function onAdd() {
        $('#dialog-form').find('input, select').each(function () {
            var input = $(this);
            if (input.is('[data-add-value]')) {
                input.val(input.attr('data-add-value'))
            }
        });
    }

    function start() {
        $('#modal-container-loading').css({display: 'block'});
        $('#modal-container-form').css({display: 'none'});
    }

    function end() {
        $('#modal-container-loading').css({display: 'none'});
        $('#modal-container-form').css({display: 'block'});
    }

    function load(data) {
        $('#dialog-form').find('input, select').each(function () {
            var att = attribute(this);
            if (att && typeof data[att] !== 'undefined') {
                var el = $(this);
                el.val(map(data[att]));
                if (el.data('select2')) {
                    el.trigger('change.select2');
                }
            }
        });
    }

    function map(data) {
        if (data === true) return '1';
        if (data === false) return '0';
        return data;
    }

    update();
};

(window).gridControl = {
    shouldRefresh: false,
    reload: function (force) {
        if (force) {
            $.pjax.reload({container: "#gridview-pjax"});
        }
        if (this.shouldRefresh) {
            this.shouldRefresh = false;
            $.pjax.reload({container: "#gridview-pjax"});
        }
    },
    delete: function (element, url) {
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            success: function (data) {
                // noinspection EqualityComparisonWithCoercionJS
                if (data == true) {
                    gridControl.reload(true);
                } else {
                    if (data === false || data === "false") {
                        toastr.error("This item can't be deleted");
                    } else {
                        toastr.error(data);
                    }
                }
            }, error: function (data) {
                toastr.error("This item can't be deleted");
            }
        });
    }
};

(window).modalControl = {
    close: function () {
        $('#dialog-form').modal('hide');
    },
    open: function () {
        $('#dialog-form').modal('show');
    }
};
(window).modalEvent = {
    pjaxSend: function (event) {
        var button = $('#modal-form-submit');
        button.find('i').removeClass('hidden');
        button.prop('disabled', true);
    },
    pjaxComplet: function (event) {
        var button = $('#modal-form-submit');
        button.find('i').addClass('hidden');
        button.prop('disabled', false);
    }
};


window.addEventListener('load', function () {
    $('#dialog-form').on('hidden.bs.modal', function () {
        gridControl.reload();
    });
    $(document).on('pjax:send', function (e) {
        if (e.target && e.target.id === 'modal-form-pjax') modalEvent.pjaxSend((event));
    });
    $(document).on('pjax:complete', function (e) {
        if (e.target && e.target.id === 'modal-form-pjax') modalEvent.pjaxComplet((event));
    });
});

