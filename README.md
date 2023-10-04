## Liberu - Laravel 10 / PHP 8.2 Backend
 ![Latest Stable Version](https://img.shields.io/github/release/laravel-liberu/boilerplate.svg) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/laravel-liberu/genealogy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/laravel-liberu/genealogy/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/laravel-liberu/genealogy/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![StyleCI](https://github.styleci.io/repos/135390590/shield?branch=master)](https://github.styleci.io/repos/135390590)
[![CodeFactor](https://www.codefactor.io/repository/github/familytree365/genealogy/badge/master)](https://www.codefactor.io/repository/github/familytree365/genealogy/overview/master)
[![codebeat badge](https://codebeat.co/badges/911f9e33-212a-4dfa-a860-751cdbbacff7)](https://codebeat.co/projects/github-com-modulargenealogy-genealogy-master)
[![CircleCI](https://circleci.com/gh/laravel-liberu/boilerplate.svg?style=svg)](https://circleci.com/gh/laravel-liberu/boilerplate)

<!--/h-->
### Description
Introducing Laravel 10 Boilerplate Application - A Robust Foundation for Feature-rich Web Applications

The Laravel 10 Boilerplate Application is an advanced and comprehensive starter template designed to kickstart your web application development with Laravel 10, the latest and most powerful version of the Laravel PHP framework. This boilerplate offers a plethora of features and functionalities to accelerate the development process and ensure a robust and scalable application.

Key Features:

User and People Management:
The boilerplate provides a comprehensive system for managing users and people, including user authentication, registration, profile management, and more.

Permissions and Roles:
Easily define and manage permissions and roles within the application, enabling fine-grained access control and authorization for users.

Menus:
Intuitive and customizable menu management, allowing easy creation, modification, and organization of navigation menus throughout the application.

Forms and Tables using JSON:
Streamline the creation of forms and tables by utilizing JSON configurations, making the UI/UX design and development process more efficient.

Two-Factor Authentication (2FA):
Implement two-factor authentication using SMS or email to enhance the security of user accounts and protect against unauthorized access.

Social Login and Register:
Enable users to register and log in using popular social media platforms, simplifying the onboarding process and improving user engagement.

Charts:
Integrate dynamic and interactive charts to visualize data and trends within the application, providing valuable insights to users.

Command Line Generators:
Utilize built-in command line generators to quickly scaffold various components, such as controllers, models, views, and more, saving development time and effort.

Optional Multi-Tenancy:
Opt for multi-tenancy support to serve multiple clients or user groups within a single application instance, ensuring scalability and flexibility.

Modular and Extensible:
Built with a modular and extensible architecture, allowing easy integration of additional features, third-party libraries, and plugins as needed for specific project requirements.

RESTful APIs:
Implement RESTful APIs for seamless communication with frontend frameworks or mobile applications, providing a standardized and scalable approach to data exchange.

Security and Performance Optimization:
Incorporates security best practices and performance optimization techniques to ensure a secure and efficient application, adhering to industry standards.

With the Laravel 10 Boilerplate Application, you can jumpstart your project with a solid foundation and a wide array of features, ultimately accelerating your development process and delivering a powerful and feature-rich web application to your users.
<!--/h-->

## Demostration website
<!--/h-->

### Installation steps

1. Begin by downloading the project using the command `git clone https://github.com/laravel-liberu/boilerplate.git`

2. Next, make a copy of the `.env.example` file and rename it as `.env`. Open the `.env` file and update the necessary details according to your specific configuration.

3. Run the command `composer install` to install the project dependencies. If you are using Windows, you may need to run `composer install --ignore-platform-reqs` instead. For docker get into container first with `docker exec -it app bash`.

4. Generate an application key by executing the command `php artisan key:generate`

5. Launch the project by running `php artisan serve`.

6. To set up the database tables and seed them with initial data, run the command `php artisan migrate --seed`

7. If needed, you can customize the configuration files located in config/enso/*.php according to your requirements.

8. For certain configurations, you may need to set up sanctum stateful domains and session domain in the `.env` file. Additionally, add your domains to the `config/cors.php` file.

9. Lastly, follow the installation steps for the client side by visiting the link provided: https://github.com/liberu-ui/boilerplate.

10. Launch the site and log into the project using the following credentials:

User: `admin@familytree365.com`
Password: `password`


By following these steps, you will successfully download the project, configure the necessary environment variables, install dependencies, generate a key, run the project, migrate the database, customize configurations if needed, and set up the client-side application. You can then log in to the project with the specified user credentials and begin exploring its features.

<!--/h-->

### Contributions

We warmly welcome new contributions from the community! We believe in the power of collaboration and appreciate any involvement you'd like to have in improving our project. Whether you prefer submitting pull requests with code enhancements or raising issues to help us identify areas of improvement, we value your participation.

If you have code changes or feature enhancements to propose, pull requests are a fantastic way to share your ideas with us. We encourage you to fork the project, make the necessary modifications, and submit a pull request for our review. Our team will diligently review your changes and work together with you to ensure the highest quality outcome.

However, we understand that not everyone is comfortable with submitting code directly. If you come across any issues or have suggestions for improvement, we greatly appreciate your input. By raising an issue, you provide valuable insights that help us identify and address potential problems or opportunities for growth.

Whether through pull requests or issues, your contributions play a vital role in making our project even better. We believe in fostering an inclusive and collaborative environment where everyone's ideas are valued and respected.

We look forward to your involvement, and together, we can create a vibrant and thriving project. Thank you for considering contributing to our community!
<!--/h-->
### License

This project is licensed under the MIT license, granting you the freedom to utilize it for both personal and commercial projects. The MIT license ensures that you have the flexibility to adapt, modify, and distribute the project as per your needs. Feel free to incorporate it into your own ventures, whether they are personal endeavors or part of a larger commercial undertaking. The permissive nature of the MIT license empowers you to leverage this project without any unnecessary restrictions. Enjoy the benefits of this open and accessible license as you embark on your creative and entrepreneurial pursuits.
<!--/h-->
