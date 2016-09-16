$(document).ready(function () {
    // Plugin initialization
    $('.slider').slider({
    full_width: false,
    interval:4000,
    transition:800,
        height:500
  });
});
$(document).ready(function(){
      $('.carousel').carousel();
    });
$('.datepicker').pickadate({ selectMonths: true,  selectYears: 1000, format: 'yyyy-mm-dd' });
  $(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});
  });