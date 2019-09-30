$(document).ready(function () {
    function getBase64 (file, callback) {
        let reader = new FileReader();

        reader.addEventListener('load', () => callback(reader.result));

        return reader.readAsDataURL(file);
    }

    function uploadImage(productId) {
        let data = {};
        let imageInput = $('#productImage')[0];
        let image;

        if (imageInput.files.length > 0) {
            image = imageInput.files[0];
        }

        if (!image) {
            return false;
        }

        getBase64(image, function(base64Data) {
            $('#base').text(base64Data);
        });

        setTimeout(function(){
            // WARNING: super dirty fix!

            data.image = $('#base').text();
            data.image = data.image.replace(/^data:image\/[a-z]+;base64,/, "");
            data = JSON.stringify(data);

            let request = $.ajax({
                url: 'http://localhost/api/products/' + productId + '/images',
                type: 'POST',
                data: data,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
        }, 1000);
    }

    let instance = $('#form').parsley();
    $('#form').on('submit', function (event) {
        event.preventDefault();

        if (!instance.isValid()) {
            return;
        }

        let productName = $('#productName').val(),
            productDescription = $('#productDescription').val(),
            productTags = [],
            productId;

        $('input[name="product-tag"]:checked').each(function () {
            productTags.push($(this).val());
        });

        let data = {};
        data.name = productName;
        data.description = productDescription;
        data.tags = productTags;
        data = JSON.stringify(data);

        let request = $.ajax({
            url: 'http://localhost/api/products',
            type: 'POST',
            data: data,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        request.done(function (response) {
            let locationHeader = request.getResponseHeader('Location').split('/');
            productId = locationHeader[locationHeader.length - 1];

            uploadImage(productId);
        });
    });
});
