#!/usr/bin/env bash

set -e

if [[ "$#" -ne 1 ]]; then
    echo "Missing arguments"
    exit 1
fi

TZ=${1}

# TODO test for existence of /usr/share/zoneinfo/${TZ}

ln -snf "/usr/share/zoneinfo/${TZ}" /etc/localtime
echo "${TZ}" > /etc/timezone
