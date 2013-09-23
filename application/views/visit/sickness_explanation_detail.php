<div class="history_list">
    <div class="resume">
        <div class="head"><span>Resume :</span></div>
        <div class="body">
            <table cellpadding="0" cellspacing="0" border="0" style="padding-left:20px">
                <tr>
                    <td style="width:100px;"><b>Nomor</b></td>
                    <td><?php echo $detail['no'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_name');?></b></td>
                    <td><?php echo $detail['name'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_sex');?></b></td>
                    <td><?php echo $detail['sex'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_address');?></b></td>
                    <td><?php echo $detail['address'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_education');?></b></td>
                    <td><?php echo $detail['education'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_job');?></b></td>
                    <td><?php echo $detail['job'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_explanation');?></b></td>
                    <td><?php echo $detail['explanation'];?></td>
                </tr>
                <tr>
                    <td><b><?php echo $this->lang->line('label_doctor');?></b></td>
                    <td><?php echo $detail['doctor'];?></td>
                </tr>
            </table>
        </div>
        <div class="foot"></div>
    </div>
    <div style="clear:both"/>
</div>
