<div id="top"></div>
<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Don't forget to give the project a star!
*** Thanks again! Now go create something AMAZING! :D
-->



<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/albinvar/cyph-php">
    <img src="https://i.ibb.co/h2HFdvT/3824032-removebg-preview.png" alt="Logo" width="260" height="260">
  </a>
  
  <h3 align="center">Canteen Management System</h3>

  <p align="center">
   A simple and inovative canteen management system api built in laravel with an experimental implementation of blockchain.
    <br />
    <br />
    <img src="https://img.shields.io/packagist/v/albinvar/termux-webzone?label=version">
    <img src="https://poser.pugx.org/albinvar/termux-webzone/downloads">
    <a href="https://github.com/albinvar/cyph-php/actions/workflows/tests.yml">
          <img src="https://github.com/albinvar/cyph-php/actions/workflows/tests.yml/badge.svg"></a>
    <img src="https://img.shields.io/github/repo-size/albinvar/termux-webzone">
    <a href="LICENSE"><img src="https://img.shields.io/apm/l/Github"></a>
    <br />
    <a href="https://github.com/albinvar/cyph-php"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/albinvar/cyph-php">View Demo</a>
    ·
    <a href="https://github.com/albinvar/cyph-php/issues">Report Bug</a>
    ·
    <a href="https://github.com/albinvar/cyph-php/issues">Request Feature</a>
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

Cyph php simlifies your cryptographic tasks in a much easier way that you would probably fall in love with cyph. The library also provides multiple adapters which allows to use different modules all along your project.

Here's why:
* Comprises of multiple adapters.
* Provides multiple strategies and ciphers.
* Easy to implement

*Disclaimer*: I don't gurantee that it is 100% secure. you may also suggest changes by forking this repo and creating a pull request or opening an issue. Thanks to all the people have contributed to expanding this library!

Use the `docs/Documentation.md` for further implementation.

<p align="right">(<a href="#top">back to top</a>)</p>



### Built With

Following modules/libraries are required to run cyph-php. Make sure you have installed each of them on your machine.

* [PHP v8.1](https://php.net/)
* [Composer v2.1](https://getcomposer.org/)
* [Libsodium Extension](https://php.net/)
* [Openssl Extension](https://php.net/)

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


### Basic Example

To use cyph, make sure that youn have already have the prerequisites mentioned above installed on your server.
After installing cyph using composer. you are good to go.
The following code shows a simple example to encrypt a text. 

```php
<?php

use Albinvar\Cyph;

// The message to Encrypt.
$plaintext = "This is a secret message.";

// Encrypt the message
$cyph = Cyph::encrypt($plaintext);

// returns cipher text
$encrypted = $cyph->get();

// Since we didn't supply a key to encrypt, Cyph automatically 
// generated a secure key for us. 
$key = $cyph->getKey();

// Decrypt the message.
$decrypted = Cyph::decrypt($encrypted, $key)->get();

?>

```

You can also customize the whole process with the help of bunch of other methods.

```php
<?php

use Albinvar\Cyph;
use Albinvar\Cyph\Sodium\KeyFactory;
use Albinvar\Cyph\Sodium\NonceFactrory;

// The message to Encrypt.
$plaintext = "This is a secret message.";

// Configure Cyph
$cyph = Cyph::adapter('sodium')->cipher('aes-256-gcm')->strategy('symmetric')

$nonce = NonceFactory::generate()->get();
$key = KeyFactory::generate()->get();
$additionalData = null;

// returns cipher text
$encrypted = $cyph->encrypt($plaintext, $key, $nonce,  $additionalData)->get();

// Decrypt the message.
$decrypted = $cyph->decrypt($encrypted, $key, $nonce, $additionalData)->get();

?>

```

### Custom Configurations

You are not forced to use the default configuration each time when using the cyph class. You could simply create an array or create a configuration file and use it for initiating the class.

#### Loading from an array.

```php
<?php

use Albinvar\Cyph;

// loading configuration parameters from an array.
$configs = [
	'adapter' => 'sodium',
	'cipher' => 'aes-256-gcm',
	'strategy' => 'symmetric'
];

// Here, we overided the default configuration with a custom one.
$cyph = Cyph::loadConfig($configs);

// Cyph class is configured with the parameters from the array.
// Now we can use Cyph like the normal one.
?>

```
#### Loading from a configuration file.
You can also create a configuration file at the root of your project.

```php
<?php

use Albinvar\Cyph;

$path = __DIR__.'/config/cyph.json';

// loading configuration parameters from the configuration file.
$cyph = Cyph::loadConfigFromFile($path);

// Cyph class is configured with the parameters from the array.
// Now we can use Cyph like the normal one.
?>

```

### Encrypting Files

You can also encrypt/decrypt files with cyph too. The files are splitted into chunks inorder to complete the encryption much efficiently.


```php
<?php

use Albinvar\Cyph;
use Albinvar\Cyph\Sodium\KeyFactory;
use Albinvar\Cyph\Sodium\NonceFactrory;

// The message to Encrypt.
$file = "/tmp/message.txt";

// Configure Cyph
$cyph = Cyph::adapter('sodium')->cipher('aes-256-gcm')->strategy('symmetric')

$nonce = NonceFactory::generate()->get();
$key = KeyFactory::generate()->get();

// returns cipher text
$encrypted = $cyph->encryptFile($file, $key, $nonce,  $additionalData)->saveTo('/tmp/encrypted.txt');

// Decrypt the message.
$decrypted = $cyph->decrypt('/tmp/encrypted.txt', $key, $nonce, $additionalData)->saveTo('/tmp/decrypted.txt');

?>

```


<p align="right">(<a href="#top">back to top</a>)</p>



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
