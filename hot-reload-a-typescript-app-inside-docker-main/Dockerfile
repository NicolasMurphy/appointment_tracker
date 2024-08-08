FROM node:18-alpine
WORKDIR /server
COPY package.json .
RUN npm install
COPY tsconfig.json .
COPY src ./src
EXPOSE 3000
CMD ["npm", "start"]
