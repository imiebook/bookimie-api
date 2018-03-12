composer install

# Symfony 3
php bin/console  doctrine:database:create
php bin/console  doctrine:schema:update --force
php bin/console doctrine:fixtures:load -n # load fixtures

# clear cache
php bin/console cache:clear

# premission on project
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
setfacl -R -m u:$HTTPDUSER:rwX -m u:`whoami`:rwX var
setfacl -dR -m u:$HTTPDUSER:rwX -m u:`whoami`:rwX var

# Public and Private key - jwt
mkdir -p var/jwt # For Symfony3+, no need of the -p option
# Pass phrase 'imie'
openssl genrsa -passout pass:imie -out var/jwt/private.pem -aes256 4096
openssl rsa -passin pass:imie -pubout -in var/jwt/private.pem -out var/jwt/public.pem
