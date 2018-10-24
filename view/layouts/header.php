<nav class="navbar navbar-light navbar-expand-lg" style="background-color:white">   
            <div class="container">
                    <a class="brand-title navbar-brand"  href="#"> WhenWeMeet</a>  
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Encuestas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbardrop">
                                    <a class="dropdown-item" href="index.php?controller=poll&amp;action=index">Ver encuestas</a>
                                    <a class="dropdown-item" href="index.php?controller=poll&amp;action=add">Crear encuesta</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav navbar-right">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Idioma
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbardrop">
                                    <a class="dropdown-item" href="#">Español</a>
                                    <a class="dropdown-item" href="#">Inglés</a>
                                </div>
                            </li>
                            <?php if (isset($_SESSION["currentusername"])): ?>
                                <li class=nav-item><a class="nav-link" href="index.php?controller=users&amp;action=logout">Cerrar Sesión</a></li>
                            <?php else: ?>
                                <li class=nav-item><a class="nav-link" href="index.php?controller=users&amp;action=login">Iniciar Sesión</a></li>
                            <?php endif ?>
                        </ul>
                    </div>           
            </div>       
                
</nav>