(function ($) {
    "use strict";
    var expiredTL = {};
    var document = $(document);
    var expired_dataTable;
    var chilCheckbox = '#expired-text-links-table tbody input[type="checkbox"]';

    function clearInstance(selector, eventType, handler){
        const element = $(selector);
        element.off(eventType);
        element.on(eventType, handler);
    }

    expiredTL.ajaxAction = (url, more_data) => {
        let ajax_data = {
            data: expired_dataTable.rows('.selected').data().toArray()
        }

        if(ajax_data['data'].length == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: 'Bạn chưa <strong>chọn Text Link</strong> nào để thực hiện!'        
            })
        }else{
            if(more_data){
                more_data.forEach(el => {
                    ajax_data[el['key']] = el['data']
                });
            }
            debugger
            $.ajax({
                url: url,
                type: 'POST',
                data: ajax_data,
                dataType: 'json',
                success: function (data) {                    
                    expired_dataTable.clear().rows.add(data['expired_data']).draw();
                    tl_dashboard.clear().rows.add(data['tl_dashboard']).draw();
                    expiredTL.initCheckbox();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Erorr: ' + textStatus + " " + errorThrown);
                }
            });
        }        
    }

    expiredTL.actions = () => {
        $('#renewal-text-links').on('click', function (event) {          
            event.preventDefault();  
            let renewal_url = 'ajax/expired-tl/renew-tl';
            let date_val = $('input[name="renewal-tl-date"]').val();            
            if(date_val === ""){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: 'Bạn chưa <strong>chọn ngày</strong> để gia hạn!'
                });
            }else{
                let data = [
                    {
                        key: 'rn_date',
                        data: date_val
                    }
                ]                
                expiredTL.ajaxAction(renewal_url, data);
            }
        });

        $('#delete-selected-tl').on('click', function(event){
            event.preventDefault();
            let delete_url = 'ajax/delete-selected-tl';
            expiredTL.ajaxAction(delete_url);
        });
    }

    expiredTL.dataTable = (tl_expired_data) => {
        expired_dataTable = $('#expired-text-links-table').DataTable({
            data: tl_expired_data,
            order: [2, 'asc'],
            columns: [
                { data: 'id' },
                { data: 'target_domain' },
                { data: 'impl_date' },
                { data: 'expired_date' },
                { data: 'anchor_text' },
                { data: 'amount' },
                { data: 'ctv_name'  },
                { data: 'status' },
                { data: 'rel_tag' },
                { data: 'website_name' },
                { data: 'actions' }
            ],
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    render: (data, type, row) => {
                        return '<input type="checkbox" value="' + data + '">';
                    }
                },
                {
                    target: 5,
                    type: 'currency',
                    render: (data, type, row) => {
                        return data.toLocaleString('it-IT', {
                            style: 'currency',
                            currency: 'VND'
                        })
                    }
                },
                {
                    target: 7,
                    render: (data, type, row) => {
                        return convert_status(data, 'tl')
                    }
                },
                {
                    target: 10,
                    render: (data, type, row) => {                
                        return two_actions(data)
                    }
                }
            ],
            drawCallback: function(){                
                $('#select-all-id').prop('checked', false);
                $(chilCheckbox).prop('checked', false).trigger('change');
                expiredTL.initCheckbox();
                if(typeof expired_dataTable !== "undefined"){                    
                    expired_dataTable.rows('.selected').remove();
                }            
            }
        });
    }

    expiredTL.initCheckbox = () => {
        clearInstance('#select-all-id', 'click', function () {
            const isSelected = this.checked;
            $(chilCheckbox).prop('checked', isSelected).trigger('change');
            if(expired_dataTable !== "undefined"){
                if(typeof expired_dataTable.rows().data().toArray().length == 0){
                    $('#select-all-id').prop('checked', false);
                }
            }

        });

        clearInstance(chilCheckbox, 'change', function () {            
            const isAllChecked = $(chilCheckbox).length == $(chilCheckbox).filter(':checked').length;
            $('#select-all-id').prop('checked', isAllChecked);
            const isSelected = this.checked;
            const row = $(this).closest('tr');
            row.toggleClass('selected', isSelected);
        });

        if(typeof expired_dataTable !== "undefined"){
            if(expired_dataTable.rows().data().toArray().length == 0){
                $('#select-all-id').prop('checked', false);
            }
        }

    }

    document.ready(function () {
        expiredTL.dataTable(expired_data);
        expiredTL.initCheckbox();
        expiredTL.actions();
    });
})(jQuery)