FROM node:20-alpine as build

RUN adduser -D -g '' nodeuser

WORKDIR /app

COPY . .

RUN chown -R nodeuser:nodeuser /app

USER nodeuser

CMD ["node", "index.js"]