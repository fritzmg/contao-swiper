Contao Swiper
=====================

Contao 4+ bundle to integrate Swiper.js

## Installation

Currently you have to add
```
"repositories": [
    {
        "type": "package",
        "package": {
            "name": "nolimits4web/swiper",
            "type": "component",
            "version": "3.4.2",
            "dist": {
                "url": "https://github.com/nolimits4web/Swiper/archive/v3.4.2.zip",
                "type": "zip"
            },
            "source": {
                "url": "https://github.com/nolimits4web/Swiper.git",
                "type": "git",
                "reference": "3.4.2"
            },
            "extra": {
                "component": {
                    "scripts": [
                        "dist/js/swiper.min.js"
                    ],
                    "styles": [
                        "dist/css/swiper.min.css"
                    ]
                }
            },
            "require": {
                "robloach/component-installer": "*"
            }
        }
    }
]
```
to your root `composer.json`. You can change the `3.4.2` version numbers to something higher whenever necessary or possible.
