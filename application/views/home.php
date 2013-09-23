<script type="text/javascript" src="<?php echo base_url()?>webroot/media/js/FusionCharts.js"></script>
<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Dashboard</div>
		<div class="ui-dialog-content" id="dialogContent">
		<div style="float:left;">
            <table cellpadding="0" cellspacing="0" border="0" class="tblBorder tblListData" style="font-size:10pt;font-style:italic;">
                <tr>
                    <th style="width:100px;text-align:left">Hari ini</th>
                    <td style="text-align:right;width:20px"><?php echo $dashboard['today']['jml'];?> px</td>
                </tr>
                <tr>
                    <th style="text-align:left">Kemarin</th>
                    <td style="text-align:right"><?php echo $dashboard['yesterday']['jml'];?> px</td>
                </tr>
                <tr>
                    <th style="text-align:left">Minggu ini</th>
                    <td style="text-align:right"><?php echo $dashboard['thisweek']['jml'];?> px</td>
                </tr>
                <tr>
                    <th style="text-align:left">Bulan ini</th>
                    <td style="text-align:right"><?php echo $dashboard['thismonth']['jml'];?> px</td>
                </tr>
                <tr>
                    <th style="text-align:left">Tahun ini</th>
                    <td style="text-align:right"><?php echo $dashboard['thisyear']['jml'];?> px</td>
                </tr>
                <tr>
                    <th style="text-align:left">Rata-rata kunjungan harian (bulan kemarin)</th>
                    <td style="text-align:right"><?php echo $dashboard['average']['jml'];?> px</td>
                </tr>
            </table>
            <br/>
            <div><?php $fc->renderChart(); ?></div>
		</div>
		<div style="float:right;">
            <img src="<?php echo base_url()?>webroot/media/upload/<?php echo $_profile['screensaver']?>" width="450" />
		</div>
        <div style="clear:both;"></div>
            <div style="text-align:center">
                <div><img src="<?php echo base_url()?>webroot/media/images/c-care-logo.gif" width="230px" height="115px"></div>
                <div style="font-size:12pt;font-weight:bold;margin-top:5px;color:#5c8118"><?php echo $_profile['name'];?></div>
                <div style="font-size:10pt;font-weight:bold;color:#000000"><?php echo $_profile['address'] . ' telp. ' . $_profile['phone'];?></div>
            </div>
        </div>
	</div>
</div>
