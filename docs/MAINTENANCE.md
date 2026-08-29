# Maintenance Documentation — zixhr.com Virtual_Machine (Ubuntu 20.04)

This document describes the **Manual — Site_Owner** operating-system maintenance
path for the Virtual_Machine that hosts the WordPress site `zixhr.com`. It covers
keeping the machine secure as Ubuntu 20.04 reaches end of standard support:
applying the updates that are immediately available, enabling Extended Security
Maintenance (ESM), and upgrading to a supported release.

**Context**

- The WordPress site `zixhr.com` runs on an Oracle Cloud free-tier Ubuntu 20.04
  virtual machine, a standard OS-level install rooted at `/var/www/html`.
  - Host: `amresh-wordpress`
  - SSH user: `ubuntu`
  - IP: `132.226.44.101`
- The assistant that authored this workflow **cannot** access the Virtual_Machine
  or WordPress credentials. Every step that touches the Virtual_Machine is a
  **Manual — Site_Owner** step that you (the Site_Owner) run yourself, from an
  SSH session on the Virtual_Machine unless stated otherwise.

> **How to read each step:** Every step below is labeled **Manual — Site_Owner**,
> gives the complete shell command to run (with any value you must substitute
> shown in `<angle-brackets>`), a **Verify** action whose observable result
> confirms the step succeeded, and a **Remediation** action to take if
> verification fails. Run the steps in the numbered order shown — each step
> assumes the previous steps have completed successfully.

---

## Ubuntu 20.04 End of Standard Support & Immediate Updates

Ubuntu 20.04 LTS (Focal Fossa) **reached end of standard support on 31 May 2025**.
After that date, Canonical no longer publishes regular security and bug-fix
updates for Ubuntu 20.04 through the standard update channels. However,
**Extended Security Maintenance (ESM) security updates remain available after
that date** — enabling ESM restores a stream of security patches for the release
(covered in the next section, *ESM Enablement & Upgrade Path*).

Before enabling ESM, first apply the updates that are already available to the
Virtual_Machine from the packages it has cached. When you log in over SSH, the
message-of-the-day banner reports how many updates are pending, for example:

```
3 updates can be applied immediately.
```

This section covers applying those **3 immediately available updates**. Perform
these steps first, before enabling ESM or attempting the release upgrade.

**Prerequisites**

- SSH access to the Virtual_Machine as user `ubuntu`.
- The `ubuntu` user has `sudo` rights (required for `apt`).
- A short maintenance window: applying updates may restart services, and some
  updates can request a reboot.

---

### Step 1 — Connect to the Virtual_Machine

**Manual — Site_Owner**

Open an SSH session to the Virtual_Machine.

```bash
ssh <ssh-user>@<vm-ip>
# For this site: ssh ubuntu@132.226.44.101
```

**Verify:** You reach a shell prompt on the Virtual_Machine and the login banner
identifies the release as Ubuntu 20.04. Confirm the release explicitly:

```bash
lsb_release -a
```

The output shows `Description:  Ubuntu 20.04 ... LTS` and `Release:  20.04`.

**Remediation:** If SSH fails to connect, confirm the IP `132.226.44.101` and the
user `ubuntu` are correct and that your local machine's key is authorized on the
VM. Do not proceed until you have a shell on the Virtual_Machine.

---

### Step 2 — Take a pre-update backup

**Manual — Site_Owner**

Before changing any packages, take a safety archive of the web root so the update
is recoverable. (If your Oracle Cloud tenancy supports boot-volume backups, also
take a full VM/boot-volume snapshot from the Oracle Cloud console for whole-machine
recovery.)

```bash
sudo mkdir -p /var/backups
sudo tar -czf /var/backups/wp-preupdate-<YYYYMMDD>.tar.gz -C /var/www/html .
```

**Verify:** The archive exists and is non-empty:

```bash
ls -lh /var/backups/wp-preupdate-<YYYYMMDD>.tar.gz
```

The listing shows the file with a size greater than 0 bytes.

**Remediation:** If `tar` reports a permission error, ensure you used `sudo`
(shown above). If `/var/backups` does not exist, the `mkdir -p` above creates it —
re-run both commands. Do not proceed to Step 3 until a valid backup exists.

---

### Step 3 — Record the number of pending updates

**Manual — Site_Owner**

Refresh the package index and confirm how many updates are available to apply
immediately. This establishes the "before" count you will confirm against after
the upgrade.

```bash
sudo apt-get update
apt list --upgradable
```

**Verify:** The `apt list --upgradable` command lists the packages that have a
newer version available. The count of listed packages matches the number reported
by the login banner — for this Virtual_Machine, **3 updates** available
immediately. Note the 3 package names; you will confirm they are gone after the
upgrade.

**Remediation:** If `apt-get update` reports repository or network errors (for
example, `Failed to fetch` for `focal` archives), confirm the Virtual_Machine has
outbound internet access and that `/etc/apt/sources.list` still references the
`focal` archives. Re-run `sudo apt-get update` until it completes without fetch
errors before proceeding.

---

### Step 4 — Apply the 3 immediately available updates

**Manual — Site_Owner**

Install all available updates. Run the commands in this order.

```bash
sudo apt-get update
sudo apt-get upgrade -y
```

If the upgrade output indicates that packages were held back (for example, kernel
or metapackage updates), also run:

```bash
sudo apt-get dist-upgrade -y
```

**Verify (observable completion indicator):** After the upgrade completes, re-run
the check from Step 3 and confirm there are **no remaining upgradable packages** —
all 3 updates are applied:

```bash
apt list --upgradable
```

The command prints only its `Listing...` header with **no package lines beneath
it** (an empty upgradable list). Equivalently, the previous count of 3 pending
updates has dropped to 0, and a fresh SSH login banner no longer reports
"updates can be applied immediately." This empty upgradable list is the observable
indicator that all 3 immediately available updates have been applied.

If the upgrade output stated that a restart is required, reboot and reconnect:

```bash
sudo reboot
# wait ~60 seconds, then reconnect:
ssh <ssh-user>@<vm-ip>   # ssh ubuntu@132.226.44.101
```

**Remediation (recovery action):** If the upgrade fails partway — for example
`apt` reports broken or unconfigured packages, or a `dpkg` interruption — return
the Virtual_Machine to a consistent state by finishing the interrupted
configuration and repairing dependencies, then re-running the upgrade:

```bash
sudo dpkg --configure -a
sudo apt-get install -f -y
sudo apt-get upgrade -y
```

If a specific package upgrade repeatedly fails, hold it and complete the rest so
the machine is otherwise current, then investigate the single package:

```bash
sudo apt-mark hold <failing-package-name>
sudo apt-get upgrade -y
```

If the Virtual_Machine does not boot or WordPress does not serve correctly after
the update, restore from the pre-update backup taken in Step 2 (extract the
archive back into `/var/www/html`), or, for whole-machine failure, restore the
Oracle Cloud boot-volume snapshot from the Oracle Cloud console:

```bash
sudo tar -xzf /var/backups/wp-preupdate-<YYYYMMDD>.tar.gz -C /var/www/html
```

Do not proceed to ESM enablement until `apt list --upgradable` shows an empty
list (all 3 updates applied).

---

_The 3 immediately available updates are applied once Step 4 verifies with an
empty upgradable list. The next section covers enabling Extended Security
Maintenance to apply the remaining ESM security updates, and the upgrade path to
Ubuntu 22.04.5 LTS._

---

## ESM Enablement & Upgrade to Ubuntu 22.04.5 LTS

With the 3 immediately available updates applied (see the previous section), the
next steps restore a full stream of security patches for Ubuntu 20.04 by enabling
**Extended Security Maintenance (ESM)** and applying the **157 ESM security
updates**, then move the Virtual_Machine onto a fully supported release by
performing the **release upgrade to Ubuntu 22.04.5 LTS**.

ESM is delivered through **Ubuntu Pro**. A free personal Ubuntu Pro subscription
(covering a small number of machines) provides the token used to attach this
Virtual_Machine and enable the `esm-infra` service. After ESM is enabled, the 157
held-back security updates become installable through `apt`. Perform the ESM steps
first; only attempt the release upgrade once ESM is enabled and the machine is
fully patched.

**Prerequisites**

- The 3 immediately available updates from the previous section are applied
  (`apt list --upgradable` shows an empty list before you begin).
- An Ubuntu Pro subscription token. Obtain a free personal token from
  `https://ubuntu.com/pro/dashboard` (log in with your Ubuntu One account and copy
  the token). You will substitute it below as `<ubuntu-pro-token>`.
- SSH access to the Virtual_Machine as user `ubuntu`, with `sudo` rights.
- A short maintenance window; the release upgrade in particular can take 30–60+
  minutes and will require a reboot.

---

### Step 5 — Attach the Virtual_Machine to Ubuntu Pro

**Manual — Site_Owner**

From an SSH session on the Virtual_Machine, ensure the Ubuntu Pro client is present
and attach the machine to your subscription using your token.

```bash
sudo apt-get install -y ubuntu-advantage-tools   # provides the `pro` (aka `ua`) client
sudo pro attach <ubuntu-pro-token>
```

**Verify:** Confirm the machine is attached and see which services are available:

```bash
sudo pro status
```

The output reports the subscription as attached and lists `esm-infra` with a
status of `enabled` or `disabled` (available to enable). If `esm-infra` appears in
the service list, the attach succeeded.

**Remediation (recovery action):** If `pro attach` reports an invalid or expired
token, re-copy the token from `https://ubuntu.com/pro/dashboard` and re-run the
attach. If the machine is already attached to a different subscription and you need
to change it, detach first and re-attach:

```bash
sudo pro detach --assume-yes
sudo pro attach <ubuntu-pro-token>
```

Attaching to Ubuntu Pro makes no changes to installed packages, so no file
restore is needed at this step; if the client itself is broken, repair it with
`sudo apt-get install -f -y` and retry. Do not proceed until `pro status` shows
the machine attached.

---

### Step 6 — Enable ESM (esm-infra)

**Manual — Site_Owner**

Enable the Extended Security Maintenance infrastructure service. This adds the ESM
package sources so the 157 held-back security updates become installable.

```bash
sudo pro enable esm-infra
```

(On older tooling the equivalent command is `sudo ua enable esm-infra`.)

**Verify:** Confirm the service is now enabled and its repositories are active:

```bash
sudo pro status
```

The `esm-infra` line reports status `enabled`. This enabled status is the output
consumed by the next step: it makes the ESM package source available so
`apt-get update` can see the 157 pending security updates.

**Remediation (recovery action):** If enabling fails (for example a repository or
network error), confirm the Virtual_Machine has outbound internet access, re-run
`sudo apt-get update`, and retry `sudo pro enable esm-infra`. If the service shows
as `enabled` but its source is not being fetched, disable and re-enable it:

```bash
sudo pro disable esm-infra
sudo pro enable esm-infra
```

Enabling ESM changes only APT source configuration (no package mutation yet), so no
file restore is required here. Do not proceed until `pro status` shows `esm-infra`
enabled.

---

### Step 7 — Apply the 157 ESM security updates

**Manual — Site_Owner**

Refresh the package index (now including the ESM source) and confirm the ESM
updates are visible, then apply them. Run the commands in this order.

```bash
sudo apt-get update
apt list --upgradable            # confirm the ESM updates are now listed
sudo apt-get upgrade -y
sudo apt-get dist-upgrade -y     # if any security packages were held back
```

**Verify (observable completion indicator):** Before applying, `apt list
--upgradable` should list the **157 ESM security updates** now made available by
the enabled `esm-infra` source. After the upgrade completes, re-run the check and
confirm there are **no remaining upgradable packages** — all 157 ESM updates are
applied:

```bash
apt list --upgradable
```

The command prints only its `Listing...` header with **no package lines beneath
it** (an empty upgradable list). Equivalently, the previous count of 157 pending
ESM updates has dropped to 0. This empty upgradable list is the observable
indicator that all 157 ESM security updates have been applied.

If the upgrade output stated a restart is required, reboot and reconnect:

```bash
sudo reboot
# wait ~60 seconds, then reconnect:
ssh <ssh-user>@<vm-ip>   # ssh ubuntu@132.226.44.101
```

**Remediation (recovery action):** If the ESM upgrade fails partway — broken or
unconfigured packages, or a `dpkg` interruption — return the Virtual_Machine to a
consistent state by finishing the interrupted configuration and repairing
dependencies, then re-running the upgrade:

```bash
sudo dpkg --configure -a
sudo apt-get install -f -y
sudo apt-get upgrade -y
```

If a specific package repeatedly fails, hold it and complete the rest so the
machine is otherwise fully patched, then investigate the single package:

```bash
sudo apt-mark hold <failing-package-name>
sudo apt-get upgrade -y
```

If the Virtual_Machine does not boot or WordPress does not serve correctly after
the ESM updates, restore the web root from the pre-update backup, or, for
whole-machine failure, restore the Oracle Cloud boot-volume snapshot from the
Oracle Cloud console:

```bash
sudo tar -xzf /var/backups/wp-preupdate-<YYYYMMDD>.tar.gz -C /var/www/html
```

Do not proceed to the release upgrade until `apt list --upgradable` shows an empty
list (all 157 ESM updates applied).

---

### Step 8 — Prepare for the release upgrade to 22.04.5 LTS

**Manual — Site_Owner**

The release upgrade rewrites system packages and sources, so complete these
prerequisites first. Do **not** run `do-release-upgrade` until all of these hold.

1. **Take a fresh full backup / snapshot.** Take a whole-machine
   **Oracle Cloud boot-volume snapshot** from the Oracle Cloud console (Compute →
   your instance → Boot volume → Create manual backup / snapshot), and a web-root
   archive so the upgrade is recoverable:

   ```bash
   sudo tar -czf /var/backups/wp-preupgrade-<YYYYMMDD>.tar.gz -C /var/www/html .
   ```

2. **Confirm all current updates are applied.** The machine must be fully patched
   (Steps 4 and 7 complete) before upgrading:

   ```bash
   sudo apt-get update
   apt list --upgradable        # must be empty
   ```

3. **Confirm sufficient free disk space.** The upgrade downloads and unpacks a
   large package set; ensure the root filesystem has ample free space (a few GB
   headroom recommended):

   ```bash
   df -h /
   ```

**Verify:** The backup archive exists and is non-empty
(`ls -lh /var/backups/wp-preupgrade-<YYYYMMDD>.tar.gz` shows size > 0), a
boot-volume snapshot is listed as available/complete in the Oracle Cloud console,
`apt list --upgradable` prints only its `Listing...` header with no package lines,
and `df -h /` shows adequate free space on `/`.

**Remediation (recovery action):** If any prerequisite is not met, resolve it
before upgrading — re-run the backup/snapshot if it did not complete, re-run the
upgrade steps (Steps 4/7) until `apt list --upgradable` is empty, and free disk
space (for example clear the apt cache with `sudo apt-get clean` and remove old
packages with `sudo apt-get autoremove -y`) until `df -h /` shows headroom. Do not
run `do-release-upgrade` until all three prerequisites are satisfied.

---

### Step 9 — Perform the release upgrade to Ubuntu 22.04.5 LTS

**Manual — Site_Owner**

Run the Ubuntu release upgrade. It will download the new release, ask for
confirmation, replace packages, and prompt for a reboot at the end. Run inside a
resilient session (for example `tmux` or `screen`) so a dropped SSH connection does
not interrupt the upgrade.

```bash
sudo apt-get install -y update-manager-core
sudo do-release-upgrade
```

Answer the interactive prompts to continue the upgrade. When asked about modified
configuration files, keep your existing versions unless you have a reason to
change them. When the upgrade finishes it will prompt to reboot — allow it, then
reconnect:

```bash
# after the upgrade completes and reboots (wait ~2–3 minutes):
ssh <ssh-user>@<vm-ip>   # ssh ubuntu@132.226.44.101
```

**Verify (observable completion indicator):** After reconnecting, confirm the
Virtual_Machine reports the new release version:

```bash
lsb_release -a
```

The output shows `Description:  Ubuntu 22.04.5 LTS` and `Release:  22.04`. This
`22.04.5` version reported by `lsb_release` is the observable indicator that the
release upgrade succeeded. As a final check, confirm the machine is patched on the
new release:

```bash
sudo apt-get update
apt list --upgradable    # empty list expected on a freshly upgraded machine
```

**Remediation (recovery action):** If `do-release-upgrade` reports that no new
release is found, ensure `update-manager-core` is installed and that
`/etc/update-manager/release-upgrades` is set to `Prompt=lts`, then retry. If the
upgrade fails partway, is interrupted, or the machine does not boot / WordPress
does not serve correctly afterward, return the Virtual_Machine to its pre-upgrade
operational state by **restoring the Oracle Cloud boot-volume snapshot** taken in
Step 8 from the Oracle Cloud console (attach/restore the snapshot to the instance
and boot from it). If the machine is bootable but the web root is damaged, restore
the web root from the pre-upgrade archive:

```bash
sudo tar -xzf /var/backups/wp-preupgrade-<YYYYMMDD>.tar.gz -C /var/www/html
```

Do not treat the upgrade as complete until `lsb_release -a` reports `22.04.5`.

---

_ESM is enabled and the 157 ESM security updates are applied once Step 7 verifies
with an empty upgradable list, and the Virtual_Machine is on a fully supported
release once Step 9 verifies that `lsb_release -a` reports Ubuntu 22.04.5 LTS. Each
step above provides a recovery action (repair-and-retry, web-root restore from the
pre-step archive, or full Oracle Cloud boot-volume snapshot restore) that returns
the Virtual_Machine to its pre-step operational state if that step fails._
