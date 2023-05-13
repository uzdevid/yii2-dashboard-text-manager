$(document).ready(function () {
    $('.text-manager-check-field-button').on('click', function () {
        let id = $(this).data('id');
        let field = $(`#${id}`);

        if (field.length <= 0) {
            return false;
        }

        let value = field.val();

        if (value.length <= 0) {
            return false;
        }

        $.ajax({
            url: BASEURL + '/' + LANGUAGE + '/' + '/system/api/text-manager/check-field',
            type: 'POST',
            data: {
                id: id,
                text: value
            },
            success: function (data) {
                $('#modal-dialog').addClass('modal-lg');
                $('#modal-page-title').html("").html(data.body.title);
                $('#modal-page-body').html(data.body.view);

                modalPage.show();
            },
            error: function (data) {
                toaster.error(data.body.message, data.body.title)
            }
        });
    });
});