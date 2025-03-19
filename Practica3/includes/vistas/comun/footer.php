<footer class="footer">
    <div class="footer-container">
        <div class="footer-section links">
            <h3>Enlaces</h3>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="checkout.php">Compra</a></li>
                <li><a href="miembros.php">About Us</a></li>
                <li><a href="contact.php">Contacto</a></li>
            </ul>
        </div>
        <div class="footer-section social">
            <h3>Síguenos</h3>
            <div class="social-icons">
                <a href="#"><img src="Imagenes Marca/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="Imagenes Marca/instagram.png" alt="Instagram"></a>
                <a href="#"><img src="Imagenes Marca/x.png" alt="X"></a>
            </div>
        </div>
        <div class="footer-section subscribe">
            <h3>Suscríbete</h3>
            <form>
                <input type="email" placeholder="Tu correo electrónico">
                <button type="submit">Suscribirse</button>
            </form>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 BrandSwap. Todos los derechos reservados.</p>
    </div>
</footer>

<style>
    .footer {
        background-color: #000;
        color: white;
        padding: 40px 20px;
        text-align: center;
    }
    .footer-container {
        display: flex;
        justify-content: space-around;
        align-items: flex-start;
        flex-wrap: wrap;
    }
    .footer-section {
        flex: 1;
        text-align: center;
        min-width: 200px;
    }
    .footer-section h3 {
        margin-bottom: 15px;
    }
    .footer-section ul {
        list-style: none;
        padding: 0;
    }
    .footer-section ul li {
        margin: 5px 0;
    }
    .footer-section ul li a {
        color: white;
        text-decoration: none;
    }
    .footer-section ul li a:hover {
        text-decoration: underline;
    }
    .social-icons a img {
        width: 30px;
        margin: 0 10px;
    }
    .footer-bottom {
        margin-top: 30px;
        font-size: 14px;
        border-top: 1px solid white;
        padding-top: 20px;
    }
    .footer form input {
        padding: 10px;
        border: none;
        width: 70%;
    }
    .footer form button {
        padding: 10px 15px;
        border: none;
        background: white;
        color: black;
        cursor: pointer;
        text-transform: uppercase;
    }
    .footer form button:hover {
        background: gray;
    }
</style>
