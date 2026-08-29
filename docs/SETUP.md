# Setup Documentation — zixhr.com WordPress GitHub Workflow

This document describes the **Manual — Site_Owner** steps required to bring the
WordPress site `zixhr.com` under Git/GitHub source control and to operate the
review-and-deploy workflow.

**Context**

- The WordPress site `zixhr.com` is a standard OS-level install rooted at
  `/var/www/html` on an Oracle Cloud free-tier Ubuntu virtual machine.
  - Host: `amresh-wordpress`
  - SSH user: `ubuntu`
  - IP: `132.226.44.101`
- The GitHub repository (Code_Repository) is `asadhana/my-website`.
- The assistant that authored this workflow **cannot** access the Virtual_Machine
  or WordPress credentials. Every step that touches the Virtual_Machine or those
  credentials is a **Manual — Site_Owner** step that you (the Site_Owner) run
  yourself, from an SSH session on the Virtual_Machine unless stated otherwise.

> **How to read each step:** Every step below is labeled **Manual — Site_Owner**,
> gives the complete shell command to run (with any value you must substitute
> shown in `<angle-brackets>`), a **Verify** action whose observable result
> confirms the step succeeded, and a **Remediation** action to take if
> verification fails. Run the steps in the numbered order shown — each step
> assumes the previous steps have completed successfully.

---

## Repository Seeding

This section covers the one-time initialization that turns the live
`/var/www/html` install into a Git working tree, applies the Ignore_File
(`.gitignore`) so that live secrets and uploads are never tracked, and records
the first commit. Perform these steps once, before any deploy automation is
used.

**Prerequisites**

- SSH access to the Virtual_Machine as user `ubuntu`.
- Git installed on the Virtual_Machine (verified in Step 1).
- The Code_Repository `asadhana/my-website` already exists on GitHub and contains
  the committed automation surface (`.gitignore`, `wp-config-sample.php`,
  `.github/workflows/deploy.yml`, `scripts/deploy.sh`, `docs/`). You will merge
  that content with the live tree during seeding.

**Output → consumer summary** (see Requirement 8.4)

| Step | Produces | Consumed by |
|---|---|---|
| 2 | The active working directory `/var/www/html` | Steps 3–9 (all run from here) |
| 5 | The applied Ignore_File `.gitignore` in the working tree | Step 6 (staging), Step 7 (verification that secrets are excluded) |
| 8 | The first commit on branch `main` | Step 9 (push to GitHub) |
| 9 | The seeded remote `origin/main` | The Deploy_Workflow and the pull-request process (see later sections) |

---

### Step 1 — Confirm SSH access and Git availability

**Manual — Site_Owner**

Open an SSH session to the Virtual_Machine and confirm Git is installed.

```bash
ssh <ssh-user>@<vm-ip>
# For this site: ssh ubuntu@132.226.44.101
git --version
```

**Verify:** The `git --version` command prints a version string, for example
`git version 2.25.1`. This confirms you are logged in to the Virtual_Machine and
Git is available.

**Remediation:** If SSH fails to connect, confirm the IP `132.226.44.101` and the
user `ubuntu` are correct and that your local machine's key is authorized on the
VM. If `git --version` reports `command not found`, install Git and re-run this
step:

```bash
sudo apt-get update && sudo apt-get install -y git
```

---

### Step 2 — Change to the WordPress web root

**Manual — Site_Owner**

Move into the directory that holds the live WordPress install. All remaining
steps run from here.

```bash
cd /var/www/html
pwd
```

**Verify:** `pwd` prints exactly `/var/www/html`. This directory is the output
that every subsequent step operates in (see Requirement 8.4).

**Remediation:** If `cd` reports `No such file or directory`, confirm the install
location with `ls -d /var/www/html` (or ask your host where WordPress is rooted)
and use the correct path in place of `/var/www/html` for the rest of this
section.

---

### Step 3 — Back up the web root before initializing Git

**Manual — Site_Owner**

Take a safety archive of the live tree so seeding is fully reversible.

```bash
sudo tar -czf /var/backups/wp-preseed-<YYYYMMDD>.tar.gz -C /var/www/html .
```

**Verify:** The archive exists and is non-empty:

```bash
ls -lh /var/backups/wp-preseed-<YYYYMMDD>.tar.gz
```

The listing shows the file with a size greater than 0 bytes.

**Remediation:** If `tar` reports a permission error, re-run with `sudo` (shown
above). If `/var/backups` does not exist, create it first with
`sudo mkdir -p /var/backups` and re-run the command. Do not proceed to Step 4
until a valid backup exists.

---

### Step 4 — Initialize a Git repository in the web root

**Manual — Site_Owner**

Initialize Git in place and set the default branch to `main` (the branch that
reflects the deployed state of the site).

```bash
cd /var/www/html
git init
git branch -M main
```

**Verify:** A `.git` directory now exists and the current branch is `main`:

```bash
git rev-parse --is-inside-work-tree   # prints: true
git branch --show-current             # prints: main
```

**Remediation:** If `git init` reports a permission error, ensure your user can
write to `/var/www/html` (for example, temporarily
`sudo chown -R ubuntu:ubuntu /var/www/html`, run the commands, then restore
web-server ownership as described in the deploy documentation). If a `.git`
directory already exists from a prior attempt and is unwanted, remove it with
`rm -rf /var/www/html/.git` and re-run this step.

---

### Step 5 — Apply the Ignore_File (`.gitignore`)

**Manual — Site_Owner**

The Ignore_File must be present in the working tree **before** you stage files,
so that live secrets (`wp-config.php`) and user media (`wp-content/uploads`) are
never tracked. Fetch the committed `.gitignore` from the Code_Repository into the
web root.

```bash
cd /var/www/html
curl -fsSL \
  https://raw.githubusercontent.com/<github-owner>/<github-repo>/main/.gitignore \
  -o .gitignore
# For this site: https://raw.githubusercontent.com/asadhana/my-website/main/.gitignore
```

**Verify:** The `.gitignore` is present and lists the Excluded_Assets:

```bash
cat /var/www/html/.gitignore
```

The output includes at least the lines `wp-config.php` and
`wp-content/uploads/`. This applied `.gitignore` is the output consumed by
Step 6 (staging) and Step 7 (exclusion verification), per Requirement 8.4.

**Remediation:** If `curl` fails (network error, or the repository/branch is
private and unreachable), create the file manually instead. Run:

```bash
cat > /var/www/html/.gitignore <<'EOF'
# Live secrets — present only on the Virtual_Machine, never committed
wp-config.php

# User-generated media — managed via WordPress Admin, stored in DB/filesystem, not code
wp-content/uploads/

# Common local/build noise
*.log
.DS_Store
EOF
```

Then re-run the Verify step. Do not proceed to Step 6 until `.gitignore` contains
`wp-config.php` and `wp-content/uploads/`.

---

### Step 6 — Stage all tracked files

**Manual — Site_Owner**

Stage the working tree. Because the Ignore_File from Step 5 is in place, the
Excluded_Assets are automatically kept out of the staged set.

```bash
cd /var/www/html
git add -A
```

**Verify:** Review what is staged:

```bash
git status
```

The listing shows the tracked WordPress files (for example `index.php`,
`wp-admin/`, `wp-includes/`, `wp-content/themes/`, `wp-content/plugins/`) as
"Changes to be committed", and does **not** list `wp-config.php` or anything
under `wp-content/uploads/`.

**Remediation:** If `wp-config.php` or a path under `wp-content/uploads/` appears
in the staged set, the Ignore_File was not applied correctly. Unstage everything,
return to Step 5 to fix `.gitignore`, then repeat Step 6:

```bash
git reset
```

---

### Step 7 — Confirm the Excluded_Assets are ignored

**Manual — Site_Owner**

Independently confirm that Git is ignoring the live secrets and uploads before
you commit.

```bash
cd /var/www/html
git check-ignore -v wp-config.php wp-content/uploads
git ls-files --error-unmatch wp-config.php 2>/dev/null && echo "TRACKED (BAD)" || echo "not tracked (good)"
```

**Verify:** `git check-ignore -v` prints a matching `.gitignore` rule for both
`wp-config.php` and `wp-content/uploads` (confirming they are ignored), and the
second command prints `not tracked (good)`.

**Remediation:** If `git check-ignore` prints nothing for a path, that path is
**not** ignored. If the second command prints `TRACKED (BAD)`, the file was
committed/staged before the Ignore_File applied — remove it from tracking
without deleting it from disk, then return to Step 6:

```bash
git rm --cached wp-config.php
git rm -r --cached wp-content/uploads
```

Do not proceed to Step 8 until both Excluded_Assets verify as ignored.

---

### Step 8 — Create the first commit

**Manual — Site_Owner**

Record the seeded tree as the first commit on `main`. Set your commit identity
first if this VM has never made a commit.

```bash
cd /var/www/html
git config user.name  "<your-name>"
git config user.email "<your-email>"
git commit -m "Seed repository from live /var/www/html (excludes secrets and uploads)"
```

**Verify:** The commit was created and its tree omits the Excluded_Assets:

```bash
git log --oneline -1
git ls-tree -r --name-only HEAD | grep -E '^(wp-config\.php|wp-content/uploads/)' && echo "FOUND (BAD)" || echo "clean (good)"
```

The first command prints exactly one commit line with your message; the second
prints `clean (good)`. This commit is the output consumed by Step 9 (see
Requirement 8.4).

**Remediation:** If `git commit` reports `nothing to commit`, re-run Step 6 to
stage files. If it reports an identity error
(`Please tell me who you are`), run the two `git config` commands shown above,
then re-run the commit. If the second verification prints `FOUND (BAD)`, an
Excluded_Asset was committed — return to Step 7's remediation
(`git rm --cached …`), commit the removal, and re-verify.

---

### Step 9 — Connect the remote and push the first commit

**Manual — Site_Owner**

Point the local repository at the GitHub Code_Repository and publish the seeded
`main` branch.

```bash
cd /var/www/html
git remote add origin https://github.com/<github-owner>/<github-repo>.git
# For this site: https://github.com/asadhana/my-website.git
git push -u origin main
```

If prompted for credentials, use your GitHub username and a Personal Access Token
(`<github-personal-access-token>`) in place of a password.

**Verify:** The remote is set and the push succeeded:

```bash
git remote -v                 # shows origin -> https://github.com/asadhana/my-website.git (fetch/push)
git ls-remote --heads origin main   # prints a commit SHA next to refs/heads/main
```

On GitHub, the `asadhana/my-website` repository's `main` branch now shows the
seeded WordPress files and the first commit message.

**Remediation:** If `git remote add` reports `remote origin already exists`,
update it instead: `git remote set-url origin https://github.com/<github-owner>/<github-repo>.git`.
If the push is rejected because the remote already has commits (for example the
committed automation surface), integrate them first and push again:

```bash
git pull --rebase origin main
git push -u origin main
```

If authentication fails, generate a new Personal Access Token with `repo` scope
on GitHub and use it as the password when prompted. Do not force-push over the
remote `main`.

---

_Repository seeding is complete once Step 9 verifies. The next sections cover
Deploy_Key / Actions_Secret configuration and the pull-request process._


---

## Deploy Key and GitHub Actions Secrets

This section covers the one-time configuration that lets the Cloud_Runner
authenticate to the Virtual_Machine over SSH during the Deploy_Workflow. You will
generate the Deploy_Key SSH pair, install its **public** half on the
Virtual_Machine so the runner is authorized to connect, and store its **private**
half — together with the connection host and user — as GitHub Actions_Secrets in
the Code_Repository. Perform these steps once, after Repository Seeding
(Steps 1–9) has completed and before the first deployment.

**Prerequisites**

- Repository Seeding is complete: `asadhana/my-website` has a seeded `main`
  branch (Step 9).
- SSH access to the Virtual_Machine as user `ubuntu` (established in Step 1).
- Admin access to the Code_Repository on GitHub so you can open
  **Settings → Secrets and variables → Actions** and create repository secrets.

**Output → consumer summary** (see Requirement 8.4)

| Step | Produces | Consumed by |
|---|---|---|
| 10 | The Deploy_Key pair: private key `~/.ssh/deploy_key` and public key `~/.ssh/deploy_key.pub` (generated on your workstation) | Step 11 (public key) and Step 12 (private key) |
| 11 | The public key appended to `~ubuntu/.ssh/authorized_keys` on the Virtual_Machine | The Deploy_Workflow's SSH authentication step (`deploy.yml`), which connects as `ubuntu` |
| 12 | The Actions_Secret `DEPLOY_SSH_KEY` (private key) in the Code_Repository | The Deploy_Workflow step that loads the key into `ssh-agent` |
| 13 | The Actions_Secrets `DEPLOY_HOST` (`132.226.44.101`) and `DEPLOY_USER` (`ubuntu`) | The Deploy_Workflow, which uses them as the SSH connection target |

---

### Step 10 — Generate the Deploy_Key SSH pair

**Manual — Site_Owner**

Generate a dedicated key pair for deployment on your local workstation (not on
the Virtual_Machine). Keeping it separate from your personal SSH key lets you
rotate or revoke deploy access independently. Use `ed25519` and no passphrase, so
the Cloud_Runner can load it non-interactively.

```bash
ssh-keygen -t ed25519 -C "deploy@<github-repo>" -f ~/.ssh/deploy_key -N ""
# For this site: ssh-keygen -t ed25519 -C "deploy@my-website" -f ~/.ssh/deploy_key -N ""
```

**Verify:** Both halves of the pair now exist:

```bash
ls -l ~/.ssh/deploy_key ~/.ssh/deploy_key.pub
```

The listing shows two files: the private key `~/.ssh/deploy_key` and the public
key `~/.ssh/deploy_key.pub`. The private key file's permissions should be `600`
(`-rw-------`). These two files are the outputs consumed by Step 11 (the public
key) and Step 12 (the private key), per Requirement 8.4.

**Remediation:** If `ssh-keygen` reports that `~/.ssh/deploy_key` already exists,
either choose a different filename with `-f ~/.ssh/<deploy-key-name>` (and use
that name throughout the remaining steps) or, if the existing key is unused,
remove it with `rm ~/.ssh/deploy_key ~/.ssh/deploy_key.pub` and re-run this step.
If the private key permissions are not `600`, fix them with
`chmod 600 ~/.ssh/deploy_key`.

---

### Step 11 — Install the public key on the Virtual_Machine

**Manual — Site_Owner**

Authorize the Deploy_Key on the Virtual_Machine by appending its **public** half
to the `authorized_keys` file for the `ubuntu` user. This is what lets the
Cloud_Runner log in as `ubuntu` over SSH. Run this from your workstation (where
the key was generated).

```bash
ssh-copy-id -i ~/.ssh/deploy_key.pub <ssh-user>@<vm-ip>
# For this site: ssh-copy-id -i ~/.ssh/deploy_key.pub ubuntu@132.226.44.101
```

If `ssh-copy-id` is unavailable, append the public key manually:

```bash
cat ~/.ssh/deploy_key.pub | ssh <ssh-user>@<vm-ip> \
  "mkdir -p ~/.ssh && chmod 700 ~/.ssh && cat >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys"
# For this site: <ssh-user>@<vm-ip> = ubuntu@132.226.44.101
```

**Verify:** Confirm the public key is present in the Virtual_Machine's
`authorized_keys`, then confirm the Deploy_Key can authenticate on its own:

```bash
ssh <ssh-user>@<vm-ip> "grep -qF \"$(cat ~/.ssh/deploy_key.pub)\" ~/.ssh/authorized_keys && echo present || echo missing"
ssh -i ~/.ssh/deploy_key -o IdentitiesOnly=yes <ssh-user>@<vm-ip> "echo deploy-key-ok"
```

The first command prints `present`, confirming the public key was appended to
`~ubuntu/.ssh/authorized_keys` (the output consumed by the Deploy_Workflow's SSH
step, per Requirement 8.4). The second command prints `deploy-key-ok`, confirming
the Cloud_Runner will be able to authenticate using the private key alone.

**Remediation:** If the first command prints `missing`, re-run the manual append
command above and re-verify. If the second command prompts for a password or is
rejected, the key was not installed for the correct user or the file permissions
are wrong — on the Virtual_Machine ensure `~/.ssh` is mode `700` and
`~/.ssh/authorized_keys` is mode `600` and owned by `ubuntu`:

```bash
ssh <ssh-user>@<vm-ip> "chmod 700 ~/.ssh && chmod 600 ~/.ssh/authorized_keys && chown -R ubuntu:ubuntu ~/.ssh"
```

Then re-run the Verify step. Do not proceed to Step 12 until the Deploy_Key
authenticates without a password.

---

### Step 12 — Store the private key as the Actions_Secret `DEPLOY_SSH_KEY`

**Manual — Site_Owner**

Copy the **private** half of the Deploy_Key into the Code_Repository as the
Actions_Secret named `DEPLOY_SSH_KEY`. The Deploy_Workflow loads this secret into
`ssh-agent` on the Cloud_Runner to authenticate to the Virtual_Machine. Never
commit the private key to the repository — it belongs only in the encrypted
Actions_Secrets store.

First, display the full private key so you can copy it (include the
`-----BEGIN …-----` and `-----END …-----` lines):

```bash
cat ~/.ssh/deploy_key
```

Then create the secret in GitHub:

1. In the Code_Repository on GitHub, open
   **Settings → Secrets and variables → Actions**.
2. Click **New repository secret**.
3. Set **Name** to `DEPLOY_SSH_KEY`.
4. Paste the entire private key (all lines, including the BEGIN/END markers) into
   **Secret**, then click **Add secret**.

Alternatively, using the GitHub CLI from your workstation:

```bash
gh secret set DEPLOY_SSH_KEY --repo <github-owner>/<github-repo> < ~/.ssh/deploy_key
# For this site: gh secret set DEPLOY_SSH_KEY --repo asadhana/my-website < ~/.ssh/deploy_key
```

**Verify:** Confirm the secret exists in the Code_Repository:

- In the browser: **Settings → Secrets and variables → Actions** lists a
  repository secret named `DEPLOY_SSH_KEY` (its value is hidden — GitHub never
  displays secret values after saving).
- Or via CLI:

```bash
gh secret list --repo <github-owner>/<github-repo>
# For this site: gh secret list --repo asadhana/my-website
```

The listing includes a row named `DEPLOY_SSH_KEY`. This Actions_Secret is the
output consumed by the Deploy_Workflow's "load key into ssh-agent" step, per
Requirement 8.4.

**Remediation:** If `DEPLOY_SSH_KEY` does not appear, repeat the creation steps —
confirm you pasted the **private** key (from `~/.ssh/deploy_key`, not the
`.pub` file) and that the name is exactly `DEPLOY_SSH_KEY` (case-sensitive). If
the deployment later fails authentication, the pasted value was likely truncated
or missing the BEGIN/END lines — delete the secret and re-create it from the full
`cat ~/.ssh/deploy_key` output.

---

### Step 13 — Store the `DEPLOY_HOST` and `DEPLOY_USER` Actions_Secrets

**Manual — Site_Owner**

Create the two remaining Actions_Secrets that tell the Deploy_Workflow where to
connect and as which user. These are the SSH connection target consumed by the
Deploy_Workflow.

In the Code_Repository on GitHub, open
**Settings → Secrets and variables → Actions**, and add two repository secrets:

| Secret name | Value |
|---|---|
| `DEPLOY_HOST` | `132.226.44.101` |
| `DEPLOY_USER` | `ubuntu` |

Or via the GitHub CLI from your workstation:

```bash
gh secret set DEPLOY_HOST --repo <github-owner>/<github-repo> --body "<vm-ip>"
gh secret set DEPLOY_USER --repo <github-owner>/<github-repo> --body "<ssh-user>"
# For this site:
# gh secret set DEPLOY_HOST --repo asadhana/my-website --body "132.226.44.101"
# gh secret set DEPLOY_USER --repo asadhana/my-website --body "ubuntu"
```

**Verify:** Both secrets are listed for the Code_Repository:

```bash
gh secret list --repo <github-owner>/<github-repo>
# For this site: gh secret list --repo asadhana/my-website
```

The listing now includes `DEPLOY_SSH_KEY`, `DEPLOY_HOST`, and `DEPLOY_USER`.
Together these three Actions_Secrets are the outputs consumed by the
Deploy_Workflow (`.github/workflows/deploy.yml`) to authenticate to the
Virtual_Machine, per Requirement 8.4.

**Remediation:** If either secret is missing, re-add it, confirming the names are
exactly `DEPLOY_HOST` and `DEPLOY_USER` (case-sensitive) and that the values
contain no surrounding quotes or trailing whitespace. If a deployment later fails
to resolve or connect to the host, verify `DEPLOY_HOST` is `132.226.44.101` and
`DEPLOY_USER` is `ubuntu` by re-creating the secret with the correct value.

---

_Deploy_Key and Actions_Secret configuration is complete once Step 13 verifies
that `DEPLOY_SSH_KEY`, `DEPLOY_HOST`, and `DEPLOY_USER` all exist in the
Code_Repository and the Deploy_Key authenticates to the Virtual_Machine (Step 11).
The next section covers the pull-request process._



---

## Pull-Request Process

This section describes how to change the site's code safely: you propose every
change on a **feature branch**, open a **pull request (PR) targeting `main`**,
obtain **at least one approving review**, and then **merge** the approved PR into
`main`. The `main` branch reflects the **deployed state** of the WordPress_Site —
its tip is what the Deploy_Workflow last synced to `/var/www/html`. Merging an
approved PR into `main` is therefore the action that ships a change: the merge
triggers the Deploy_Workflow, which deploys the reviewed code to the
Virtual_Machine.

Because a merge to `main` deploys to the live site, you never commit directly to
`main`. All work flows through a reviewed PR so every change reaching the site
has been recorded and approved by at least one reviewer.

**Prerequisites**

- Repository Seeding is complete: `asadhana/my-website` has a seeded `main`
  branch (Step 9).
- Branch protection is enabled on `main` in the Code_Repository so that a PR
  cannot be merged until it has at least one approving review (see the
  **Branch-protection setup** note at the end of this section).
- The GitHub CLI (`gh`) is authenticated on your workstation
  (`gh auth status` reports a logged-in account), or you use the GitHub web UI
  for the review/merge steps. Steps that use `gh` or the web UI run from your
  **workstation**, not the Virtual_Machine.

**Output → consumer summary** (see Requirement 8.4)

| Step | Produces | Consumed by |
|---|---|---|
| 14 | A feature branch containing one or more commits | Step 15 (the PR's head branch) |
| 15 | An open pull request targeting `main` | Step 16 (the review) and Step 17 (the merge) |
| 16 | At least one approving review on the PR | Step 17 (which is blocked until this exists) |
| 17 | An updated `main` tip and the merged change | The Deploy_Workflow (triggered by the merge to `main`) |

---

### Step 14 — Create a feature branch and commit the change

**Manual — Site_Owner**

Start every change from an up-to-date `main`, create a short-lived feature
branch, make your edits, and commit them. Working on a branch keeps `main`
(the deployed state) untouched until the change is reviewed.

```bash
git checkout main
git pull origin main
git checkout -b <feature-branch-name>
# For example: git checkout -b fix/footer-copyright-year

# ...make your code edits...

git add <changed-files>
git commit -m "<concise description of the change>"
```

**Verify:** You are on the feature branch and it carries your new commit:

```bash
git branch --show-current   # prints: <feature-branch-name> (not main)
git log --oneline -1        # prints your commit message
```

**Remediation:** If `git checkout -b` reports the branch already exists, pick a
different `<feature-branch-name>` or switch to the existing one with
`git checkout <feature-branch-name>`. If you accidentally committed on `main`,
move the commit onto a branch and reset `main` to the remote before continuing:

```bash
git branch <feature-branch-name>          # save the work on a branch
git reset --hard origin/main              # restore local main to the deployed state
git checkout <feature-branch-name>
```

---

### Step 15 — Push the branch and open a pull request targeting `main`

**Manual — Site_Owner**

Publish the feature branch to the Code_Repository and open a PR whose **base**
is `main` and whose **head** is your feature branch.

```bash
git push -u origin <feature-branch-name>

gh pr create \
  --repo <github-owner>/<github-repo> \
  --base main \
  --head <feature-branch-name> \
  --title "<pull-request-title>" \
  --body  "<what-changed-and-why>"
# For this site: --repo asadhana/my-website
```

If you prefer the web UI, open
`https://github.com/<github-owner>/<github-repo>/pull/new/<feature-branch-name>`,
confirm the **base** dropdown shows `main`, fill in a title and description, and
click **Create pull request**.

**Verify:** The PR exists and targets `main`:

```bash
gh pr view <feature-branch-name> --repo <github-owner>/<github-repo> \
  --json number,baseRefName,state
# For this site: --repo asadhana/my-website
```

The output shows `"baseRefName": "main"` and `"state": "OPEN"`. On GitHub, the
`asadhana/my-website` **Pull requests** tab lists the new PR with base `main`.

**Remediation:** If the push is rejected, run `git pull --rebase origin main`,
resolve any conflicts, then push again. If `gh pr create` reports the base is
wrong, re-run it with `--base main`. If the PR was opened against the wrong base
branch in the web UI, edit the PR and change the base to `main` rather than
opening a new one.

---

### Step 16 — Obtain at least one approving review

**Manual — Site_Owner**

Have a reviewer examine the PR and submit an **approving** review. Branch
protection on `main` blocks the merge until at least one approval is recorded, so
this step is mandatory before Step 17. Request a review, then the reviewer
approves it.

Request review (optional if the reviewer is already assigned):

```bash
gh pr edit <feature-branch-name> --repo <github-owner>/<github-repo> \
  --add-reviewer <reviewer-github-username>
```

The reviewer (on their own account) approves via the web UI
(**Files changed → Review changes → Approve → Submit review**) or with the CLI:

```bash
gh pr review <pr-number> --repo <github-owner>/<github-repo> --approve
```

**Verify:** The PR has at least one approving review and reports as mergeable:

```bash
gh pr view <pr-number> --repo <github-owner>/<github-repo> \
  --json reviewDecision,mergeStateStatus
# For this site: --repo asadhana/my-website
```

The output shows `"reviewDecision": "APPROVED"`. On the PR page, the merge box
changes from a blocked state ("Review required" / merge button disabled) to
showing at least one approval and an enabled merge button.

**Remediation:** If the merge box still reads "Review required" or the merge
button stays disabled, no approving review has been recorded yet — confirm the
reviewer submitted an **Approve** (not just a comment or "Request changes") and
that the review is on the current commit. If the reviewer requested changes,
address the feedback with additional commits on the feature branch, push them
(the PR updates automatically), and ask for re-review. A change cannot reach
`main` — and therefore cannot deploy — without an approving review.

---

### Step 17 — Merge the approved pull request into `main`

**Manual — Site_Owner**

Once the PR has an approving review, merge it into `main`. This updates the
deployed-state branch and triggers the Deploy_Workflow, which syncs the reviewed
code to `/var/www/html` on the Virtual_Machine. Delete the feature branch after
merging to keep the repository tidy.

```bash
gh pr merge <pr-number> --repo <github-owner>/<github-repo> --merge --delete-branch
# For this site: --repo asadhana/my-website
```

You may substitute `--squash` for `--merge` if you prefer a single squashed
commit on `main`; either way the merge to `main` is what triggers deployment. In
the web UI, click **Merge pull request → Confirm merge**, then **Delete branch**.

**Verify:** The change is on `main` and the Deploy_Workflow started:

```bash
gh pr view <pr-number> --repo <github-owner>/<github-repo> --json state,merged
# shows "state": "MERGED", "merged": true

gh run list --repo <github-owner>/<github-repo> --branch main --limit 1
# For this site: --repo asadhana/my-website
```

The `gh run list` output shows a Deploy_Workflow run for `main` that started at or
just after the merge (a run appears within about a minute of the merge
completing). On GitHub, the repository's **Actions** tab shows a new
Deploy_Workflow run triggered by the push to `main`; when it finishes
successfully the change is live on `zixhr.com`.

**Remediation:** If the merge button is disabled or `gh pr merge` reports the PR
is not mergeable, return to Step 16 — an approving review is still missing or a
required check has not passed. If the merge succeeds but **no** Deploy_Workflow
run appears within about a minute, open the **Actions** tab to confirm the merge
event was recorded and that `.github/workflows/deploy.yml` is present on `main`
with a `push` trigger for the `main` branch; a run that fails after starting is
diagnosed from its logs in the Actions tab (and, for SSH/authentication issues,
against the Deploy_Key configuration in the previous section).

---

**Branch-protection setup (one-time, Manual — Site_Owner).** For Step 16 to block
merges until a review exists, enable a branch protection rule on `main` in the
Code_Repository. In the browser, open **Settings → Branches → Add branch
protection rule**, set the branch name pattern to `main`, and enable **Require a
pull request before merging** with **Require approvals** set to at least `1`.
Equivalent via the GitHub CLI from your workstation:

```bash
gh api -X PUT repos/<github-owner>/<github-repo>/branches/main/protection \
  -H "Accept: application/vnd.github+json" \
  -f "required_pull_request_reviews[required_approving_review_count]=1" \
  -F "enforce_admins=true" \
  -F "required_status_checks=null" \
  -F "restrictions=null"
# For this site: repos/asadhana/my-website/branches/main/protection
```

**Verify:** `gh api repos/<github-owner>/<github-repo>/branches/main/protection`
returns a body containing `required_pull_request_reviews` with
`required_approving_review_count` of at least `1`. With this rule active, a PR
targeting `main` cannot be merged until it has at least one approving review,
enforcing the review gate described in Steps 16–17.

---

_The pull-request process is complete once Step 17 verifies that the PR merged
into `main` and the Deploy_Workflow was triggered. From here, every subsequent
code change repeats Steps 14–17: branch → PR to `main` → approving review →
merge → deploy._



---

## Content and Settings Management

This section states how site content and settings are managed and why they are
deliberately kept out of the Code_Repository. Unlike the preceding sections,
these are **informational statements** describing the operating boundary between
the source-controlled code and the site's runtime content — they are not
numbered **Manual — Site_Owner** command steps. Understanding this boundary is
what keeps the Git/PR/deploy workflow (code) from ever colliding with day-to-day
content editing (WordPress Admin).

**Where content and settings live**

- **Site content and settings are managed exclusively through the WordPress
  Admin interface.** Pages, posts, menus, widgets, theme customizer options,
  plugin configuration, and all other site settings are created and edited by the
  Site_Owner from WordPress Admin (`https://zixhr.com/wp-admin`) — never by
  editing files in the Code_Repository and never through the pull-request or
  Deploy_Workflow process. The reviewed-code workflow described in the earlier
  sections governs **code** (themes, plugins, and other files under
  `/var/www/html`); it is not the mechanism for changing content or settings.

- **Site content and settings are stored in the WordPress database and are
  excluded from the Code_Repository.** WordPress persists content and settings in
  its MySQL/MariaDB database on the Virtual_Machine, not in tracked files, so the
  Code_Repository tracks **code only** and does not represent site content. The
  Excluded_Assets reinforce this boundary: user-uploaded media under
  `wp-content/uploads` and the live secrets in `wp-config.php` are excluded from
  version control via the Ignore_File (`.gitignore`) — as verified during
  Repository Seeding (Steps 5–7) — so neither the database-backed content nor the
  uploaded media and live credentials are ever committed or deployed.

**Why this separation matters**

Keeping content and settings in the WordPress database (managed via WordPress
Admin) and keeping only code in the Code_Repository means the two never conflict:
a merge to `main` deploys reviewed code to `/var/www/html` without touching the
database, and because the Deploy_Sync excludes `wp-config.php` and
`wp-content/uploads`, deployments never overwrite live credentials or
user-uploaded media (see the Deploy_Workflow's preservation behavior). Content
changes made in WordPress Admin therefore survive every deployment untouched, and
code changes flow only through the reviewed pull-request path.

---

_Content and settings management is intentionally separate from the code
workflow: content and settings live in the WordPress database and are edited in
WordPress Admin, while the Code_Repository tracks code only and excludes
`wp-config.php` and `wp-content/uploads` from version control._
