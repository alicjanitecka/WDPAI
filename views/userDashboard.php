<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="../Public/css/userDashboard.css"/>
    <title>PetZone - Dashboard</title>
</head>
<body>

    <nav class="navbar">

        <div class="nav-links">
            <a href="#" class="nav-item">
                <img src="../Public/img/home.svg" alt="">
                home
            </a>



            <a href="#" class="nav-item">
                <img src="../Public/img/pet.svg" alt="">
                my visits
            </a>
            <!-- <a href="#" class="nav-item">
                <img src="../Public/img/pet.svg" alt="">
                become a petsitter
            </a> -->
<!-- 
            <a href="#" class="nav-item">
                <img src="../Public/img/logout.svg" alt="">
                log out
            </a> -->
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
 