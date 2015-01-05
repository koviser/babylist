$(document).ready(function() {
  $("input[type='text'], input[type='password'], textarea").each(function() {
    var input = $(this);
    input.val(input.attr('placeholder'));
    input.focus(function() {if ( $(this).val() === $(this).attr('placeholder')){$(this).val('');}});
	input.focusout(function() {if ( $(this).val() === '' || $(this).val() === $(this).attr('placeholder')){input.val(input.attr('placeholder'));}});
  });

  $("a[href='#start_shodow']").click( function() {
    var id = $(this).attr('rel');
    center_show(id);
    $('#load').animate({ opacity: 'show' }, "slow");
    $(id).animate({ opacity: 'show' }, "slow");
    $(window).resize(function(){center_show(id);});
    return false;
  });

  $("a[href='#closed']").click( function() {
  	var idach = $(this).parents('div.show').attr('id');
  	$('#load').animate({opacity: 'hide'}, "slow");
  	$('#'+idach).animate({opacity: 'hide'}, "slow");
  	return false;
  });

    $("#load, a[href='#closed']").click( function() {
  	var idach = $("a[href='#closed']").data('type');
  	$('#load').animate({opacity: 'hide'}, 400);
  	$('#zacaz, .show').animate({opacity: 'hide'}, 300);
  	return false;
  });

  $("#load, a[href='#closedT']").click( function() {
  	var idach = $("a[href='#closed']").data('type');
  	$('#load').animate({opacity: 'hide'}, 400);
  	$('.show-slaider').animate({opacity: 'hide'}, 300);
  	return false;
  });

  $('.forma').submit(function(){
    var idach = $(this).parents('div.show').attr('id'),
        link = $(this).attr('action'),
        post = $(this).serialize(),
        block = 0,
        vid = $(this).data('vid');
		if($(this).data('id'))idach = $(this).data('id');


  $('#'+idach+' input').removeAttr('style');
  $("#"+idach+"  input[type='text']").each(function() {if ( $(this).val() == $(this).attr('placeholder')){block = 1;$(this).css('background-color','#FFE1E1');}});
    if(block == 0){
  $.ajax({type: 'POST', url: link, data: post, dataType: 'json',
        success: function(data) {
          if(data.code != 0){
          for (var i = 0; i < data.input.length; i++) {
              $("#"+idach+" input[name='"+data.input[i]+"']").css('background-color','#FFE1E1');            }
          } else if(data.code == 0){
           $('#succes').css('color','#009D00').html('Ваша заявка отправлена');
           center_show('#succes');
            if(vid != 1){
            $('#'+idach).animate({opacity: 'hide'}, "slow", function(){
             $('#succes').animate({ opacity: 'show' }, "slow", function(){
               setTimeout(
                  function(){
                    $('#load').animate({opacity: 'hide'}, "slow");
                    $('#succes').animate({ opacity: 'hide' }, "slow", function(){$('#succes').html('');});
                  }
                ,1500);
             });
           });

           }else{
		     $('#load').animate({opacity: 'show'}, "slow");
             $('#succes').animate({ opacity: 'show' }, "slow", function(){
               setTimeout(
                  function(){
                    $('#load').animate({opacity: 'hide'}, "slow");
                    $('#succes').animate({ opacity: 'hide' }, "slow", function(){$('#succes').html('');});
                  }
                ,1500);
             });
           }
          }

        }
      });
    }
 return false;
  });

});

function center_show(elem){
  $(elem).css({
    position:'absolute',
    left: ($(window).width() - $(elem).outerWidth())/2 + $(window).scrollLeft() + "px",
    top: ($(window).height() - $(elem).outerHeight())/2 + $(window).scrollTop() + "px"
  });
}