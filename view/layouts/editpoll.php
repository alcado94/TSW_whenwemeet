

<?php
//file: view/posts/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$poll = $view->getVariable("poll");


?>

<div class="container">
        <div class="container">
            <div class="logmod__wrapper">
                <form id="formT" class="logmod__container_add_day" action="index.php?controller=poll&amp;action=edit&amp;id=<?php echo $poll['Id'] ?>" method="POST">
                    <ul class="logmod__tabs">
                        <div class="sminputs">
                            <div class="input full">
                                <label class="string optional" for="user-name">Titulo</label>
                                <input class="string optional" required maxlength="255" id="user-email" placeholder="Titulo" name="title" type="text" size="50" value="<?php echo $poll['title']; ?>">
                            </div>
                        </div>
                    </ul>
                    <div  class="schedule-pos table-autoscroll">
                    <?php
                            $indexdia = 0;
                            foreach ($poll['dias'] as $key => $value) : ?>
                        <div class="schedule-day pre-schedule-day">

                        
                            <label class="string optional" for="user-name">Dia</label>
                            <div>
                                <input class="input-date noedit" type="date" name="dayPred[<?php echo $indexdia; ?>][0]" id="" value="<?php echo $key; ?>" readonly>
                                <button class="btn btn-small-day"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button>
                            </div>
                            
                            <?php 
                                $indexhoras = 1;
                                $i=0;
                                foreach ($value as $keyhoras => $valuehoras) :  ?>
                                <div class="schedule-date" id="dia0">
                                    <div class="schedule-date-pos">
                                        <input type="time" name="dayExist[<?php echo $poll['diasId'][$key][$i] ?>]" class="timeIn noedit" value="<?php echo $valuehoras['Init']; ?>" readonly>
                                        <input type="time" name="dayExist[<?php echo $poll['diasId'][$key][$i++] ?>]" class="timeIn noedit" value="<?php echo $valuehoras['End']; ?>" readonly>
                                    </div>
                                    <button class="btn btn-small"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button>
                                </div>
                            <?php endforeach; ?>
                            <input type="button" value="Añadir Hora" class="btn btn-time">
                        </div>
                        <?php endforeach; ?>
                        
                    </div>
                    <div class="errors-date"></div>
                    <div class="add-day" id="AñadirFecha" >
                        <input type="button" value="" >
                        <svg class="add-day-icon" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 15h4.071v2h-4.071v4.071h-2v-4.071h-4.071v-2h4.071v-4.071h2v4.071zm-8 6h-12v-2h12v2zm0-4.024h-12v-2h12v2zm0-3.976h-12v-2h12v2zm12-4h-24v-2h24v2zm0-4h-24v-2h24v2z"/></svg>
                    </div>
                </form>
            </div>
        </div>
        <div class="accept-poll-banner">
            <div class="accept-poll-banner-pos">
                <button id="enviarformEdit" class="btn btn-primary">Enviar</button>
            </div>

        </div>
    </div>
    