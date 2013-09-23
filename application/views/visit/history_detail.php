<div class="history_list">
    <div class="anamnese">
        <div class="head"><span>Resume :</span></div>
        <div class="body">
        <dl>
            <dt>Anamnesa &amp; Diagnosa : </dt>
            <?php 
                if(!empty($anamnese_diagnose)) : 
                    foreach($anamnese_diagnose as $key => $val) :?>
                        <dd><?php echo $val; ?></dd>
            <?php 
                    endforeach;
                else : echo '-- data not available --';
                endif;
            ?>
            <dt>Tindakan : </dt>
            <?php 
                if(!empty($treatment)) : 
                    foreach($treatment as $key => $val) :?>
                        <dd><?php echo $val; ?></dd>
            <?php 
                    endforeach;
                else : echo '-- data not available --';
                endif;
            ?>
            
            <dt>Resep : </dt>
            <?php 
                if(!empty($prescribe)) : 
                    foreach($prescribe as $key => $val) :?>
                        <dd><?php echo $val; ?></dd>
            <?php 
                    endforeach;
                else : echo '-- data not available --';
                endif;
            ?>
        </dl>
        </div>
        <div class="foot"></div>
    </div>
    <div class="anamnese">
        <div class="head"><span>Anamnesa :</span></div>
        <div class="body">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="width:150px;"><b><?php echo $this->lang->line('label_blood_pressure');?></b></td>
                    <td><?php echo $detail['blood_pressure'];?> mmhg</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_temperature');?></b></td>
                    <td><?php echo $detail['temperature'];?> &ordm; C</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_pulse');?></b></td>
                    <td><?php echo $detail['pulse'];?> x/mnt</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_respiration');?></b></td>
                    <td><?php echo $detail['respiration'];?> x/mnt</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_weight');?></b></td>
                    <td><?php echo $detail['weight'];?> Kg</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_height');?></b></td>
                    <td><?php echo $detail['height'];?> Cm</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_golongan_darah');?></b></td>
                    <td><?php echo $detail['blood_type'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_physic_anamnese');?> :</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:0 0 0 10px;"><?php echo $detail['physic_anamnese'];?></td>
                </tr>
            </table>
        
        </div>
        <div class="foot"></div>
    </div>
    <div style="clear:both"/>
</div>
