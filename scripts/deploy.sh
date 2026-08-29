#!/usr/bin/env bash
set -euo pipefail

# --- DeployContext (see design.md Component 6 / Data Models: DeployContext) ---
# Built from Actions_Secret-provided env vars DEPLOY_USER and DEPLOY_HOST.
REMOTE="${DEPLOY_USER}@${DEPLOY_HOST}"
WEBROOT="/var/www/html"
SSH_OPTS="-o ConnectTimeout=30 -o StrictHostKeyChecking=accept-new"
TS="$(date +%Y%m%d-%H%M%S)"
BACKUP_DIR="/var/backups/wp-deploy"

# Timestamped logging helper.
log() { echo "[deploy][$(date -u +%FT%TZ)] $*"; }

# --- Stage C: SSH authentication, 3 attempts, 30s connect timeout (Req 3.2, 3.4) ---
authenticate() {
  local attempt
  for attempt in 1 2 3; do
    log "SSH auth attempt ${attempt}/3 to ${REMOTE}"
    if ssh ${SSH_OPTS} "${REMOTE}" 'true'; then
      log "SSH authentication succeeded"
      return 0
    fi
    log "SSH auth attempt ${attempt} failed"
  done
  log "ERROR: authentication-failure — 3 attempts exhausted; no changes made to VM"
  return 10   # distinct code; sync is never reached
}

# --- Stage D: Pre_Deploy_Backup BEFORE any mutation (Req 5.1, 5.2) ---
backup() {
  log "Creating Pre_Deploy_Backup on VM"
  if ! ssh ${SSH_OPTS} "${REMOTE}" \
      "sudo mkdir -p '${BACKUP_DIR}' && sudo tar -czf '${BACKUP_DIR}/wp-${TS}.tar.gz' -C ${WEBROOT} ."; then
    log "ERROR: backup-failure — aborting before Deploy_Sync; VM files unchanged"
    return 20
  fi
  # Optional DB dump; best-effort only. A mysqldump absence must NOT fail the backup.
  ssh ${SSH_OPTS} "${REMOTE}" \
      "command -v mysqldump >/dev/null && sudo mysqldump --defaults-file=/etc/wp-backup.cnf --all-databases | sudo tee '${BACKUP_DIR}/db-${TS}.sql' >/dev/null" \
      || log "WARNING: mysqldump not run (not configured); filesystem backup still present"
  log "Pre_Deploy_Backup complete: ${BACKUP_DIR}/wp-${TS}.tar.gz"
}

# --- Stage E: Deploy_Sync with exclusions (Req 3.5, 4.1–4.5) ---
sync() {
  # Warn if wp-config.php is absent on the VM (Req 4.4) — but never transfer/create it.
  if ! ssh ${SSH_OPTS} "${REMOTE}" "test -f '${WEBROOT}/wp-config.php'"; then
    log "WARNING: wp-config.php absent on VM; sync will not create it"
  fi

  log "Starting Deploy_Sync (rsync) to ${WEBROOT}"
  if ! rsync -az --delete \
        --exclude 'wp-config.php' \
        --exclude 'wp-content/uploads' \
        --exclude '.git' \
        -e "ssh ${SSH_OPTS}" \
        ./ "${REMOTE}:${WEBROOT}/"; then
    log "ERROR: synchronization-failure — one or more files failed to copy"
    return 30
  fi
  log "Deploy_Sync complete"
}

# --- Stage F/G: Post-sync file-state restoration + cache flush (Req 5.3–5.6) ---
finalize() {
  if ! ssh ${SSH_OPTS} "${REMOTE}" "sudo chown -R www-data:www-data ${WEBROOT}"; then
    log "ERROR: post-sync-failure — ownership assignment failed"; return 40; fi
  if ! ssh ${SSH_OPTS} "${REMOTE}" "sudo find ${WEBROOT} -type d -exec chmod 755 {} +"; then
    log "ERROR: post-sync-failure — directory permission assignment failed"; return 41; fi
  if ! ssh ${SSH_OPTS} "${REMOTE}" "sudo find ${WEBROOT} -type f -exec chmod 644 {} +"; then
    log "ERROR: post-sync-failure — file permission assignment failed"; return 42; fi
  if ! timeout 60 ssh ${SSH_OPTS} "${REMOTE}" \
        "command -v wp >/dev/null && sudo -u www-data wp --path=${WEBROOT} cache flush"; then
    log "ERROR: post-sync-failure — cache flush failed or exceeded 60s"; return 43; fi
  log "Post-sync restoration and cache flush complete"
}

# Fixed ordering is load-bearing: backup precedes sync, restoration follows it.
main() {
  authenticate      # Req 3.2/3.4 — must pass before any VM mutation
  backup            # Req 5.1/5.2 — must succeed before sync
  sync              # Req 3.5/4.x
  finalize          # Req 5.3–5.6
  log "Deployment succeeded"
}
main "$@"
