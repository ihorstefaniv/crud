$('#all-items').on('click', function() {
    var check = this;
    $(this).parents('table').find('tbody :checkbox').each(function(){
        if ($(check).is(':checked')) {
            $(this).prop('checked', true);
            $(this).parents('tr').addClass('selected');
        } else {
            $(this).prop('checked', false);
            $(this).parents('tr').removeClass('selected');
        }
    });
});




$('#user-modal-save').on('click', function (){
    let form = $('#user-form');
    let action = form.attr('data-action');
    let $data = {};
    // сериализация формы
    form.find ('input, select').each(function() {
        $data[this.name] = $(this).val();
    });
    if($('#status').prop("checked") == true){
        $data.status = 1;
    }else{
        $data.status = 2;
    }
    errorAreaClear();
    // Если data-action = add создаем нового пользователя
    if(action === 'add') createUser($data);
    // Если data-action = edit обновляем пользователя
    if(action === 'edit') editUser($data);

});

// Присваиваем форме data-action=add и подымаем модальное окно
$('.add-user').on('click', function (){
    $('#user-form').attr('data-action', 'add');
    clearModal();
    $('#user-form-modal').modal('show');
});






function editUser($data){
    $.ajax({
        url: '/update-user',
        type: 'post',
        data: $data,
        success: function(result) {
            if(result.status) {
                showSuccessMessage(result.message, '');
                updateToTable(result.user);
                $('#user-form-modal').modal('hide');
            }else{
                showErrors(result.error, 'modal');
            }
        },
        error: function (result){
            showErrors('Server error', 'modal');
        }
    });
}



function createUser($data){
    $.ajax({
        url: '/create-user',
        type: 'post',
        data: $data,
        success: function(result) {
            console.log(result);
            if(result.status) {
                showSuccessMessage(result.message, '');
                addToTable(result.user);
                $('#user-form-modal').modal('hide');
            }else{
                showErrors(result.error, 'modal');
            }
        },
        error: function (result){
            showErrors('Server error', 'modal');
        }
    });
}

function deleteUser(userId){
    $.ajax({
        url: '/delete-user',
        type: 'post',
        data: {
            id:userId
        },
        success: function(result) {
            if(result.status) {
                showSuccessMessage(result.message, '');
                deleteFromTable(userId);
            }else{
                showErrors(result.error, '');
            }
        },
        error: function (result){
            showErrors('Server error', '');
        }
    });
}


function setActiveUser(userId){
    $.ajax({
        url: '/setactive-user',
        type: 'post',
        data: {
            id:userId
        },
        success: function(result) {

            if(result.status) {
                showSuccessMessage(result.message, '');
                updateToTable(result.user[0]);
            }else{
                showErrors(result.error, '');
            }
        },
        error: function (result){
            showErrors('Server error', '');
        }
    });
}
function setUnactiveUser(userId){
    $.ajax({
        url: '/setunactive-user',
        type: 'post',
        data: {
            id:userId
        },
        success: function(result) {
            if(result.status) {
                showSuccessMessage(result.message, '');
                updateToTable(result.user[0]);
            }else{
                showErrors(result.error, '');
            }
        },
        error: function (result){
            showErrors('Server error', '');
        }
    });
}












function getUser(userId){
    $.ajax({
        url: '/get-user',
        data:{
            id:userId
        },
        success: function(result) {

            if(result.status) {
                editModal(result.user);
            }else{
                showErrors(result.error, '');
            }
        },
        error: function (result){
            showErrors('Server error', '');
        }
    });
}






function editModal(data){
    clearModal();
    $('#user-form').attr('data-action', 'edit');
    $('#modal-user-id').val(data[0].id);
    $('#first-name').val(data[0].first_name);
    $('#last-name').val(data[0].last_name);
    $('#role option[value=' + data[0].role + ']').prop('selected', true);
    if(data[0].status == 1){
        $('#status').prop('checked', true);
    }
    $('#user-form-modal').modal('show');
}

function errorAreaClear(){
    $('#error-message').html('');
    $('#error-message-modal').html('');
}

function clearModal(){
    $('#user-form')[0].reset();
    $('#error-message-modal').html('');
}


function showErrors(errorsArray, target){
    let out = '';
    if($.isArray(errorsArray)) {
        $.each(errorsArray, function( index, value ) {
            out += '<div class="alert alert-danger" role="alert">' + value.message + '</div>';
        });
    }else{
        out += '<div class="alert alert-danger" role="alert">' + errorsArray.message + '</div>';
    }

    if(target === 'modal'){
        $('#error-message-modal').append(out);
    }else{
        $('#error-message').append(out);
    }

}

function showSuccessMessage(message, target){

    let out = '';
    out += '<div class="alert alert-success" role="alert">'+message+'</div>';
    if(target === 'modal'){
        $('#error-message-modal').html(out);
    }else{
        $('#error-message').html(out);
    }
}


function addToTable(user){
        let out = '<tr id="user-item-' + user.id + '">\n' +
        '    <td class="align-middle">\n' +
        '        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">\n' +
        '            <input type="checkbox" class="custom-control-input check-item" data-user="' + user.id + '" id="item-' + user.id + '">\n' +
        '                <label class="custom-control-label" for="item-' + user.id + '"></label>\n' +
        '        </div>\n' +
        '    </td>\n' +
        '    <td class="text-nowrap align-middle">' + user.first_name + ' ' + user.last_name + '</td>\n';
        if(user.role == 1){
            out += '    <td class="text-nowrap align-middle"><span>Admin</span></td>\n';
        }else{
            out += '    <td class="text-nowrap align-middle"><span>User</span></td>\n';
        }
        if(user.status == 1){
            out += '<td class="text-center align-middle"><i class="fa fa-circle active-circle"></i></td>\n';
        }else{
            out += '<td class="text-center align-middle"><i class="fa fa-circle not-active-circle"></i></td>\n';
        }
        out += '<td class="text-center align-middle">\n' +
        '        <div class="btn-group align-top">\n' +
        '            <button class="btn btn-sm btn-outline-secondary badge user-edit" data-user="' + user.id + '" type="button">Edit</button>\n' +
        '            <button class="btn btn-sm btn-outline-secondary badge user-delete" data-user="' + user.id + '" type="button"><i class="fa fa-trash"></i>\n' +
        '            </button>\n' +
        '        </div>\n' +
        '    </td>\n' +
        '</tr>';

    $('#user-table-body').append(out);
}






function updateToTable(user){
    let userId = user.id;
    let tableRow = $('#user-item-' + userId);
    let out = '    <td class="align-middle">\n' +
        '        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">\n' +
        '            <input type="checkbox" class="custom-control-input check-item" data-user="' + user.id + '" id="item-' + user.id + '">\n' +
        '                <label class="custom-control-label" for="item-' + user.id + '"></label>\n' +
        '        </div>\n' +
        '    </td>\n' +
        '    <td class="text-nowrap align-middle">' + user.first_name + ' ' + user.last_name + '</td>\n';
    if(user.role == 1){
        out += '    <td class="text-nowrap align-middle"><span>Admin</span></td>\n';
    }else{
        out += '    <td class="text-nowrap align-middle"><span>User</span></td>\n';
    }
    if(user.status == 1){
        out += '<td class="text-center align-middle"><i class="fa fa-circle active-circle"></i></td>\n';
    }else{
        out += '<td class="text-center align-middle"><i class="fa fa-circle not-active-circle"></i></td>\n';
    }
    out += '<td class="text-center align-middle">\n' +
        '        <div class="btn-group align-top">\n' +
        '            <button class="btn btn-sm btn-outline-secondary badge user-edit" data-user="' + user.id + '" type="button">Edit</button>\n' +
        '            <button class="btn btn-sm btn-outline-secondary badge user-delete" data-user="' + user.id + '" type="button"><i class="fa fa-trash"></i>\n' +
        '            </button>\n' +
        '        </div>\n' +
        '    </td>';

    tableRow.html(out);
}



function deleteFromTable(userId){
    $('#user-item-'+userId).remove();
}

$("#user-table-body").on("click", ".user-delete", function () {
    let userId = $(this).attr('data-user');
    deleteUser(userId);
});

$("#user-table-body").on("click", ".user-edit", function () {
    let userId = $(this).attr('data-user');
    getUser(userId);
});

$('.group-action-send').on('click', function (){
    errorAreaClear();
   let action =  $(this).parent().parent().find('.group-action').val();
   let isChecked =   $('#user-table-body input:checkbox:checked');

    if(isChecked.length <= 0){
        showSuccessMessage('Please select user\n');
    }else{
        isChecked.each(function(){
            let userId = $(this).attr('data-user');
            if(action === 'delete') deleteUser(userId);
            if(action === 'active') setActiveUser(userId);
            if(action === 'unactive') setUnactiveUser(userId);
            if(action === 'none') showSuccessMessage('Action not selected\n');
        });
    }


});

$("#user-table-body").on("click", ".check-item", function () {
    let notChecked =   $('#user-table-body input:checkbox:not(:checked)');
    if(notChecked.length <= 0){
        $('#all-items').prop('checked', true);
    }else{
        $('#all-items').prop('checked', false);
    }
});
