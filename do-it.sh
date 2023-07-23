export NODE_OPTIONS=--openssl-legacy-provider

docker-compose stop nginx php
docker-compose rm nginx php --force
cd nfpco-web
npm run build
cd ..
docker rmi nfp-coms-nginx 
docker rmi nfp-coms-php
docker volume prune --force
docker-compose up -d  php nginx