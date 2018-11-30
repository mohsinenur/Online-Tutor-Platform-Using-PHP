<?php
class timeago 
{
  
    function time_ago($timestamp){
    
    date_default_timezone_set("Asia/Dhaka");         
    $time_ago        = strtotime($timestamp);
    $current_time    = time();
    $time_difference = $current_time - $time_ago;
    $seconds         = $time_difference;
    
    $minutes = round($seconds / 60); // value 60 is seconds  
    $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
    $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
    $weeks   = round($seconds / 604800); // 7*24*60*60;  
    $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
    $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                  
    if ($seconds <= 60){

      return "Just Now";

    } else if ($minutes <= 60){

      if ($minutes == 1){

        return "1 min ago";

      } else {

        return "$minutes mins ago";

      }

    } else if ($hours <= 24){

      if ($hours == 1){

        return "1 hr ago";

      } else {

        return "$hours hrs ago";

      }

    } else if ($days <= 7){

      if ($days == 1){

        return "yesterday";

      } else {

        return "$days days ago";

      }

    } else if ($weeks <= 4.3){

      if ($weeks == 1){

        return "1 week ago";

      } else {

        return "$weeks weeks ago";

      }

    } else if ($months <= 12){

      if ($months == 1){

        return "1 month ago";

      } else {

        return "$months months ago";

      }

    } else {
      
      if ($years == 1){

        return "1 year ago";

      } else {

        return "$years years ago";

      }
    }
  }
}
?>