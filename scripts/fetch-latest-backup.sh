#!/usr/bin/env bash
# Download the most recent zixhr.com DB backup from S3 into docker/db-init/
# so `docker compose up` seeds the local MariaDB with it.
#
# Requires the AWS CLI and credentials with read access to the backup bucket.
#
# Usage:
#   S3_BACKUP_BUCKET=my-zixhr-backups ./scripts/fetch-latest-backup.sh
#
set -euo pipefail

BUCKET="${S3_BACKUP_BUCKET:-}"
if [ -z "$BUCKET" ]; then
  echo "Set S3_BACKUP_BUCKET (bucket name only) before running." >&2
  exit 1
fi

PREFIX="zixhr.com/backups/db/"
DEST_DIR="$(cd "$(dirname "$0")/.." && pwd)/docker/db-init"
mkdir -p "$DEST_DIR"

echo "Finding most recent backup under s3://${BUCKET}/${PREFIX} ..."
LATEST_KEY="$(aws s3 ls "s3://${BUCKET}/${PREFIX}" --recursive \
  | sort | tail -n1 | awk '{print $4}')"

if [ -z "$LATEST_KEY" ]; then
  echo "No backups found under s3://${BUCKET}/${PREFIX}" >&2
  exit 1
fi

# Clear old dumps so MariaDB init only sees the freshest one.
rm -f "$DEST_DIR"/*.sql "$DEST_DIR"/*.sql.gz 2>/dev/null || true

FILE_NAME="$(basename "$LATEST_KEY")"
echo "Downloading ${LATEST_KEY} -> docker/db-init/${FILE_NAME}"
aws s3 cp "s3://${BUCKET}/${LATEST_KEY}" "${DEST_DIR}/${FILE_NAME}" --only-show-errors

echo "Done. Now run: docker compose up -d --build"
