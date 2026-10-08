# Obesity visualizer

A web application for exploring obesity statistics across countries and years. Country views and charts sit alongside user and admin interfaces.

Built for the **Web Technologies** course at Alexandru Ioan Cuza University of Iași. The repository preserves the course application, database schema, and presentation material.

## Explore the implementation

- [ChartService](ChartService): chart queries and HTTP handling.
- [CountryService](CountryService): country-oriented data views.
- [LoginService](LoginService) and [UserService](UserService): account flows.
- [AdminService](AdminService): administrative views and operations.
- [Database schema](structure/obesity-vis.sql): tables and seed data.
- [Project structure document](structure/ov-structure.pdf) and [presentation](structure/presentation.mp4): course deliverables.

The `Service` folders organize PHP modules inside the application; they are not separate deployed microservices.

## Local setup

Use a PHP web-server environment with database support. Import `structure/obesity-vis.sql` into a local database and configure the PHP model files for that database. Host the repository at `/obesity-visualizer` under your document root: the included paths and rewrite configuration assume that location.

Open the application through the web server, rather than opening `index.php` as a file. [The rewrite configuration](.htaccess) and each module’s `index.php` show how requests are routed.


## Screenshots

![image](https://github.com/user-attachments/assets/122d2316-82bf-4f4d-a96a-077fd92c048e)

![image](https://github.com/user-attachments/assets/03b8bd8d-b87d-464f-96a9-cdbc5308240a)

![image](https://github.com/user-attachments/assets/7682fa73-af56-4275-a103-8624bfa8fb59)

![image](https://github.com/user-attachments/assets/f25fce18-298d-4d0a-8050-5d65aedc3280)

![image](https://github.com/user-attachments/assets/c6f06fd1-d12f-4458-86bd-471cab8d8723)

![image](https://github.com/user-attachments/assets/f4ea8b6f-4300-4b09-a315-0005f9fa36ca)

![image](https://github.com/user-attachments/assets/50f1db73-1896-426b-b98f-621ef0b39f16)

![image](https://github.com/user-attachments/assets/bcb82a15-7db0-4d7f-a711-4960441814be)

![image](https://github.com/user-attachments/assets/cfbf9b3c-db84-4530-abff-267895723128)
