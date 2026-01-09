Step 1: Clone the Repositorybashgit clone https://github.com/Joshua123895/ThesisMeet.gitcd ThesisMeetStep 2: Install DependenciesInstall PHP dependencies:bashcomposer installInstall Node.js dependencies:bashnpm installStep 3: Environment Configuration
Copy the example environment file:
bashcp .env.example .env
Generate application key:
bashphp artisan key:generate
Configure your database in the .env file:
envDB_CONNECTION=mysqlDB_HOST=127.0.0.1DB_PORT=3306DB_DATABASE=thesismeetDB_USERNAME=your_usernameDB_PASSWORD=your_passwordStep 4: CA Certificate Bundle Setup (Windows)⚠️ Important for Windows users to avoid SSL certificate errors Step 1: Download the CA Certificate Bundle
Download the cacert.pem file from: https://curl.se/ca/cacert.pem
Save it to a permanent location, such as: C:\php\cacert.pem
 Step 2: Configure php.ini
Locate your php.ini file by running:
bashphp --ini

Open php.ini in a text editor (as Administrator)


Find the line with curl.cainfo (use Ctrl+F to search)


Uncomment it (remove the ;) and set the path:

inicurl.cainfo = "C:\php\cacert.pem"
Also find and update openssl.cafile:
iniopenssl.cafile = "C:\php\cacert.pem"
Save the file
 Step 3: Restart the ServerRestart your local server (XAMPP, WAMP, or built-in PHP server) for changes to take effect.Step 5: Database Setup
Create the database:
sqlCREATE DATABASE thesismeet;
Run migrations:
bashphp artisan migrate
(Optional) Seed the database with sample data:
bashphp artisan db:seedStep 6: Build Frontend AssetsCompile CSS and JavaScript assets:bashnpm run devFor production:bashnpm run buildStep 7: Storage LinkCreate a symbolic link for file storage:bashphp artisan storage:link