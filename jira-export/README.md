# Jira Import — zixhr.com WordPress GitHub Workflow

`jira-import.csv` maps the implementation plan into Jira Epics and Stories for
import via **Jira → Settings → System → External System Import → CSV**.

- **7 Epics** = the top-level task groups
- **24 Stories** = the sub-tasks (optional tests/checklists are labeled `optional;test`)
- All issues carry the label `zixhr-wp-workflow`
- Target project key: `ZIXHR-MOD`

## Column mapping (on the Jira import screen)

| CSV column   | Jira field  |
|--------------|-------------|
| Issue Type   | Issue Type  |
| Summary      | Summary     |
| Epic Name    | Epic Name   |
| Epic Link    | Epic Link   |
| Description  | Description |
| Labels       | Labels      |

> Note: `Epic Name` / `Epic Link` work directly in **company-managed** projects.
> For **team-managed** projects, import the issues then attach Stories to Epics
> in the backlog (or request a team-managed-formatted file).
