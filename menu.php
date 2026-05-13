
<ul id="menu">
    <li><a href="home.php">HOME</a></li>
    <li><a href="facciamo.php">COSA FACCIAMO</a></li>
    <li><a href="contatto.php">CONTATTI</a></li>
    <?php if (isset($_SESSION['ruolo'])): ?>
        <?php if ($_SESSION['ruolo'] === 'admin'): ?>
            <li><a href="admin.php">AREA ADMIN</a></li>
        <?php else: ?>
            <li><a href="area_utente.php">AREA RISERVATA</a></li>
        <?php endif; ?>
        <li><a href="logout.php">LOGOUT</a></li>
    <?php else: ?>
        <li><a href="login.php">LOGIN</a></li>
    <?php endif; ?>
</ul>


