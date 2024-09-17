<!--register area start-->
<div class="col-lg-6 col-md-6">
    <div class="account_form register">
        <h2 class="text-center">Đăng Ký</h2>
        <form method="POST" action="{{route('client.signin')}}">
            @csrf
            <p>
                <label>Họ và tên <span style="color: red">*</span></label>
                <input type="text" name="name" value="{{old('name')}}" placeholder="Nhập họ và tên">
                @if ($errors->has('name'))
                           <span class="error-message">* {{$errors->first('name')}}</span>
                       @endif
            </p>
            <p>
                <label>Email <span style="color: red">*</span></label>
                <input type="text" name="email" value="{{old('email')}}" placeholder="example@gmail.com">

                @if ($errors->has('email'))
                           <span class="error-message">* {{$errors->first('email')}}</span>
                       @endif
            </p>
            <div style="margin-bottom: 20px">
                <label>Mật khẩu <span style="color: red">*</span></label>
                    <div class="signin_password">
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu">
                    <i class="fa fa-eye" id="togglePassword"></i>
                    </div>
                @if ($errors->has('password'))
                           <span class="error-message">* {{$errors->first('password')}}</span>
                       @endif
                </div>
                <div style="margin-bottom: 20px">
                <label>Xác nhận mật khẩu <span style="color: red">*</span></label>
                <div class="signin_password">
                <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Xác nhận mật khẩu">
                <i class="fa fa-eye" id="toggleConfirmPassword"></i>
                </div>
                @if ($errors->has('password_confirmation'))
            <span class="error-message">* {{ $errors->first('password_confirmation') }}</span>
        @endif
            </div>
            <div class="login_submit">
                <button type="submit">Đăng Ký</button>
            </div>
        </form>
    </div>
</div>
<!--register area end-->
<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
    const passwordField = document.getElementById('password');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);

    // Đổi biểu tượng mắt
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
document.getElementById('toggleConfirmPassword').addEventListener('click', function (e) {
    const passwordField = document.getElementById('confirmPassword');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);

    // Đổi biểu tượng mắt
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
</script>