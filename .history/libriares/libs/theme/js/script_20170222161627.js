function xmlToString(xmlData) { 

    var xmlString;
    //IE
    if (window.ActiveXObject){
        xmlString = xmlData.xml;
    }
    // code for Mozilla, Firefox, Opera, etc.
    else{
        xmlString = (new XMLSerializer()).serializeToString(xmlData);
    }
    return xmlString;
}  
/**
jQuery(function($) {
    $(".progress").hide();
    $('#login').on('submit', function(event) {

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "xml",
            beforeSubmit: function() {
                $(".progress").show();
            },

            success: function(data, status) {
                //alert(status);
                $(".progress").show();
                $(".login-bar").html($(data).find('text'));
                //$(".login-bar").append(data).html();
            }
        });

        event.preventDefault();
    });
});
**/
$(document).ready(function(e){
    dcheck();
    $('#show-pass').click(function() {  
    
    
    $(this).toggleClass('btn-info');
    $(this).toggleClass('btn-warning');

    $("#u-pass .icon-pass").toggleClass('fa-eye');
    $("#u-pass .icon-pass").toggleClass('fa-eye-slash');


    //$("#u-pass input").prop('disabled', function (_, val) { return ! val; });

    if ($(this).hasClass( "btn-info" )) {
        $("#u-pass input").attr( "type", "text");
        $(this).html($(this).html().replace("Pokaż", "Ukryj"));
    } else {
        $("#u-pass input").attr( "type", "password");
        $(this).html($(this).html().replace("Ukryj", "Pokaż"));
    }
       
    });

$('#d-add-new .btn').click(function() {
    if($('#d-add-new input').val()!="Wybierz" && $('#d-add-new input').val()!="") {
        var idata = $('#d-add-new datalist [value="' +$('#d-add-new input').val()+ '"]');
        var ndata = (idata.data('type')!==null)?idata.data('type'):encodeURIComponent($('#d-add-new input').val());
        var vdata = (idata.val()!==undefined)?idata.val():$('#d-add-new input').val();
    $(".d-contact").find('#d-add-new').before('<div class="form-group d-can-del">'+
              '<div class="col-sm-12">'+
                '<div class="input-group">'+
                  '<input type="text" name="'+
                  ndata+'[]" class="form-control">'+
                  '<span class="input-group-addon">'+
                    '<i class="fa fa-lg fa-asterisk"></i>&nbsp;'+vdata+''+'</span>'+
                  '<span class="input-group-btn">'+
                    '<a class="btn btn-danger d-delete">'+
                      '<i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>'+
                  '</span>'+
                '</div>'+
              '</div>'+
            '</div>').end().find('.d-delete').on('click' ,function() {
                //alert('tak');
                $(this).closest('.d-can-del').remove();
            });
    }
});

$('.d-delete').on('click' ,function() {
//alert('tak');
    $(this).closest('.d-can-del').remove();
});

$('#d-login-check').change(function() {
     if(this.checked) {
        $(".d-login").show();
        $(".d-login input").prop('disabled', false);
    } else {
        $(".d-login").hide();
        $(".d-login input").prop('disabled', true);
    }
});

$('#d-address-send').change(function() {
     if(this.checked) {
        $(".d-address-send").show();
        $(".d-address-send input").prop('disabled', false);
    } else {
        $(".d-address-send").hide();
        $(".d-address-send input").prop('disabled', true);
    }
});


$('#d-account-edit').change(function() {
     if(this.checked) {
        $(".d-form :input").prop('disabled', false);
        $('#summernote').summernote('disable');
    } else {
        $(".d-form :input").prop('disabled', true);
        $('#summernote').summernote('enable');
    }
});


$('.combobox').combobox();


$('cform').submit(function(){
    return false;
});
});

function dcheck(){
    if ($('#d-login-check').prop('checked')) {
        $(".d-login").show();
    } else {
        $(".d-login").hide();
    }
    if ($('#d-address-send').prop('checked')) {
        $(".d-address-send").show();
    } else {
        $(".d-address-send").hide();
    }
}