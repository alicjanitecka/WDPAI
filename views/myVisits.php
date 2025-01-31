<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Public/css/myVisits.css"/>
    <script src="../public/js/visits.js"></script>
    <title>PetZone - My Visits</title>
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
        <h1>MANAGE YOUR VISITS</h1>
        <div class="visits-container">
            <?php foreach($visits as $visit): ?>
                <div class="visit-card">
                    <div class="visit-date">
                    <strong>Date:</strong> <?= $visit->getStartDate() ?> - <?= $visit->getEndDate() ?>
            </div>
            
            <div class="visit-type">
                <strong>Care Type:</strong> 
                <?php 
                    $careType = $visit->getCareType();
                    echo str_replace('_', ' ', ucfirst($careType));
                ?>
            </div>

            <?php if($isPetsitter): ?>
                <div class="owner-info">
                    <strong>Owner Details:</strong>
                    <p><?= $visit->getOwnerFirstName() ?></p>
                    <p><?= $visit->getOwnerLastName() ?></p>
                    <p>Phone: <?= $visit->getOwnerPhone() ?></p>
                    <?php if($visit->getCareType() === 'owner_home' || $visit->getCareType() === 'dog_walking'): ?>
                        <p>Address: <?= $visit->getOwnerAddress() ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if(!$isPetsitter): ?>
                <div class="petsitter-info">
                    <strong>Petsitter:</strong>
                    <p><?= $visit->getPetsitterFirstName() ?></p>
                    <p><?= $visit->getPetsitterLastName() ?></p>
                    <p>Phone: <?= $visit->getPetsitterPhone() ?></p>
                    <?php if($visit->getCareType() === 'petsitter_home' && $visit->getIsConfirmed()): ?>
                        <p>Address: <?= $visit->getPetsitterAddress() ?></p>
                    <?php endif; ?>
                </div>
                
            <?php endif; ?>

            <div class="pets-info">
                <strong>Pets:</strong>
                <?php 
                $petNames = $visit->getPetNames();
                if (!empty($petNames)): ?>
                    <div class="pet-list">
                        <?php foreach($petNames as $petName): ?>
                            <div class="pet-item">
                                <!-- <img src="../Public/img/pet.svg" alt="pet"> -->
                                <span><?= htmlspecialchars($petName) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($isPetsitter): ?>
                <div class="visit-actions">
                    <?php if(!$visit->getIsConfirmed() && !$visit->getIsCanceled()): ?>
                        <button onclick="confirmVisit(<?= $visit->getId() ?>)" class="confirm-button">
                            Confirm
                        </button>
                    <?php endif; ?>
                    <?php if(!$visit->getIsCanceled()): ?>
                        <button onclick="cancelVisit(<?= $visit->getId() ?>)" class="cancel-button">
                            Cancel
                        </button>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="visit-status">
                    <?php if($visit->getIsConfirmed()): ?>
                        <span class="status confirmed">Visit is confirmed</span>
                    <?php endif; ?>
                    <?php if($visit->getIsCanceled()): ?>
                        <span class="status canceled">Visit is canceled</span>
                    <?php else: ?>
                        <button onclick="cancelVisit(<?= $visit->getId() ?>)" class="cancel-button">
                            Cancel
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
    </main>
    <script src="../public/js/visits.js"></script>
</body>
</html>
