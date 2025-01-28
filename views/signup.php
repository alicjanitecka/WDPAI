<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../Public/css/signup.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PetZone - Sign up</title>
    </head>
    <body>
        <div class="container">
            <div class="left">
                <h2>JOIN US</h2>
                <form class="signup" action="signup" method="POST">
                    <div class="messages">
                        <?php if(isset($messages)){
                            foreach($messages as $message)
                            echo $message;
                        }
                        ?>                  
                    </div>
                    <div class="name-row">
                        <input name="name" type="text" placeholder="First name">
                        <input name="surname" type="text" placeholder="Last name">
                    </div>
                    <input name="email" type="email" placeholder="E-mail address">
                    <input name="password" type="password" placeholder="Password">
                    <input name="confirmedPassword" type="password" placeholder="Confirm password">
                    <button type="submit">SIGN UP</button>
                    <p>Do you have account yet? <a href="/login">Log in</a></p>
                </form>
            </div>
            <div class="right">
                <img src="../Public/img/logo.svg">
            </div>
        </div>
    </body>
</html>
