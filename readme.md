
Установка
1. Скопировать .env-example в .env: bash cp .env.example .env
2. Запустить docker и запустить проект bash docker-compose up -d --build
3. Установить зависимости composer
bash docker exec -it php composer install