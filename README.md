# Kepa's Link Ninja

A Linktree-style link page for WordPress — built specifically for musicians.
Add your social media, streaming platforms, and new releases all in one beautiful page.

---

## Table of Contents

1. [Before You Install — Safety Checklist](#1-before-you-install--safety-checklist)
2. [System Requirements](#2-system-requirements)
3. [Installation Method A — WordPress Admin (Recommended)](#3-installation-method-a--wordpress-admin-recommended)
4. [Installation Method B — FTP / SFTP](#4-installation-method-b--ftp--sftp)
5. [First Setup After Installation](#5-first-setup-after-installation)
6. [Divi Builder Compatibility](#6-divi-builder-compatibility)
7. [How to Safely Test Before Going Live](#7-how-to-safely-test-before-going-live)
8. [How to Update the Plugin](#8-how-to-update-the-plugin)
9. [How to Uninstall Safely](#9-how-to-uninstall-safely)
10. [Troubleshooting](#10-troubleshooting)
11. [What Data the Plugin Stores](#11-what-data-the-plugin-stores)

---

## 1. Before You Install — Safety Checklist

Run through this checklist **before** doing anything. It takes 5 minutes and protects you from losing work.

### Step 1 — Back up your site

> **This is the single most important step. Do not skip it.**

A full backup means that even if something goes wrong you can restore your site to exactly how it was — in minutes.

**How to back up (choose one method):**

- **UpdraftPlus (free plugin)** — Go to Plugins → Add New → search "UpdraftPlus" → Install and Activate → Settings → UpdraftPlus Backups → Backup Now. Store the backup files somewhere safe (your computer, Google Drive, Dropbox).
- **Through your hosting control panel** — cPanel, Plesk, Kinsta, WP Engine, SiteGround, Cloudways, etc. all have one-click backup tools. Use them.
- **Manually via FTP** — Download the entire `public_html` or `www` folder and export the database via phpMyAdmin.

A good backup includes:
- All WordPress files (plugins, themes, uploads)
- The database (posts, pages, settings, users)

### Step 2 — Check your PHP version

This plugin requires **PHP 7.4 or higher** (PHP 8.0+ is recommended).

How to check:
1. Go to WordPress Admin → Tools → Site Health → Info tab → Server
2. Look for "PHP version"
3. If it says 7.3 or lower, ask your hosting provider to upgrade PHP before you install this plugin

### Step 3 — Check for plugin conflicts (optional but good practice)

If you have a lot of plugins active, consider whether any of them might conflict:
- Security plugins that block POST requests (Wordfence, iThemes Security) — usually fine, but worth noting
- Caching plugins (WP Rocket, W3 Total Cache, LiteSpeed) — will work fine, but remember to clear cache after saving changes
- Page builder plugins other than Divi — should not conflict, this plugin uses its own template

---

## 2. System Requirements

| Requirement | Minimum | Recommended |
|---|---|---|
| WordPress | 5.9 | 6.4 or higher |
| PHP | 7.4 | 8.0 or higher |
| MySQL / MariaDB | 5.6 | 8.0 |
| Browser (admin) | Chrome 80+ / Firefox 75+ | Latest version |

The plugin **does not** require:
- Any paid libraries or services
- An account with any external service
- WooCommerce or any other plugin

---

## 3. Installation Method A — WordPress Admin (Recommended)

This is the easiest and safest way. WordPress handles everything automatically.

### Step 1 — Prepare the plugin folder

The plugin folder must be named exactly: `kepas-link-ninja`

If your folder is named something else (like `kepasLinkNinja` or `kepas-link-ninja-main`), rename it to `kepas-link-ninja` first.

Then zip the folder:
- **Windows**: Right-click the `kepas-link-ninja` folder → Send to → Compressed (zipped) folder
- **Mac**: Right-click the `kepas-link-ninja` folder → Compress "kepas-link-ninja"

The resulting file should be named `kepas-link-ninja.zip`.

### Step 2 — Upload via WordPress Admin

1. Log in to your WordPress Admin (yoursite.com/wp-admin)
2. Go to **Plugins → Add New Plugin**
3. Click **Upload Plugin** (top of the page)
4. Click **Choose File** and select your `kepas-link-ninja.zip`
5. Click **Install Now**
6. WordPress will upload and unpack the plugin
7. Click **Activate Plugin**

### Step 3 — Verify installation

After activation:
- You should see **"Link Ninja"** in the left WordPress sidebar (below the Dashboard items)
- A page called **"Links"** should have been created automatically (check Pages → All Pages)
- There should be NO error messages on screen

If you see a white screen or PHP error message, see the [Troubleshooting](#10-troubleshooting) section.

---

## 4. Installation Method B — FTP / SFTP

Use this method only if the admin upload fails, or if you prefer direct server access.

> **Important:** Always use **SFTP** (Secure FTP), not plain FTP. Plain FTP sends your credentials unencrypted over the internet. Use FileZilla, Cyberduck, or your hosting control panel's file manager.

### Step 1 — Connect to your server

You need:
- Your hosting SFTP hostname, username, password (or SSH key)
- Find these in your hosting control panel (cPanel → FTP Accounts, or ask your host)

### Step 2 — Navigate to the plugins folder

In your SFTP client, go to:
```
/public_html/wp-content/plugins/
```
(On some hosts the path is `/www/wp-content/plugins/` or `/httpdocs/wp-content/plugins/`)

### Step 3 — Upload the plugin folder

- Drag the `kepas-link-ninja` folder (not the zip) from your computer into the `plugins/` folder on the server
- Wait for the upload to complete fully before doing anything else

### Step 4 — Set correct permissions

After uploading, check that permissions are set correctly:
- **Folders** should be `755`
- **Files** should be `644`

Most SFTP clients let you right-click → File Permissions. If you're unsure, the defaults your SFTP client sets are usually correct.

### Step 5 — Activate in WordPress

1. Go to WordPress Admin → Plugins → Installed Plugins
2. Find **Kepa's Link Ninja** in the list
3. Click **Activate**

---

## 5. First Setup After Installation

Once the plugin is activated:

1. **Click "Link Ninja"** in the WordPress sidebar
2. Go to the **Profile tab** — add your name, bio, and upload a photo
3. Go to the **Links tab** — add your Social Media, Streaming, and Release sections
4. Go to the **Appearance tab** — pick your colours and style
5. Click the purple **Save Changes** button (top right)
6. Go to the **Settings tab** — click "View Page" to see your live link page
7. Copy that URL and add it to your Instagram bio, email signature, etc.

The **Help & Guide tab** inside the plugin explains every feature in detail.

---

## 6. Divi Builder Compatibility

This plugin is built to be **completely safe with Divi**.

### How it works

When someone visits your Link Ninja page, this plugin replaces the page template **before** Divi loads — using WordPress's `template_include` filter at priority 99. Divi never runs on that page.

### What this means for you

| Situation | What happens |
|---|---|
| Open Link Ninja page in browser | Shows the Link Ninja template — Divi is not involved |
| Open Link Ninja page in Divi Visual Builder | Do not do this — the builder has nothing to work with here |
| Edit any other page with Divi | Works exactly as normal |
| Edit Link Ninja page in WordPress classic editor | You can edit the page title, but the content is managed by the plugin |
| Divi theme options / global styles | Unaffected — still apply everywhere except the Link Ninja page |

### Recommended Divi settings

No special Divi settings are required. The plugin works out of the box.

If you use a Divi child theme, the plugin still works correctly — it replaces the template entirely.

---

## 7. How to Safely Test Before Going Live

**Best practice: always test on a staging site first.**

A staging site is an exact copy of your WordPress installation where you can test changes without affecting your live site. Most good hosting providers offer one-click staging.

**Hosting providers with built-in staging:**
- WP Engine: Sites → [your site] → Copy to Staging
- Kinsta: MyKinsta → Sites → [your site] → Staging
- SiteGround: Site Tools → WordPress → Staging
- Cloudways: Applications → [your app] → Staging Management

**If your host does not offer staging:**
- Install and activate the free plugin **WP Staging** (wordpress.org/plugins/wp-staging)
- It creates a local copy of your site you can safely test on

**Testing checklist:**
- [ ] Plugin activates without errors
- [ ] "Links" page was created
- [ ] Profile, links, and appearance save correctly
- [ ] Link page displays correctly in a browser
- [ ] Link page looks good on mobile (use browser DevTools → toggle device toolbar)
- [ ] Divi pages still work normally
- [ ] No errors in WP Admin → Tools → Site Health

---

## 8. How to Update the Plugin

Your links and settings are stored in the database and **are not lost** when you update. You can safely replace the plugin files.

### Option A — Update from first version (or any manual update)

Use this when you have v1.0.0 (or any version) and want to install a newer version from GitHub.

1. **Back up your site** (see Section 1).
2. **Download** the latest code from GitHub (clone the repo or use **Code → Download ZIP**).
3. **Rename** the folder to exactly **`kepas-link-ninja`** (e.g. if the folder is `kepasLinkNinja-main`, rename it to `kepas-link-ninja`).
4. **Zip** that folder so the zip contains one folder named `kepas-link-ninja` with all plugin files inside.
5. In WordPress: **Plugins → Add New → Upload Plugin** → choose your zip → **Install Now** → when asked, choose **Replace current with upload**.
6. Your links, profile, and appearance stay intact.

**Alternative (FTP):** Upload the new `kepas-link-ninja` folder over the old one in `wp-content/plugins/`. Then refresh the Plugins page. No need to deactivate.

### Option B — One-click update from GitHub (after you set it up)

To get an **Update** link on the Plugins page that installs from GitHub:

1. On GitHub, create a **Release** (e.g. tag `v1.0.1`).
2. **Attach a .zip file** to the release. The zip must contain **one folder named `kepas-link-ninja`** with the plugin files inside (same as in Option A, step 4).
3. In WordPress: **Link Ninja → Settings** → click **Check for updates** → you are taken to the Plugins page.
4. If a new version is available, click **Update now** next to Kepa's Link Ninja.

The plugin checks the repo **kepanadolski/kepasLinkNinja** by default. To use a different repo, define `KLN_GITHUB_REPO` in the main plugin file (e.g. `define( 'KLN_GITHUB_REPO', 'yourname/your-repo' );`).

---

## 9. How to Uninstall Safely

### Deactivate only (keeps all data)

1. Go to WordPress Admin → Plugins
2. Click **Deactivate** next to Kepa's Link Ninja
3. Your links, profile, and settings are preserved
4. The link page will fall back to your default theme template (it will look like a blank page until you reactivate)

### Full removal (deletes everything)

1. Go to WordPress Admin → Plugins
2. Deactivate the plugin
3. Click **Delete**
4. Manually delete the following database options (via phpMyAdmin or a plugin like WP-Optimize):
   - `kln_profile`
   - `kln_appearance`
   - `kln_sections`
   - `kln_page_id`
5. Optionally, delete the "Links" page from Pages → All Pages

---

## 10. Troubleshooting

### White screen / blank page after activating

**Cause:** PHP error, usually a version incompatibility.

**Fix:**
1. In your hosting control panel, enable PHP error display or check the PHP error log
2. Make sure you are running PHP 7.4 or higher (see Section 2)
3. If you cannot access the admin, connect via SFTP, navigate to `wp-content/plugins/`, and rename the `kepas-link-ninja` folder to `kepas-link-ninja-disabled` — this deactivates the plugin without needing admin access
4. Once the admin is accessible again, check your PHP version and fix it, then rename the folder back

### "Links" page shows the Divi/theme template instead of the Link Ninja page

**Cause:** The page does not have the `_kln_link_page` meta key, which the plugin uses to identify it.

**Fix:**
1. Go to Settings tab in the plugin
2. If the page ID shown does not match the actual page, delete the current "Links" page from Pages → All Pages
3. Click "Create Link Page" in the Settings tab to create a fresh one

### Changes I save don't appear on the frontend

**Cause:** Caching — either a caching plugin or server-side cache is serving the old version.

**Fix:**
1. If you use WP Rocket: WP Rocket menu → Clear Cache
2. If you use W3 Total Cache: Performance → Purge All Caches
3. If you use LiteSpeed Cache: LiteSpeed Cache → Manage → Purge All
4. If your host has server-side caching (Kinsta, WP Engine, SiteGround): clear it from your hosting control panel
5. Also try opening the link page in an incognito/private browser window

### The admin page is slow to save

**Cause:** Server response time. This is normal for shared hosting.

No fix needed — just wait for the "Saved!" notification to appear. Do not click Save multiple times.

### Plugin broke after a WordPress core update

**Cause:** Rare, but WordPress occasionally changes internal APIs.

**Fix:**
1. Check the PHP error log for specific error messages
2. Temporarily deactivate the plugin (rename folder via SFTP if admin is broken)
3. Check if other plugins are also affected — if many plugins break, it is likely a hosting/PHP issue rather than the plugin itself
4. Restore from backup if needed, then apply the update again on a staging site first

---

## 11. What Data the Plugin Stores

The plugin stores all data in your WordPress database (wp_options table). No data is sent to any external server.

| Option key | What it contains |
|---|---|
| `kln_profile` | Your name, bio, avatar URL and attachment ID |
| `kln_appearance` | Background, colours, font, card style, button radius |
| `kln_sections` | All your sections and links (type, URL, label, active status) |
| `kln_page_id` | The WordPress page ID of your link page |

**No external connections.** The plugin does not phone home, does not send analytics, and does not use any third-party services. Google Fonts are loaded on the public-facing page from Google's servers (fonts.googleapis.com) — if you need to avoid this for GDPR reasons, choose a font and self-host it, or disable font loading by editing `public/class-kln-public.php`.

---

*Kepa's Link Ninja — built for musicians, by a musician.*
