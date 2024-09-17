<!--login area start-->
<div class="col-lg-6 col-md-6">
    <div class="account_form">
        <h2 class="text-center">Đăng Nhập</h2>
        <form method="POST" action="{{route('client.login')}}">
            @csrf
            <p>
                <label>Email <span class="text-danger">*</span></label>
                <input type="text" name="email" placeholder="Nhập email" value="{{old('email')}}">
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
            <div class="login_submit">
                <a href="{{route("client.form.signin")}}">Tôi chưa có tài khoản?</a>
                {{-- <label for="remember">
                    <input id="remember" type="checkbox">
                    Ghi nhớ mật khẩu
                </label> --}}
                <button type="submit">Đăng Nhập</button>

            </div>

        </form>
    </div>
</div>
<!--login area end-->
<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
    const passwordField = document.getElementById('password');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);

    // Đổi biểu tượng mắt
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
</script>