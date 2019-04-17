    <?php if(isset($_SESSION['user_id'])){ ?>
    <footer class="footer">
        <div class="text">Bienvenido <?= $_SESSION['user_name'] ?></div>
        <div class="logout"><a href="/proyecto/logout.php">Desconectarse</a></div>
    </footer>
    <?php } ?>
</body>
</html>