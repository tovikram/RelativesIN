<?php
date_default_timezone_set("Asia/Kolkata");

function getMonthName($index){
    $monthNameArray = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    return $monthNameArray[$index-1];
}

function getTotalMonthsCount($d1,$d2){
    $ts1 = strtotime($d1);
    $ts2 = strtotime($d2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
    return $diff;
}

function getCurrentMonthDetails($requestFor,$passedDate){
    $currentDate = date("Y-m-d") . "";
    $currentDateArray = preg_split("/-/", $currentDate);
    $passedDateArray = preg_split("/-/", $passedDate);
    $firstDateOfMonth = $passedDateArray[0]."-".$passedDateArray[1]."-01";
    $firstDayOfMonth = date('w', strtotime($firstDateOfMonth));
    $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$passedDateArray[1],$passedDateArray[0]);
    settype($firstDayOfMonth,"int");
    settype($totalDaysOfMonth,"int");
    $numberOfRows = ceil(($firstDayOfMonth + $totalDaysOfMonth)/7);
    settype($numberOfRows,"int");
    $calendarArray = array($numberOfRows);
    $calendarCellClassArray = array("0");
    $totalMonthsDiffCount = getTotalMonthsCount($passedDate,$currentDate) + 1;
    $previousMonth = date('Y-m', strtotime(date('Y-m')." -".$totalMonthsDiffCount." month"))."";
    $previousMonthArray = preg_split("/-/", $previousMonth);
    $totalDaysOfPreviousMonth = cal_days_in_month(CAL_GREGORIAN,$previousMonthArray[1],$previousMonthArray[0]);
    settype($totalDaysOfPreviousMonth,"int");
    //adding elements for previous month's dates
    $countCalendarArray = count($calendarArray);
    if($firstDayOfMonth != 0){
        for($i=$firstDayOfMonth;$i>=$countCalendarArray;$i--){
            $calendarArray[$i] = $totalDaysOfPreviousMonth;
            $calendarCellClassArray[$i] = "NA";
            $totalDaysOfPreviousMonth--;
        }
    }
    //adding elements for current month's dates
    $d = 1;
    $countCalendarArray = count($calendarArray);
    for ($i=$countCalendarArray; $i <($totalDaysOfMonth+$countCalendarArray) ; $i++) { 
        $calendarArray[$i] =$d;
        if($d."" == $currentDateArray[2] && $passedDateArray[1]==$currentDateArray[1] && $passedDateArray[0]==$currentDateArray[0]){
            $calendarCellClassArray[$i] = "TODAY";
        }else{
            $calendarCellClassArray[$i] = "A";
        }
        $d++;
    }
    //adding elements for next month's date
    $countCalendarArray = count($calendarArray);
    $nd = 1;
    for($i=$countCalendarArray;$i<=($numberOfRows*7);$i++){
        $calendarArray[$i] = $nd;
        $calendarCellClassArray[$i] = "NA";
        $nd++;
    }
    
    if($requestFor == 'getClassNames'){
        return $calendarCellClassArray;
    }else {
        return $calendarArray;
    }
}

function getMonthYearString($date,$type){
    switch ($type) {
        case 'Current':
            $preAraay = preg_split("/-/",date('Y-m', strtotime(date('Y-m')." -".(getTotalMonthsCount($date,date('Y-m-d').''))." month")));
            break;
        case 'Previous':
            $preAraay = preg_split("/-/",date('Y-m', strtotime(date('Y-m')." -".(getTotalMonthsCount($date,date('Y-m-d').'')+1)." month")));
            break;
        case 'Next':
            $preAraay = preg_split("/-/",date('Y-m', strtotime(date('Y-m')." -".(getTotalMonthsCount($date,date('Y-m-d').'')-1)." month")));
            break;
        default:
            $preAraay = preg_split("/-/",date('Y-m'));
            break;
    }
    $monthIndex = $preAraay[1];
    settype($monthIndex,'int');
    $string = getMonthName($monthIndex)." ".$preAraay[0].'';
    return $string;
}

function getLinkDate($date,$type){
    switch ($type) {
        case 'Previous':
            $preAraay = date('Y-m', strtotime(date('Y-m')." -".(getTotalMonthsCount($date,date('Y-m-d').'')+1)." month"))."-01";
            return $preAraay;
            break;
        case 'Next':
            $preAraay = date('Y-m', strtotime(date('Y-m')." -".(getTotalMonthsCount($date,date('Y-m-d').'')-1)." month"))."-01";
            return $preAraay;
            break;
        default:
            $preAraay = date('Y-m')."-01";
            return $preAraay;
            break;
    }
}

function getFullDateString($date,$day,$type){
    if($day <10){
        $day = "0".$day;
    }
    switch ($type) {
        case 'Current':
            return date('Y-m', strtotime(date('Y-m')." -".(getTotalMonthsCount($date,date('Y-m-d').''))." month"))."-".$day;
            break;
        case 'Previous':
            return date('Y-m', strtotime(date('Y-m')." -".(getTotalMonthsCount($date,date('Y-m-d').'')+1)." month"))."-".$day;
            break;
        case 'Next':
            return date('Y-m', strtotime(date('Y-m')." -".(getTotalMonthsCount($date,date('Y-m-d').'')-1)." month"))."-".$day;
            break;
        default:
            return date('Y-m')."-".$day;
            break;
    }
}

function getEventName($conn,$date){
    $query = "SELECT event_name FROM indian_calendar_2019_events WHERE event_date='".$date."'";
    $result=mysqli_query($conn,$query,MYSQLI_USE_RESULT);
    $row = mysqli_fetch_assoc($result);
    $result->close();
    return $row['event_name'];
}

?>