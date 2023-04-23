# Facebook Clone

This is a simple clone of Facebook with basic features such as creating posts, commenting, and creating profiles. The project was built using HTML, CSS, and JavaScript for the front-end, and PHP and MySQL for the back-end.

## Features

The following features are available in this Facebook clone:

- User authentication: Users can sign up, log in, and log out of the system.
- Create posts: Users can create new posts, which can be text-only or include images.
- Comment on posts: Users can leave comments on posts created by other users.
- Profile creation: Users can create a profile with basic information, such as name, profile picture, and bio.
- Add friends: Users can add other users as friends by sending a friend request.

## Installation

To run this project on your local machine, follow these steps:

1. Clone this repository to your local machine using `git clone https://github.com/Magvib/Facebook.git`
2. Navigate to the root directory of the project.
3. Update the `DATABASE_URL` variable in the `.env` file to point to your local database.
4. Update the `$db_config` array in the `includes/DB.php` file to point to your local database.
5. Run `npx prisma db push` in the terminal to create the necessary tables in the database.
6. Start a PHP server using the command `php -S 127.0.0.1:8000`
7. Open `http://localhost:8000` in your web browser to view the app.

Note: You must have PHP and Prisma installed on your local machine to use this method.

## Installation with Docker

To run this project with Docker, follow these steps:

1. Clone the repository to your local machine using `git clone https://github.com/Magvib/Facebook.git`.
2. Navigate to the project directory in your terminal.
3. Create a `.env` file with the necessary environment variables.
4. Update the `$db_config` array in the `includes/DB.php` file to point to your local database.
5. Run `npx prisma db push` in the terminal to create the necessary tables in the database.
5. Build the Docker container using `docker-compose build`.
6. Start the container using `docker-compose up`.

The web application will be accessible at `http://localhost:8000`. You can stop the container at any time by running `docker-compose down`.

Note that you may need to update the `docker-compose.yml` file to match your desired configuration, such as setting the database credentials and port number.

## Contribution

We welcome contributions from anyone who is interested in improving this project! Here's how you can get started:

1. Fork the repository to your own GitHub account.
2. Clone the forked repository to your local machine using `git clone https://github.com/your-username/facebook-clone.git`.
3. Create a new branch for your changes using `git checkout -b your-branch-name`.
4. Make your changes to the code and commit them to your branch.
5. Push your branch to your forked repository using `git push origin your-branch-name`.
6. Go to your forked repository on GitHub and submit a pull request with your changes.

Before submitting a pull request, make sure that your code follows the project's coding standards and that it has been thoroughly tested.

Please note that while we appreciate all contributions, we cannot guarantee that all pull requests will be accepted. We reserve the right to reject any changes that we feel are not in line with the goals and vision of the project.

Thank you for considering contributing to this project!

Note: I will decline any pull requests that changes any of the following: php files, html files, or the database schema. ;)

## Credits

This project was built by Magnus Nielsen. 

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
