http://localhost:3002/



docker-compose up -d


Rebuild and start the containers using the updated Dockerfile:
docker-compose up -d --build



To stop the containers, run:
docker-compose down


To view the logs of the containers, run:
docker-compose logs

Or to view the logs of a specific service, for example, the Nginx service:
docker-compose logs nginx





docker exec -it project_php bash




docker-compose exec node npm install --save-dev sass-loader@^12.0.0 sass@^1.32.0
docker-compose exec node npm run dev
