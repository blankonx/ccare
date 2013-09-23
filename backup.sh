#/bin/sh

#dump database
mysqldump --single-transaction -r  /media/www/c-Care/data/2.db_ccare.sql db_ccare -u root -pr33b00t


#kompres ke partisi/folder lain
tgl=`date +%G_%m_%d-%H_%M_%S`
#tar -czf  /usr/local/web/www/c-Care_$tgl.tar.gz ../c-Care
tar -czf  /media/DATAQU/Share\ Develop\ Aplikasi\ Webbase/c-Care/c-Care_$tgl.tar.gz ../c-Care
#kopikan ke uninstall

#rm -dfr /media/master/installer/linux/lampp/htdocs/c-Care
#cp -dfr ../c-Care /media/master/installer/linux/lampp/htdocs
