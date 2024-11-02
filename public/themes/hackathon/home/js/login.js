$(document).ready(function () {

    $(document).ready(function () {
      $("#loginForm").submit(function (e) {
        e.preventDefault();
        var usernameOrEmail = $("#email").val();
        var password = $("#password").val();
  
    
        var data = {
          usernameOrEmail: usernameOrEmail,
          password: password,
        };
  
        $.ajax({
          url: "/src/Ajax/hackathon/home/login.php",
          type: "POST",
          data: {
            data: JSON.stringify(data),
          },
          success: function (response) {
            $("#message").text(response.message).css("color", response.color);
            if (response.success) {
              window.location.href = "/";
            }
          },
        });
      });
    });
  });
  