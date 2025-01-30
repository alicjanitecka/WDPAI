<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="../Public/css/dashboard.css"/>
    
    <title>PetZone - Dashboard</title>
</head>
<body>
<script src="../public/js/selectPet.js"></script>
<script src="../public/js/searchPetsitter.js"></script>
    <nav class="navbar">

        <div class="nav-links">
            <a href="/dashboard" class="nav-item">
                <img src="../Public/img/home.svg" alt="">
                home
            </a>
            <?php if (!$isPetsitter): ?>
            <a href="/becomePetsitter" class="nav-item">
                <img src="../Public/img/pet.svg" alt="">
                become a petsitter
            </a>
            <?php endif; ?>
            <a href="#" class="nav-item">
                <img src="../Public/img/calendar.svg" alt="">
                my visits
            </a>
            <a href="/manageAccount" class="nav-item">
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


    <div class="logo">
        <img src="../Public/img/logo.svg" alt="PetZone">
    </div>


    <main>

        <form action="/search" method="POST" class="search-bar" id="searchForm">
            <div class="search-item">
                <img src="../Public/img/calendar.svg" alt="calendar">
                <input type="date" name="start_date" placeholder="Start date" required>
                <input type="date" name="end_date" placeholder="End date" required>
            </div>
            <div class="search-item">
        <img src="../Public/img/home.svg" alt="home">
        <select name="care_type" required>
            <option value="">Select care type</option>
            <option value="petsitter_home">At petsitter's home</option>
            <option value="owner_home">At owner's home</option>
            <option value="dog_walking">Walking the dog</option>
        </select>
        
    </div>
    <div class="search-item">
    <img src="../Public/img/pet.svg" alt="pet">
    <div class="pet-select-wrapper">
        <div class="pet-select-display">Select pets</div>
        <div class="pet-options">
            <?php foreach ($userPets as $pet): ?>
            <div class="pet-option" data-value="<?= $pet->getId() ?>">
                <input type="checkbox" name="pets[]" value="<?= $pet->getId() ?>">
                <span><?= $pet->getName() ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


    <button type="submit" class="search-button">
        <img src="../Public/img/search.svg" alt="Search Icon" class="button-icon">
    </button>
</form>
<div class="search-results" id="searchResults" style="display: none;">

</div>



        <div class="services-container">

            <div class="service-card">
                <h3>Care at your home</h3>
                <img src="../Public/img/home-care.svg" alt="home care">
                <p>Book a petsitter to visit your home! Your pet stays in a familiar environment while the petsitter comes by several times a day.</p>
            </div>

            <div class="service-card">
                <h3>Care at the petsitter's home</h3>
                <img src="../Public/img/petsitter-care.svg" alt="petsitter care">
                <p>Going away? Leave your pet at the petsitter’s home, where they’ll receive constant care and attention.</p>
            </div>

            <div class="service-card">
                <h3>Walking the dog</h3>
                <img src="../Public/img/dog-walking.svg" alt="dog walking">
                <p>No time for a walk? Schedule a walk with a petsitter and keep your dog happy and active!</p>
            </div>
        </div>
    </main>

</body>
</html>