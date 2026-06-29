#!/usr/bin/env bash
PORT="${PORT:-8080}"
DIR="$(cd "$(dirname "$0")" && pwd)"
exec php \
    -d upload_max_filesize=50M \
    -d post_max_size=55M \
    -d memory_limit=256M \
    -d display_errors=1 \
    -d error_reporting=E_ALL \
    -S "0.0.0.0:${PORT}" \
    -t "${DIR}/public" \
    "${DIR}/public/index.php"
