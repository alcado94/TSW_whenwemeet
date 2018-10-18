
<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<div class="container">

        <div class="logmod">
            <div class="logmod__wrapper">
                <div class="logmod__container">
                <?= isset($errors["general"])?$errors["general"]:"" ?>
                    <ul class="logmod__tabs">
                        <li data-tabtar="lgm-2"><a href="#">Logueate</a></li>
                        <li data-tabtar="lgm-1"><a href="#">Registrate</a></li>
                    </ul>
                    <div class="logmod__tab-wrapper">
                        <div class="logmod__tab lgm-1">
                            <div class="logmod__heading">
                                <span class="logmod__heading-subtitle">Introduce tus datos personales <strong>para crear una cuenta</strong></span>
                            </div>
                            <div class="logmod__form">
                                <form accept-charset="utf-8" action="index.php?controller=users&amp;action=register" method="POST"  class="simform">
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label class="string optional" for="user-name">Login*</label>
                                            <input class="string optional" maxlength="255" id="login" name="login" placeholder="Correo"
                                                type="text" size="50" />
                                        </div>
                                    </div>
                                    <div class="sminputs">
                                        <div class="input string optional">
                                            <label class="string optional" for="user-pw">Name *</label>
                                            <input class="string optional" maxlength="255" id="name" name="name" placeholder="Contraseña"
                                                type="text" size="50" />
                                        </div>
                                        <div class="input string optional">
                                            <label class="string optional" for="user-pw-repeat">Surname *</label>
                                            <input class="string optional" maxlength="255" id="surname" name="surname"
                                                placeholder="Contraseña" type="text" size="50" />
                                        </div>
                                    </div>
                                    <div class="sminputs">
                                        <div class="input string optional">
                                            <label class="string optional" for="user-pw">Contraseña *</label>
                                            <input class="string optional" maxlength="255" id="passwd" placeholder="Contraseña" name="passwd"
                                                type="password" size="50" />
                                        </div>
                                        <div class="input string optional">
                                            <label class="string optional" for="user-pw-repeat">Repite Contraseña *</label>
                                            <input class="string optional" maxlength="255" id="user-pw-repeat"
                                                placeholder="Contraseña" type="password" size="50" />
                                        </div>
                                    </div>
                                    <div class="simform__actions">
                                        <input class="sumbit" name="commit" type="submit" value="Crear cuenta" />
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                        <div class="logmod__tab lgm-2">
                            <div class="logmod__heading">
                                <span class="logmod__heading-subtitle">Introduce tu email y contraseña <strong>para entrar</strong></span>
                            </div>
                            <div class="logmod__form">
                                <form accept-charset="utf-8" action="index.php?controller=users&amp;action=login" method="POST" class="simform">
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label class="string optional" for="user-name">Login*</label>
                                            <input class="string optional" name="login" maxlength="255" id="user-email" placeholder="Login"
                                                 size="50" />
                                        </div>
                                    </div>
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label class="string optional" for="user-pw">Contraseña *</label>
                                            <input class="string optional" name="passwd" maxlength="255" id="user-pw" placeholder="Contraseña"
                                                type="password" size="50" />
                                            <span class="hide-password">Mostrar</span>
                                        </div>
                                    </div>
                                    <div class="simform__actions">
                                        <input class="sumbit" name="commit" type="submit" value="Entrar" />
                                        
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>