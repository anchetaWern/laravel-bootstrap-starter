@section('content')
<div class="row">
  <div class="col-md-5">
  @include('partials.alert')
  </div>
</div>
<div class="row">
  <div class="col-md-5">
    <form id="payment-form" method="POST" action="/register">
      <fieldset id="fldset-accountinfo">
        <legend>1. Sign Up for {{ Session::get('plan.name') }} account</legend>
        <div id="js-alert"></div>
        <div class="form-group">
          <label for="username">Name</label>
          <input type="text" class="form-control" id="username" name="username" value="{{ Input::old('username') }}">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ Input::old('email') }}">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
          <button type="button" id="btn-getstarted" class="btn btn-primary btn-block">Get Started</button>
        </div>
      </fieldset>

      <fieldset id="fldset-billinginfo">
        <legend>2. Billing Information</legend>

        <div id="payment-alert"></div>

        <div class="form-group">
          <label for="card_number">Credit Card #</label>
          <span id="cardnumber_error" class="field-error"></span>
          <input type="text" class="form-control" id="card_number" name="card_number" data-stripe="number">
        </div>

        <div class="form-group" id="security_code_container">
          <label for="security_code">Security Code</label>
          <br>
          <span id="securitycode_error" class="field-error"></span>
          <input type="text" class="form-control" id="security_code" name="security_code" data-stripe="cvc" required="">
        </div>

        <div class="form-group">
          <label id="lbl-expirydate">Expiry Date</label>
          <select name="expiry_month" id="expiry_month" class="form-control" data-stripe="exp-month">
          @foreach($months as $id => $month)
            <option value="{{ $id }}">{{ $month }}</option>
          @endforeach
          </select>

          <select name="expiry_year" id="expiry_year" class="form-control" data-stripe="exp-year">
          @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
          @endforeach
          </select>

        </div>

      </fieldset>

      <fieldset id="fldset-review">
        <legend>3. Review Payment</legend>
        <div class="alert alert-info">
          {{ $plan->name }} - ${{ number_format($plan->price, 2, '.', '') }}
        </div>

        <button type="submit" class="btn btn-primary btn-block">Process Payment</button>
      </fieldset>

    </form>
  </div>
</div>
@include('partials/js/alert')
@stop