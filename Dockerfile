FROM node:latest AS frontend-build

WORKDIR /app
COPY frontend/package.json frontend/package-lock.json ./
RUN npm install
COPY frontend/ ./
RUN npm run build

FROM php:8.3-apache

COPY --from=frontend-build /app/dist /var/www/html/frontend

COPY backend/ /var/www/html/backend
