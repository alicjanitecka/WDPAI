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
            <a href="/myVisits" class="nav-item">
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

            </nav>
        </div>

        <div class="profile-content">
        <div class="content-section personal-info active" data-tab="personal-information">

                <h2>MANAGE YOUR PROFILE</h2>
                <div class="profile-form">
                    <form action="/updateAccount" method="POST" >
                        <div class="form-container">
                            <div class="form-left">
                                <input type="text" name="first_name" value="<?= $user->getFirstName() ?>" placeholder="first name" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="last_name" value="<?= $user->getLastName() ?>" placeholder="last name" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="email" name="email" value="<?= $user->getEmail() ?>" placeholder="email address" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="tel" name="phone" value="<?= $user->getPhone() ?>" placeholder="phone number" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <?php if ($isPetsitter): ?>
                                    <textarea name="description" placeholder="Description" required readonly><?= $petsitter->getDescription() ?></textarea>
                                <?php endif; ?>
                            </div>


                            <div class="form-right">
                                <input type="text" name="city" value="<?= $user->getCity() ?>" placeholder="city" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="postal_code" value="<?= $user->getPostalCode() ?>" placeholder="postal code" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="street" value="<?= $user->getStreet() ?>" placeholder="street" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="house_number" value="<?= $user->getHouseNumber() ?>" placeholder="house number" <?= $isPetsitter ? 'required' : '' ?>readonly>
                                <input type="text" name="apartment_number" value="<?= $user->getApartmentNumber() ?>" placeholder="apartment number" readonly>

                            </div>


                        </div>
                        <div class="form-actions">
                            <button type="button" class="edit-btn" >Edit</button>
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
                                <p>Pet Type: <?= ucfirst($pet->getPetType()) ?></p>
                                <p>Breed: <?= $pet->getBreed() ?></p>
                                <p>Additional info: <?= $pet->getAdditionalInfo() ?></p>
                            </div>

                            <div class="pet-actions">
                                <button class="edit-pet-btn">Edit</button>
                                <form id="deletePetForm-<?= $pet->getId() ?>" action="/deletePet" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $pet->getId() ?>">
                                    <button type="button" class="delete-pet-btn" data-pet-id="<?= $pet->getId() ?>">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="edit-pet-form" style="display: none;" data-pet-id="<?= $pet->getId() ?>">
                            <form action="/updatePet" method="POST">
                                <input type="hidden" name="id" value="<?= $pet->getId() ?>">
                                <div class="form-container">
                                <div class="form-left">
                                <input type="text" name="name" value="<?= $pet->getName() ?>" required>
                                <input type="number" name="age" value="<?= $pet->getAge() ?>" required>
                                </div>
                                <div class="form-right">
                                <select name="pet_type" required>
                                    <option value="dog">Dog</option>
                                    <option value="cat">Cat</option>
                                    <option value="rodent">Rodent</option>
                                </select>
                                <input type="text" name="breed" value="<?= $pet->getBreed() ?>">
                                </div>
                                </div>
                                <textarea name="additional_info"><?= htmlspecialchars($pet->getAdditionalInfo()) ?></textarea>
                                <div class="edit-actions">
                                <button type="submit" class="save-edit-btn">Save Changes</button>
                                <button type="button" class="cancel-edit-btn">Cancel</button>
                                </div>
                            </form>
                        </div>

                    <?php endforeach; ?>
                </div>
                <button class="add-pet-btn" id="add-pet-btn">Add Pet</button>
                <div class="add-pet-form" id="add-pet-form" style="display: none;">
                    <form action="/addPet" method="POST">
                        <div class="form-container">
                            <div class="form-left">
                                <input type="text" name="name" placeholder="Pet Name" required>
                                <input type="number" name="age" placeholder="Age" required>
                            </div>
                            <div class="form-right">
                                <select name="pet_type" required>
                                    <option value="dog">Dog</option>
                                    <option value="cat">Cat</option>
                                    <option value="rodent">Rodent</option>
                                </select>
                                <input type="text" name="breed" placeholder="Breed">
                            </div>
                        </div>
                        <textarea name="additional_info" placeholder="Additional Info"></textarea>
                        <div class="add-pet-actions">
                            <button type="submit" class="save-btn">Save Pet</button>
                            <button type="button" class="cancel-btn cancel-add-pet">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>

            <?php if ($isPetsitter): ?>
                <div class="content-section services-info" data-tab="services">
                    <h2>YOUR SERVICES</h2>

                    <h3>Availability</h3>
                        <div class="availability-section">
                            <form action="/updateAvailability" method="POST">
                                <div class="date-range">
                                    <label>From: <input type="date" name="start_date" class="date-input" required></label>
                                    <label>To: <input type="date" name="end_date" class="date-input" required></label>
                                </div>
                                <div class="availability-status">
                                    <label>
                                        <input type="radio" name="is_available" value="1" checked> Available
                                    </label>
                                    <label>
                                        <input type="radio" name="is_available" value="0"> Unavailable
                                    </label>
                                </div>
                                <button type="submit" class="update-btn">Update Availability</button>
                            </form>
                        </div>
                        <div class="availability-calendar">
    <h3>Current Availability</h3>
    <table class="availability-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($availabilities && count($availabilities) > 0): ?>
                <?php foreach ($availabilities as $availability): ?>
                    <tr>
                        <td><?= $availability['date'] ?></td>
                        <td><?= $availability['is_available'] ? 'Available' : 'Not Available' ?></td>
                        <td>
                            <form action="/updateAvailability" method="POST" style="display: inline;">
                                <input type="hidden" name="start_date" value="<?= $availability['date'] ?>">
                                <input type="hidden" name="end_date" value="<?= $availability['date'] ?>">
                                <input type="hidden" name="is_available" value="<?= $availability['is_available'] ? '0' : '1' ?>">
                                <button type="submit" class="<?= $availability['is_available'] ? 'available' : 'unavailable' ?>">
                                    <?= $availability['is_available'] ? 'Set Unavailable' : 'Set Available' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No availability data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



                        <form action="/updatePetsitterServices" method="POST">
                        <h3>Pet Types</h3>
                        <label><input type="checkbox" name="pet_types[]" value="dog" <?= $petsitterServices['pet_types']['dog'] ? 'checked' : '' ?>> Dogs</label>
                        <label><input type="checkbox" name="pet_types[]" value="cat" <?= $petsitterServices['pet_types']['cat'] ? 'checked' : '' ?>> Cats</label>
                        <label><input type="checkbox" name="pet_types[]" value="rodent" <?= $petsitterServices['pet_types']['rodent'] ? 'checked' : '' ?>> Rodents</label>
                        <h3>Services</h3>
                        <label><input type="checkbox" name="services[]" value="care_at_owner_home" <?= $petsitterServices['services']['care_at_owner_home'] ? 'checked' : '' ?>> Care at owner's home</label>
                        <label><input type="checkbox" name="services[]" value="care_at_petsitter_home" <?= $petsitterServices['services']['care_at_petsitter_home'] ? 'checked' : '' ?>> Care at petsitter's home</label>
                        <label><input type="checkbox" name="services[]" value="dog_walking" <?= $petsitterServices['services']['dog_walking'] ? 'checked' : '' ?>> Dog walking</label>
                        <div class="rate-input">
                <label>Hourly Rate: <input type="number" name="hourly_rate" class="rate-field" min="0" step="0.01" required></label>
            </div>
                        <button type="submit" class="save-services-btn">Save Services</button>
                    </form>
                </div>
            <?php endif; ?>


        </div>
    </main>

</body>
</html>


