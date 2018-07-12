default: start

start:
	docker-compose up

stop:
	docker-compose down

exec:
	docker-compose exec laravel bash