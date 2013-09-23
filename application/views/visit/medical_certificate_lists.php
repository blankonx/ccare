<?php if(!empty($list)) :?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('.link_history_list_all').toggle(
        function() {
            $(this).children().removeClass('history_list_all')
                .addClass('history_list_all_reverse');
            $(this).next().load(this.href, function() {
                $(this).slideDown('fast');
            });
            return false;
    },
        function() {
            $(this).children().removeClass('history_list_all_reverse')
                .addClass('history_list_all');
            $(this).next().slideUp('fast');
            return false;
    });
    /*jQuery + CI PAGINATIONZZZZZZZZZ*/
    $('.paging a').click(function() {
        //alert(this.href);
        $('#list_mc').load(this.href);
        return false;
    });
});
</script>
<div class="paging"><?php echo $links;?></div>
<?php for($i=0;$i<sizeof($list);$i++) :?>
<a class="link_history_list_all" href="medical_certificate/detail/<?php echo $list[$i]['id']?>">
    <div class="history_list_all">
        <div>
            <?php echo $list[$i]['explanation'] ?> <em>(<?php echo $list[$i]['datediff'];?>&nbsp;&nbsp;<span style="font-style:normal;font-size:8pt;font-weight:bold;"><?php echo $list[$i]['date'] ?></span>),
            <?php echo $list[$i]['doctor']?>
            </em>
        </div>
    </div>
</a>
<div class="history_list_detail" style="display:none;margin:0 18px 0 12px;float:center;height:auto;background:#BAD260;overflow:visible;padding:0 0 0 65px;"></div>
<?php endfor;?>

<div class="paging"><?php echo $links;?></div>
<?php endif;?>