<div class="login_form">
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->


    <div class="card-body success_alert">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- {{ __('You are logged in!') }} --}}
    </div>

    <center class="login_form_box">
        <span>LOgin</span>
        @if (session('failure'))
        <div class="sailure_of_session">
            {{ session('failure') }}
        </div>
    @endif


        <form class="" method="POST" action="{{ route('login_check') }}" enctype="multipart/form-data">
            @csrf
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="email" name="email" id="form2Example1" class="form-control" required />
                <label class="form-label" for="form2Example1">Email address</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password" id="form2Example2" class="form-control" required />
                <label class="form-label" for="form2Example2">Password</label>
            </div>

            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-success btn-block mb-4">Sign in</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="register">Register</a></p>

            </div>
        </form>
    </center>
</div>
