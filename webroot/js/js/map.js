/**
 * Created by rom on 3/15/17.
 */

var map;
var featureLayer;
var L;
var locals;

function createMap(){
    L.mapbox.accessToken = 'pk.eyJ1Ijoiam9zZW1vcmVpcmEiLCJhIjoiUmRYelFJQSJ9.-Cm5qED-S78cnOPy5g4IOQ';
    map = L.mapbox.map('map', 'josemoreira.o2hel2eo')
        .setView([40.50, -8.68], 12);

}


function getStyle(feature) {
    return {
        fillColor: getColor(feature.properties.id),
        weight: 3,
        opacity: 1,
        color: 'white',
        dashArray: '2',
        fillOpacity: 0.65
    };
}

function onEachFeature(data,layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: displayProperties
    });
}

function displayProperties(e) {

    var c = e.latlng;
    var layer = e.target;

    var htmlContent;

    switch(selected)
    {
        case 'view1':
            htmlContent = displayParque(layer);
            break;
        case 'view2':
            htmlContent = displayPopulacao(layer);
            break;
        case 'view3':
            htmlContent = displayNecessidades(layer);
            break;
    }


    var popup = L.popup()
        .setLatLng(c)
        .setContent(htmlContent)
        .openOn(map);
}

function get_territory(id) {

    for (var o in locals)
    {
        if (locals[o].id === id)
            return locals[o];
    }

}

function getColor(d) {
    //definir cor pela ordem ou pelo máximo
    var territory = get_territory(d);
    var cor;

    if((selected == "view1")) {

        cor = (territory.predicted_tax_anual_mean_lodges * 1000)/10 ;

    }
    else if(selected == "view2") {
        if(  (Math.round((territory.predicted_population_variance) * 1000) / 10)  >= 0)
            cor = -0.75;
        else
            cor = 0.75;
    }
    else if(selected == "view3") {
        if(Math.round(territory.predicted_required_lodges) >= 0)
            cor = -0.75;
        else
            cor = 0.75;
    }
    else {


        cor = 0.5;
    }
    return color(cor);
}

function displayParque(layer) {

    var territory = get_territory(layer.feature.properties.id);

    console.log(layer.feature.properties);

    var htmlContent = '<p><b>' + territory.name +'</b></p>';
    //taxa = (formula3(idx) - myLocalData[idx].alojamentos2011) / myLocalData[idx].alojamentos2011;
    htmlContent += '<p><font size="2">Variação no período 2011-2040: ' + Math.round(territory.predict_tax_period_variance_lodges * 1000)/10 + '%<br>';
    //taxa = Math.pow((formula3(idx) / myLocalData[idx].alojamentos2011), 1.0/29) - 1;
    htmlContent += 'Variação média anual 2011-2040: '+ Math.round(territory.predicted_tax_anual_mean_lodges * 1000)/10 + '%</font></p>';

    htmlContent += '<p><font size="2">Alojamentos 1ª residência: ' + Math.round(territory.predicted_first_lodges) + '<br>';
    htmlContent += 'Alojamentos 2ª residência: ' + Math.round(territory.predicted_second_lodges) + '</font></p>';

    htmlContent += '<p><font size="2">Alojamentos vagos no mercado: ' + Math.round(territory.predicted_empty_avail_lodges) + '<br>';
    htmlContent += 'Alojamentos vagos para reabilitar: ' + Math.round(territory.predicted_empty_rehab_lodges)  + '<br>';
    htmlContent += 'Alojamentos vagos total: ' + Math.round(territory.predicted_total_empty_lodges) + '</font></p>';

    return htmlContent;

}

function displayPopulacao(layer)
{

    var territory = get_territory(layer.feature.properties.id);

    var htmlContent = '<p><b>' + territory.name +'</b></p>';
    htmlContent += '<p><font size="2">População (2040): ' + territory.total_population + '</font></p>';
    htmlContent += '<p><font size="2">Variação (2011 &ndash; 2040): ' + Math.round((territory.predicted_population_variance) * 1000) / 10 + '%</font></p>';

    return htmlContent;
}

function displayNecessidades(layer)
{
    var territory = get_territory(layer.feature.properties.id);

    var htmlContent = '<p><b>' + territory.name +'</b></p>';
    htmlContent += '<p><font size="2">Alojamentos ocupados necessários: ' + Math.round(territory.predicted_required_lodges) + '</font></p>';

//    htmlContent += '<p><font size="2">Necessidades (hab/aloj ocupado): ' + Math.round(result13()) + '</font></p>';

    return htmlContent;
}

function color(cor) {
    return  cor > 0.75  ? '#800026' :
        cor > 0.50  ? '#BD0026' :
            cor > 0.25  ? '#E31A1C' :
                cor > 0.0  ? '#FC4E2A' :
                    cor > -0.25  ? '#FD8D3C' :
                        cor > -0.50  ? '#FEB24C' :
                            cor > -0.75  ? '#FED976' :
                                '#FFEDA0';

}

function highlightFeature(e) {
    var layer = e.target;

    layer.setStyle({
        weight: 3,
        dashArray: '3',
        fillOpacity: 0.4
    });

    if (!L.Browser.ie && !L.Browser.opera) {
        layer.bringToFront();
    }
}

function resetHighlight(e) {
    featureLayer.resetStyle(e.target);
}

function getLegendHTML() {
    var grades = [-1, -0.75, -0.50, -0.25, 0.0, 0.25, 0.50, 0.75],
        labels = [],
        from, to;

    for (var i = 0; i < grades.length; i++) {
        from = grades[i];
        to = grades[i + 1];

        labels.push(
            '<li><span class="swatch" style="background:' + color(from + 0.01) + '"></span> ' +
            from + (from != 0.75 ? ' a ' + to : '+')) + '</li>';
    }
    return '<span><b>Balanço (%) <br> (2011 &ndash; 2040)</b></span><ul>' + labels.join('') + '</ul>';
}

function getLegendHTML_alternate() {

    var labels;
    labels = [],
        labels.push(
            '<li><span class="swatch" style="background:' + color(0.75) + '"></span> ' +
            'Negativa </li>');

    labels.push(
        '<li><span class="swatch" style="background:' + color(-0.75) + '"></span> ' +
        'Positiva </li>');

    return '<span><b>Tipo de variação<br>2011 &ndash; 2040</b></span><ul>' + labels.join('') + '</ul>';
}


function refreshLocalLayer(data) {

    if (map.hasLayer(featureLayer))
        map.removeLayer(featureLayer);

    //console.log("local_layer" + data)
    featureLayer = L.geoJson(data, {
        style: getStyle,
        onEachFeature: onEachFeature
    }).addTo(map);

}

function restyleLayer(layer)
{
    layer.eachLayer(function (layer) {
        layer.setStyle(getStyle(layer.feature));
        console.log(layer.feature.properties.id);
    });

}


