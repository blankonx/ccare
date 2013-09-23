<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
        Surat Keterangan Sakit
    </div>
    <div style="text-align:center;">No. <?php echo $detail['no']?></div><br/>
    Yang bertanda tangan dibawah ini <b><?php echo $detail['doctor'];?></b><br/>
    Menerangkan dengan sebenarnya bahwa :<br/><br/>
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="width:150px;"><?php echo $this->lang->line('label_name');?></td>
            <td>:&nbsp;<?php echo $detail['name'];?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('label_sex');?></td>
            <td>:&nbsp;<?php echo $detail['sex'];?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('label_place_date_of_birth');?></td>
            <?php
                $age = ''; $xage = '';
                $age = getAge($detail['birth_date']);
                if($age['year'] != 0) $xage = $age['year'] . 'yr ';
                if($age['month'] != 0) $xage .= $age['month'] . 'mo ';
                if($age['day'] != 0) $xage .= $age['day'] . 'dy';
            ?>
            <td>:&nbsp;<?php echo $detail['birth_place'] . ", " . tanggalIndo($detail['birth_date'], 'd/m/Y');?> (<?php echo $xage;?>)</td>
        </tr>
        <!-- <tr>
            <td><b><?php echo $this->lang->line('label_address');?></b></td>
            <td><?php echo $detail['address'];?></td>
        </tr> -->
        <!-- <tr>
            <td><b><?php echo $this->lang->line('label_job');?></b></td>
            <td><?php echo $detail['job'];?></td>
        </tr> -->
    </table><br/>
	Membutuhkan istirahat selama <?php echo $detail['permit_day'];?> hari.
    <?php echo $detail['explanation']?><br/>
    <br/>Terimakasih.
    <div style="margin-top:2cm;"></div>
    <div style="float:left;width:9cm;text-align:center;margin-left:9cm">
        Gunung Kidul, <?php echo tanggalIndo(date('Y-m-d'), 'd F Y');?><br/>
        Dokter Pemeriksa<br/><br/><br/>
        <?php echo $detail['doctor'];?>
    </div>
</div>
