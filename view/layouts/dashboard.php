
<?php
//file: view/posts/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$polls = $view->getVariable("polls");
$currentusername = $view->getVariable("currentusername");

$view->setVariable("title", "Posts");

?>

<div class="container">

        <div class="dashboard-title">
            <h2><span>Bienvenido,</span> <?php echo $currentusername; ?></h2>
            <a href="index.php?controller=poll&amp;action=add"><button class="btn">Crear Encuesta</button></a>
        </div>
        <div class="container">
            <div class="row card-deck">
                <?php if ($polls==NULL){
                    ?>
                        <h3>No tienes ninguna encuesta</h3>
                    <?php
                } ?>
                <?php foreach($polls as $poll): ?>
                <a href="index.php?controller=poll&amp;action=find&amp;id=<?php echo($poll->getId()); ?>" class="col-lg-3 col-md-4 col-sm-6 col-12 card ">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo($poll->getTitulo()); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $poll->getUsuarios_idcreador()->getName().' '; echo $poll->getUsuarios_idcreador()->getSurname(); ?></h6>
                        <ul class="avatars">
                            <?php for($i = 0; $i <= $poll->getNumUsrs(); $i++): ?>
                                <li>
                                    <img alt="Avatar" class="avatar" src="https://epilawg.com/wp-content/uploads/2013/12/Professional-Photo-square.jpg">
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </a>
                    
                <?php endforeach; ?>
                
            </div>
            <button type="button" class="btn btn-secondary btn-block btn-showmore">Mostrar más</button>
        </div>
    </div>
    <button type="button" class="btn-add-poll" data-toggle="tooltip" data-placement="left" title="Crear Encuesta">
        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 15h4.071v2h-4.071v4.071h-2v-4.071h-4.071v-2h4.071v-4.071h2v4.071zm-8 6h-12v-2h12v2zm0-4.024h-12v-2h12v2zm0-3.976h-12v-2h12v2zm12-4h-24v-2h24v2zm0-4h-24v-2h24v2z"/></svg>
    </button>
