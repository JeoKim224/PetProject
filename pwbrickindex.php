<script src="https://api.paymentwall.com/brick/brick.1.4.js"> </script>
<div id="payment-form-container"> </div>
<script>
  var brick = new Brick({
    public_key: 't_68efda3f15830a84b8ff027228e650',
    amount: 9.99,
    currency: 'USD',
    container: 'payment-form-container',
    action: 'billing.php',
    form: {
      merchant: 'Jeo Kim',
      product: 'Test Product',
      pay_button: 'Pay',
      zip: true
    }
  });

  brick.showPaymentForm(function(data) {
    // handle success
    
  }, function(errors) {
    // handle errors
  });
</script>

<script src="https://api.paymentwall.com/brick/brick.1.4.js"> </script>
<form id="brick-creditcard-form" action="billing.php" method="POST">
  <input name="custom_parameter" type="hidden" value="custom_value"/>
  <div>
    <label>
      <span>Card number</span>
      <input data-brick="card-number" type="text" id="card-number"/>
    </label>
  </div>
  <div>
    <label>
      <span>Card expiration</span>
      <input data-brick="card-expiration-month" type="text" size="2" id="card-exp-month"/> / 
      <input data-brick="card-expiration-year" type="text" size="4" id="card-exp-year"/>
    </label>
  </div>
  <div>
    <label>
      <span>Card CVV</span>
      <input data-brick="card-cvv" type="text" id="card-cvv"/>
    </label>
  </div>
  <div>
    <label>
      <span>Email</span>
      <input data-brick="email" type="text" id="email"/>
    </label>
  </div>
  <button type="submit">Submit</button>
</form>
<script>
  // using jQuery
  var $form = $('#brick-creditcard-form');
  var brick = new Brick({
    public_key: 't_68efda3f15830a84b8ff027228e650',
    form: { formatter: true }
  }, 'custom');

  $form.submit(function(e) {
    e.preventDefault();

    $form.find('button').prop('disabled', true);

    brick.tokenizeCard({
      card_number: $('#card-number').val(),
      card_expiration_month: $('#card-exp-month').val(),
      card_expiration_year: $('#card-exp-year').val(),
      card_cvv: $('#card-cvv').val(),
      email: $('#email').val()
    }, function(response) {
      if (response.type == 'Error') {
        // handle errors
      } else {
        $form.append($('<input type="hidden" name="brick_token"/>').val(response.token));
        $form.append($('<input type="hidden" name="brick_fingerprint"/>').val(Brick.getFingerprint()));
        $form.get(0).submit();
      }
    });

    return false;
  });
</script>
