<?php

function parseStufen($description) {
	$stufen = null;
	preg_match('/\[(W)?(J)?(P)?(R)?(L)?(E)?\]/i', $description, $stufen);
	$result = new stdClass();
	$result->woes = !empty($stufen[1]);
	$result->jupfis = !empty($stufen[2]);
	$result->pfadis = !empty($stufen[3]);
	$result->rover = !empty($stufen[4]);
	$result->leiter = !empty($stufen[5]);
	$result->eltern = !empty($stufen[6]);
	return $result;
}

function renderDate($jsonDate, $end = false) {
	$dateStr = isset($jsonDate->dateTime) ? $jsonDate->dateTime : $jsonDate->date;
	$timestamp = strtotime($dateStr);
	$dt = new DateTime("now", new DateTimeZone('Europe/Berlin'));
	$dt->setTimestamp($timestamp - ($end ? (60 * 60 * 12) : 0));
	return renderWeekday($dt->format('w')) . ' ' . $dt->format('d.m.Y');
}

function renderTime($jsonDate, $end = false) {
	$dateStr = isset($jsonDate->dateTime) ? $jsonDate->dateTime : $jsonDate->date;
	$timestamp = strtotime($dateStr);
	$dt = new DateTime("now", new DateTimeZone('Europe/Berlin'));
	$dt->setTimestamp($timestamp - ($end ? (60 * 60 * 12) : 0));
	return $dt->format('H:i'). ' Uhr';
}

function getDurationInHours($startJsonDate, $endJsonDate) {
	$startStr = isset($startJsonDate->dateTime) ? $startJsonDate->dateTime : $startJsonDate->date;
	$endStr = isset($endJsonDate->dateTime) ? $endJsonDate->dateTime : $endJsonDate->date;
	$start = strtotime($startStr);
	$end = strtotime($endStr);
	return ($end - $start) / 60 / 60;
}

function renderWeekday($weekday) {
	switch ($weekday) {
		case 0:
			return 'So.';
		case 1:
			return 'Mo.';
		case 2:
			return 'Di.';
		case 3:
			return 'Mi.';
		case 4:
			return 'Do.';
		case 5:
			return 'Fr.';
		case 6:
			return 'Sa.';
	}
}


function shortcode_google_calendar($attr) {
    if(!isset($attr['id'])) {
        return '"google_calendar" short-code requires an attribute "id".';
    }
    
    $slim = isset($attr['slim']) && $attr['slim'] == 'true';

    $nowMinusTwoWeeks = date('Y-m-d', time() - (60 * 60 * 24 * 14));
    $nowPlusOneYear = date('Y-m-d', time() + (60 * 60 * 24 * 30 * 12));
    
    $filterParams = 'orderBy=startTime&singleEvents=true&timeMin=' . $nowMinusTwoWeeks . 'T00:00:00Z&timeMax=' . $nowPlusOneYear . 'T00:00:00Z';
    
    $json = file_get_contents("https://content.googleapis.com/calendar/v3/calendars/" . $attr['id'] . "/events?" . $filterParams . "&key=" . get_theme_mod('google_calendar_api_key'));
    $calendar = json_decode($json);

    ob_start();
    ?>

    <style>
      .termine table {
        width: 100%;
        border-spacing: 0;
        border: 5px solid #fff;
        box-shadow: 0px 1px 0px #ccd6dd;
      }
      
      .termine thead tr,
      .termine tbody tr:nth-child(even) {
        background: #fff;
      }
      
      .termine td {
        padding: 10px;
      }
      
      .termine td.title {
        width: 50%;
      }

      .termine.slim .tn {
        max-width: 115px;
      }
      
      .termine .legende {
        padding-top: 10px;
      }

      .termine img,
      .termine-legende img  {
        padding-right: 5px;
        height: 20px;
        border: 0;
        box-shadow: none;
      };
    </style>

    
    <div class="termine<?php if($slim) echo ' slim' ?>">
        <table>
            <?php if (!$slim) { ?>
            <thead>
                <tr>
                    <td>Datum</td>
                    <td>Aktion</td>
                    <td>Teilnehmer</td>
                </tr>
            </thead>
            <?php } ?>
            <tbody>
                <?php
                foreach ($calendar->items as $item) {
                    $stufen = parseStufen($item->description);
                    $durationInHours = getDurationInHours($item->start, $item->end);
                    if (!$stufen->woes && !$stufen->jupfis && !$stufen->pfadis && !$stufen->rover && !$stufen->leiter && !$stufen->eltern) continue;
                    
                    if($slim) {
                    ?>
                    <tr>
                        <td>
                            <b><?=$item->summary;?></b><br>
                            <i>
                            <?php
                            if ($durationInHours <= 4) {
                              echo renderDate($item->start, $slim) . ', ' . renderTime($item->start);
                            } else if ($durationInHours <= 24) {
                              echo renderDate($item->start, $slim);
                            } else {
                              echo renderDate($item->start) . ' -<br>' . renderDate($item->end, true);
                            }
                            ?>
                            </i>
                            
                        </td>
                        <td class="tn">
                            <?=($stufen->woes ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/woes.png" title="Wölflinge">' : '');?>
                            <?=($stufen->jupfis ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/jupfis.png" title="Jungpfadfinder">' : '');?>
                            <?=($stufen->pfadis ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/pfadis.png" title="Pfadfinder">' : '');?>
                            <?=($stufen->rover ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/rover.png" title="Rover">' : '');?>
                            <?=($stufen->leiter ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/leiter.png" title="Leiter">' : '');?>
                            <?=($stufen->eltern ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/eltern.png" title="Eltern">' : '');?>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <td>
                            <?php
                            if ($durationInHours <= 4) {
                              echo renderDate($item->start, $slim) . '<br>' . renderTime($item->start);
                            } else if ($durationInHours <= 24) {
                              echo renderDate($item->start, $slim);
                            } else {
                              echo renderDate($item->start) . ' -<br>' . renderDate($item->end, true);
                            }
                            ?>
                        </td>
                        <td class="title"><b><?=$item->summary;?></b></td>
                        <td class="tn">
                            <?=($stufen->woes ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/woes.png" title="Wölflinge">' : '');?>
                            <?=($stufen->jupfis ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/jupfis.png" title="Jungpfadfinder">' : '');?>
                            <?=($stufen->pfadis ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/pfadis.png" title="Pfadfinder">' : '');?>
                            <?=($stufen->rover ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/rover.png" title="Rover">' : '');?>
                            <?=($stufen->leiter ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/leiter.png" title="Leiter">' : '');?>
                            <?=($stufen->eltern ? '<img src="'.get_stylesheet_directory_uri().'/images/calendar-lilien/eltern.png" title="Eltern">' : '');?>
                        </td>
                    </tr>
                    <?php
                    }
                }
                ?>
            </tbody>
        </table>
    
      <div class="legende">
          Legende:
          <img src="<?=get_stylesheet_directory_uri();?>/images/calendar-lilien/woes.png" title="Wölflinge"> Wölflinge | 
          <img src="<?=get_stylesheet_directory_uri();?>/images/calendar-lilien/jupfis.png" title="Jungpfadfinder"> Jungpfadfinder | 
          <img src="<?=get_stylesheet_directory_uri();?>/images/calendar-lilien/pfadis.png" title="Pfadfinder"> Pfadfinder | 
          <img src="<?=get_stylesheet_directory_uri();?>/images/calendar-lilien/rover.png" title="Rover"> Rover |
          <img src="<?=get_stylesheet_directory_uri();?>/images/calendar-lilien/leiter.png" title="Leiter"> Leiter | 
          <img src="<?=get_stylesheet_directory_uri();?>/images/calendar-lilien/eltern.png" title="Eltern"> Eltern
      </div>
    </div>
    <?php

    return ob_get_clean();
}

add_shortcode("google_calendar", "shortcode_google_calendar");
