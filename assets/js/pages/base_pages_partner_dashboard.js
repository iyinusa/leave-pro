/*
 *  Document   : base_pages_partner_dashboard.js
 *  Author     : TBDigital
 */
var BasePagesEcomDashboard=function(){var o=function(){var o=jQuery(".js-chartjs-overview")[0].getContext("2d"),e={scaleFontFamily:"Candara",scaleFontColor:"#999",scaleFontStyle:"600",tooltipTitleFontFamily:"Candara",tooltipCornerRadius:3,maintainAspectRatio:!1,responsive:!0},t={labels:["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"],datasets:[{label:"Earnings",fillColor:"rgba(0,200,0,.3)",strokeColor:"rgba(0,200,0,1)",pointColor:"rgba(0,200,0,1)",pointStrokeColor:"#fff",pointHighlightFill:"#fff",pointHighlightStroke:"rgba(0,200,0,1)",data:[earn[0],earn[1],earn[2],earn[3],earn[4],earn[5],earn[6],earn[7],earn[8],earn[9],earn[10],earn[11]]},{label:"Payout",fillColor:"rgba(255, 160, 122, .3)",strokeColor:"rgba(255, 160, 122, 1)",pointColor:"rgba(255, 160, 122, 1)",pointStrokeColor:"#fff",pointHighlightFill:"#fff",pointHighlightStroke:"rgba(255, 160, 122, 1)",data:[pay[0],pay[1],pay[2],pay[3],pay[4],pay[5],pay[6],pay[7],pay[8],pay[9],pay[10],pay[11]]}]};new Chart(o).Line(t,e)};return{init:function(){o()}}}();jQuery(function(){BasePagesEcomDashboard.init()});