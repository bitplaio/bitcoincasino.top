<?php
// =============================================================================
// Our theme messages
// =============================================================================

function poka_printmsg($item,$output=false){
    $poka_msgs = array(
        'inactive_widgets' => __("Please go to Appearance > Widgets and activate the widgets you want.","poka"),
        'set_home_tpl' => __("You can import the demo content and then you can edit the Homepage that will be created. If you don't want to import the demo content, you can create a page and then set it as Homepage at Settings/Reading.","poka"),
        'rating_error' => __("You have already voted","poka"),
        'rating_success' => __("Thanks for your vote!","poka")
    );
    if( $output === false ){
        echo $poka_msgs[$item];
    } else {
        return $poka_msgs[$item];
    }
}

