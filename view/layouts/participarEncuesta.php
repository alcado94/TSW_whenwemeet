<?php 

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$poll = $view->getVariable("poll");

$view->setVariable("title", i18n("Participating in ").$poll['titulo']);

?>
<div class="container">


        <div class="info-meeting">
            <h2><?php echo $poll['titulo']; ?></h2>
            <h6><?php echo $poll['autor']; ?></h6>
            <h5><?php echo count($poll['participantes']); ?> <?= i18n("members") ?></h5>
        </div>
        <div class="container table-autoscroll" id="style-6">
            <div class="divTable">
                <form class="divTableBody" id="form" action="index.php?controller=poll&amp;action=participatePoll&amp;id=<?php echo $poll['id'] ?>" method="POST">
                    <div class="divTableColumn divTableColumnAvatar">
                        <div class="divTableCell">&nbsp;</div>
                        <?php foreach($poll['participantes'] as $k => $part): ?>
                            <?php if($k == 0){ ?>
                                <div class="divTableCell divTableCellAvatar divTableCellAddLeft">
                                <?php if($poll['participantesImg'][$k] != '') { ?>
                                    <img alt="Avatar" class="avatar" src="<?php echo $poll['participantesImg'][$k] ?>">
                                <?php } else { ?>
                                    <img alt="Avatar" class="avatar" src="https://epilawg.com/wp-content/uploads/2013/12/Professional-Photo-square.jpg">
                                <?php } ?>
                                    <h6><?php echo $part; ?></h6>
                                </div>
                            <?php } else { ?>
                                <div class="divTableCell divTableCellAvatar">
                                <?php if($poll['participantesImg'][$k] != '') { ?>
                                    <img alt="Avatar" class="avatar" src="<?php echo $poll['participantesImg'][$k] ?>">
                                <?php } else { ?>
                                    <img alt="Avatar" class="avatar" src="https://epilawg.com/wp-content/uploads/2013/12/Professional-Photo-square.jpg">
                                <?php } ?>
                                <h6><?php echo $part; ?></h6>
                            </div>
                            <?php } ?>
                        <?php endforeach; ?>
                        
                    </div>
                    <?php $indexDiasId = 0; foreach($poll['dias'] as $dia => $horas): ?>
                    <div class="divTableColumn" id="<?php $diaParts = explode('-', $dia); echo $diaParts[2].$diaParts[1]; ?>">
                        <div class="divTableCell cellDay ">
                            <h5>
                            <?php 
                                switch ($diaParts[1]) {
                                    case '01':
                                        echo "Ene";
                                        break;
                                    case '02':
                                        echo "Feb";
                                        break;
                                    case '03':
                                        echo "Mar";
                                        break;
                                    case '04':
                                        echo "Abr";
                                        break;
                                    case '05':
                                        echo "May";
                                        break;
                                    case '06':
                                        echo "Jun";
                                        break;
                                    case '07':
                                        echo "Jul";
                                        break;
                                    case '08':
                                        echo "Ago";
                                        break;
                                    case '09':
                                        echo "Sep";
                                        break;
                                    case '10':
                                        echo "Oct";
                                        break;
                                    case '11':
                                        echo "Nov";
                                        break;
                                    case '12':
                                        echo "Dic";
                                        break;
                                }
                            ?>
                            </h5>
                            <h4><?php $diaParts = explode('-', $dia); echo $diaParts[2]; ?></h4>
                        </div>
                        <?php foreach($poll['participantes'] as $k => $v): ?>
                        
                            <?php if($k == 0){ ?>
                                <div class="divTableCell divTableCellAdd"><svg class="check-nocomplete" width="24" height="24"
                                        xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                        <path d="M24 4.685l-16.327 17.315-7.673-9.054.761-.648 6.95 8.203 15.561-16.501.728.685z" /></svg></div>
                            <?php } else { ?>
                                <?php 
                                    $ch = array();
                                    foreach($horas as $hora => $estados): 
                                        array_push($ch,$estados[$k]);
                                    endforeach;

                                    if(in_array(1,$ch) & !in_array(0,$ch)){
                                ?>
                                        <div class="divTableCell"><svg class="check-accept" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 4.685l-16.327 17.315-7.673-9.054.761-.648 6.95 8.203 15.561-16.501.728.685z"/></svg></div>
                                <?php 
                                    }else if(in_array(1,$ch)){
                                ?>
                                        <div class="divTableCell"><svg class="check-nocomplete" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 4.685l-16.327 17.315-7.673-9.054.761-.648 6.95 8.203 15.561-16.501.728.685z"/></svg></div>
                                <?php 
                                    }else {
                                ?>
                                        <div class="divTableCell"><svg class="check-reject" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z"/></svg></div>
                                <?php } ?>
                            <?php } ?>
                        <?php endforeach; ?>

                        
                        
                    </div>
                    <div class="divTableColumnSchedule" id="<?php $diaParts = explode('-', $dia); echo $diaParts[2].$diaParts[1]; ?>Sched">
                        <div class="divTableCellSchedule divTableCellScheduleHour">
                            <?php foreach($horas as $hora => $estados): ?>
                                <div class="divTableCell">
                                    <div class="divTableCellHour">
                                        <span><?php $horaParts = explode('-', $hora); echo substr($horaParts[0], 0, -3); ?></span>
                                        <span><?php $horaParts = explode('-', $hora); echo substr($horaParts[1], 0, -3); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php foreach($poll['participantes'] as $k => $v): ?>
                        
                            <?php if($k == 0){ ?>
                                
                                <div class="divTableCellSchedule divTableCellAddCheckbox">

                                    <?php  foreach($horas as $hora => $estados): ?>
                                        <div class="divTableCell">
                                            <div class="exp">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="participateDate[<?php echo $poll['diasId'][$indexDiasId++];?>]" 
                                                        id="participate<?php echo str_replace("-", "", $dia); echo str_replace(":", "", str_replace("-", "", $hora));?>"
                                                        <?php if($estados[$k] == 1){ echo 'checked'; } ?>/>
                                                    <label for="participate<?php echo str_replace("-", "", $dia); echo str_replace(":", "", str_replace("-", "", $hora));?>" >
                                                        <span ></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>

                            <?php } else { ?>
                            
                                <div class="divTableCellSchedule">

                                    <?php foreach($horas as $hora => $estados): ?>
                                        <?php if($estados[$k] == 1){ ?>
                                            <div class="divTableCell"><svg class="check-accept" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 4.685l-16.327 17.315-7.673-9.054.761-.648 6.95 8.203 15.561-16.501.728.685z"/></svg></div>
                                            <?php
                                                }else{
                                            ?>
                                            <div class="divTableCell"><svg class="check-reject" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z"/></svg></div>
                                        <?php } ?>
                                    <?php endforeach; ?>

                                </div>
                            
                            <?php } ?>

                        <?php endforeach; ?>
                        
                        <div class="divTableCellScheduleMobile">
                            <?php foreach($horas as $hora => $estados): ?>
                                <div class="divTableCell">
                                    <div class="exp">
                                        <div class="checkbox">
                                            <input type="checkbox" value="" id="mparticipate<?php echo str_replace("-", "", $dia); echo str_replace(":", "", str_replace("-", "", $hora));?>"
                                            <?php if($estados[0] == 1){ echo 'checked'; } ?>/>
                                            <label for="mparticipate<?php echo str_replace("-", "", $dia); echo str_replace(":", "", str_replace("-", "", $hora));?>">
                                                <span ></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>  
                        </div>
                    </div>
                        <?php endforeach; ?>
                    </div>
                </form>
            </div>

        </div>
        <div class="accept-poll-banner">
            <div class="accept-poll-banner-pos">
                <button class="btn btn-primary" id="enviarParticipar"><?= i18n("Send") ?></button>
            </div>

        </div>
    </div>