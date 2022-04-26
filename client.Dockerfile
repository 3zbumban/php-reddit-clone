# build stage
FROM node:latest as build-stage
WORKDIR /client
COPY client/package*.json .
RUN npm install
COPY client/ .
RUN npm run build

# production stage
FROM nginx:stable-alpine as production-stage
COPY --from=build-stage /client/dist /var/www/html
COPY client.nginx.conf /etc/nginx/conf.d/default.conf
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]