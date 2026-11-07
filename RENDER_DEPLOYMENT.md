# Deploy Smart Campus (Laravel 12) on Render

This repository is configured for a **free demonstration deployment** using Render Docker + Render Postgres.

## What the deployment files do

- `Dockerfile`: installs PHP 8.3 extensions and Composer production dependencies, builds Vite assets with Node 22, and serves Laravel's `public/` directory using Apache on port 10000.
- `render.yaml`: creates a free Render web service and a free PostgreSQL database, then connects them with `DATABASE_URL`.
- `docker-entrypoint.sh`: waits for PostgreSQL, runs migrations, caches Laravel configuration/views, optionally creates the first admin, then starts Apache.
- The old MySQL-only Render config and committed application key have been removed from the deployment blueprint.

## Deploy

1. Push/merge the `render-deployment` branch into `main` when you are ready. The Blueprint below currently targets `render-deployment`; if you prefer to deploy from `main`, change the `branch` value in `render.yaml` before merging.
2. Open https://dashboard.render.com/ and sign in with GitHub.
3. Choose **New + → Blueprint** and select `rasheshshrimankar-alt/college`.
4. Select the `render.yaml` Blueprint and create the resources. Choose the Free plan for the web service and database.
5. When Render asks for unsynced environment values, provide:
   - `APP_KEY`: generate locally from the project folder with `php artisan key:generate --show` (copy the complete `base64:...` value).
   - `INITIAL_ADMIN_EMAIL`: the email address you want to use for the first admin.
   - `INITIAL_ADMIN_PASSWORD`: a new unique password of at least 12 characters. Do not reuse a personal or school password.
6. Save the environment variables and create the Blueprint. After Render creates the web service, open **Environment** and add `APP_URL` with the HTTPS URL shown on the service page (for example, `https://college-xxxx.onrender.com`). Save and redeploy.
7. The container runs migrations and creates the admin account once (it will not reset that account's password on later restarts). Open the service URL and test the public home page, login, registration, and role-based dashboards.

## Important database and data notes

- The app's existing migrations use Laravel schema-builder features such as enums and column modifiers. Laravel's PostgreSQL grammar handles the enum columns as strings; PostgreSQL does not preserve MySQL enum types. Review app queries for MySQL-only raw SQL before using a production database.
- The old `DatabaseSeeder` inserts a large set of demo records and hard-coded demo accounts and is **not safe to run automatically on every boot**. This deployment deliberately does not run it. The deployment creates only the first administrator using `RenderAdminSeeder`.
- Free Render web services sleep after 15 minutes without traffic. Their local filesystem is temporary: uploaded files and local storage changes can disappear on sleep/redeploy/restart.
- Free Render Postgres is limited to 1 GB and expires 30 days after creation. This setup is suitable for a college demo, not long-term production or real student records. Export anything you need before the database expires.
- If the service is private, the web service and database must be created in the same Render region so the internal database URL works.

## If deployment fails

Open the Render service → **Events** and **Logs**. Check:
- The image build completed (Composer and npm stages).
- The database is linked and `DB_CONNECTION=pgsql`.
- `APP_KEY` is set and starts with `base64:`.
- The database is ready and the migration step completed.
- `APP_URL` matches the service's HTTPS URL.

Never paste `APP_KEY`, database URLs, or the initial admin password into GitHub issues or chat.
