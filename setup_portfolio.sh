#!/bin/bash

echo "*************Defining variables*****************"
REPO_URL="https://github.com/verventech/portfolio-shell-automation.git"
DB_NAME="portfolio_db"
DB_USER="musharaf"
DB_PASS="musharaf_secure_pass_123"


echo "***************apt update + install packages*************"

sudo apt update -y
sudo apt install -y apache2 postgresql postgresql-contrib php libapache2-mod-php php-pgsql git

echo "***********Start + enable services of apache and psql**************"
sudo systemctl start apache2
sudo systemctl enable apache2
sudo systemctl start postgresql
sudo systemctl enable postgresql

echo "****************Cloning sourcecode + initsql from github *****************"
sudo rm -rf /tmp/portfolio_repo
git clone $REPO_URL /tmp/portfolio_repo

echo "*****************Initialize D.B************************"

cd /tmp
sudo -u postgres psql -f /tmp/portfolio_repo/init.sql


echo "****************Setup apache env vars *******************"

cat <<EOF | sudo tee -a /etc/apache2/envvars

export PGHOST="localhost"
export PGDATABASE="$DB_NAME"
export PGUSER="$DB_USER"
export PGPASSWORD="$DB_PASS"
export PGPORT="5432"
EOF



echo "*******************Copy php file to /var/www/html ****************"
sudo rm -f /var/www/html/index.html
sudo cp /tmp/portfolio_repo/index.php /var/www/html/

sudo chmod -R 777 /var/www/html/


echo "*********************Restart apache*********************"
sudo systemctl restart apache2

echo " ************** ALL DONE!! **************"
