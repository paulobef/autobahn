FROM node:10.15.3



#RUN mkdir -p /usr/src/app

#define working dir
WORKDIR /application

#available package.json, package-lock.json as well
COPY package*.json ./

#install all dependencies listed in package.json
RUN npm install

#copy all the source code to working dir
COPY . .

#mapping of port to docker daemon
EXPOSE 3000

#command in the form of array
CMD ["npm", "run", "watch"]