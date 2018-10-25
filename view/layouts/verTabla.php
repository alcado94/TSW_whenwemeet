
<?php
//file: view/posts/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$poll = $view->getVariable("poll");

$view->setVariable("title", $poll['titulo']);

$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
$url = explode("?",$escaped_url);
$link = $url[0]."?poll=".$poll['url'];
?>

<div class="container">
        
        <div class="info-meeting">
            <h2><?php echo $poll['titulo']; ?></h2>
            <h6><?php echo $poll['autor']; ?></h6>
            <h5><?php echo count($poll['participantes']); ?> <?= i18n("members") ?></h5>
        </div>
		<a href="<?php echo $link?>"><?php echo $link?></a>
	<div class="edit-poll-set">
            
            <a href="index.php?controller=poll&amp;action=participatePoll&amp;id=<?php echo $poll['id']; ?>"><?= i18n("Modify participation") ?></a>
        <div class="edit-poll">
            <input type="button" value="">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M17 12.645v-2.289c-1.17-.417-1.907-.533-2.28-1.431-.373-.9.07-1.512.6-2.625l-1.618-1.619c-1.105.525-1.723.974-2.626.6-.9-.374-1.017-1.117-1.431-2.281h-2.29c-.412 1.158-.53 1.907-1.431 2.28h-.001c-.9.374-1.51-.07-2.625-.6l-1.617 1.619c.527 1.11.973 1.724.6 2.625-.375.901-1.123 1.019-2.281 1.431v2.289c1.155.412 1.907.531 2.28 1.431.376.908-.081 1.534-.6 2.625l1.618 1.619c1.107-.525 1.724-.974 2.625-.6h.001c.9.373 1.018 1.118 1.431 2.28h2.289c.412-1.158.53-1.905 1.437-2.282h.001c.894-.372 1.501.071 2.619.602l1.618-1.619c-.525-1.107-.974-1.723-.601-2.625.374-.899 1.126-1.019 2.282-1.43zm-8.5 1.689c-1.564 0-2.833-1.269-2.833-2.834s1.269-2.834 2.833-2.834 2.833 1.269 2.833 2.834-1.269 2.834-2.833 2.834zm15.5 4.205v-1.077c-.55-.196-.897-.251-1.073-.673-.176-.424.033-.711.282-1.236l-.762-.762c-.52.248-.811.458-1.235.283-.424-.175-.479-.525-.674-1.073h-1.076c-.194.545-.25.897-.674 1.073-.424.176-.711-.033-1.235-.283l-.762.762c.248.523.458.812.282 1.236-.176.424-.528.479-1.073.673v1.077c.544.193.897.25 1.073.673.177.427-.038.722-.282 1.236l.762.762c.521-.248.812-.458 1.235-.283.424.175.479.526.674 1.073h1.076c.194-.545.25-.897.676-1.074h.001c.421-.175.706.034 1.232.284l.762-.762c-.247-.521-.458-.812-.282-1.235s.529-.481 1.073-.674zm-4 .794c-.736 0-1.333-.597-1.333-1.333s.597-1.333 1.333-1.333 1.333.597 1.333 1.333-.597 1.333-1.333 1.333z"/></svg>
        </div>
	</div>
        <div class="container table-autoscroll" id="style-6">
            <div class="divTable">
                <div class="divTableBody">
                    <div class="divTableColumn divTableColumnAvatar">
                        <div class="divTableCell">&nbsp;</div>
                        <?php foreach($poll['participantes'] as $k => $v): ?>
                            <div class="divTableCell divTableCellAvatar">
                            
                                <?php if($poll['participantesImg'][$k] != '') { ?>
                                    <img alt="Avatar" class="avatar" src="<?php echo $poll['participantesImg'][$k] ?>">
                                <?php } else { ?>
                                    <img alt="Avatar" class="avatar" src="https://epilawg.com/wp-content/uploads/2013/12/Professional-Photo-square.jpg">
                                <?php } ?>
                                <h6><?php echo $v; ?></h6>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php foreach($poll['dias'] as $dia => $horas): ?>
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
                        <?php } endforeach; ?>
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
                            <div class="divTableCellSchedule">
                                <?php foreach($horas as $hora => $estados): 
                                    if($estados[$k] == 1){
                                    ?>
                                    <div class="divTableCell"><svg class="check-accept" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 4.685l-16.327 17.315-7.673-9.054.761-.648 6.95 8.203 15.561-16.501.728.685z"/></svg></div>
                                    <?php
                                        }else{
                                    ?>
                                    <div class="divTableCell"><svg class="check-reject" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z"/></svg></div>
                                <?php 
                                    } 
                                    endforeach; 
                                    ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="divTableCellScheduleMobile">
                            <?php 
                                foreach($horas as $hora => $estados): 
                                    $ch = 0;
                                    foreach($estados as $estado): 
                                        if($estado == 1){
                                            $ch++;
                                        }
                                    endforeach;
                                ?>
                                    
                                <div class="divTableCell"><h5><?php echo $ch; ?></h5><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 4.685l-16.327 17.315-7.673-9.054.761-.648 6.95 8.203 15.561-16.501.728.685z"/></svg></div>
                            <?php endforeach; ?>     
                        </div>
                    </div>

                    <?php endforeach; ?>
                    
                    
                </div>
            </div>
                
        </div>
    </div>
