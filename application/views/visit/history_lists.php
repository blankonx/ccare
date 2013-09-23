<?php if(!empty($history)) :?>
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
        $('#list_hi').load(this.href);
        return false;
    });
});
</script>
<div class="paging"><?php echo $links;?></div>
<?php for($i=0;$i<sizeof($history);$i++) :?>
<a class="link_history_list_all" href="<?php echo base_url()."visit/history/detail/".$history[$i]['id'];?>">
    <div class="history_list_all">
        <div>
            <?php echo $history[$i]['clinic'] ?> <em>(<?php echo $history[$i]['datediff'];?>&nbsp;&nbsp;<span style="font-style:normal;font-size:8pt;font-weight:bold;"><?php echo $history[$i]['date'] ?></span>)
            <span style="font-style:normal;font-size:8pt;font-weight:bold;color:#333333"><?php echo $history[$i]['diagnose']?></span>
            </em>
        </div>
    </div>
</a>
<div class="history_list_detail" style="display:none;margin:0 18px 0 12px;float:center;height:auto;background:#BAD260;overflow:visible;padding:0 0 0 65px;"></div>
<?php endfor;?>

<div class="paging"><?php echo $links;?></div>
<!-- <div class="" style="background:url('../webroot/media/images/LembarPemeriksaanRawatJalan.gif') no-repeat;height:196px;width:945px;"></div> -->
<?php endif;?>