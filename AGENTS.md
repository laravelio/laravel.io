# Agent Guidelines

## Configuration

- Put custom app configuration in `config/lio.php` under its own key (e.g. `lio.moderation`). Don't create new top-level config files for app-specific settings. Package config files (e.g. `config/ai.php`) stay as they are.

## Database Backups (production)

Database-only backups use [Spatie Laravel Backup](https://spatie.be/docs/laravel-backup) and a private S3 destination configured through environment variables. Files and uploaded images are not included. Keep deployment-specific bucket names, regions, archive prefixes, and credentials out of tracked files, including this guidance.

Set these variables in the production hosting environment, not in source control:

```dotenv
BACKUP_ENABLED=true
BACKUP_NAME=database
BACKUP_AWS_ACCESS_KEY_ID=
BACKUP_AWS_SECRET_ACCESS_KEY=
BACKUP_AWS_DEFAULT_REGION=
BACKUP_AWS_BUCKET=
BACKUP_ARCHIVE_PASSWORD=
```

Set the bucket and region explicitly in the hosting environment before enabling backups. `BACKUP_NAME` controls the archive prefix and defaults to `database`; use the same prefix in the IAM policy. Use a dedicated AWS IAM identity with `s3:ListBucket` on `arn:aws:s3:::<bucket>`, restricted to the `<backup-name>/*` prefix, and `s3:GetObject`, `s3:PutObject`, and `s3:DeleteObject` on `arn:aws:s3:::<bucket>/<backup-name>/*`. Keep S3 Block Public Access enabled. Buckets using a customer-managed KMS key also require the corresponding KMS permissions.

Set a strong archive password to enable AES-256 encryption, and keep a copy in a password manager outside the hosting platform for restores. Leaving it empty disables archive encryption.

The host needs PHP ZIP support, process execution, compatible `mysqldump` and `gzip` binaries, and writable temporary storage at `storage/app/backup-temp`. Dumps are gzip-compressed before ZIP creation to reduce temporary disk usage. MySQL dumps use a single transaction without table locks; this assumes InnoDB tables. Run Laravel's scheduler every minute on one production instance (or enable the hosting platform's scheduler). After deploying, rebuild cached configuration and check `php artisan schedule:list`.

Backups run daily at **02:30 UTC**, cleanup at **02:35 UTC**, and health checks at **02:40 UTC**. Backups are retained for seven days, subject to a 5,000 MiB limit; the newest backup is always preserved. Health checks fail when no backup exists, the newest is over a day old, or storage exceeds that limit. Backup emails are disabled; ensure the existing scheduled-task monitoring reports failures and missed runs.

After production credentials are configured, create and check the first backup:

```bash
php artisan backup:run --only-db
php artisan backup:list
php artisan backup:monitor
```

Download an archive, decrypt it with the saved password, decompress its `.sql.gz` entry, and restore the SQL dump into a separate disposable database before relying on the backups. Never test a restore against production. Confirm a subsequent daily archive appears without manually triggering a backup. `BACKUP_ENABLED` only controls scheduling; manual backup commands remain available.
