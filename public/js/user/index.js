var UserIndex = function () {
    return {
        init: function () {

            $('#contentForm').submit(
                function (e) {
                    e.preventDefault();
                    var url = $(this).attr('action');
                    var contentUrl = $('#contentInput').val();
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: {
                            'url': contentUrl
                        },
                        success: function (json) {
                            if (json.status) {
                                var data = json.data;

                                if (data.title) {
                                    $('#responseDiv').show();
                                    $('#titleInput').val(data.title);

                                    if (data.images.length > 0) {
                                        var ul = $('#images');
                                        ul.empty();
                                        for (i in data.images) {
                                            var img = $(document.createElement('img'));
                                            img.attr('src', data.images[i]);
                                            img.attr('width','150');

                                            var li = $(document.createElement('li'));
                                            li.append(img);
                                            ul.append(li);

                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            );
        }
    };
}();