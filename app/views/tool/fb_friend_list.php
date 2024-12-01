<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Sample</h1>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam minus nesciunt vitae animi reiciendis, 
        obcaecati perferendis recusandae deleniti error? Et cumque nulla nam voluptates, 
        dolorum excepturi earum vel maiores quas!
    </p>

    <fb:login-button 
        scope="public_profile,email"
        onlogin="checkLoginState();">
        </fb:login-button>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '809030094413146',
            cookie     : true,
            xfbml      : true,
            version    : 'v19.0'
            });
            
            FB.AppEvents.logPageView();    
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    console.log(response.authResponse.accessToken);
                    FB.api(
                        '/me',
                        'GET',
                        {"fields":"id,name,friends.limit(10){first_name,last_name,name}"},
                        function(response) {
                            console.log(response);
                        }
                    );
                }
            });
        }
    </script>
</body>
</html>