# TallmanCode Devalicious

##### Table of Contents
* [Installation](#installation)
* [Make Bundle Command](#make-bundle-command)
    * How To Make A Bundle

## Installation
```lang=bash
composer require tallmancode/devalicious --dev
```

## Make Bundle Command
This bundle provides a handy command under the `make:` namespace. Intended to speed up getting started with developing a symfony bundle, the command with create a boilerpalt template for your bundles and get you making cool stuff faster.

### Usage
To make a bundle simply run.
```lang=bash 
php bin/console make:bundle 
```
or
```lang=bash 
php bin/console make:bundle <vendor_name> <bundle_name>
```
To bypass the vendor and bundle name questions.

