<script language="JavaScript" type="text/javascript">
    <?php if($status == 'success') :?>
    window.parent.document.getElementById('screensaver_img').src='<?php echo base_url()?>webroot/media/upload/<?php echo $name;?>';
    window.parent.document.getElementById('Filedata2').value='';
    <?php endif;?>
</script>
