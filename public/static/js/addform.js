Date.prototype.dateFormat = function(format){
    return moment(this).format(format);
};

Dropzone.autoDiscover = false;

var MainDropzone = new Dropzone("div#main_image", {
    url: "/auctions/upload/",
    uploadMultiple: false,
    acceptedFiles: 'image/*',
    maxFiles: 1,
    thumbnailWidth: 200,
    thumbnailHeight: 200,
    dictDefaultMessage: '<i class="glyphicon glyphicon-camera"></i><br>Завантажити',
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    init: function() {
        this.on("success", function(file, xhr) {
            // Handle the responseText here. For example, add the text to the preview element:

            var image = Dropzone.createElement('<input type="hidden" name="lot_image" value="'+ xhr.img +'" />');
            var image_min = Dropzone.createElement('<input type="hidden" name="lot_image_min" value="'+ xhr.imgmin +'" />');

            console.log(xhr.responseText);
            file.previewTemplate.appendChild(image);
            file.previewTemplate.appendChild(image_min);

            // Create the remove button
            var removeButton = Dropzone.createElement("<div class='remove-image' data-name='"+ xhr.url +"'><i class='glyphicon glyphicon-remove'></i></div>");

            // Capture the Dropzone instance as closure.
            var _this = this;

            // Listen to the click event
            removeButton.addEventListener("click", function(e) {
                // Make sure the button click doesn't submit the form:
                e.preventDefault();
                e.stopPropagation();

                // Remove the file preview.
                _this.removeFile(file);

                $.ajax({
                    type: "POST",
                    url: "/auctions/upload/delete",
                    data: "name="+ xhr.url,
                    success: function(msg){
                        console.log(msg);
                    }
                });

                // If you want to the delete the file on the server as well,
                // you can do the AJAX request here.
            });

            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);

        });
    }
});

var myDropzone = new Dropzone("div#more_image", {
    paramName: "file",
    maxFiles: maxfiles,
    url: "/auctions/upload/",
    acceptedFiles: 'image/*',
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    dictDefaultMessage: 'Натисніть або перетягніть фотографії в цю область для початку завантаження',
    init: function() {
        this.on("maxfilesexceeded", function(file){
            // Выводим сообщение о максимальном кол-ве загруженных изображений
            alert("Не більше " + maxfiles +" додаткових зображень");
            this.removeFile(file);
        });
        
        this.on("success", function(file, xhr) {
            // Handle the responseText here. For example, add the text to the preview element:

            var image = Dropzone.createElement('<input type="hidden" name="more_images[]" value="'+ xhr.id +'" />');

            console.log(xhr.responseText);
            file.previewTemplate.appendChild(image);

            // Create the remove button
            var removeButton = Dropzone.createElement("<div class='remove-image' data-name='"+ xhr.url +"'><i class='glyphicon glyphicon-remove'></i></div>");

            // Capture the Dropzone instance as closure.
            var _this = this;

            // Listen to the click event
            removeButton.addEventListener("click", function(e) {
                // Make sure the button click doesn't submit the form:
                e.preventDefault();
                e.stopPropagation();

                // Remove the file preview.
                _this.removeFile(file);

                $.ajax({
                    type: "POST",
                    url: "/auctions/upload/delete",
                    data: "name="+ xhr.url,
                    success: function(msg){
                        console.log(msg);
                    }
                });

                // If you want to the delete the file on the server as well,
                // you can do the AJAX request here.
            });

            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);

        });


    }
});

$(function () {
    $('#data_start').datetimepicker({
        locale: 'ru'
    });

    $('#date_end').datetimepicker({
        locale: 'ru'
    });
});

$('#free_sale').on('change', function()
{
    if($(this).is(':checked')) {
        $('#data_start').prop('disabled', true);
        $('#bid_price').prop('disabled', true);
        $('#date_end').prop('disabled', true);
        $('#guarantee_fee').prop('disabled', true);
        $('#starting_price_lable').text('Вартість');
        $('.possible-bargain').show();
        $('.negotiable-price').show();
    } else {
        $('#data_start').prop('disabled', false);
        $('#starting_price').prop('disabled', false);
        $('#bid_price').prop('disabled', false);
        $('#date_end').prop('disabled', false);
        $('#guarantee_fee').prop('disabled', false);
        $('#starting_price_lable').text('Стартова ціна');
        $('.possible-bargain').hide();
        $('.negotiable-price').hide();
    }
});

$('#SelectCategory').on('change', function(){
    var _this = $(this);
    if(_this.val())
    {
        $.ajax({
            url: '/auction/helpers/childrens-'+ _this.val(),
            dataType : "html",
            success: function (data, textStatus) {
                $('#loadChildren').html(data);
            }
        });

        $('.category_group').hide();
        $('.load_children').show();
        $('#Category-' + $(this).val()).show();
    } else {
        $('.load_children').hide();
        $('.category_group').hide();
    }


});



$(document).ready(function() {
    var selcat = $('#SelectCategory');

    if(selcat.val())
    {
        $.ajax({
            url: '/auction/helpers/childrens-'+ selcat.val(),
            dataType : "html",
            success: function (data, textStatus) {
                $('#loadChildren').html(data);
            }
        });

        $('.category_group').hide();
        $('.load_children').show();
        $('#Category-' + selcat.val()).show();
    } else {
        $('.load_children').hide();
        $('.category_group').hide();
    }

});