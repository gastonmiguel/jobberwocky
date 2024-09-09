# Jobberwocky - Job Posting Service

This project implements a job posting service where companies can share open job positions, and users can search for jobs. The application also integrates with external job sources to fetch additional job opportunities.

## Features

- Create and list job postings.
- Search for jobs by title, company, salary range, country, and more.
- Fetch external job opportunities from a separate service.
- Subscribe to job alerts and receive notifications for new job postings.

## Requirements

- PHP >= 8.2
- Composer
- MySQL (or any other supported database)
- Laravel 11
- Node.js & NPM (optional for front-end assets, if needed)

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/gastonmiguel/jobberwocky.git
   cd jobberwocky
   ```

2. **Install dependencies:**

   Run the following command to install PHP and Laravel dependencies:

   ```bash
   composer install
   ```

3. **Environment setup:**

   Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

   Update the `.env` file with your database connection details:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

4. **Set up the external job service URL:**

   In your `.env` file, add the following constant and set it to the URL of the external job service:

   ```
   EXTERNAL_JOB_SERVICE_URL=http://external-job-service-url.com
   ```

   This URL will be used to fetch job postings from the external source.

5. **Run migrations:**

   Run the database migrations to create the necessary tables:

   ```bash
   php artisan migrate
   ```

6. **Seed the database (optional):**

   You can seed the database with some initial job data using the following command:

   ```bash
   php artisan db:seed
   ```

7. **Run the development server:**

   Finally, start the Laravel development server:

   ```bash
   php artisan serve
   ```

   The application will be accessible at `http://localhost:8000`.

## API Endpoints

Here are the main API endpoints for interacting with the job service:

- **Create a job**: `POST /api/jobs`
- **List all jobs**: `GET /api/jobs`
- **Search jobs**: `GET /api/jobs/search`
  - Optional query parameters:
    - `title`: Search by job title.
    - `company`: Search by company name.
    - `salary_min`: Minimum salary.
    - `salary_max`: Maximum salary.
    - `country`: Filter by country.
- **Subscribe to job alerts**: `POST /api/subscriptions`

## External Job Service Integration

The application integrates with an external job service to fetch additional job listings. Make sure to configure the `EXTERNAL_JOB_SERVICE_URL` in your `.env` file.

## License

This project is open-source and available under the [MIT License](LICENSE).
