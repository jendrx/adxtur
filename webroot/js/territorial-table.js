/**
 * Created by rom on 3/20/17.
 */
function get_table_data() {
    var table_values = [];
    $("#table_territorials tbody").find("tr").each(function () {
        var $l_input = $(this).find(".label_input");
            table_values.push({
                id: $l_input.attr('value'),
                territory:  $l_input.text(),
                tax_rehab: $(this).find(".tax_rehab_input").val(),
                tax_construction: $(this).find(".tax_cons_input").val(),
                tax_demolition: null
            });
        }
    );
    return table_values;
}

function load_table_data(data, type_admin) {

    //choose table's header
    $('#table_territorials').append('<thead>' +
        '<th>' + type_admin + '</th>' + '<th>' + 'Construção' + '</th>' +
        '<th>' + 'Reabilitação' + '</th><th>' + 'Demolição'+'</th></thead><tbody></tbody>');


    // populate rows
    $.each(data, function (key,value) {
        var $cons_input  = $('<input>', {"class":"tax_cons_input","type":"number","min":0,"max":10, "step":0.5, "value":value['tax_construction']});
        var $rehab_input = $('<input>', {"class":"tax_rehab_input","type":"number","min":0,"max":10, "step":0.5, "value":value['tax_rehab']});
        var $demo_input = $('<input>', {"class":"tax_rehab_input","type":"number","min":0,"max":10, "step":0.5, "value":value['tax_anual_desertion'],'disabled':'true','style':'width:auto'});
        $("#table_territorials > tbody:last-child").append('<tr><td><label class = "label_input" value="' + value["id"] + '">' + value['territory'] + '</td>' +
            '<td>' + $cons_input.prop('outerHTML') + ' </td><td>' + $rehab_input.prop('outerHTML') + '</td><td>' + $demo_input.prop('outerHTML') + '</td></tr>')
    });
}

function removeTableRows(table_id) {
    $('#'+table_id).find('tr').each( function()
    {
        $(this).remove();
    })

}