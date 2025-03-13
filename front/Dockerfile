FROM node:20.18.3-bullseye

COPY ./front/ /app/movimentacao_financeira
WORKDIR /app/movimentacao_financeira

RUN npm install
EXPOSE 3000

CMD ["npm", "run", "dev"]
