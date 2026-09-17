JASAIN JOB BOARD - PHASE 1 (FIXED)

IMPORTANT:
Job Board uses the table `job_posts`.
Laravel's default `jobs` table is reserved for queue jobs and is NOT touched.

Copy/overwrite these files into C:\laragon\www\marketplace-jasa

After copying:
1. php artisan optimize:clear
2. php artisan migrate
3. php artisan route:list --path=jobs

Routes are unchanged:
/jobs
/jobs/{job}
client/jobs
client/jobs/create
client/jobs/{job}
client/jobs/{job}/edit
freelancer/jobs
freelancer/jobs/{job}
freelancer/jobs/{job}/proposals

Do NOT run migrate:fresh.
