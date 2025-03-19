    <?php
    // Load .env file and set variables
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (strpos($line, '#') === 0) continue; // Skip comments
            list($key, $value) = explode('=', $line, 2);
            putenv(trim($key) . '=' . trim($value));
        }
    }

    class DBController {
        // Database connection properties
        protected $host;   
        protected $user;        
        protected $password;       
        protected $database; 
        public $conn = null;
        // Constructor to establish the connection
        public function __construct() {
            if ($this->conn === null) {
                $this->host = getenv('DB_HOST');
                $this->user = getenv('DB_USER');
                $this->password = getenv('DB_PASS');
                $this->database = getenv('DB_NAME');
                $this->connect();
            }
        }

        // Method to establish the database connection
        private function connect() {
            // Create the connection
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

            // Check if the connection was successful
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            // Output success message if connected
            // echo "Connected successfully to the database: " . $this->database . "<br>";
        } 

        // Method to get the current connection
        public function getConnection() {
            return $this->conn;
        }

        // Destructor to close the database connection
        public function __destruct() {
            // Only close the connection if it is open
            if ($this->conn !== null) {
                $this->closeConnection();
            }
        }

        // Method to close the connection
        protected function closeConnection() {
            if ($this->conn !== null) {
                $this->conn->close();
                $this->conn = null;
                // echo "Connection closed successfully.<br>";
            }
            
        }
    }
    ?>
