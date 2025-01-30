<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="../Public/css/dashboard.css"/>
    <title>PetZone - Dashboard</title>
</head>
<body>

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

        <form action="/search" method="GET" class="search-bar">
            <div class="search-item">
                <img src="../Public/img/calendar.svg" alt="calendar">
                <input type="date" name="start_date" placeholder="Start date" required>
                <input type="date" name="end_date" placeholder="End date" required>
            </div>
            <div class="search-item">
                <img src="../Public/img/home.svg" alt="home">
                <div class="pet-checkboxes">
                <?php foreach ($userPets as $pet): ?>
                <label>
                    <input type="checkbox" name="pets[]" value="<?= $pet->getId() ?>" >
                    <?= $pet->getName() ?>
                </label>
                <?php endforeach; ?>
                </div>
            </div>
            <button type="submit" class="search-button">
                <img src="../Public/img/search.svg" alt="Search Icon" class="button-icon">
            </button>
        </form>

        <div class="services-container">

            <div class="service-card">
                <h3>Care at your home</h3>
                <img src="../Public/img/home-care.svg" alt="home care">
                <p>Find out more</p>
            </div>

            <div class="service-card">
                <h3>Care at the petsitter's home</h3>
                <img src="../Public/img/petsitter-care.svg" alt="petsitter care">
                <p>Find out more</p>
            </div>

            <div class="service-card">
                <h3>Walking the dog</h3>
                <img src="../Public/img/dog-walking.svg" alt="dog walking">
                <p>Find out more</p>
            </div>
        </div>
    </main>
</body>
</html>