    <div class="mx-auto">
        <h1 class="font-weight-bold text-center">{{ config('app.name', 'MCQ Modul') }}</h1>
        @if (session('msg'))
            <div class="alert alert-danger">
                {{ session('msg') }}
            </div>
        @endif
    </div>
    {{ csrf_field() }}
    <div class="form-group">
        <label for="username">Email</label>
        <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" required name="username" autocomplete="off" placeholder="Email">
        @if ($errors->has('username'))
            <p class="text-danger">
                {{ $errors->first('username') }}
            </p>
        @endif
    </div>
    <div class="form-group">
        <label for="pwd">Password</label>
        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="pwd" name="password" required placeholder="Password">
        @if ($errors->has('password'))
            <p class="text-danger">
                {{ $errors->first('password') }}
            </p>
        @endif
    </div>
    <div class="form-group">
        <label class="form-check-label lbl">
            <input class="form-check-input" type="checkbox" name="remember">
            <span class="checkmark cb border"></span>
            Remember me
        </label>
    </div>
    <button type="submit" class="btn btn-success btn-block">Submit</button> 
    <div style="margin-top: 10px;">
    <center>
            <a href="{{ custom_url('register') }}" target="_blank" style="text-decoration: none;">Register for matrix</a>
    </center>
</div>