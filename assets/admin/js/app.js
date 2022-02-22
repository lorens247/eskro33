'use strict';

$(function(){
  $('.custom-field').each(function(i, v){
    if(v.value !=''){
      $(this).addClass('hascontent');      
    }else{
      $(this).removeClass('hascontent');
    }
  });


  $('.custom-field').on('keydown', function(){
    var inputField = $(this).val();
    if(inputField !=''){
      $(this).addClass('hascontent');      
    }else{
      $(this).removeClass('hascontent');
    }
  });


  $('#sidebar__menuWrapper').slimScroll({
    height: 'calc(100vh - 86.75px)',
    railVisible: true,
		alwaysVisible: true
  });


  $('.dropdown-menu__body').slimScroll({
    height: '270px'
  });


  // modal-dialog-scrollable
  $('.modal-dialog-scrollable .modal-body').slimScroll({
    height: '100%'
  });


  // activity-list 
  $('.activity-list').slimScroll({
    height: '385px'
  });


  // recent ticket list 
  $('.recent-ticket-list__body').slimScroll({
    height: '295px'
  });


  let img = $('.bg_img');
  img.css('background-image', function () {
    let bg = ('url(' + $(this).data('background') + ')');
    return bg;
  });


  $('.nice-select').niceSelect();


  $('.res-sidebar-open-btn').on('click', function (){
    $('.sidebar').addClass('open');
  });


  $('.res-sidebar-close-btn').on('click', function (){
    $('.sidebar').removeClass('open');
  });

  $('.fullscreen-btn').on('click', function(){
    $(this).toggleClass('active');
  });

  $('.sidebar-dropdown > a').on('click', function () {
    if ($(this).parent().find('.sidebar-submenu').length) {
      if ($(this).parent().find('.sidebar-submenu').first().is(':visible')) {
        $(this).find('.side-menu__sub-icon').removeClass('transform rotate-180');
        $(this).removeClass('side-menu--open');
        $(this).parent().find('.sidebar-submenu').first().slideUp({
          done: function done() {
            $(this).removeClass('sidebar-submenu__open');
          }
        });
      } else {
        $(this).find('.side-menu__sub-icon').addClass('transform rotate-180');
        $(this).addClass('side-menu--open');
        $(this).parent().find('.sidebar-submenu').first().slideDown({
          done: function done() {
            $(this).addClass('sidebar-submenu__open');
          }
        });
      }
    }
  });

  // select-2 init
  $('.select2-basic').select2();
  $('.select2-multi-select').select2();
  $(".select2-auto-tokenize").select2({
    tags: true,
    tokenSeparators: [',']
  });

  function proPicURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              var preview = $(input).parents('.thumb').find('.profilePicPreview');
              $(preview).css('background-image', 'url(' + e.target.result + ')');
              $(preview).addClass('has-image');
              $(preview).hide();
              $(preview).fadeIn(650);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }


  $(".profilePicUpload").on('change', function () {
      proPicURL(this);
  });

  $(".remove-image").on('click', function () {
      $(this).parents(".profilePicPreview").css('background-image', 'none');
      $(this).parents(".profilePicPreview").removeClass('has-image');
      $(this).parents(".thumb").find('input[type=file]').val('');
  });

  $("form").on("change", ".file-upload-field", function(){ 
    $(this).parent(".file-upload-wrapper").attr("data-text",$(this).val().replace(/.*(\/|\\)/, '') );
  });


  //Custom Data Table
  $('.custom-data-table').closest('.card').prepend('<div class="card-header" style="border-bottom: none;"><div class="text-right"><div class="form-inline float-sm-right bg--white"><input type="text" name="search_table" class="form-control" placeholder="Search"></div></div></div>');
  $('.custom-data-table').closest('.card').find('.card-body').attr('style','padding-top:0px');
  var tr_elements = $('.custom-data-table tbody tr');
  $(document).on('input','input[name=search_table]',function(){
    var search = $(this).val().toUpperCase();
    var match = tr_elements.filter(function (idx, elem) {
      return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
    }).sort();
    var table_content = $('.custom-data-table tbody');
    if (match.length == 0) {
      table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
    }else{
      table_content.html(match);
    }
  });


  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    $.each($('input, select, textarea'), function (i, element) {
      if (element.hasAttribute('required')) {
        $(element).closest('.form-group').find('label').addClass('required');
      }
    });


  $('#verification-code').on('input', function () {
    $(this).val(function(i, val){
        if (val.length >= 6) {
            $('.submit-form').find('button[type=submit]').html('<i class="las la-spinner fa-spin"></i>');
            $('.submit-form').submit()
        }
        if(val.length > 6){
            return val.substring(0, val.length - 1);
        }
        return val;
    });

    for (let index = $(this).val().length; index >= 0 ; index--) {
        $($('.boxes span')[index]).html('');
    }
  });


});

//nic editor
jQuery(document).ready(function ($) {
  let editors = $(".nicEdit-main");
  let parent = editors.parent();
  editors.addClass("w-100").css("min-height", "200px");
  parent.addClass("w-100");
  parent.siblings("div").addClass("w-100");
});


/* Get the documentElement (<html>) to display the page in fullscreen */
let elem = document.documentElement;

/* View in fullscreen */
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

/* Close fullscreen */
function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) { /* Firefox */
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE/Edge */
    document.msExitFullscreen();
  }
}