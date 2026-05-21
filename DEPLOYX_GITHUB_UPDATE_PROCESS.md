# PHPix DeployX GitHub Update Process

This file documents the exact process for creating and publishing a PHPix incremental update package to the GitHub updates repository.

Use this process when instructed to deploy or update the GitHub package repo for PHPix.

## Goal

Create a new incremental update zip through `PHPIX-DEPLOYX`, copy the generated files into the local GitHub packages repo, and push the update to GitHub.

## Local Paths

- Working app repo:
  - `D:\XAMPP\htdocs\phpix`
- DeployX folder:
  - `D:\XAMPP\htdocs\PHPIX-DEPLOYX`
- DeployX changelog file:
  - `D:\XAMPP\htdocs\PHPIX-DEPLOYX\changelog.html`
- DeployX builder page:
  - `http://localhost/PHPIX-DEPLOYX/create-update.php`
- Local GitHub packages repo:
  - `D:\GITHUB\phpix-packages`
- Local update package folder inside Git repo:
  - `D:\GITHUB\phpix-packages\phpix-updates`
- Remote GitHub repo:
  - `https://github.com/phploaded/phpix-packages`

## Important Rules

### 1. Changelog format is strict

`D:\XAMPP\htdocs\PHPIX-DEPLOYX\changelog.html` must contain plain HTML list markup only:

```html
<ul>
<li>First update line.</li>
<li>Second update line.</li>
</ul>
```

Rules:

- Use short, plain update lines.
- Keep them safe for the updater script.
- Do not put quotes inside the changelog lines unless absolutely necessary.
- Avoid special characters that may break the AJAX updater reader.
- Keep the file in `ul` and `li` format only.

If there is no clear previous deployment context, summarize the major work done recently, preferably from the last week.

### 2. The order matters

Follow the steps in the exact order below.

### 3. Wait for the builder to finish

Do not assume the zip is ready immediately after opening the builder page.

The process is complete only when the page shows:

`Update process completed.`

### 4. Use the generated version, not guesses

The currently published version is read from:

- `D:\GITHUB\phpix-packages\phpix-updates\updates.json`

The new generated version comes from:

- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\updates.json`

Do not assume the next number without checking.

## Exact Deployment Steps

### Step 1. Review current package version

Read:

- `D:\GITHUB\phpix-packages\phpix-updates\updates.json`

Check the value of:

- `latest`

Example:

- If `latest` is `2.08`, the next generated package should become `2.09`.

This step is for awareness. The builder itself creates the next version automatically.

### Step 2. Update the changelog

Edit:

- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\changelog.html`

Write a short list of meaningful changes included in this release.

Recommended style:

```html
<ul>
<li>Cluster manager added for face review, merge, move, delete, finalize and tag assignment.</li>
<li>Face tags now use real face boxes and manual tag boxes are resizable on touch screens.</li>
<li>AI photos mode added with viewer toggle, AI downloads and optional AI image loading.</li>
</ul>
```

### Step 3. Run the DeployX builder page

Open:

- `http://localhost/PHPIX-DEPLOYX/create-update.php`

Wait until the page finishes and visibly contains:

- `Update process completed.`

Do not continue before that text appears.

### Step 4. Read the newly generated DeployX metadata

After the builder finishes, read:

- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\updates.json`

Check:

- `latest`

This gives the exact new version number created by the builder.

Example:

- old GitHub `latest`: `2.08`
- new DeployX `latest`: `2.09`

The generated zip should then be:

- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\2.09.zip`

### Step 5. Verify the new zip exists

Confirm that this file exists:

- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\<new-version>.zip`

Example:

- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\2.09.zip`

### Step 6. Copy generated files into the GitHub packages repo

Copy these two files:

- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\<new-version>.zip`
- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\updates.json`

Into:

- `D:\GITHUB\phpix-packages\phpix-updates`

Overwrite if they already exist.

Example:

- copy `D:\XAMPP\htdocs\PHPIX-DEPLOYX\2.09.zip`
- copy `D:\XAMPP\htdocs\PHPIX-DEPLOYX\updates.json`

to:

- `D:\GITHUB\phpix-packages\phpix-updates\2.09.zip`
- `D:\GITHUB\phpix-packages\phpix-updates\updates.json`

### Step 7. Commit and push the GitHub repo

Git repo path:

- `D:\GITHUB\phpix-packages`

Expected changed files usually:

- `phpix-updates\updates.json`
- `phpix-updates\<new-version>.zip`

Recommended commands:

```powershell
git -C D:\GITHUB\phpix-packages status --short --branch
git -C D:\GITHUB\phpix-packages add phpix-updates\updates.json phpix-updates\<new-version>.zip
git -C D:\GITHUB\phpix-packages commit -m "Add phpix update <new-version>"
git -C D:\GITHUB\phpix-packages push origin main
```

Example:

```powershell
git -C D:\GITHUB\phpix-packages add phpix-updates\updates.json phpix-updates\2.09.zip
git -C D:\GITHUB\phpix-packages commit -m "Add phpix update 2.09"
git -C D:\GITHUB\phpix-packages push origin main
```

## Final Success Criteria

The deployment is successful only if all of the following are true:

- `changelog.html` was updated properly.
- `create-update.php` finished and showed `Update process completed.`
- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\updates.json` contains the new version.
- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\<new-version>.zip` exists.
- both the zip and `updates.json` were copied into `D:\GITHUB\phpix-packages\phpix-updates`
- the Git commit succeeded
- the Git push succeeded

## What To Report Back

If successful, report:

- success
- the new version number
- the commit hash

Example:

- Success
- version: `2.09`
- commit: `e93d708`

If failed, report the exact reason and the exact step that failed.

## Recommended Agent Checklist

Use this checklist every time:

1. Read current GitHub `updates.json`
2. Update `PHPIX-DEPLOYX\changelog.html`
3. Run `http://localhost/PHPIX-DEPLOYX/create-update.php`
4. Wait for `Update process completed.`
5. Read `PHPIX-DEPLOYX\updates.json`
6. Confirm new zip exists
7. Copy zip and `updates.json` to `D:\GITHUB\phpix-packages\phpix-updates`
8. `git status`
9. `git add`
10. `git commit`
11. `git push`
12. Report success or exact failure reason

## Notes From Real Execution

During one successful run, this exact pattern was used:

- old version in GitHub repo: `2.08`
- new generated version in DeployX: `2.09`
- zip copied from:
  - `D:\XAMPP\htdocs\PHPIX-DEPLOYX\2.09.zip`
- files copied into:
  - `D:\GITHUB\phpix-packages\phpix-updates`
- commit message:
  - `Add phpix update 2.09`

This confirms the documented process works.
