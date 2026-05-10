# Workforce & Attendance Management System

A streamlined Employee Tracking and Attendance Management system built to handle workforce data with a focus on database performance and scalable architecture. This application allows HR departments to manage employee identities and track attendance records through seamless Excel imports and data visualization.

## 🛠 Tech Stack
- **Backend:** PHP 7.4 & Laravel 8
- **Frontend:** Bootstrap 5, JQuery, SweetAlert2, SheetJS
- **Database:** PostgreSQL 13

## 🧬 Technical Implementation: UUID v6 Strategy
During the development of this project, a strategic decision was made regarding data indexing and primary keys:

- **Why UUIDv6?** Given the environment constraints (**PHP 7.4** and **Laravel 8**), the `ramsey/uuid` library version used does not support UUIDv7. To ensure database performance remains high through lexicographical ordering (time-ordered), **UUIDv6** was implemented instead of the standard UUIDv4.
- **Security & Privacy:** To mitigate the security risks inherent in standard UUIDv1/v6 (which can leak the server's MAC address), I implemented a **Random Node Provider**. This ensures that the node part of the UUID is cryptographically random while maintaining the time-ordered benefits.
- **Performance over Database Defaults:** I opted against using PostgreSQL's native `gen_random_uuid()` because it generates UUIDv4. For large datasets, UUIDv4 can lead to index fragmentation and slower inserts compared to the time-sequential nature of UUIDv6.
- **Implementation:** The generation logic is encapsulated within a custom `HasUuid` Trait, which is applied across all Eloquent models to automate primary key assignment.

## 🚀 Getting Started

Follow these steps to set up the project locally:

### 1. Prerequisites
Ensure you have **PHP 7.4**, **Composer**, and **PostgreSQL 13** installed on your machine.

### 2. Installation
1. Clone the repository:
```bash
git clone https://github.com/mahadidn/hr_app.git
```
```bash
cd hr_app
```
2. Install dependencies:
```bash
composer install
```
3. Copy the environment file:
```bash
cp .env.example .env
```
4. Open .env and configure your PostgreSQL database credentials:
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
5. Generate the application key and run migrations:
```bash
php artisan key:generate
php artisan migrate
```
6. Seed the database with initial records and admin credentials:
```bash
php artisan db:seed --class=DatabaseSeeder
```
You can find the default admin credentials in your .env file under:

`ADMIN_EMAIL`

`ADMIN_PASSWORD`

7. Login via the web interface to begin managing attendance records.
Running the App
```bash
php artisan serve
```

## 🐳 Running with Docker (VS Code Devcontainers)

For a seamless, fully containerized development experience, this project includes a pre-configured **VS Code Devcontainer** setup. This eliminates the need to manually install PHP 7.4, PostgreSQL 13, or any local dependencies.

### Prerequisites
- [Docker](https://www.docker.com) installed and running.
- [Visual Studio Code](https://code.visualstudio.com/).
- The [Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) extension for VS Code.

### Steps to Run
1. **Open the Project:** Open the cloned repository folder in VS Code.
2. **Reopen in Container:** A prompt will appear in the bottom-right corner asking to **"Reopen in Container"**. Click it. 
   *(Alternatively, press `Ctrl+Shift+P` / `Cmd+Shift+P`, type `Dev Containers`, and select **Reopen in Container**).*
3. **Wait for the Build:** VS Code will build the `app` (PHP 7.4) and `postgres` (PostgreSQL 13) containers, and automatically install the recommended PHP and Laravel extensions.
4. **Database Configuration:** The database is automatically provisioned via `docker-compose.yml`. The environment variables are already injected into the container:
   - **DB_HOST:** `postgres`
   - **DB_DATABASE:** `hr_db`
   - **DB_USERNAME:** `hr_user`
   - **DB_PASSWORD:** `secret`
5. **Run Migrations & Serve:** Once inside the container, open the VS Code integrated terminal and run:
   ```bash
   composer install
   php artisan migrate
   php artisan db:seed --class=DatabaseSeeder
   php artisan serve --host=0.0.0.0

## 🚧 Known Limitations & Future Improvements

Due to the time constraints of this technical assessment, I focused on delivering a solid architectural foundation (such as the UUIDv6 database optimization and Docker containerization) and the core Minimum Viable Product (MVP) features like the Excel import and data visualization. 

As a result, some supplementary features shown in the UI were not fully implemented. Given more time, I would prioritize the following improvements:

- **Complete CRUD Operations:** Fully implementing the remaining Create, Update, and Delete functionalities across all modules with comprehensive backend validation.
- **Export Functionality:** Activating the "Import Excel" buttons to stored and preview the data.

I apologize for any imperfections in the current iteration of the application. I treated this project as an opportunity to showcase my backend logic, problem-solving skills, and coding standards. I would be very excited to discuss these limitations and my planned solutions with the team during the technical interview.

## Authors
- [Mahadi Dwi Nugraha](https://www.github.com/mahadidn) | mahadidwinugraha@gmail.com

