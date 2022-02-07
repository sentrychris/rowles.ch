#!/bin/bash

# TODO read the .env file
COMPOSE_NETWORK_NAME=rowles
COMPOSE_NETWORK_SUBNET=192.168.32.0/24
COMPOSE_NETWORK_GATEWAY=192.168.32.1

echo "Checking whether the $COMPOSE_NETWORK_NAME network already exists."
if [ -z "$(docker network ls --filter name=^"$COMPOSE_NETWORK_NAME"$ --format="{{ .Name }}")" ] ; then
    echo "Creating $COMPOSE_NETWORK_NAME network."
    docker network create --driver=bridge --subnet="$COMPOSE_NETWORK_SUBNET" --gateway="$COMPOSE_NETWORK_GATEWAY" "$COMPOSE_NETWORK_NAME";
    echo "$COMPOSE_NETWORK_NAME network created successfully."
else
    echo "$COMPOSE_NETWORK_NAME network already exists."
fi

echo "Spinning up containers."
docker-compose up -d
sleep 15
echo "Completed spinning up containers."
echo "Local environment is ready."