<?php

/* draws a calendar */
function draw_calendar($month, $year){

	$today = date('j');
	
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	
	$calendar .= "<thead class='calendar-header'><tr><th colspan='7'>" . date("F", mktime(0, 0, 0, $month, 10)) . ", " . $year . "</th></tr></thead>";
	$calendar .= "<tbody class='calendar-body' id='selectable'>";
	
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		if (strlen($list_day) == 2){
			$gate = $list_day;
		} else {
			$gate = '0' . $list_day;
		}
		
		$calendar.= ($list_day >= date('j')) ? "<td class='calendar-day' id='" . $month . '.' . $gate . "'>" : "<td class='calendar-day-gone'>";
			/* add in the day number */
			$calendar.= ($list_day >= date('j')) ? '<div class="day-number">'.$gate.'</div>' : '<div class="day-number-gone">'.$gate.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			//$calendar.= str_repeat('<p> </p>',2);
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week > 8):				/* NOTE: Not sure whether it should be greater than or less than! */
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';
	
	$calendar .= "</tbody>";
	
	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}
