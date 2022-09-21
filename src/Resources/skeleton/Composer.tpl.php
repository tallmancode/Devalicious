{
    "name": "<?php echo $name; ?>",
    "autoload": {
        "psr-4": {
            "<?php echo $vendor; ?>\\<?php echo $bundleName; ?>\\": "src/",
            "<?php echo $vendor; ?>\\<?php echo $bundleName; ?>\\Tests\\": "tests/"
        }
    },
    "license": "MIT",
    "type": "symfony-bundle",
    "authors": [
        {
            "name": "Tallmancode",
            "email": "steve@tallmancode.co.za"
        }
    ],
    "require": {
        "php": ">=7.2.5",
        "symfony/config": "^4.4 | ^5.0 | ^6.0",
        "symfony/dependency-injection": "^4.4 | ^5.0 | ^6.0",
        "symfony/deprecation-contracts": "^2.2 | ^3.0",
        "symfony/http-kernel": "^4.4 | ^5.0 | ^6.0"
    },
    "require-dev": {
        "symfony/phpunit-bridge": "^6.0"
    }
}
