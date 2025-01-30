<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Public/css/findAPetsitter.css"/>
    <title>PetZone - Find A Petsitter</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../Public/img/logo.svg" alt="PetZone">
        </div>
        <div class="nav-links">
            <a href="#" class="nav-item">
                <img src="../Public/img/home.svg" alt="">
                home
            </a>
            <a href="#" class="nav-item">
                <img src="../Public/img/search.svg" alt="">
                find a petsitter
            </a>
            <a href="#" class="nav-item">
                <img src="../Public/img/calendar.svg" alt="">
                my visits
            </a>
            <a href="#" class="nav-item">
                <img src="../Public/img/login.svg" alt="">
                my account
            </a>
            <a href="#" class="nav-item">
                <img src="../Public/img/logout.svg" alt="">
                log out
            </a>
        </div>
    </nav>

    <main>

        <div class="search-bar">
            <div class="search-item">
                <img src="../Public/img/calendar.svg" alt="calendar">
                <input type="text" placeholder="choose the date">
            </div>
            <div class="search-item">
                <img src="../Public/img/home.svg" alt="home">
                <input type="text" placeholder="enter the address">
            </div>
            <div class="search-item">
                <img src="../Public/img/pet.svg" alt="pet">
                <input type="text" placeholder="choose your pet">
            </div>

            <button type="submit" class="search-button">
                <img src="../Public/img/search.svg" alt="Search Icon" class="button-icon">
            </button>
            
        </div>

        <div class="sort-dropdown">
                <select>
                    <option>sort by (default)</option>
                </select>
        </div>

        <div class="petsitter-list">
            <?php foreach ($petsitters as $petsitter): ?>
                <div class="petsitter-card">
                    <div class="profile-image"></div>
                    <div class="petsitter-info">
                        <h3><?= htmlspecialchars($petsitter['first_name']) ?> </h3>
                        <p>Services offered: <?= PetsitterRepository::getServicesOffered($petsitter) ?></p>
                        <p>Service Location: <?= PetsitterRepository::getServiceLocations($petsitter) ?></p>
                    </div>
                    <button class="book-btn">+ book now</button>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>&service_type=<?= $serviceType ?>&<?= http_build_query(['pets' => $petIds]) ?>" <?= $i == $currentPage ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>
        </div>

    </main>
</body>
</html>
