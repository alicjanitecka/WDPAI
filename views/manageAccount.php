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
            <a href="/dashboard" class="nav-item">
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
                <?php if ($isPetsitter): ?>
                    <button class="nav-btn">services</button>
                <?php endif; ?>
                <button class="nav-btn">settings</button>
            </nav>
        </div>

        <div class="profile-content">
        <div class="content-section personal-info active" data-tab="personal-information">

                <h2>MANAGE YOUR PROFILE</h2>
                <div class="profile-form">
                    <form action="/updateAccount" method="POST">
                        <div class="form-container">
                            <div class="form-left">
                                <input type="text" name="first_name" value="<?= $user->getFirstName() ?>" placeholder="first name" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="last_name" value="<?= $user->getLastName() ?>" placeholder="last name" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="email" name="email" value="<?= $user->getEmail() ?>" placeholder="email address" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="tel" name="phone" value="<?= $user->getPhone() ?>" placeholder="phone number" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="city" value="<?= $user->getCity() ?>" placeholder="city" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="postal_code" value="<?= $user->getPostalCode() ?>" placeholder="postal code" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="street" value="<?= $user->getStreet() ?>" placeholder="street" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="house_number" value="<?= $user->getHouseNumber() ?>" placeholder="house number" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="apartment_number" value="<?= $user->getApartmentNumber() ?>" placeholder="apartment number" readonly>
                            </div>


                            <div class="form-right">
                                <div class="photo-upload">
                                    <img src="<?= $user->getAvatarUrl() ?? '../Public/img/default-avatar.svg' ?>" alt="User photo">
                                    <button type="button" class="edit-photo-btn">Change photo</button>
                                </div>
                                <?php if ($isPetsitter): ?>
                                    <textarea name="description" placeholder="Description" required readonly><?= $petsitter->getDescription() ?></textarea>
                                <?php endif; ?>
                            </div>


                        </div>
                        <div class="form-actions">
                            <button type="button" class="edit-btn">Edit</button>
                            <button type="submit" class="save-btn" style="display: none;">Save changes</button>
                            <button type="button" class="cancel-btn" style="display: none;">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="content-section pets-info" data-tab="your-pets">
                <h2>YOUR PETS</h2>
                <div class="pets-list">
                    <?php foreach ($pets as $pet): ?>
                        <div class="pet-card" data-pet-id="<?= $pet->getId() ?>">
                            <div class="pet-info">
                                <h3><?= $pet->getName() ?></h3>
                                <p>Age: <?= $pet->getAge() ?></p>
                                <p>Species: <?= $pet->getSpecies() ?></p>
                                <p>Breed: <?= $pet->getBreed() ?></p>
                                <p>Additional info: <?= $pet->getAdditionalInfo() ?></p>
                            </div>
                            <div class="pet-photo">
                                <img src="<?= $pet->getPhotoUrl() ?? '../Public/img/default-pet.svg' ?>" alt="Pet photo">
                            </div>
                            <div class="pet-actions">
                                <button class="edit-pet-btn">Edit</button>
                                <form action="/deletePet" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $pet->getId() ?>">
                                    <button type="submit" class="delete-pet-btn">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="edit-pet-form" style="display: none;" data-pet-id="<?= $pet->getId() ?>">
                            <form action="/updatePet" method="POST">
                                <input type="hidden" name="id" value="<?= $pet->getId() ?>">
                                <input type="text" name="name" value="<?= $pet->getName() ?>" required>
                                <input type="number" name="age" value="<?= $pet->getAge() ?>" required>
                                <input type="text" name="species" value="<?= $pet->getSpecies() ?>" required>
                                <input type="text" name="breed" value="<?= $pet->getBreed() ?>">
                                <textarea name="additional_info"><?= htmlspecialchars($pet->getAdditionalInfo()) ?></textarea>
                                <input type="file" name="photo" accept="image/*">
                                <button type="submit">Save Changes</button>
                                <button type="button" class="cancel-edit-pet">Cancel</button>
                            </form>
                        </div>

                    <?php endforeach; ?>
                </div>
                <button id="add-pet-btn">Add Pet</button>
                <div id="add-pet-form" style="display: none;">
                    <form action="/addPet" method="POST">
                    <input type="text" name="name" placeholder="Pet Name" required>
                    <input type="number" name="age" placeholder="Age" required>
                    <input type="text" name="species" placeholder="Species" required>
                    <input type="text" name="breed" placeholder="Breed">
                    <textarea name="additional_info" placeholder="Additional Info"></textarea>
                    <input type="file" name="photo" accept="image/*">
                    <button type="submit">Save Pet</button>
                    <button type="button" id="cancel-add-pet">Cancel</button>
                    </form>
                </div>
            </div>

            <?php if ($isPetsitter): ?>
                <div class="content-section services-info" data-tab="services">
                    <h2>YOUR SERVICES</h2>
                    <form action="/updatePetsitterServices" method="POST">

                        <h3>Availability</h3>
                        <!-- Calendar or availability selection -->
                        
                        <h3>Pet Types</h3>
                        <label><input type="checkbox" name="pet_types[]" value="dog" <?= $petsitterServices['pet_types']['dog'] ? 'checked' : '' ?>> Dogs</label>
                        <label><input type="checkbox" name="pet_types[]" value="cat" <?= $petsitterServices['pet_types']['cat'] ? 'checked' : '' ?>> Cats</label>
                        <label><input type="checkbox" name="pet_types[]" value="rodent" <?= $petsitterServices['pet_types']['rodent'] ? 'checked' : '' ?>> Rodents</label>
                        <h3>Services</h3>
                        <label><input type="checkbox" name="services[]" value="care_at_owner_home" <?= $petsitterServices['services']['care_at_owner_home'] ? 'checked' : '' ?>> Care at owner's home</label>
                        <label><input type="checkbox" name="services[]" value="care_at_petsitter_home" <?= $petsitterServices['services']['care_at_petsitter_home'] ? 'checked' : '' ?>> Care at petsitter's home</label>
                        <label><input type="checkbox" name="services[]" value="dog_walking" <?= $petsitterServices['services']['dog_walking'] ? 'checked' : '' ?>> Dog walking</label>
                        <h3>Hourly Rate</h3>
                        <input type="number" name="hourly_rate" value="<?= $petsitterServices['hourly_rate'] ?>" step="0.01" min="0">

                        <button type="submit">Save Services</button>
                    </form>
                </div>
            <?php endif; ?>

            <div class="content-section settings-info" data-tab="settings">
                <h2>SETTINGS</h2>
                <!-- Settings content -->
            </div>
        </div>
    </main>

</body>
</html>


