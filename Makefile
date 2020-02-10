.DEFAULT_GOAL := up

up:
	docker-compose -f .docker/docker-compose.yml up -d

down:
	docker-compose -f .docker/docker-compose.yml down

shell: 
	docker-compose -f .docker/docker-compose.yml exec server sh -c "cd /app && /bin/zsh"