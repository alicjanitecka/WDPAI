<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../Public/css/login.css"/>
        <title>PetZone</title>
    </head>
    <body>
        <div class="container">
            <div class="left">
                <h2> WELCOME BACK!</h2>
                <form class="login" action="login" method="POST">
                <div class="messages">
                    <?php if(isset($messages)){
                        foreach($messages as $message)
                        echo $message;
                    }
                    ?>                  
                </div>

                    <input name="email" type="text" placeholder="Enter your email address">
                    <input name="password" type="password" placeholder="Enter your password">
                    <div>
                        <label>
                            <input type="checkbox">Remember me
                        </label>
                        
                    </div>
                    <button type="submit">LOG IN</button>
                    <p>Don't have an account yet? <a href="#">Sign up</a></p>
                    <a href="#">Fogrot password?</a>
                </form>

            </div>
            <div class="right">
                <img src="../Public/img/logo.svg">
            </div>
        </div>
    <body>
</html>