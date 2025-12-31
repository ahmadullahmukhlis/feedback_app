FROM node:latest as build-stage

WORKDIR /app

COPY package*.json ./

RUN npm install --force

COPY . .

RUN mv /app/.env.production /app/.env
RUN npm run build

FROM nginx:alpine

COPY --from=build-stage /app/dist /usr/share/nginx/html
RUN rm /usr/share/nginx/html/index.html
RUN mv /usr/share/nginx/html/spa/* /usr/share/nginx/html/

RUN rm /etc/nginx/conf.d/default.conf
COPY default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
