var inputAvatar = $('#avatar'),
    output = $('.output'),
    nameAvatar = $('#name_avatar'),
    imageCrop = $('#img-crop'),
    modalToCrop = $('#modal_image_crop'),
    inputBase64 = $('#base64'),
    formAvatar = $('#form-avatar'),
    btcCrop = $('#btnCrop');

$(document).ready(function () {
    inputAvatar.change(whenChangeAvatarInput);
    btcCrop.click(whenClickBtnCrop);
    modalToCrop.on('hide.bs.modal', whenModalHide);
});

function whenChangeAvatarInput() {
    var self = this;

    output.each(function (key, item) {
        $(item).attr('src', URL.createObjectURL(self.files[0]));
        $(item).css('display', '');
    });

    modalToCrop.modal('toggle');

    setTimeout(function () {
        imageCrop.cropper({
            aspectRatio: 1 / 1,
            checkCrossOrigin: false
        });
    }, 150);
}

function whenClickBtnCrop() {
    var croppedImageDataURL = imageCrop.cropper('getCroppedCanvas').toDataURL("image/png");

    output.each(function (key, item) {
        $(item).attr('src', croppedImageDataURL);
    });

    inputBase64.val(croppedImageDataURL);

    imageCrop.cropper('destroy');
    imageCrop.attr('src', '');

    modalToCrop.modal('toggle');

    formAvatar.submit();
}

function whenModalHide() {
    output.each(function (key, item) {
        $(item).attr('src', '');
        $(item).css('display', 'none');
    });

    inputAvatar.val('');
    nameAvatar.val('');
    imageCrop.cropper('destroy');
}