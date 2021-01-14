# Symfony UX React

## Installation

Symfony UX React requires PHP 7.2+ and Symfony 4.4+.

Install this bundle using Composer and Symfony Flex:

```sh
composer require YannickArmspach/symfony-ux-react

# Don't forget to install the JavaScript dependencies as well and compile
yarn install --force
yarn encore dev
```

## Usage

To use Symfony UX React, inject the `ReactBuilderInterface` service and
create react in PHP:

```php
// ...
use YannickArmspach\UX\React\Builder\ReactBuilderInterface;
use YannickArmspach\UX\React\Model\React;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ReactBuilderInterface $reactBuilder): Response
    {
        $react = $reactBuilder->createReact();

        return $this->render('home/index.html.twig', [
            'react' => $react,
        ]);
    }
}
```

Once created in PHP, a react can be displayed using Twig:

```twig
{{ render_react(react) }}

{# You can pass HTML attributes as a second argument to add them on the <canvas> tag #}
{{ render_react(react, {'class': 'my-class'}) }}
```

### Extend the default behavior

Symfony UX React allows you to extend its default behavior using a custom Stimulus controller:

```js
// myreact_controller.js

import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        this.element.addEventListener('react:connect', this._onConnect);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side effects
        this.element.removeEventListener('react:connect', this._onConnect);
    }

    _onConnect(event) {
        // The react was just created
        console.log(event.detail.react); // You can access the react instance using the event details

        // For instance you can listen to additional events
        event.detail.react.options.onHover = (mouseEvent) => {
            /* ... */
        };
        event.detail.react.options.onClick = (mouseEvent) => {
            /* ... */
        };
    }
}
```

Then in your render call, add your controller as an HTML attribute:

```twig
{{ render_react(react, {'data-controller': 'myreact'}) }}
```

## Backward Compatibility promise

This bundle aims at following the same Backward Compatibility promise as the Symfony framework:
[https://symfony.com/doc/current/contributing/code/bc.html](https://symfony.com/doc/current/contributing/code/bc.html)

However it is currently considered
[**experimental**](https://symfony.com/doc/current/contributing/code/experimental.html),
meaning it is not bound to Symfony's BC policy for the moment.

## Run tests

### PHP tests

```sh
php vendor/bin/phpunit
```

### JavaScript tests

```sh
cd Resources/assets
yarn test
```
