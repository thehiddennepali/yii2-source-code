/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  "use strict";

  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  /* jQueryKnob */
  $(".knob").knob();

  //The Calender
  $("#calendar").datepicker();

});
