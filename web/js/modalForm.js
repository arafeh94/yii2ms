(window).modalForm = function (element, url) {
    function update() {
        $('#dialog-form').modal('show');
        clearForm(document.getElementById('model-form'));
        $('#form-state-alert').remove();
        if (!url) {
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

    function end() {
        $('#modal-container-loading').css({display: 'none'});
        $('#modal-container-form').css({display: 'block'});
    }


    function load(data) {
        $('#dialog-form').find('input,select').each(function () {
            var att = attribute(this);
            if (att && data[att]) this.value = data[att];
        });
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


window.addEventListener('load', function () {
    $('#dialog-form').on('hidden.bs.modal', function () {
        gridControl.reload();
    });
});

