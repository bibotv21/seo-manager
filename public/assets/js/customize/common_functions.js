function convert_status(boolean_data, type) {
    let yes = 'Yes';
    if(type == 'gp'){
        yes = 'Indexed'
    }
    return boolean_data ? '<i class="fa fa-check c-green"></i> ' + yes : '<i class="fa fa-times c-red"></i> No';
}

function two_actions(data) {
    return '<a class="btn btn-info" href="' + data[0] +
        '"><i class="fa fa-paste"></i> Edit</a><a class="btn btn-info btn-danger delete-action" href="' +
        data[1] + '"><i class="fa fa-ban"></i> Delete</a>';
}

function copyLongStringBtn(data) {
    return '<button class="copy-url-btn"><input value ="' + data + '"hidden/><p>copy</p></button>';
}


function initCopyToCliboard(selector){    
    $(selector).off('click');
    $(selector).on('click', function(){
        var link = $(this).find('input');
        link.select();
        navigator.clipboard.writeText(link.val());
    });
}


function statistics_details(data) {    
    $('#number-of-alls').text(data['data'].length);
    $('#number-of-status-no').text(data['status_no']);
    $('#number-of-status-yes').text(data['status_yes']);
    $('#status-no-percent').text(' ' + data['status_no'] * 100 / data['data'].length + '% )');
}

function renderTwoActions(data){    
    return '<a class="btn btn-info" href="' + data['url_edit'] +
    '"><i class="fa fa-paste"></i>Edit</a><button class="btn btn-info btn-danger delete-action" data-url="' +
    data['url_delete'] + '" data-name="' + data['name'] + '"><i class="fa fa-ban"></i>Delete</button>';
}

function deleteAction(){
    $('.delete-action').off('click');
    $('.delete-action').on('click', function(){
        let el = this;    
        Swal.fire({
            title: 'Thông báo',
            html: 'Nếu bạn xóa <span class="c-red">' + $(el).data('name') + '</span>, tất cả back links liên quan sẽ bị xóa. Bạn có chắc chắn muốn xóa không?',
            showCancelButton: true,
            icon: 'warning',
            confirmButtonText: 'Xóa',
        }).then((result) => {        
            if(result.isConfirmed){
                window.location.href = $(el).data('url');         
            }
        });
    });
}

