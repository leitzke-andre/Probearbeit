# README
This is a test application done to fulfill the code challenge for SIO AG.

It is not intended for productive usage. 
It **will** violate many good practices, especially when it comes to secrets management.

A number of assumptions were taken for the execution, these will be listed below.
In a real project environment those would be discussed previously, but these are nonetheless used here to advance with development given the disposable nature of the code.

## Requirements:
- PHP (tested with version 8.1)
- Composer
- Docker

## Usage
### First run:
- Run `composer update` in the project directory
- Run `docker compose up` to start the database server.
- Run `symfony console doctrine:migrations:migrate` to start the database server.
- Run `symfony server:start` to start the server.
- Navigate to https://127.0.0.1:8000/

### Subsequent executions:
- Run `docker compose up` to start the database server.
- Run `symfony server:start` to start the server.
- Navigate to https://127.0.0.1:8000/

# Assumptions
## Technical
- MariaDB (version 10.5.0) is being used instead of MySQL, as it is a 100% compatible drop-in for this. The code itself requires no changes to be executed against MySQL, requiring only the adjustment of the connection string's `serverVersion` parameter.
- For the sake of simplicity, all changes will be directly merged into main, no branching strategy will be used for the challenge repository.
- For the sake of simplicity, only non-standard methods in the Entity contain Unit Tests. A more comprehensive suite of tests would of course be required for a complete product.

## Business
- A Work Unit contains only start and end date/time, and no description is given.
- A Work Unit pertains to only a single Project, a Project is expected to have multiple WorkUnits
- The evaluation chart will bring the full data history, aggregated by day or month as requested by the user. 
  - In a real production environment, there would likely be a cut-off or initial filter to ensure usability would not be sacrificed due to data volume.
- The report will be generated as a CSV with raw data containing headers in the first row. No calculation will be done.
- A Work Unit can span multiple days, no validation exists to prevent an unreasonable number of hours to be input by the user. 
  - No significant treatment of this last point was done, including in the evaluation reports which are based on the Work Unit's start date.
