#!/bin/env bash

NETWORK_NAME=rowles

echo "Shutting down containers."
docker-compose down

# For some reason, sometimes the network isn't removed via the command above, so do a manual check
network=$(docker network ls --filter name=$NETWORK_NAME --format="{{ .Name }}")
echo "Performing residual check for $NETWORK_NAME network."
if [ "$network" == "$NETWORK_NAME" ] ; then
    echo "Removing network."
    docker network rm "$network"
fi

echo "Docker development environment has been successfully destroyed."