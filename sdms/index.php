<?php @include("includes/head.php"); ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
        <div class="login-logo">
          <center><img src="company/bjmp_logo.png" width="150" height="130" class="user-image" alt="User Image" /></center>
        </div>
        <p class="login-box-msg">
        <h4>
          <center>Welcome</center>
        </h4>
        </p>
        <div id="errorMessage" style="color: red; text-align: center; margin-top: 10px;"></div>
        <form id="loginForm" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input id="passwordField" type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text"><span id="toggleButton" style="cursor: pointer;" class="fas fa-eye"></span></div>
            </div>
          </div>
          <div class="row position-relative">
            <div class="col-8">
              <div class="icheck-primary">
                <p class="mb-1 position-absolute end-0"></p>
              </div>
            </div>
            <div class="col-4">
              <button style="width:100%;" type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php @include("includes/foot.php"); ?>

  <script>
    $(document).ready(function() {
      $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'login.php',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              window.location.href = 'dashboard.php';
            } else {
              $('#errorMessage').text(response.message);
            }
          }
        });
      });

      const passwordField = document.getElementById('passwordField');
      const toggleButton = document.getElementById('toggleButton');
      passwordField.type = "password";

      toggleButton.addEventListener('click', function() {
        if (passwordField.type === 'password') {
          passwordField.type = 'text';
          toggleButton.classList.remove('fa-eye');
          toggleButton.classList.add('fa-eye-slash');
        } else {
          passwordField.type = 'password';
          toggleButton.classList.remove('fa-eye-slash');
          toggleButton.classList.add('fa-eye');
        }
      });
    });
  </script>
</body>

</html>