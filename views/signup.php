<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../Public/css/signup.css"/>
        <title>PetZone - Rejestracja</title>
    </head>
    <body>
        <div class="container">
            <div class="left">
                <h2>DOŁĄCZ DO NAS!</h2>
                <form class="signup" action="signup" method="POST">
                    <div class="messages">
                        <?php if(isset($messages)){
                            foreach($messages as $message)
                            echo $message;
                        }
                        ?>                  
                    </div>
                    <div class="name-row">
                        <input name="name" type="text" placeholder="Imię">
                        <input name="surname" type="text" placeholder="Nazwisko">
                    </div>
                    <input name="email" type="email" placeholder="Adres email">
                    <input name="password" type="password" placeholder="Hasło">
                    <input name="confirmedPassword" type="password" placeholder="Potwierdź hasło">
                    <button type="submit">ZAREJESTRUJ SIĘ</button>
                    <p>Masz już konto? <a href="#">Zaloguj się</a></p>
                </form>
            </div>
            <div class="right">
                <img src="../Public/img/logo.svg">
            </div>
        </div>
    </body>
</html>
