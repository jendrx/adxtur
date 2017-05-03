/**
 * Created by rom on 3/20/17.
 */
function get_table_data() {
    var table_values = [];
    $("#table_territorials tbody").find("tr").each(function () {

            table_values.push({
                id: $(this).find(".label_input").attr('value'),
                tax_rehab: $(this).find("#tax_rehab_input").val(),
                tax_construction: $(this).find("#tax_construct_input").val(),
                tax_demolition: null
            });
        }
    );
    console.log(table_values);
    return table_values;
}

function load_table_data(data, type_admin) {

    var construct_input = '<input  id="tax_construct_input" class="tax_input text-right" type="number"  min="0" value="0" max="10" step="0.5" />'
    var rehab_input = '<input  id=tax_rehab_input class="tax_input text-right" type="number" min="0" value="0" max="10" step="0.5" />'


    //choose table's header
    $('#table_territorials').append('<thead>' +
        '<th>' + type_admin + '</th>' + '<th>' + 'Construção' + '</th>' +
        '<th>' + 'Reabilitação' + '</th></thead><tbody></tbody>');


    // populate rows
    $.each(data, function (key, value) {
        $("#table_territorials > tbody:last-child").append('<tr><td><label class = "label_input" value="' + value["id"] + '">' + value['name'] + '</td><td>' + construct_input + ' </td><td>' + rehab_input + '</td></tr>')
    });

}



function get_parishes(data,municipality) {
    var parishes = []
    $.each(data, function(key,value)
    {
        if(data[key].municipality === municipality && data[key].admin_type === 'parish' ) {
            parishes.push(data[key])
        }
    });
    return parishes;
}

function get_municipalities(data) {
    var parishes = []
    $.each(data, function(key,value)
    {
        if(data[key].admin_type === 'municipality' ) {
            parishes.push(data[key])
        }
    });
    return parishes;
}

function filter_table_data(data,admin_type,municipality) {

    if(municipality === null)
        return get_municipalities(data);
    return get_parishes(data,municipality);

}