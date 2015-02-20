(function(){

  var js_alert_template = Handlebars.compile($('#js-alert-template').html());

  Stripe.setPublishableKey('pk_test_dU8btf8RMglDTx90RT2yC2Ry');

  function stripeResponseHandler(status, response){

    var form = $('#payment-form');

    if(response.error){
      $('#payment-alert').text(response.error.message).removeClass().addClass('alert alert-danger');
      form.find('button').prop('disabled', false);
    }else{
      var token = response.id;
      form.append($('<input type="hidden" name="stripeToken" />').val(token));
      form.get(0).submit();
    }
  };

  $('#payment-form').submit(function(event){

    var form = $(this);

    form.find('button').prop('disabled', true);
    Stripe.card.createToken(form, stripeResponseHandler);

    return false;
  });

  $('#btn-getstarted').click(function(){

    var username = $('#username').val();
    var email = $('#email').val();
    var password = $('#password').val();

    $.post(
      '/register/check',
      {
        'username': username,
        'email': email,
        'password': password
      },
      function(response){
        $('#js-alert').html(js_alert_template(response)).removeClass();
        if(response == 'success'){
          $('#fldset-billinginfo, #fldset-review').show();
          $('#btn-getstarted').hide();
          $('#card_number').focus();
        }else{
          ('#js-alert').addClass('alert-danger');
        }
      }
    );
  });

})();