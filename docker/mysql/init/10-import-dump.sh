#!/bin/sh
set -eu

DUMP_SOURCE="/docker-entrypoint-initdb-src/source.sql"

if [ ! -f "${DUMP_SOURCE}" ]; then
    echo "SQL dump not found at ${DUMP_SOURCE}" >&2
    exit 1
fi

echo "Importing ${DB_IMPORT_DUMP:-source.sql} into ${MYSQL_DATABASE}..."

sed "s/\`ucp_handled_note\` text NOT NULL DEFAULT 'NaN'/\`ucp_handled_note\` text NOT NULL/" "${DUMP_SOURCE}" \
    | mysql --default-character-set=utf8mb4 -uroot -p"${MYSQL_ROOT_PASSWORD}" "${MYSQL_DATABASE}"
