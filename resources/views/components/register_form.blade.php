<div class="login_form">

    <div class="card-body success_alert">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <center id="register_form" class="register_form_box">
        <span>Register</span>
        <form class="" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- First name input -->
            <div class="form-group">
                <input type="text" name="first_name" id="firstName" class="form-control" required />
                <label class="form-label" for="firstName">First Name</label>
            </div>

            <!-- Last name input -->
            <div class="form-group">
                <input type="text" name="last_name" id="lastName" class="form-control" required />
                <label class="form-label" for="lastName">Last Name</label>
            </div>

            <!-- Gender dropdown -->
            <div class="form-group">
                <select name="gender" id="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
                <label class="form-label" for="gender">Gender</label>
            </div>

            <!-- Email input -->
            <div class="form-group">
                <input type="email" name="email" id="registerEmail" class="form-control" required />
                <label class="form-label" for="registerEmail">Email address</label>
            </div>

            <!-- Password input -->
            <div class="form-group">
                <input type="password" name="password" id="registerPassword" class="form-control" required />
                <label class="form-label" for="registerPassword">Password</label>
            </div>


            <!-- Phone number input -->
            <div class="form-group">
                <input type="tel" name="phone_number" id="phoneNumber" class="form-control" required />
                <label class="form-label" for="phoneNumber">Phone Number</label>
            </div>

            <!-- Profile image input -->
            <div class="form-group">
                <input type="file" name="profile_image" id="profileImage" class="form-control" accept="image/*" />
                <label class="form-label" for="profileImage">Profile Image</label>
            </div>

            <div class="text-center">
                <p>Registered? <a href="login">Login</a></p>

            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-success btn-block mb-4">Register</button>
        </form>
    </center>
</div>
