#!/bin/env bash

NETWORK_NAME=rowles
NETWORK_SUBNET=192.168.32.0/24
NETWORK_GATEWAY=192.168.32.1

declare -a containers=("rowles-web" "rowles-database")

function verify {
    while status=$(docker inspect --format "{{json .State.Status }}" "$1"); [ "$status" != "\"running\"" ]
    do
        echo "$status"
        if [ "$status" = "\"exited\"" ]; then
            echo "Failed!" >&2
            exit 1
        fi
        printf .
        lf=$'\n'
        sleep 1
    done
    printf "%s" "$lf"
}

function performPostInitVerification {
    for container in "${containers[@]}"
    do
       verify "$container"
    done
}

echo "Checking whether the $NETWORK_NAME network has been created."
if [ -z "$(docker network ls --filter name=^"$NETWORK_NAME"$ --format="{{ .Name }}")" ] ; then
    echo "Creating $NETWORK_NAME network."
    docker network create --driver=bridge \
                          --subnet="$NETWORK_SUBNET" \
                          --gateway="$NETWORK_GATEWAY" \
                          "$NETWORK_NAME";

    echo "$NETWORK_NAME network created successfully."
else
    echo "$NETWORK_NAME network has already been created."
fi

echo "Spinning up containers."
docker-compose up -d

sleep 5
echo "Performing checks."
performPostInitVerification
sleep 5

echo "Completed spinning up containers."
echo "Local development environment is ready."