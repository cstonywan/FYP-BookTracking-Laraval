function change_date_format(date) {
    var day = ('0' + date.getDate()).slice(-2);
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var year = date.getFullYear();
    var yyyymmdd = year + "-" + month + "-" + day;
    return yyyymmdd;
}

function change_deadline() {
    var newDate = new Date($('#borrow_at').val());
    newDate.setDate(newDate.getDate() + 14);
    var new_deadline_date = change_date_format(newDate);
    document.getElementById("deadline_at").value = new_deadline_date;
}

function autocomplete_edit_user(users) {
    var user_id = $('#borrow_edit_user_id').val();
    $('#borrow_edit_user_name').val('User Not Found');
    for (var i=0; i<users.length; i++) {
        if (users[i]['id'] == user_id) {
            $('#borrow_edit_user_name').val(users[i]['name']);
        }
    }
}

function autocomplete_edit_book(books) {
    var book_id = $('#borrow_edit_book_id').val();
    $('#borrow_edit_book_title').val('Book Not Found');
    for (var i=0; i<books.length; i++) {
        if (books[i]['id'] == book_id) {
            if (books[i]['status'] == "inLibrary")
                $('#borrow_edit_book_title').val(books[i]['title']);
            else
                $('#borrow_edit_book_title').val("The book is " + books[i]['status']);
        }
    }
}

function autocomplete_create_user(users) {
    var user_id = $('#borrow_create_user_id').val();
    $('#borrow_create_user_name').val('User Not Found');
    for (var i=0; i<users.length; i++) {
        if (users[i]['id'] == user_id) {
            $('#borrow_create_user_name').val(users[i]['name']);
        }
    }
}

function autocomplete_create_book(books) {
    var book_id = $('#borrow_create_book_id').val();
    $('#borrow_create_book_title').val('Book Not Found');
    for (var i=0; i<books.length; i++) {
        if (books[i]['id'] == book_id) {
            if (books[i]['status'] == "inLibrary")
                $('#borrow_create_book_title').val(books[i]['title']);
            else
                $('#borrow_create_book_title').val("The book is " + books[i]['status']);
        }
    }
}

<!-- Click Return Button -->
$(document).on('click', '.return-btn-modal', function() {
    var currentDate = new Date();
    currentDate = change_date_format(currentDate);

    $('#return_borrow_id').html($(this).data('id'));
    $('#return_book_id').html($(this).data('bookid'));
    $('#return_book_title').html($(this).data('booktitle'));
    $('#return_user_id').html($(this).data('userid'));
    $('#return_user_name').html($(this).data('username'));
    $('#return_borrow_at').html($(this).data('borrowat'));
    $('#return_deadline_at').html($(this).data('deadlineat'));
    $('#return_return_at').html(currentDate);
    $('#return_renewal_num').html($(this).data('renewalnum'));

    $('#return_book_modal').modal('show');
});

<!-- Click Renew Button -->
$(document).on('click', '.renew-btn-modal', function() {
    var original_date = new Date($(this).data('deadlineat'));
    original_date.setDate(original_date.getDate() + 14);
    var new_deadline_date = change_date_format(original_date);

    $('#renew_record_id').html($(this).data('id'));
    $('#renew_book_title').html($(this).data('booktitle'));
    $('#renew_user_name').html($(this).data('username'));
    $('#renew_renewal_num').html($(this).data('renewalnum'));
    $('#renew_borrow_at').html($(this).data('borrowat'));
    $('#renew_o_deadline_at').html($(this).data('deadlineat'));
    $('#renew_n_deadline_at').html(new_deadline_date);

    $('#renew_book_modal').modal('show');
});

<!-- Click Create Button -->
$(document).on('click', '.record-create-modal', function() {
    $('#record-create-modal').modal('show');
});

<!-- Click Edit Button -->
$(document).on('click', '.record-edit-modal', function() {

    $('#borrow_edit_id').val($(this).data('id'));
    $('#borrow_edit_book_id').val($(this).data('bookid'));
    $('#borrow_edit_book_title').val($(this).data('booktitle'));
    $('#borrow_edit_user_id').val($(this).data('userid'));
    $('#borrow_edit_user_name').val($(this).data('username'));
    $('#borrow_edit_staff_id').val($(this).data('staffid'));
    $('#borrow_edit_borrow_at').val($(this).data('borrowat'));
    $('#borrow_edit_deadline_at').val($(this).data('deadlineat'));
    $('#borrow_edit_return_at').val($(this).data('returnat'));
    $('#borrow_edit_renewal_num').val($(this).data('renewalnum'));

    $('#record-edit-modal').modal('show');
});

<!-- Click Delete Button -->
$(document).on('click', '.record-delete-modal', function() {
    var currentDate = new Date();
    currentDate = change_date_format(currentDate);

    $('#del_record_borrow_id').html($(this).data('id'));
    $('#del_record_book_id').html($(this).data('bookid'));
    $('#del_record_book_title').html($(this).data('booktitle'));
    $('#del_record_user_id').html($(this).data('userid'));
    $('#del_record_user_name').html($(this).data('username'));
    $('#del_record_borrow_at').html($(this).data('borrowat'));
    $('#del_record_deadline_at').html($(this).data('deadlineat'));
    $('#del_record_return_at').html(currentDate);
    $('#del_record_renewal_num').html($(this).data('renewalnum'));

    $('#record-delete-modal').modal('show');
});

$(document).ready(function(){
    $('#manage_borrow').ready(function() {
        var currentDate = new Date();
        var borrow_date = change_date_format(currentDate);
        currentDate.setDate(currentDate.getDate() + 14);
        var deadline_date = change_date_format(currentDate);
        $('#borrow_at').val(borrow_date);
        $('#deadline_at').val(deadline_date);
    });

    if ($('#add_specific_book').html()) {
        var book_id = $('#add_specific_book').html();
        $('#borrow_create_book_id').val(book_id);
        autocomplete_create_book(json_books);
        $('#record-create-modal').modal('show');
    }

    <!-- Submit Return Form -->
    $("#return_submit_btn").on('click', function() {
        $.ajax({
            type: 'GET',
            url: '/borrow/return/' + $('#return_borrow_id').html(),
            enctype: 'multipart/form-data',
            data: {
                'id': $('#return_borrow_id').html(),
                'return_at': $('#return_return_at').html(),
            },
            success: function() {
                window.location.href = "manage";
            },
        });
    });

    <!-- Submit Renew Form -->
    $("#renew_submit_btn").on('click', function() {
        $.ajax({
            type: 'GET',
            url: '/borrow/renew/' + $('#renew_record_id').html(),
            enctype: 'multipart/form-data',
            data: {
                'id': $('#renew_record_id').html(),
                'deadline_at': $('#renew_n_deadline_at').html(),
            },
            success: function() {
                window.location.href = "manage";
            },
        });
    });

    <!-- Submit Create Form -->
    $("#create_record_btn").on('click', function() {
        $('.create-input').removeClass("border border-danger");
        $('.error-box').removeClass("border border-danger rounded");
        $('.error-box').empty();
        $.ajax({
            type: 'POST',
            url: '/borrow/store',
            enctype: 'multipart/form-data',
            data: {
                '_token': $('input[name=_token]').val(),
                'book_id': $('#borrow_create_book_id').val(),
                'user_id': $('#borrow_create_user_id').val(),
                'borrow_at': $('#borrow_at').val(),
                'deadline_at': $('#deadline_at').val(),
            },
            success: function(data) {
                // location.reload();
                if ($.isEmptyObject(data.error)) {
                    window.location.href = "manage";
                }
                else {
                    $('#create_borrow_error').addClass("border border-danger rounded");
                    if (!($.isEmptyObject(data.error.book_id))) {
                        $('#create_borrow_error').append("<h2 class='pt-1'>" + data.error.book_id + "</h2>");
                        $('#borrow_create_book_id').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.user_id))) {
                        $('#create_borrow_error').append("<h2 class='pt-1'>" + data.error.user_id + "</h2>");
                        $('#borrow_create_user_id').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.borrow_at))) {
                        $('#create_borrow_error').append("<h2 class='pt-1'>" + data.error.borrow_at + "</h2>");
                        $('#borrow_at').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.deadline_at))) {
                        $('#create_borrow_error').append("<h2 class='pt-1'>" + data.error.deadline_at + "</h2>");
                        $('#deadline_at').addClass("border border-danger");
                    }
                }
            },
        });
    });

    //<!-- Submit Edit Form -->
    $("#edit_record_btn").on('click', function() {
        $('.edit-input').removeClass("border border-danger");
        $('.error-box').removeClass("border border-danger rounded");
        $('.error-box').empty();
        $.ajax({
            type: 'POST',
            url: '/borrow/edit/' + $('#borrow_edit_id').val(),
            enctype: 'multipart/form-data',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#borrow_edit_id').val(),
                'book_id': $('#borrow_edit_book_id').val(),
                'user_id': $('#borrow_edit_user_id').val(),
                'staff_id': $('#borrow_edit_staff_id').val(),
                'borrow_at': $('#borrow_edit_borrow_at').val(),
                'deadline_at': $('#borrow_edit_deadline_at').val(),
                'return_at': $('#borrow_edit_return_at').val(),
                'renewal_num': $('#borrow_edit_renewal_num').val(),
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    window.location.href = "manage";
                }
                else {
                    $('#edit_borrow_error').addClass("border border-danger rounded");
                    if (!($.isEmptyObject(data.error.book_id))) {
                        $('#edit_borrow_error').append("<h2 class='pt-1'>" + data.error.book_id + "</h2>");
                        $('#borrow_edit_book_id').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.user_id))) {
                        $('#edit_borrow_error').append("<h2 class='pt-1'>" + data.error.user_id + "</h2>");
                        $('#borrow_edit_user_id').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.staff_id))) {
                        $('#edit_borrow_error').append("<h2 class='pt-1'>" + data.error.staff_id + "</h2>");
                        $('#borrow_edit_staff_id').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.renewal_num))) {
                        $('#edit_borrow_error').append("<h2 class='pt-1'>" + data.error.renewal_num + "</h2>");
                        $('#borrow_edit_renewal_num').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.borrow_at))) {
                        $('#edit_borrow_error').append("<h2 class='pt-1'>" + data.error.borrow_at + "</h2>");
                        $('#borrow_edit_borrow_at').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.deadline_at))) {
                        $('#edit_borrow_error').append("<h2 class='pt-1'>" + data.error.deadline_at + "</h2>");
                        $('#borrow_edit_deadline_at').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.return_at))) {
                        $('#edit_borrow_error').append("<h2 class='pt-1'>" + data.error.return_at + "</h2>");
                        $('#borrow_edit_return_at').addClass("border border-danger");
                    }
                }
            },
        });
    });

    <!-- Submit Delete Form -->
    $("#delete_record_btn").on('click', function() {
        $.ajax({
            type: 'GET',
            url: '/borrow/delete/' + $('#del_record_borrow_id').html(),
            enctype: 'multipart/form-data',
            success: function() {
                window.location.href = "manage";
            },
        });
    });
});
