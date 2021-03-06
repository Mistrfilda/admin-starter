import '../scss/app.scss';

import $ from 'jquery';
import 'bootstrap';

import naja from 'naja';
import './customLiveFormValidation';

import '../sbadmin/js/sb-admin-2';

//Datagrid
import 'ublaboo-datagrid'
import 'ublaboo-datagrid/assets/datagrid-instant-url-refresh';
import 'bootstrap-datepicker';
import 'bootstrap-select';


//Google maps
import markerCluster from '@google/markerclustererplus';

//Charts
import chart from 'chart.js';

//Custom js
import clock from "./clock";
import modalExtension from "./modalExtension";
import googleMap from './googleMapControl';
import chartRenderer from "./chartRenderer";

let googleMapControl = new googleMap(naja, markerCluster);
let chartRendererControl = new chartRenderer(naja, chart, $);

naja.registerExtension(modalExtension, $);
document.addEventListener('DOMContentLoaded', naja.initialize.bind(naja));

$(document).ready(function () {
    initCustomJs();
    clock();
    googleMapControl.load();
    chartRendererControl.bindGraphs();
});

naja.snippetHandler.addEventListener('afterUpdate', function () {
    initCustomJs();
});

function initCustomJs() {
    $('.bootstrap-selectpicker').selectpicker({
        'liveSearch': true,
        'style': 'btn-primary'
    });
}