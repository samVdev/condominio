#!/bin/sh
mkdir -p /run
chown nginx:nginx /run

exec "$@"
