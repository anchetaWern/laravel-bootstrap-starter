@section('content')
<div class="row">
  <div class="col-md-12 text-center">
    @foreach($subscription_plans as $sp)
    <div class="col-lg-4">
      <div class="plan">
        <h4>{{ $sp->name }}</h4>
        <h5>${{ $sp->price }}</h5>
        <ul class="features">
        <?php
        $features = json_decode($sp->features , true);
        ?>
        @foreach($features as $feature)
          <li>{{ $feature }}</li>
        @endforeach
        </ul>
        <a href="/plan/{{ $sp->id }}" class="btn btn-sm btn-primary">Sign Up</a>
      </div>
    </div>
    @endforeach
  </div>
</div>
@stop