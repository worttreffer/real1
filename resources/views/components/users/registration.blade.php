<div>
  <div class="col-sm-8 offset-sm-2">
    <h1>Profil vervollständigen</h1>
  <div>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div><br />
  @endif
  <form method="POST" action="/home/saveProfile">
    @csrf
    <div class="form-group">
      <label for="first_name">Straße:</label>
      <input type="text" class="form-control" name="street"/>
    </div>

    <div class="form-group">
      <label for="first_name">Ort:</label>
      <input type="text" class="form-control" name="place"/>
    </div>

    <div class="form-group">
      <label for="first_name">Postleitzahl:</label>
      <input type="text" class="form-control" name="postal_code"/>
    </div>

    <button type="submit" class="btn btn-primary-outline">Weiter</button>
  </form>
</div>
