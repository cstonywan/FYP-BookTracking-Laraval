// <!-- Click Create Button -->
$(document).on('click','.user-create-modal', function() {
    $('#user_add_modal').modal('show');
});

// <!-- Click Edit Button -->
$(document).on('click', '.user-edit-modal', function() {
    // $('.form-horizontal').show();
    $('#user_edit_id').val($(this).data('id'));
    $('#user_edit_name').val($(this).data('name'));
    $('#user_edit_email').val($(this).data('email'));
    $('#user_edit_role').val($(this).data('role'));
    $('#user_edit_modal').modal('show');
});

// <!-- Click Delete Button -->
$(document).on('click', '.user-delete-modal', function() {
    $('.id').text($(this).data('id'));
    $('.name').html($(this).data('name'));
    $('#user_delete_modal').modal('show');
});



$(document).ready(function(){
    // <!-- Submit Add User Form -->
    $("#add_user_btn").on('click', function() {
        $('.add-input').removeClass("border border-danger");
        $('.error-box').removeClass("border border-danger rounded");
        $('.error-box').empty();
        var form = $('#add_user_form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '/user/add',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formData,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    location.reload();
                }
                else {
                    $('#add_user_error').addClass("border border-danger rounded");
                    if (!($.isEmptyObject(data.error.name))) {
                        $('#add_user_error').append("<h2 class='pt-1'>" + data.error.name + "</h2>");
                        $('#name').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.email))) {
                        $('#add_user_error').append("<h2 class='pt-1'>" + data.error.email + "</h2>");
                        $('#email').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.password))) {
                        $('#add_user_error').append("<h2 class='pt-1'>" + data.error.password + "</h2>");
                        $('#password').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.password_confirm))) {
                        $('#add_user_error').append("<h2 class='pt-1'>" + data.error.password_confirm + "</h2>");
                        $('#password-confirm').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.photo))) {
                        $('#add_user_error').append("<h2 class='pt-1'>" + data.error.photo + "</h2>");
                        $('#photo').addClass("border border-danger");
                    }
                }
            },
        });
    });

    // <!-- Submit Edit User Form -->
    $("#edit_user_btn").on('click', function() {
        $('.edit-input').removeClass("border border-danger");
        $('.error-box').removeClass("border border-danger rounded");
        $('.error-box').empty();
        var form = $('#edit_user_form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '/user/edit/' + $('#user_edit_id').val(),
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formData,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    location.reload();
                }
                else {
                    $('#edit_user_error').addClass("border border-danger rounded");
                    if (!($.isEmptyObject(data.error.name))) {
                        $('#edit_user_error').append("<h2 class='pt-1'>" + data.error.name + "</h2>");
                        $('#user_edit_name').addClass("border border-danger");
                    }
                    if (!($.isEmptyObject(data.error.email))) {
                        $('#edit_user_error').append("<h2 class='pt-1'>" + data.error.email + "</h2>");
                        $('#user_edit_email').addClass("border border-danger");
                    }
                }
            },
        });
    });

    // <!-- Submit Delete User Form -->
    $("#delete_user_btn").on('click', function() {
        $.ajax({
            type: 'get',
            url: '/user/delete/' + $('.id').text(),
            data: {
                'id': $('.id').text(),
            },
            success: function() {
                location.reload();
            },
        });
    });
});
