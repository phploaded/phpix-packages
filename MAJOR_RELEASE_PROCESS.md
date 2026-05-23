## PHPix Major Release Process

Use this process when creating a full major release from the current local installation at `D:\XAMPP\htdocs\phpix`.

### 1. Confirm local install is already on latest updater version

- Open or request `http://localhost/phpix/phpix-manage.php?page=update`.
- Wait for the AJAX result.
- Proceed only if it says:
  - `No new updates found! You are using the latest version of PHPix!`
- If any update is available, stop and tell the user to update first.

### 2. Read release version

- Read `D:\XAMPP\htdocs\phpix\phpix-info.php`
- Use `$software_version` as the release zip version.
- Example zip name: `PHPix-2.13.zip`

### 3. Prepare staging folder

- Staging folder is:
  - `D:\XAMPP\htdocs\PHPIX-DEPLOYX\major-release`
- Rebuild the staging tree from the current local install:
  - source: `D:\XAMPP\htdocs\phpix`
  - destination: `D:\XAMPP\htdocs\PHPIX-DEPLOYX\major-release`

### 4. Exclude these folders completely

- `/cluster-manager/`
- `/local-face-processing/`

### 5. Exclude markdown files

- Remove all `.md` files except `README.md`

### 6. Clean generated/media folders

In the staged release, delete everything inside these folders except `index.html`:

- `/temp/`
- `/cache/`
- `/thumb/`
- `/2k/`
- `/ai/`
- `/fhd/`
- `/hd/`
- `/full/`

### 7. Rename xthumb file

- Find `xthumb-<random>.php`
- Rename it to:
  - `xthumb-rt37yp.php`

### 8. Update installer for fresh install

Edit staged:
- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\major-release\phpix-install.php`

Rules:
- Include all current PHPix tables except `px_cm_*`
- Use current live DB structure from the local `phpix` database
- Do not include user content or unwanted live data
- Keep only needed fresh-install seed data

Seed/system data should include only what is needed for a blank install, such as:
- `px_dirs` default rows
- `px_import` defaults
- bundled package rows

Do not include:
- `px_cm_*` tables
- live uploads
- live albums
- live users
- live access rows
- live spot content

### 9. Sanitize config if needed

Check staged:
- `D:\XAMPP\htdocs\PHPIX-DEPLOYX\major-release\phpix-config.php`

Do not ship local/private secrets. Replace local-only values with safe defaults if needed.

### 10. Build release zip

- Create zip inside:
  - `D:\XAMPP\htdocs\PHPIX-DEPLOYX\major-release`
- Name it:
  - `PHPix-<software_version>.zip`

### 11. Copy release tree to GitHub clone

- GitHub repo local clone:
  - `D:\GITHUB\PHPix`
- Replace/update that repo with the staged release contents

### 12. Verify final important points before commit

Check these again:
- updater page was already latest
- excluded folders are not present
- cleaned folders contain only `index.html`
- `thumb` is also cleaned
- `xthumb-rt37yp.php` exists
- `phpix-install.php` is updated for fresh install
- release zip exists with correct version name

### 13. Commit and push GitHub repo

In `D:\GITHUB\PHPix`:

- `git add -A`
- `git commit -m "Prepare PHPix <version> major release"`
- `git push origin master`

If a follow-up fix is needed, commit that too with a precise message and push again.

### 14. Report back

Return:
- success or failure
- zip path
- repo path
- commit hash
- push status

### Notes from the last successful run

- Updater latest-state check was mandatory before release work.
- `thumb` also had to be cleaned to `index.html` only.
- The live install at `D:\XAMPP\htdocs\phpix` should remain untouched; build from a staged copy.
