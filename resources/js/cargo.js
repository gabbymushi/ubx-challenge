function createBill(id, category) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/create-bill',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            charge_id: id,
            category: category
        },
        // dataType: 'JSON',
        success: function(data) {
            $("#sub_summary").html(data);
        }
    });
}