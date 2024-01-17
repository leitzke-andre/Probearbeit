# README
This is a test application done to fulfill the code challenge for SIO AG.

The application in question acts as a time tracker, and could potentially be used by a professional to keep their time log in order.
The application is divided between "Projects" and "Work Units".
A Project is an aggregator of work units, and supports the reporting of those by enabling the user to categorize their working hours between (potentially) multiple projects.
A Work Unit corresponds to the time spent working on the project, represented by start date/time and end date/time.
The application also offers reporting capabilities in the form of:
- Daily Report
- Monthly Report
- CSV export of the data

**It is not intended for productive usage.**

It **will** violate software development "best practices", including those related to security, usability and performance.

A number of assumptions were taken for the development, these will be listed below.
In a real project environment those would be discussed previously, but these are nonetheless used here to advance with development given the disposable nature of the code.

## Requirements:
- PHP (tested with version 8.1)
- Composer
- Docker

## Usage
- [Only in first execution] Run `composer update` in the project directory
- Run `docker compose up -d` to start the database server and run it in background.
- [Only in first execution] Run `symfony console doctrine:migrations:migrate` to execute the database migrations.
- Run `symfony server:start` to start the server.
- Navigate to the address indicated by Symfony after startup (usually https://127.0.0.1:8000/) 

# Assumptions
## Technical assumptions
- MariaDB (version 10.5.0) is being used instead of MySQL, as it is a 100% compatible drop-in for this. The code itself requires no changes to be executed against MySQL, requiring only the adjustment of the connection string's `serverVersion` parameter.
- For the sake of simplicity, all changes will be directly merged into main, no branching strategy will be used for the challenge repository.
- For the sake of simplicity, only non-standard methods in the Entity contain Unit Tests. A more comprehensive suite of tests would of course be required for a complete product.

## Business assumptions
- A Work Unit contains only start and end date/time, and no description is given.
- A Work Unit pertains to only a single Project, a Project is expected to have multiple Work Units.
- The evaluation chart will bring the full data history, aggregated by day or month as requested by the user. 
  - In a real production environment, there would likely be a cut-off or initial filter to ensure usability would not be sacrificed due to data volume.
- The report will be generated as a CSV with raw data containing headers in the first row. No calculation will be done.
- A Work Unit can span multiple days, no validation exists to prevent an unreasonable number of hours to be input by the user. 
  - No significant treatment of this last point was done, including in the evaluation reports which are based on the Work Unit's start date.
- The Work Unit must have a positive number of minutes, if `end` and `start` **are equal**, or `start` is **greater than** `end` the Work Unit will not be saved.
  - This will not, at the current point in time, show any error to the end user, and should ideally be handled on the frontend, whereas the backend should throw an exception and ideally respond with HTTP Status `400 (Bad Request)`.

# Tests
A number of unit tests are available, to execute them you can run them by executing `php bin/phpunit tests` in the project folder, or using the appropriate IDE functionality.
