/**
 * Created by rom on 5/9/17.
 */

var response;

function newcalc(domain_id,politic_id,scenario_id,taxes,levels,parent_id) {
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


//    function study_rules_markup(content)
//    {
//	    var html =
//		        '<table> ' +
//		        '   <thead>' +
//		        '     <th> Territory </th>'
//
//	    for(i = 0; i < content.rules.length; i++) {
//	        html += '<th>' + content.rules[i].description + '</th>';
//	    }
//
//	    //close header begin body tag
//	    html += '</thead><tbody>';
//
//	    for( key in content.studyRules )
//	    {
//	        if(content.studyRules.hasOwnProperty(key)) {
//
//	            var current = content.studyRules[key];
//
//	            html += '<tr><td>'+ key + '</td>';
//
//	            for(i = 0; i < current.length; i++)
//                    html += '<td><input type="number", step=0.1, value='+current[i].value +' > </input></td>';
//
//	            html += '</tr>';
//	        }
//	    }
//
//	    html += '</tbody></table>';
//	    return html;
//
//    }
//
//    function getStudyRules(study_id) {
//        $.ajax(
//            {
//                type: 'get',
//                url: '/homes/updateStudyRules',
//	            dataType: 'json',
//                data: {
//                    study: study_id
//                },
//                success: function (data) {
//	                $("#modal_body").prepend(study_rules_markup(data.content));
//	                $("#myModal").modal('show');
//
//                }
//            }
//        );
//
//    }

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
    //get_politic_taxes(study_id,levels,parent);

    $.when(get_politic_taxes(study_id,levels,parent)).done(function(){
        newcalc(data.id,study_id,scenario_id,get_table_data(),levels,null);
    });

}

function update_taxes(study_id,table_data) {
    $.ajax(
        {
            type: 'post',
            url: '/studies-rules-territories-domains/updateTaxes.json',
            data: {
                study: study_id,
                table_data: table_data
            },
            success: function (data) {
                alert(data.message);
            }
        }
    );

}