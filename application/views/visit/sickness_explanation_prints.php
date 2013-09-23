<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo strip_tags($report['report_title']);?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/print_full.css" media="print,screen">
    <script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.1.2.6.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
		window.print();
	});
    </script>
</head>
<body>
<div id="all-container">
<div id="header" style="height:6cm;overflow:visible;border:none;">
    <div>
		<img src="<?php echo base_url()?>webroot/media/upload/<?php echo $profile['photo']?>" alt="Logo" height="70" border="0"/>
    </div>
    <div style="text-align:center;font-weight:bold;width:18cm;font-size:14px"><?php echo $profile['report_header_1'];?></div>
    <div style="text-align:center;font-weight:bold;width:18cm;font-size:16px;"><?php echo $profile['report_header_2'];?></div>
    <div style="text-align:center;width:18cm;font-weight:bold;"><?php echo strtoupper($profile['name']);?></div>
	<div style="font-size:10px;text-align:center;width:18cm;"><?php echo $profile['address'] . " Telp. " . $profile['phone'];?></div>
</div>
<div style="clear:both"></div>
<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
        Surat Keterangan Sakit
    </div>
    <div style="text-align:center;">No. <?php echo $detail['no']?></div><br/>
    Yang bertanda tangan dibawah ini Dokter UPT <?php echo $profile['name'] . ", " . removeKotaKab($profile['district']);?>, dengan ini menerangkan bahwa :<br/><br/>
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="width:150px;"><?php echo $this->lang->line('label_name');?></td>
            <td>:&nbsp;<?php echo $detail['name'];?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:&nbsp;<?php echo $detail['sex'];?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('label_place_date_of_birth');?></td>
            <td>:&nbsp;<?php echo $detail['birth_place'] ;?>, <?php echo unYMD($detail['birth_date']) . " (" . getOneAge($detail['birth_date']) . ")";?> </td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('label_job');?></td>
            <td>:&nbsp;<?php echo $detail['job'];?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('label_address');?></td>
            <td>:&nbsp;<?php echo $detail['address'];?></td>
        </tr>
    </table><br/>
	Pada saat pemeriksaan dalam keadaan <b>sakit</b>, sehingga perlu istirahat selama <?php echo $detail['permit_day'];?> hari, <br/>
    Mulai tanggal <?php echo $detail['date_before']?> s.d. tanggal <?php echo $detail['date_after']?><br/>
    <?php echo $detail['explanation']?><br/>
    Demikian Surat Keterangan ini dibuat, dengan mengingat sumpah saat menerima jabatan, agar dapat digunakan sebagaimana mestinya.
    <br/>
    <div style="margin-top:2cm;"></div>
    <div style="float:left;width:9cm;text-align:center;margin-left:9cm">
        <?php echo removeKotaKab($profile['district']);?>, <?php echo tanggalIndo(date('Y-m-d'), 'j F Y');?><br/>
        Dokter Pemeriksa<br/><br/><br/>
        <u><?php echo $detail['doctor'];?></u>
        <br/>
        NIP. <?php echo $detail['nip'];?>
        <br/>
    </div>
    <div style="clear:both"></div>
</div>
</body>
</html>
