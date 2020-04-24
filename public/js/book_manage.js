//<!-- Click Create Button -->
$(document).on('click','.book-create-modal', function() {
    $('#book_add_modal').modal('show');
});

//<!-- Click Edit Button -->
$(document).on('click', '.book-edit-modal', function() {
    $('#book_edit_id').val($(this).data('id'));
    $('#book_edit_tag_id').val($(this).data('tag_id')); //added by tony
    $('#book_edit_title').val($(this).data('title'));
    $('#book_edit_author').val($(this).data('author'));
    $('#book_edit_publisher').val($(this).data('publisher'));
    $('#book_edit_publicationYear').val($(this).data('publicationyear'));
    $('#book_edit_language').val($(this).data('language'));
    $('#book_edit_ISBN').val($(this).data('isbn'));
    $('#book_edit_description').val($(this).data('description'));
    $('#book_edit_pageNumber').val($(this).data('pagenumber'));
    $('#book_edit_type').val($(this).data('type'));
    $('#book_edit_status').val($(this).data('status'));

    $('#book_edit_modal').modal('show');
});

//<!-- Click Delete Button -->
$(document).on('click', '.book-delete-modal', function() {
    $('.id').text($(this).data('id'));
    $('.title').html($(this).data('title'));
    $('#book_delete_modal').modal('show');
});


$(document).ready(function(){
    //<!-- Submit Add Book Form -->
    $("#add_book_btn").on('click', function() {
        $('.add-input').removeClass("border border-danger");
        $('.error-box').removeClass("border border-danger rounded");
        $('.error-box').empty();
        var form = $('#add_book_form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '/b/add',
            enctype: 'multipart/form-data',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    location.reload();
                }
                else {
                    $('#add_book_error').addClass("border border-danger rounded");
                   
                    if (!($.isEmptyObject(data.error.tag_id))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.tag_id + "</h2>");
                        $('#tag_id').addClass("border border-danger");
                    }

                    if (!($.isEmptyObject(data.error.title))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.title + "</h2>");
                        $('#title').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.author))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.author + "</h2>");
                        $('#author').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.type))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.type + "</h2>");
                        $('#type').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.ISBN))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.ISBN + "</h2>");
                        $('#ISBN').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.publisher))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.publisher + "</h2>");
                        $('#publisher').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.publicationYear))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.publicationYear + "</h2>");
                        $('#publicationYear').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.language))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.language + "</h2>");
                        $('#language').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.pageNumber))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.pageNumber + "</h2>");
                        $('#pageNumber').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.description))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.description + "</h2>");
                        $('#description').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.image))) {
                        $('#add_book_error').append("<h2 class='pt-1'>" + data.error.image + "</h2>");
                        $('#image').addClass("border border-danger");
                    }
                }
            },
        });
    });

    //<!-- Submit Edit Book Form -->
    $("#edit_book_btn").on('click', function() {
        $('.edit-input').removeClass("border border-danger");
        $('.error-box').removeClass("border border-danger rounded");
        $('.error-box').empty();
        var form = $('#edit_book_form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '/b/edit/' + $('#book_edit_id').val(),
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    location.reload();
                }
                else {
                    $('#edit_book_error').addClass("border border-danger rounded");
                    if (!($.isEmptyObject(data.error.tag_id))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.tag_id + "</h2>");
                        $('#book_edit_tag_id').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.title))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.title + "</h2>");
                        $('#book_edit_title').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.author))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.author + "</h2>");
                        $('#book_edit_author').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.ISBN))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.ISBN + "</h2>");
                        $('#book_edit_ISBN').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.publisher))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.publisher + "</h2>");
                        $('#book_edit_publisher').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.publicationYear))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.publicationYear + "</h2>");
                        $('#book_edit_publicationYear').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.language))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.language + "</h2>");
                        $('#book_edit_language').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.pageNumber))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.pageNumber + "</h2>");
                        $('#book_edit_pageNumber').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.description))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.description + "</h2>");
                        $('#book_edit_description').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.image))) {
                        $('#edit_book_error').append("<h2 class='pt-1'>" + data.error.image + "</h2>");
                        $('#book_edit_image').addClass("border border-danger");
                    }
                }
            },
        });
    });

    //<!-- Submit Delete Form -->
    $("#delete_book_btn").on('click', function() {
        $.ajax({
            type: 'get',
            url: '/b/delete/' + $('.id').text(),
            data: {
                'id': $('.id').text(),
            },
            success: function() {
                location.reload();
            },
        });
    });
});
