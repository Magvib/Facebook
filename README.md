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

1. Clone this repository to your local machine using `git clone https://github.com/your-username/facebook-clone.git`
2. Navigate to the root directory of the project.
3. Update the `DATABASE_URL` variable in the `.env` file to point to your local database.
4. Run `npx prisma db push` in the terminal to create the necessary tables in the database.
5. Start a PHP server using the command `php -S 127.0.0.1:8000`
6. Open `http://localhost:8000` in your web browser to view the app.

Note: You must have PHP and Prisma installed on your local machine to use this method.

## Contributing

If you would like to contribute to this project, please fork the repository and submit a pull request. 

## Credits

This project was built by Magnus Nielsen. 

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
