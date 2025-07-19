FROM nginx:alpine

RUN addgroup -g 1001 ssl-cert && \
    addgroup nginx ssl-cert

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

USER nginx

CMD ["nginx", "-g", "daemon off;"]
