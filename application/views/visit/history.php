<script language="javascript" type="text/javascript">
$(document).ready(function() {
    //LIST 
    $('#list_hi').load('<?php echo base_url().'visit/history/lists/'.$data['visit_id']?>');
});
</script>
<div class="history_list">
    <!-- last visit -->
    <h2><u style="color:#25A710;"><?php echo $latest['clinic'];?></u> <em>(<?php echo $latest['datediff'];?>&nbsp;&nbsp;<span style="font-style:normal;font-size:8pt;font-weight:bold;"><?php echo $latest['date']; ?></span>)</em></h2>
    <div class="resume">
        <div class="head"><span>Resume :</span></div>
        <div class="body">
        <dl>
            <dt>Anamnese &amp; Diagnose : </dt>
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
        <div class="head"><span>Anamnese :</span></div>
        <div class="body">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="width:150px;"><b><?php echo $this->lang->line('label_blood_pressure');?></b></td>
                    <td><?php echo $latest['blood_pressure'];?> mmhg</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_temperature');?></b></td>
                    <td><?php echo $latest['temperature'];?> &ordm; C</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_pulse');?></b></td>
                    <td><?php echo $latest['pulse'];?> x/mnt</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_respiration');?></b></td>
                    <td><?php echo $latest['respiration'];?> x/mnt</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_weight');?></b></td>
                    <td><?php echo $latest['weight'];?> Kg</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_height');?></b></td>
                    <td><?php echo $latest['height'];?> Cm</td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_golongan_darah');?></b></td>
                    <td><?php echo $latest['blood_type'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_physic_anamnese');?> :</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:0 0 0 10px;"><?php echo $latest['physic_anamnese'];?></td>
                </tr>
            </table>
        </div>
        <div class="foot"></div>
    </div>
    <div style="clear:both"></div>
</div>

<div id="list_hi"></div>
