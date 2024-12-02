cli:
	docker exec -it vat-php bash
down:
	docker-compose down
up:
	docker-compose up -d
node:
	docker exec -it shop-node bash
dev: 
	docker exec  vat-node npm run dev