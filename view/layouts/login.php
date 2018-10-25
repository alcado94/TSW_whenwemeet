<?php
    //file: view/users/login.php

    require_once(__DIR__."/../../core/ViewManager.php");
    $view = ViewManager::getInstance();
    $view->setVariable("title", "WhenWeMeet: ".i18n("Enter or register") );
    $errors = $view->getVariable("errors");
?>

<div class="container">

        <div class="logmod">
            <div class="logmod__wrapper">
                <div class="logmod__container">
                <?= isset($errors["general"])?$errors["general"]:"" ?>
                    <ul class="logmod__tabs">
                        <li data-tabtar="lgm-2"><a href="#"><?= i18n("Sign in") ?></a></li>
                        <li data-tabtar="lgm-1"><a href="#"><?= i18n("Sign up") ?></a></li>
                    </ul>
                    <div class="logmod__tab-wrapper">
                        <div class="logmod__tab lgm-1">
                            <div class="logmod__heading">
                                <span class="logmod__heading-subtitle"><?= i18n("Enter your personal data to create an account") ?></span>
                            </div>
                            <div class="logmod__form">
                                <form accept-charset="utf-8" action="index.php?controller=users&amp;action=register" method="POST"  class="simform" enctype="multipart/form-data">
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label class="string optional" for="user-name"><?= i18n("Login") ?>*</label>
                                            <input class="string optional" maxlength="255" id="login" name="login" placeholder="<?= i18n("Login") ?>"
                                                type="text" size="50" />
                                        </div>
                                    </div>
                                    <div class="sminputs">
                                        <div class="input string optional">
                                            <label class="string optional" for="user-pw"><?= i18n("Name") ?> *</label>
                                            <input class="string optional" maxlength="255" id="name" name="name" placeholder="<?= i18n("Name") ?>"
                                                type="text" size="50" />
                                        </div>
                                        <div class="input string optional">
                                            <label class="string optional" for="user-pw-repeat"><?= i18n("Surname") ?> *</label>
                                            <input class="string optional" maxlength="255" id="surname" name="surname"
                                                placeholder="<?= i18n("Surname") ?>" type="text" size="50" />
                                        </div>
                                    </div>
                                    <div class="sminputs">
                                        <div class="input string optional">
                                            <label class="string optional" for="user-pw"><?= i18n("Password") ?> *</label>
                                            <input class="string optional" maxlength="255" id="passwd" placeholder="<?= i18n("Password") ?>" name="passwd"
                                                type="password" size="50" />
                                        </div>
                                        <div class="input string optional">
                                            <label class="string optional" for="user-pw-repeat"><?= i18n("Repeat password") ?> *</label>
                                            <input class="string optional" maxlength="255" id="user-pw-repeat"
                                                placeholder="<?= i18n("Password") ?>" type="password" size="50" />
                                        </div>
                                    </div>
                                    <div class="simform__actions">
										<div>
											<label class="string optional" for="user-pw"><?= i18n("Image") ?> (JPG)</label>
											<input type="file" class="string optional" maxlength="45"  id="img" name="img" tabindex="1" accept="image/jpg" required>
										</div>
                                        <input class="sumbit" name="commit" type="submit" value="<?= i18n("Create account") ?>" />
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                        <div class="logmod__tab lgm-2">
                            <div class="logmod__heading">
                                <span class="logmod__heading-subtitle"><?= i18n("Enter your login and password to sign in") ?></strong></span>
                            </div>
                            <div class="logmod__form">
                                <form accept-charset="utf-8" action="index.php?controller=users&amp;action=login" method="POST" class="simform">
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label class="string optional" for="user-name"><?= i18n("Login") ?>*</label>
                                            <input class="string optional" name="login" maxlength="255" id="user-email" placeholder="<?= i18n("Login") ?>"
                                                 size="50" />
                                        </div>
                                    </div>
                                    <div class="sminputs">
                                        <div class="input full">
                                            <label class="string optional" for="user-pw"><?= i18n("Password") ?> *</label>
                                            <input class="string optional" name="passwd" maxlength="255" id="user-pw" placeholder="<?= i18n("Password") ?>"
                                                type="password" size="50" />
                                            <span class="hide-password"><?= i18n("Show") ?></span>
                                        </div>
                                    </div>
                                    <div class="simform__actions">
                                        <input class="sumbit" name="commit" type="submit" value="<?= i18n("Enter") ?>" />
                                        
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
