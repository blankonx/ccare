<div class="history_list">
    <div class="resume">
        <div class="head"><span>Hasil :</span></div>
        <div class="body">
                
            <ol style="list-style-type:lower-alpha;margin:0">
                <?php for($i=0;$i<sizeof($detail);$i++) :?>
                <?php if($detail[$i]['parent_name'] != $detail[$i-1]['parent_name']) :?>
                <!-- parent menu -->
                    <?php if($i == 0) :?>
                        <li>
                            <label>
                            <b><?php echo $detail[$i]['parent_name']?></b>
                            <ol>
                                <li style="list-style-type: decimal"><?php echo $detail[$i]['name']?>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $detail[$i]['result']?></b></li>
                    <?php else :?>
                            </ol>
                        </li>
                        <li>
                            <b><?php echo $detail[$i]['parent_name']?></b>
                            <ol>
                                <li style="list-style-type: decimal"><?php echo $detail[$i]['name']?>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $detail[$i]['result']?></b></li>
                    <?php endif;?>
                <?php else :?>
                            <li style="list-style-type: decimal"><?php echo $detail[$i]['name']?>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $detail[$i]['result']?></b></li>
                <?php endif;?>
                <?php endfor;?>
            </ol>
        </div>
        <div class="foot"></div>
    </div>
    <div style="clear:both"/>
</div>
