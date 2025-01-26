<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Public/css/manageAccountUser.css">
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../public/js/userProfile.js" defer></script>
    <script src="../public/js/petManagement.js" defer></script>

    <title>PetZone - Manage Profile</title>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../Public/img/logo.svg" alt="PetZone">
        </div>
        <div class="nav-links">
            <a href="/userDashboard" class="nav-item">
                <img src="../Public/img/home.svg" alt="">
                home
            </a>
            <a href="#" class="nav-item">
                <img src="../Public/img/calendar.svg" alt="">
                my visits
            </a>
            <a href="#" class="nav-item">
                <img src="../Public/img/login.svg" alt="">
                my account
            </a>
            <form action="/logout" method="POST" style="display: inline;">
                <button type="submit" class="nav-item" style="border: none; cursor: pointer;">
                    <img src="../Public/img/logout.svg" alt="">
                    log out
                </button>
            </form>
        </div>
    </nav>

    <main>
        <div class="sidebar">
            <nav class="profile-nav">
                <button class="nav-btn active">personal information</button>
                <button class="nav-btn">your pets</button>
                <button class="nav-btn">settings</button>
            </nav>
        </div>

        <div class="profile-content">
            <div class="content-section personal-info active">
                <h2>MANAGE YOUR PROFILE</h2>
                <div class="profile-form">
                    <div class="form-left">
                    <input type="text" name="first_name" placeholder="first name">
                    <input type="text" name="last_name" placeholder="last name">
                    <input type="email" name="email" placeholder="email address">
                    <input type="tel" name="phone" placeholder="phone number">
                    <input type="text" name="city" placeholder="city">
                    <input type="text" name="street" placeholder="street">
                    <input type="text" name="house_number" placeholder="house number">
                    <input type="text" name="apartment_number" placeholder="apartment number">
                    </div>
                    <div class="form-right">
                        <div class="photo-upload">
                            <button>add a photo</button>
                        </div>
                    </div>
                </div>
                <div class="saving">
                        <button>save changes</button>
                </div>
            </div>

            <div class="content-section pets-info">
                <h2>YOUR PETS</h2>
                <div class="pets-list">
                    <?php if (isset($pets) && !empty($pets)): ?>
                        <?php foreach ($pets as $pet): ?>
                            <div class="existing-pet" data-pet-id="<?= $pet->getId() ?>">
                                <div class="pet-photo">
                                    <img src="<?= $pet->getPhotoUrl() ?? '../Public/img/default-pet.svg' ?>" alt="Pet photo">
                                </div>
                                <div class="pet-info">
                                    <h3><?= $pet->getName() ?></h3>
                                    <p>Age: <?= $pet->getAge() ?></p>
                                    <p>Species: <?= $pet->getSpecies() ?></p>
                                    <p>Breed: <?= $pet->getBreed() ?></p>
                                    <p>Additional info: <?= $pet->getAdditionalInfo() ?></p>
                                </div>
                                <div class="pet-actions">
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn">Delete</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <button type="button" class="add-pet-btn">+ Add new pet</button>
                
                <div class="pet-form" style="display: none;">
                    <form id="add-pet-form">
                        <div class="pet-card">
                            <div class="pet-photo">
                                <img src="../Public/img/default-pet.svg" alt="Pet photo">
                            </div>
                            <div class="pet-details">
                                <input type="text" name="name" placeholder="Pet name" required>
                                <input type="number" name="age" placeholder="Age">
                                <input type="text" name="species" placeholder="Species">
                                <input type="text" name="breed" placeholder="Breed">
                                <textarea name="additional_info" placeholder="Additional information"></textarea>
                            </div>
                            <div class="pet-actions">
                                <button type="submit" class="save-btn">Save</button>
                                <button type="button" class="cancel-btn">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="content-section settings-info">
                <h2>SETTINGS</h2>
                <!-- ... zawartość ustawień ... -->
            </div>
        </div>

        </div>
    </main>
</body>
</html>
