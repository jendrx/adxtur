/**
 * Created by rom on 3/28/17.
 */
function fill_ddown(data,ddown_id) {
    $.each(data, function (key, value) {
        $(ddown_id).append(
            $('<option></option>').val(value['id']).html(value['name'])
        );
    });
}


