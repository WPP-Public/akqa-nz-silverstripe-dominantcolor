# Silverstripe Dominant Color

Utilises the [Color Thief PHP](https://github.com/ksubileau/color-thief-php) library to extract the dominant color from an image. 

This can be particularly useful for setting the background color of lazy-loaded images or for styling accompanying HTML markup.

## Requirements

- Silverstripe 4 or 5
- PHP >= 7.2 or >= PHP 8.0
- Supports JPEG, PNG, GIF and WEBP images.

## Installation via Composer

```
composer require heyday/silverstripe-dominantcolor
```

## Usage

Adds the `DominantColor()` method to the `Image` class which returns the dominant color of an image in hex format `#bada55`

```html
<div style="background-color: $Image.DominantColor">
```

```php
Image::get()->find(…)->DominantColor();
```