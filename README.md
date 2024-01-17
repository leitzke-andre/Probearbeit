# README
This is a test application done to fulfill the code challenge for SIO AG.

It is not intended for productive usage. 
It **will** violate many good practices, especially when it comes to secrets management.

A number of assumptions were taken for the execution, these will be listed below.
In a real project environment those would be discussed previously, but are nonetheless used here to advance with development given the nature of the code.

## Requirements:
- PHP (tested with version 8.1)
- Docker

## Usage
- Run `docker compose up` to start the database server.
- Run `symfony server:start` to start the server.
- Navigate to https://127.0.0.1:8000/timetracker

# Assumptions
## Technical
- MariaDB (version 10.5.0) is being used instead of MySQL, as it is a 100% compatible drop-in for this. The code itself requires no changes to be executed against MySQL, requiring only the adjustment of the connection string's `serverVersion` parameter.

## Business
- A WorkUnit contains only start and end date/time, and no description is given.
- A WorkUnit pertains to only a single Project, a Project is expected to have multiple WorkUnits