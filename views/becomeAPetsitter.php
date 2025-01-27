<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../Public/css/becomeAPetsitter.css"/>
        <title>PetZone - Become a Petsitter</title>
    </head>
    <body>
        <div class="container">
            <div class="left">
                <h2>BECOME A PETSITTER</h2>
                <form class="petsitter-form" action="becomePetsitter" method="POST">
                <div class="messages">
                    <?php if(isset($messages)){
                        foreach($messages as $message)
                        echo $message;
                    }
                    ?>                  
                </div>

                    <input name="city" type="text" placeholder="City" required>
                    <input name="street" type="text" placeholder="Street" required>
                    <input name="house_number" type="text" placeholder="House number" required>
                    <input name="apartment_number" type="text" placeholder="Apartment number">
                    <input name="postal_code" type="text" placeholder="Postal code" required>
                    <input name="phone" type="tel" placeholder="Phone number" required>
                    <textarea name="description" placeholder="Describe your experience with pets" required></textarea>
                    <div>
                        <label>
                            <input type="checkbox" required>I agree to the terms and conditions
                        </label>
                    </div>
                    <button type="submit">REGISTER AS PETSITTER</button>
                    <p>Already a petsitter? <a href="#">Log in</a></p>
                </form>
            </div>
            <div class="right">
                <img src="../Public/img/logo.svg">
            </div>
        </div>
    </body>
</html>
