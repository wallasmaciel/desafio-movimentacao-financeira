FROM node:20.18.3-bullseye

WORKDIR /app/movimentacao_financeira
COPY ./front/package*.json ./

RUN npm install
COPY ./front/ .

RUN npm run build

EXPOSE 3000

CMD ["node", ".output/server/index.mjs"]
