# develop stage
FROM node:20-alpine as develop-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
#COPY . .

# build stage
FROM develop-stage as build-stage
RUN npm run build

# production stage
FROM nginx:1.15.7-alpine as production-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html
EXPOSE 5173
CMD ["nginx", "-g", "daemon off;"]
