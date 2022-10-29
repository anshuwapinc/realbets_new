$(document).ready(function () {
  var globHistory = 0;
  var pageName = '';
  $(document).on("click", "#paginateClick a, #submit_form_button", function (e) {
    e.preventDefault();
    var per_page = '';
    pageName = $('#ajaxUrl').val();
    var url = site_url + pageName;
    var formData = $("#formSubmit").serializeJSON();
    if($(this).attr('data-attr') != 'submit'){
        per_page = $(this).attr('data-ci-pagination-page');
        url = site_url + pageName+'/'+per_page;
    }   
    formData['per_page'] = per_page;
    if(pageName == 'gamepl'){
      formData['totalLiveTeenpatti'] = $('#totalLiveTeenpatti').text();
      formData['totalCasino'] =  $('#totalCasino').text();
    }
    postRequest(formData,url);
  });
  $(document).on("click", "#backbutton", function (e) {
    e.preventDefault();
    window.location.reload();
  });
  function postRequest(data,url){
    //$('body').addClass('report-loader');
    var xhr = $.ajax({
      type: "post",
      url: url,
      data: setFormData(data),
      cache: false,
      success: function success(output) {
        output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
        setTimeout(function () {
          $('body').removeClass('report-loader');
        }, 100);
        $('.appendAjaxTbl').html(output);
        if($('#datatable').length > 0){
          $('#datatable').DataTable();
          if(pageName == 'sportpl'){
            $("#data-pagination").append($(".dataTables_info"));
            $("#data-pagination").append($(".dataTables_paginate"));
          }
        }
        if(pageName == 'report/userpl'){
          $('#from-date').val($('.span-from').text());
          $('#to_date').val($('.span-to').text());
        }
        if(pageName == 'userList' || pageName == 'childList'){
          $('.toggle-password').hide();
        }
        if(pageName == 'gamepl'){
          $('#totalLiveTeenpatti').text($('#updatedTotalLT').val());
          $('#totalCasino').text($('#updatedTotalLC').val());
        }
      }
    });
  }
});