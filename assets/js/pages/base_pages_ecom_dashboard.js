/*
 *  Document   : base_pages_ecom_dashboard.js
 *  Author     : TBDigital
 */
var BasePagesEcomDashboard=function(){var o=function(){var o=jQuery(".js-chartjs-overview")[0].getContext("2d"),e={scaleFontFamily:"Candara",scaleFontColor:"#999",scaleFontStyle:"600",tooltipTitleFontFamily:"Candara",tooltipCornerRadius:3,maintainAspectRatio:!1,responsive:!0},t={labels:["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"],datasets:[{label:"Sales",fillColor:"rgba(0,200,0,.3)",strokeColor:"rgba(0,200,0,1)",pointColor:"rgba(0,200,0,1)",pointStrokeColor:"#fff",pointHighlightFill:"#fff",pointHighlightStroke:"rgba(0,200,0,1)",data:[sale[0],sale[1],sale[2],sale[3],sale[4],sale[5],sale[6],sale[7],sale[8],sale[9],sale[10],sale[11]]},{label:"Expenses",fillColor:"rgba(255, 160, 122, .3)",strokeColor:"rgba(255, 160, 122, 1)",pointColor:"rgba(255, 160, 122, 1)",pointStrokeColor:"#fff",pointHighlightFill:"#fff",pointHighlightStroke:"rgba(255, 160, 122, 1)",data:[ep[0],ep[1],ep[2],ep[3],ep[4],ep[5],ep[6],ep[7],ep[8],ep[9],ep[10],ep[11]]}]};new Chart(o).Line(t,e)};return{init:function(){o()}}}();jQuery(function(){BasePagesEcomDashboard.init()});