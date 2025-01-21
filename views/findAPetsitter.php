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
            
            <div class="petsitter-card">
                <div class="profile-image"></div>
                <div class="petsitter-info">
                    <h3>TOM (30)</h3>
                    <p>Experience: 5 years</p>
                    <p>Services offered: walking the dog, cat care, dog care, overnight care</p>
                    <p>Service Location: at pet sitter's home / at owner's home / outdoors</p>
                </div>
                <button class="book-btn">+ book now</button>
            </div>

            <div class="petsitter-card">
                <div class="profile-image"></div>
                <div class="petsitter-info">
                    <h3>SARA (25)</h3>
                    <p>Experience: 2 years</p>
                    <p>Services offered: cat care, overnight care</p>
                    <p>Service Location: at owner's home</p>
                </div>
                <button class="book-btn">+ book now</button>
            </div>

            <div class="petsitter-card">
                <div class="profile-image"></div>
                <div class="petsitter-info">
                    <h3>EMILY (23)</h3>
                    <p>Experience: 1 years</p>
                    <p>Services offered: cat care, dog care, overnight care</p>
                    <p>Service Location: at owner's home / outdoors</p>
                </div>
                <button class="book-btn">+ book now</button>
            </div>
        </div>
    </main>
</body>
</html>
