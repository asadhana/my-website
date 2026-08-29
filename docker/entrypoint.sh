#!/usr/bin/env bash
# Entrypoint for the all-in-one zixhr.com dev container.
# Initializes MariaDB (first run), creates the WP database + user, seeds any
# dump found in /docker-entrypoint-initdb.d, then hands off to supervisord
# which runs mariadb + php-fpm + nginx together.
set -euo pipefail

DB_NAME="${WORDPRESS_DB_NAME:-zixhr_wp}"
DB_USER="${WORDPRESS_DB_USER:-zixhr}"
DB_PASSWORD="${WORDPRESS_DB_PASSWORD:-zixhr_local_pw}"
DB_ROOT_PASSWORD="${DB_ROOT_PASSWORD:-root_local_pw}"
DATADIR="/var/lib/mysql"
INITDIR="/docker-entrypoint-initdb.d"

mysql_up() { mariadb-admin --silent --wait=30 ping >/dev/null 2>&1; }

if [ ! -d "${DATADIR}/mysql" ]; then
    echo "[entrypoint] Initializing MariaDB data directory..."
    mariadb-install-db --user=mysql --datadir="${DATADIR}" --auth-root-authentication-method=normal >/dev/null

    echo "[entrypoint] Starting temporary MariaDB for bootstrap..."
    mariadbd --user=mysql --skip-networking &
    TMP_PID="$!"
    for i in $(seq 1 30); do mysql_up && break; sleep 1; done

    echo "[entrypoint] Creating database '${DB_NAME}' and user '${DB_USER}'..."
    mariadb -u root <<-SQL
        -- Remove anonymous accounts; '' @'localhost' otherwise shadows our
        -- app user for localhost/socket connections and causes access-denied.
        DELETE FROM mysql.global_priv WHERE User='';
        CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASSWORD}';
        CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
        GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'%';
        GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
        ALTER USER 'root'@'localhost' IDENTIFIED BY '${DB_ROOT_PASSWORD}';
        FLUSH PRIVILEGES;
	SQL

    if [ -d "$INITDIR" ]; then
        shopt -s nullglob
        for f in "$INITDIR"/*; do
            case "$f" in
                *.sql)    echo "[entrypoint] Importing $f"; mariadb -u root "${DB_NAME}" < "$f" ;;
                *.sql.gz) echo "[entrypoint] Importing $f"; gunzip -c "$f" | mariadb -u root "${DB_NAME}" ;;
                *)        echo "[entrypoint] Skipping $f" ;;
            esac
        done
        shopt -u nullglob
    fi

    echo "[entrypoint] Shutting down bootstrap MariaDB..."
    mariadb-admin -u root -p"${DB_ROOT_PASSWORD}" shutdown || kill "$TMP_PID" || true
    wait "$TMP_PID" 2>/dev/null || true
    echo "[entrypoint] MariaDB bootstrap complete."
else
    echo "[entrypoint] Existing MariaDB data directory found; skipping init."
fi

chown -R mysql:mysql "${DATADIR}" /run/mysqld

echo "[entrypoint] Handing off to supervisord..."
exec "$@"
