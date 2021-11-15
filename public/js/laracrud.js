jQuery(document).ready(function($){
    ////----- Open the modal to CREATE a order -----////
    jQuery('#btn-add').click(function () {
        jQuery('#btn-save').val("add");
        jQuery('#modalFormData').trigger("reset");
        jQuery('#orderEditorModal').modal('show');
    });

    ////----- Open the modal to UPDATE a order -----////
    jQuery('body').on('click', '.open-modal', function () {
        var order_id = $(this).val();
        $.get(order_id, function (data) {
            console.log(data.data);
            jQuery('#order_id').val(data.data.id);
            jQuery('#details').val(data.data.details);
            jQuery('#client').val(data.data.client);
            jQuery('#btn-save').val("update");
            jQuery('#orderEditorModal').modal('show');
        })
    });

    // Clicking the save button on the open modal for both CREATE and UPDATE
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            details: jQuery('#details').val(),
            client: jQuery('#client').val(),
        };
        var state = jQuery('#btn-save').val();
        var type = "POST";
        var order_id = jQuery('#order_id').val();
        var ajaxurl = 'add';
        if (state == "update") {
            type = "POST";
            ajaxurl = 'update/' + order_id;
        }
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                // var order = '' + data.data.id + '' + data.data.details + '' + data.data.client + '';
                var order = '<td>'+data.data.id+'</td><td>'+data.data.details+'</td><td>'+data.data.client+'</td><td><button class="btn btn-info open-modal" value="'+data.data.id+'">Edit</button><button class="btn btn-danger delete-order" value="'+data.data.id+'">Delete</button></td>';
                // order += 'Edit';
                // order += 'Delete';
                if (state == "add") {
                    jQuery('#orders-list').prepend(order);
                } else {
                    $("#order" + order_id).replaceWith(order);
                }
                jQuery('#modalFormData').trigger("reset");
                jQuery('#orderEditorModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    ////----- DELETE a order and remove from the page -----////
    jQuery('.delete-order').click(function () {
        console.log("hi");
        var order_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'delete/' + order_id,
            success: function (data) {
                console.log(data.data);
                $("#order" + order_id).remove();
            },
            error: function (data) {
                console.log('Error:', data.data);
            }
        });
    });
});