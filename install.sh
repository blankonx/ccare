#/bin/sh

#petunjuk instalasi : 
#kopi folder c-care ke htdocs
#masuk konsole, masuk ke folder c-care dan jalankan skrip ini.
#setting owner :

#perubahan mulai dari sini :
dbname=db_ccare
#mysqlbin=/usr/bin
mysqlbin=/opt/lampp/bin
#sikesdapath=/usr/local/web/www/c-care
sikesdapath=/media/www/c-Care
#sikesdapath=/opt/lampp/htdocs/c-care

#perubahan selesai 
echo Install Database $dbname
$mysqlbin/mysqladmin drop $dbname -h localhost -u root -pr33b00t
$mysqlbin/mysqladmin create $dbname -h localhost -u root -pr33b00t
$mysqlbin/mysql -h localhost -u root -pr33b00t -D $dbname < $sikesdapath/data/1.function.sql
$mysqlbin/mysql -h localhost -u root -pr33b00t -D $dbname < $sikesdapath/data/2.db_ccare.sql
$mysqlbin/mysql -h localhost -u root -pr33b00t -D $dbname < $sikesdapath/data/3.view.sql

echo Set Permission file
chmod -R 777 $sikesdapath/webroot/backup_database
chmod -R 777 $sikesdapath/webroot/media/upload
chmod -R 777 $sikesdapath/webroot/Charts
chmod -R 777 $sikesdapath/webroot/media/charts

echo Sukses dab
