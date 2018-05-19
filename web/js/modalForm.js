(window).modalForm = function (element, url) {
    function update() {
        $('#dialog-form').modal('show');
        clearForm(document.getElementById('model-form'));
        $('#form-state-alert').remove();
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

    function end() {
        $('#modal-container-loading').css({display: 'none'});
        $('#modal-container-form').css({display: 'block'});
    }

    function load(data) {
        $('#dialog-form').find('input, select').each(function () {
            var att = attribute(this);
            if (att && typeof data[att] !== 'undefined') $(this).val(map(data[att]));
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
                gridControl.reload(true);
            }
        });
    }
};
(window).modalControl = {
    close: function () {

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

