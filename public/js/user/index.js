var UserIndex = function () {
    return {
        init: function () {

            $('.select2').select2();

            $("#tagInput").select2({
                tags: []
            });


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
                                    $('#titleInput').text(data.title);

                                    var ul = $('#images');
                                    if (data.images.length > 0) {
                                        ul.show();
                                        ul.empty();
                                        for (i in data.images) {

//                                            <div class="active item">
//                                                <img src="assets/img/pics/img2-medium.jpg" alt="">
//                                                </div>

                                            var img = $(document.createElement('img'));
                                            img.attr('src', data.images[i]);

                                            var div = $(document.createElement('div'));

                                            div.attr('class', 'item');
                                            if (i == 0) {
                                                div.addClass('active');
                                            }
                                            div.append(img);
                                            ul.append(div);
                                        }

                                        $('#myCarousel').carousel(0);
                                    } else {
                                        ul.hide();
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