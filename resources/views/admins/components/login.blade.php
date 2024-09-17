<!DOCTYPE html>
<html>
  <head>
    @include('admins.components.head')
  </head>

  <body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
      <div>
        <div>
          <h1 class="logo-name">IN+</h1>
        </div>
        <h3>Welcome to IN+</h3>
        <p>
          Perfectly designed and precisely prepared admin theme with over 50
          pages with extra new web app views.
          <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
        </p>
        <p>Login in. To see it in action.</p>
        <form class="m-t" method="post" role="form" action="{{route('store')}}">
            @csrf
          <div class="form-group">
            <input
              type="text"
              class="form-control {{$errors->has('email') ? "is-invalid" : ""}}"
              value="{{old('email')}}"
              placeholder="Email"
              name="email"
            />
            @if ($errors->has('email'))
                <div style="text-align: left"><span class="error-message">* {{$errors->first('email')}}</span></div>
            @endif
          </div>
          <div class="form-group">
            <input
              type="password"
              class="form-control {{$errors->has('password') ? "is-invalid" : ""}}"
              placeholder="Password"
              name="password"
            />
            @if ($errors->has('password'))
            <div style="text-align: left"><span class="error-message">* {{$errors->first('password')}}</span></div>
            @endif
          </div>
          <button type="submit" class="btn btn-primary block full-width m-b">
            Login
          </button>

          <a href="#"><small>Forgot password?</small></a>
          <p class="text-muted text-center">
            <small>Do not have an account?</small>
          </p>
          <a class="btn btn-sm btn-white btn-block" href="register.html"
            >Create an account</a
          >
        </form>
        <p class="m-t">
          <small
            >Inspinia we app framework base on Bootstrap 3 &copy; 2014</small
          >
        </p>
      </div>
    </div>

    <!-- Mainly scripts -->
    <script src="template/js/jquery-3.1.1.min.js"></script>
    <script src="template/js/bootstrap.min.js"></script>
  </body>
</html>
