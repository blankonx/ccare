<?php 
//print_r($chat);
for($i=0;$i<sizeof($chat);$i++) :
    if($chat[$i]['user_id'] == $chat[$i-1]['user_id']) : ?>
        <div class="chat_list_msg_double"><?php echo $chat[$i]['msg'];?></div>
    <?php else : ?>
        <div class="chat_list_username"><?php echo $chat[$i]['username'];?> :</div>
        <div class="chat_list_msg" style="float:left"><?php echo $chat[$i]['msg'];?></div>
        <div style="clear:both"></div>
    <?php endif;?>
<?php endfor;?>
