FROM mysql:8.0

COPY init/10-import-dump.sh /docker-entrypoint-initdb.d/10-import-dump.sh

RUN chmod +x /docker-entrypoint-initdb.d/10-import-dump.sh
