#!/bin/bash

# SherPanel Auto Installer
# Supports Ubuntu 20.04 / 22.04 LTS
# Installs: Nginx, PHP 8.2, MariaDB, Node.js 18, Composer

set -e

# Colors
GREEN='\033[0;32m'
CYAN='\033[0;36m'
RED='\033[0;31m'
NC='\033[0m'

# Check Root
if [ "$EUID" -ne 0 ]; then 
  echo -e "${RED}Please run as root${NC}"
  exit
fi

clear
echo -e "${CYAN}"
echo "   _____ __               ____                  __";
echo "  / ___// /_  ___  ____  / __ \____ _____  ___  / /";
echo "  \__ \/ __ \/ _ \/ __ \/ /_/ / __ \`/ __ \/ _ \/ / ";
echo " ___/ / / / /  __/ / / / ____/ /_/ / / / /  __/ /  ";
echo "/____/_/ /_/\___/_/ /_/_/    \__,_/_/ /_/\___/_/   ";
echo -e "${NC}"
echo "Welcome to SherPanel Auto Installer"
echo "-----------------------------------"

# User Inputs
read -p "Enter Domain Name (or press enter for IP): " DOMAIN
if [ -z "$DOMAIN" ]; then
    DOMAIN=$(curl -s ifconfig.me)
fi

read -p "Enter Admin Email (default: admin@sherpanel.com): " ADMIN_EMAIL
ADMIN_EMAIL=${ADMIN_EMAIL:-admin@sherpanel.com}

read -p "Enter Admin Password (default: password): " ADMIN_PASSWORD
ADMIN_PASSWORD=${ADMIN_PASSWORD:-password}

# 1. Update System
echo -e "\n${GREEN}[1/9] Updating system packages...${NC}"
apt-get update -y && apt-get upgrade -y

# 2. Install Dependencies
echo -e "\n${GREEN}[2/9] Installing core dependencies...${NC}"
apt-get install -y software-properties-common curl git unzip zip nginx mariadb-server acl

# 3. Install PHP 8.2
echo -e "\n${GREEN}[3/9] Installing PHP 8.2...${NC}"
add-apt-repository ppa:ondrej/php -y
apt-get update -y
apt-get install -y php8.2 php8.2-fpm php8.2-cli php8.2-common php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath

# 4. Install Composer
echo -e "\n${GREEN}[4/9] Installing Composer...${NC}"
if ! command -v composer &> /dev/null; then
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi

# 5. Install Node.js 18
echo -e "\n${GREEN}[5/9] Installing Node.js 18...${NC}"
if ! command -v node &> /dev/null; then
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
    apt-get install -y nodejs
fi

# 6. Configure Database
echo -e "\n${GREEN}[6/9] Configuring Database...${NC}"
DB_NAME="sherpanel"
DB_USER="sherpanel"
DB_PASS=$(openssl rand -base64 12)

mysql -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME};"
mysql -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
mysql -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

# 7. Setup Application
echo -e "\n${GREEN}[7/9] Setting up SherPanel...${NC}"
INSTALL_DIR="/var/www/sherpanel"

# If we are running this script from the repo itself (cloned)
if [ -d "$PWD/app" ] && [ -f "$PWD/artisan" ]; then
    mkdir -p $INSTALL_DIR
    cp -r . $INSTALL_DIR
else
    # Clone if not present (Adjust URL to your actual repo)
    if [ ! -d "$INSTALL_DIR" ]; then
        git clone https://github.com/sherif1day-ux/Sherpanel.git $INSTALL_DIR
    fi
fi

cd $INSTALL_DIR

# Environment Setup
cp .env.example .env
sed -i "s/APP_URL=http:\/\/localhost/APP_URL=http:\/\/$DOMAIN/g" .env
sed -i "s/DB_DATABASE=laravel/DB_DATABASE=$DB_NAME/g" .env
sed -i "s/DB_USERNAME=root/DB_USERNAME=$DB_USER/g" .env
sed -i "s/DB_PASSWORD=/DB_PASSWORD=$DB_PASS/g" .env

# Generate Key & Migrate
echo -e "\n${GREEN}[8/9] Finalizing configuration...${NC}"
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force

# Create Admin User (if not exists via seeder)
# This is a simple way to ensure the admin exists with the provided credentials
php artisan tinker --execute="
\$user = \App\Models\User::firstOrNew(['email' => '$ADMIN_EMAIL']);
\$user->name = 'Admin';
\$user->password = \Illuminate\Support\Facades\Hash::make('$ADMIN_PASSWORD');
\$user->role = 'admin';
\$user->save();
"

# Permissions
chown -R www-data:www-data $INSTALL_DIR
chmod -R 775 $INSTALL_DIR/storage $INSTALL_DIR/bootstrap/cache

# Build Frontend
npm install
npm run build

# 9. Nginx Configuration
echo -e "\n${GREEN}[9/9] Configuring Web Server...${NC}"
cat > /etc/nginx/sites-available/sherpanel <<EOF
server {
    listen 80;
    server_name $DOMAIN;
    root $INSTALL_DIR/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

ln -sf /etc/nginx/sites-available/sherpanel /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl restart nginx

echo -e "${GREEN}"
echo "-------------------------------------------------------"
echo " Installation Complete! "
echo "-------------------------------------------------------"
echo -e "${NC}"
echo -e "URL      : http://$DOMAIN"
echo -e "Email    : $ADMIN_EMAIL"
echo -e "Password : $ADMIN_PASSWORD"
echo -e "${CYAN}Please save these credentials!${NC}"
