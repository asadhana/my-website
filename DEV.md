# Local development — zixhr.com WordPress

Run the production site locally in a single Docker container, seeded from a real
database backup. One container runs nginx + PHP-FPM (WordPress) + MariaDB
together via supervisord, mirroring the single production server.

## Stack (all in ONE container)

| Component | Version | Purpose |
|-----------|---------|---------|
| nginx     | package (Debian) | Web server, config at `/etc/nginx/nginx.conf` |
| php-fpm   | 8.2 + WP-CLI | Runs WordPress from `/var/www/html` |
| MariaDB   | package (Debian) | Database (test creds), on `127.0.0.1` |

Process manager: `supervisord`. Local address: http://localhost:8080

The `./html` directory (the cloned git site) is mounted directly, so code edits
show up immediately. Only `wp-config.php` is overridden inside the container by
`docker/php/wp-config-docker.php` — the tracked/production `wp-config.php` is
never touched.

## 1. Configure environment

```bash
cp .env.example .env
```

`.env` holds **test-only** values (safe to keep locally, it is git-ignored):

- `DB_NAME` / `DB_USER` / `DB_PASSWORD` — local MariaDB app user
- `DB_ROOT_PASSWORD` — local MariaDB root password
- `WP_HOME` / `WP_SITEURL` — `http://localhost:8080` (keeps WP off the prod domain)
- `NGINX_HTTP_PORT` — change if 8080 is taken

## 2. Get a database backup

The `Backup zixhr.com MariaDB to S3` GitHub Action stores backups at
`s3://<bucket>/zixhr.com/backups/db/d<YYYY-MM-DD>/`:

- `zixhr-db-<stamp>.sql.gz` — the MariaDB dump
- `zixhr-config-<stamp>.tar.gz` — WordPress admin file(s) + `nginx.conf`

Fetch the newest DB dump automatically:

```bash
S3_BACKUP_BUCKET=<your-bucket> ./scripts/fetch-latest-backup.sh
```

Or drop any `*.sql` / `*.sql.gz` file into `docker/db-init/` manually. It is
imported the first time the container initializes its database. (Dumps in that
folder are git-ignored.)

## 3. Start

```bash
docker compose up -d --build
```

- Site:  http://localhost:8080
- Admin: http://localhost:8080/wp-admin/

Because the dump comes from production, its URLs point at the live domain. If
links/redirects send you off localhost, rewrite them with WP-CLI:

```bash
docker compose exec zixhr wp --allow-root search-replace 'https://zixhr.com' 'http://localhost:8080' --all-tables --skip-columns=guid
```

## 4. Everyday commands

```bash
docker compose logs -f                                   # tail all service logs
docker compose exec zixhr wp --allow-root ...            # run WP-CLI
docker compose exec zixhr mariadb -uroot -p              # DB shell
docker compose exec zixhr supervisorctl status           # check nginx/php/mariadb
docker compose down                                      # stop (keeps the db volume)
docker compose down -v                                   # stop and wipe DB (re-import next up)
```

## Notes

- This stack is for local testing only. Never expose it publicly and never put
  production credentials in `.env`.
- The database initializes only on first boot (empty `db_data` volume). To
  re-seed with a fresh dump: `docker compose down -v`, put the new file in
  `docker/db-init/`, then `docker compose up -d --build`.
- With an empty database, `/wp-admin/` redirects to `install.php` — that's
  expected until you seed a real dump.
