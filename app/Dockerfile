FROM php:8.3-cli

WORKDIR /app

COPY . .

RUN chmod +x start.sh

EXPOSE 8080

CMD ["./start.sh"]