#!/bin/sh

cd /usr/share/client/frontend
echo '--------Build client side'
npm install && npm run build

cd /usr/share/client/admin
echo '--------Build admin side'
npm install && npm run build

cd /usr/share
echo "--------Execute migration db"
php artisan migrate
echo "--------Create sample data"
php artisan db:seed
echo "--------Create s3 bucket on localstack"
php artisan aws:createbucket

sleep 5
echo "--------create kafka configuration"
until curl -sS "http://host.docker.internal:9200/_cat/health?h=status" | grep -q "green\|yellow"; do
    sleep 1
done
if [ $(curl -LI http://host.docker.internal:9200/postmodel -o /dev/null -w '%{http_code}\n' -s) == "404" ]
then
    curl -X PUT "http://host.docker.internal:9200/postmodel" -H "Content-Type: application/json" -d @./server-conf/elasticsearch/post-mappings.json; 
    sleep 1
    curl -i -X POST -H "Accept:application/json" -H "Content-Type:application/json" host.docker.internal:8083/connectors/ -d @./server-conf/connectors/mysql.json;
    sleep 1
    curl -i -X POST -H "Accept:application/json" -H "Content-Type:application/json" host.docker.internal:8083/connectors/ -d @./server-conf/connectors/elasticsearch.json;
fi
