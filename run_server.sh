#!/bin/bash

echo "  _                       _____ _             _____  _    _ _____    "
echo " | |                     / ____| |           |  __ \| |  | |  __ \   "
echo " | |     ___  _ __   ___| (___ | |_ __ _ _ __| |__) | |__| | |__) |  "
echo " | |    / _ \| '_ \ / _ \\\\___ \| __/ _\` | '__|  ___/|  __  |  ___/"
echo " | |___| (_) | | | |  __/____) | || (_| | |  | |    | |  | | |       "
echo " |______\___/|_| |_|\___|_____/ \__\__,_|_|  |_|    |_|  |_|_|       "
echo ""
echo "Running PHP internal server... When this is finished, you may view LoneStarPHP at:"
echo "    http://localhost:4000/ "
echo ""
echo ""


cd ./public

# Check for pagoda gem
type pagoda >/dev/null 2>&1 || echo "Please install the 'pagoda' gem, it is required for DB tunnel";
ENVIRONMENT=dev DB1_HOST=127.0.0.1 DB1_NAME=2014_lonestarphp DB1_USER=dixie DB1_PASS=le2XkMi3 DB1_PORT=3306 php -S localhost:4000