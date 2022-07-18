# How to run

1. Clone this project to your PC
2. Use your CLI of choice, then move inside this project directory
3. Running below command to start using
```shell
docker-compose up -d
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

npm install
npm run watch
```

After that, go to `http://localhost` to check demo
