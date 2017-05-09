/**
 * Created by rom on 3/31/17.
 */
var selected = "view1";
var legend = getLegendHTML();
var legendAlternate = getLegendHTML_alternate();
var showLegend = false;

function activate(btn) {
    var selection = document.getElementById(btn);
    selection.style.backgroundColor = "activecaption";
    selection.style.color = "darkblue";
}

function deactivate(btn) {
    var selection = document.getElementById(btn);
    selection.style.backgroundColor = "#3887be";
    selection.style.border = "transparent";
    selection.style.color = "white";
}

function view1() {

    deactivate(selected);
    activate("view1");
    selected = "view1";

    if (map.hasLayer(featureLayer))
    {
        restyleLayer(featureLayer);
    }

    if (showLegend === false) {
        map.legendControl.removeLegend(legendAlternate);
        map.legendControl.addLegend(legend);
    }
    showLegend = true;

}

function view2() {

    deactivate(selected);
    activate("view2");
    selected = "view2";

    if (map.hasLayer(featureLayer))
    {
        restyleLayer(featureLayer);
    }


    if (showLegend === true) {
        map.legendControl.removeLegend(legend);
        map.legendControl.addLegend(legendAlternate);
    }
    showLegend = false;
}

function view3() {


    deactivate(selected);
    activate("view3");
    selected = "view3";

    if (map.hasLayer(featureLayer))
    {
        restyleLayer(featureLayer);
    }


    if (showLegend === true) {
        map.legendControl.removeLegend(legend);
        map.legendControl.addLegend(legendAlternate);
    }
    showLegend = false;
}
