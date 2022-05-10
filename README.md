<div id="top"></div>


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/albinvar/canteen-management-system">
    <img src="https://i.ibb.co/F5qdVDY/undraw-breakfast-psiw-removebg-preview.png" alt="Logo" width="600" height="200">
  </a>
  
  <h3 align="center">Canteen Management System</h3>

<h4 align="center">Rest Api  - Docs</h4>


  <p align="center">
   A simple REST Api built on laravel with an experimental implementation of blockchain.
    <br />
    <br />
    <img src="https://img.shields.io/packagist/v/albinvar/canteen-management-system?label=version">
    <img src="https://poser.pugx.org/albinvar/canteen-management-system/downloads">
    <a href="https://github.com/albinvar/canteen-management-system/actions/workflows/tests.yml">
          <img src="https://github.com/albinvar/canteen-management-system/actions/workflows/tests.yml/badge.svg"></a>
    <img src="https://img.shields.io/github/repo-size/albinvar/canteen-management-system">
    <a href="LICENSE"><img src="https://img.shields.io/apm/l/Github"></a>
    <br />
    <a href="https://github.com/albinvar/canteen-management-system"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/albinvar/canteen-management-system">View Demo</a>
    ·
    <a href="https://github.com/albinvar/canteen-management-system/issues">Report Bug</a>
    ·
    <a href="https://github.com/albinvar/canteen-management-system/issues">Request Feature</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

Canteen Management System is an implementation of an e-commerce website with a wide variety of features which would surely enhance your users experiences and makes operations simple and efficient.

Here's why:
* Simple and efficient
* Blockchain Implementation
* Order Tracking
* Ticket Verification
* Easy to implement

*Disclaimer*: I don't guarantee that it is 100% secure. you may also suggest changes by forking this repo and creating a pull request or opening an issue. Thanks to all the people have contributed to expanding this library!

Use the `docs/Documentation.md` for further implementation.

<p align="right">(<a href="#top">back to top</a>)</p>



### Built With

Following modules/libraries are required to run the project. Make sure you have installed each of them on your machine.

* [PHP v8.1](https://php.net/)
* [Composer v2.1](https://getcomposer.org/)

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- GETTING STARTED -->
## Getting Started

Cyph php is easy to use and pretty straight forward to use. 
This is an example of how you may encrypt a simple text using default configuration recommended by cyph itself.
To get a basic idea of how it works, see this example below and follow these steps.

### Prerequisites

The following prerequisites should be installed and configured that you need to use the package.

* php v8.1 +

  ```sh
  sudo apt-get install php8.1
  ```
  
* Libsodium Extension - php v8.1+ (Optional based on usage)

  ```sh
  sudo apt-get install php8.1
  ```
  
* Openssl Extension - php v8.1+ (Optional based on usage)

  ```sh
  sudo apt-get install php8.1
  ```
  
* composer v2.1 +

  ```sh
  sudo apt-get install composer -y
  ```

### Installation

_Below is an example of how you can instruct your audience on installing and setting up your app. This template doesn't rely on any external dependencies or services._

1. Install Cyph php using composer

   ```sh
   composer require albinvar/cyph-php
   ```
2. All set!

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

Use this space to show useful examples of how a project can be used. Additional screenshots, code examples and demos work well in this space. You may also link to more resources.

_For more examples, please refer to the [Documentation](https://example.com)_

<!-- ENDPOINTS -->
### Endpoints
| Endpoints | Method | Authentication Required | Docs |
| ------------ | ------------- | ------------- | ------------ |
| /login | `GET` | No  | [Click Here](docs/login.md) |
| /register | `Get` | No  | [Click Here](docs/login.md) |
| /categories | `Get` | No  | [Click Here](docs/login.md) |
| /categories/`{category}`/products | `Get` | No  | [Click Here](docs/login.md) |
| /categories/`{category}`/products/`{slug}` | `Get` | No  | [Click Here](docs/login.md) |
| /products/`{slug}` | `Get` | No  | [Click Here](docs/login.md) |
| /products/`{slug}`/reviews | `Get` | No  | [Click Here](docs/login.md) |
| /products/today | `Get` | No  | [Click Here](docs/login.md) |
| /cart | `Get` | Yes  | [Click Here](docs/login.md) |
| /orders | `Get` | Yes  | [Click Here](docs/login.md) |
| /orders/checkout | `Get` | Yes  | [Click Here](docs/login.md) |
| /wallet | `Get` | Yes  | [Click Here](docs/login.md) |
| /wallet/credit | `Get` | Yes  | [Click Here](docs/login.md) |
| /wallet/refresh | `POST` | Yes  | [Click Here](docs/login.md) |

<!-- ROADMAP -->
## Roadmap

- [x] Add Support for Libsodium Operations.
- [x] Add support for openssl operations.
- [ ] Add Additional Templates w/ Examples
- [ ] Add "components" document to easily copy & paste sections of the readme
- [ ] Multi-language Support
    - [ ] Chinese
    - [ ] Spanish

See the [open issues](https://github.com/albinvar/cyph-php/issues) for a full list of proposed features (and known issues).

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- LICENSE -->
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CREDIT -->
## Credits

- [Albin Varghese](https://github.com/albinvar)
- [All Contributors](../../contributors)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

Use this space to list resources you find helpful and would like to give credit to. I've included a few of my favorites to kick things off!

* [Choose an Open Source License](https://choosealicense.com)
* [GitHub Emoji Cheat Sheet](https://www.webpagefx.com/tools/emoji-cheat-sheet)
* [Malven's Flexbox Cheatsheet](https://flexbox.malven.co/)
* [Malven's Grid Cheatsheet](https://grid.malven.co/)
* [Img Shields](https://shields.io)
* [GitHub Pages](https://pages.github.com)
* [Font Awesome](https://fontawesome.com)
* [React Icons](https://react-icons.github.io/react-icons/search)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/othneildrew/Best-README-Template.svg?style=for-the-badge
[contributors-url]: https://github.com/albinvar/cyph-php/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/othneildrew/Best-README-Template.svg?style=for-the-badge
[forks-url]: https://github.com/albinvar/cyph-php/network/members
[stars-shield]: https://img.shields.io/github/stars/othneildrew/Best-README-Template.svg?style=for-the-badge
[stars-url]: https://github.com/albinvar/cyph-php/stargazers
[issues-shield]: https://img.shields.io/github/issues/othneildrew/Best-README-Template.svg?style=for-the-badge
[issues-url]: https://github.com/albinvar/cyph-php/issues
[license-shield]: https://img.shields.io/github/license/othneildrew/Best-README-Template.svg?style=for-the-badge
[license-url]: https://github.com/albinvar/cyph-php/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/othneildrew
[product-screenshot]: images/screenshot.png
