# SD777Slots Casino Project

This is a PHP-based casino web application that includes games like Slot Machine, Roulette, and Blackjack.

## Features

- User authentication (signup, login, logout)
- Multiple casino games (Slot Machine, Roulette, Blackjack)
- Admin portal
- Responsible gambling features
- Deposit functionality

## Requirements

- PHP 7.4 or higher
- PostgreSQL database
- Composer (for managing PHP dependencies)

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/sd777slots.git
   ```

2. Navigate to the project directory:
   ```
   cd sd777slots
   ```

3. Install dependencies:
   ```
   composer install
   ```

4. Set up your PostgreSQL database and update the database configuration in `config/database.php`.

5. Run the database migrations (if any).

6. Start the PHP built-in web server:
   ```
   php -S localhost:8080 -t public
   ```

7. Access the application in your web browser at `http://localhost:8080`.

## Deployment

For deployment on Android using Termux, use the provided `start_sd777slots.sh` script:

1. Install Termux on your Android device.
2. Install PHP and PostgreSQL in Termux.
3. Clone this repository in Termux.
4. Navigate to the project directory.
5. Run `./start_sd777slots.sh` to start the server and open the admin portal.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open source and available under the [MIT License](LICENSE).

## Disclaimer

This is a fictional casino application created for educational purposes only. It does not involve real money gambling.