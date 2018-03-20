<div class="modal fade" id="login-modal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Accedi a Renteet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        <div class="modal-body">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    <input id="email" placeholder="Indirizzo email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ricordami
                        </label>
                    </div>
                </div>
            </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Hai dimenticato la password?
                        </a>
                    </div>
                </div>
      </div>
            
            

            <div class="modal-footer">
                <div class="col-md-12">
                    <p class="text-center">
                        Non sei registrato? 
                        <a href="{{ route('register') }}">
                            Registrati adesso!
                        </a>
                    </p>
                </div>
                
            </div>
      
        </form>
    </div>
  </div>
</div>