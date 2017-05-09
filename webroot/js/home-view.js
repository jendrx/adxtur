/**
 * Created by rom on 5/9/17.
 */

var response;

function newcalc(domain_id,politic_id,scenario_id,levels,parent_id) {
    var taxes = get_table_data();

    console.log(taxes);
    get_territorial_results(domain_id,politic_id,scenario_id,taxes,levels,parent_id);
}

function fill_resume(globals) {
    $('#popResidente').val(Math.round(globals.predicted_total_population));
    $('#migrantes').val((globals.predicted_migrations));
    $('#alojExistentes').val(Math.round(globals.predicted_total_lodges));
    $('#alojPorOcupar').val(Math.round(globals.predicted_empty_lodges));
    $('#dimFamilias').val(Math.round(globals.predicted_habitants_per_lodge * 10)/10);
    $('#taxaReabilitacao').val(Math.round(globals.predicted_mean_tax_rehab*10000)/100);
    $('#taxaConstrucao').val(Math.round(globals.predicted_mean_tax_construction * 10000)/100);

}

// function has_children(territory) {
//     var territories = JSON.parse('<?php echo json_encode($territories);?>') ;
//     for( var i = 0; i < territories.length; i++ )
//     {
//         if(territories[i].territory.parent_id == territory.id)
//             return true;
//
//     }
//     return false;
// }

// function is_leaf(id) {
//     var territories = JSON.parse(('<?php echo json_encode($territories);?>'));
//     var domain_data = JSON.parse(('<?php echo json_encode($current_domain);?>'));
//     if (domain_data.types.length === 1)
//     {
//         return true;
//     }
//
//     for( var i = 0; i < territories.length; i++ )
//     {
//         if(territories[i].territory.id == id )
//         {
//             console.log(territories[i].territory.id);
//
//             if(territories[i].territory.code == 6 || !has_children(territories[i].territory))
//                 return true;
//         }
//     }
//     console.log('ahahah');
//     return false;
// }

// function refreshTable(id) {
//     var territories = JSON.parse(('<?php echo json_encode($territories);?>'));
//     var domain_data = JSON.parse(('<?php echo json_encode($current_domain);?>'));
//     var study_id = $('#sel_studies').val();
//     remove_table_rows('table_territorials');
//     get_politic_taxes(study_id,domain_data.types.length,id);
//     getTerritorialLayer(domain_data.id,domain_data.types.length,id);
//
//
// }

// function session_store_values(id) {
//     var json_to_string = (JSON.stringify(get_table_data()));
//     alert (json_to_string);
//     console.log(get_table_data());
//     sessionStorage.setItem('locals', json_to_string);
//
// }

// function go_to_next_level(id) {
//     session_store_values(id);
// }

function get_politic_taxes(study_id,levels,parent) {
    $.ajax(
        {
            type: 'get',
            url: '/Homes/getPoliticTaxes.json',
            data: {
                study:study_id,
                level:levels,
                parent: parent
            },
            success: function(data)
            {
                load_table_data(data.response);

            }
        }
    );
}

function getTerritorialLayer(domain_id,levels,parent) {
    $.ajax(
        {
            type: 'get',
            url: '/Maps/getTerritorialLayer.json',
            data: {
                domain: domain_id,
                level:levels,
                parent: parent

            },
            success: function (data) {
                refreshLocalLayer(data.response);

            }
        }
    );
}

function get_territorial_results(domain_id,politic_id,scenario_id,taxes,levels,parent_id) {

    console.log(taxes);
    $.ajax(
        {
            type: 'get',
            url: '/Calcs/getResults.json',
            data: {
                domain: domain_id,
                politic:politic_id,
                scenario:scenario_id,
                taxes: taxes,
                parent: parent_id,
                levels: levels
            },
            success: function(data)
            {

                locals=data.response.locals;
                getTerritorialLayer(domain_id,levels,1,parent_id);
                fill_resume(data.response.global_predict);

            }
        }
    );
}


function init(data) {

    console.log(data)
    if(data.studies.length === 0 || data.scenarios.length === 0)
     {
     alert('Insuficient data (Studies data or Scenarios Data)');

         window.location.replace("/homes/index");
     }
    var levels = data.types.length;
    var parent = null;
    var study_id = $("#sel_studies").val();
    var scenario_id = $('#sel_scenarios').val();

    get_politic_taxes(study_id,levels,parent);
}