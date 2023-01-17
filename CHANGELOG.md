# Change Log for OXID geo-blocking module

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

### Added
- Support for twig template engine
- Migrations directory configured, queries from activation events moved to migrations
- Development workflows with test runners
- Module works on smarty engine (Smarty related extensions in views/smarty resp. views/admin_smarty directory)
- Module works on twig engine (Twig related extensions in views/twig resp. views/admin_twig directory)

### Changed
- Adapted module to work with OXID eShop 7.0.x
- Adapted test to work with OXID eShop 7.0.x and without testing library
- Moved all php code to src directory with some cleanups:
    - Application folder omitted
- All assets moved to `assets` folder to be available after module installation

## [1.1.1] - 2022-06-13

### Fixed
- Updated documentation link

## [1.1.0] - 2021-07-14

### Added
- Ensure module works with php 7.2

### Removed
- Support of php 5.6 and 7.0

### Fixed
- Fixed tests to work with latest module registration/activation changes
- Fixed compatibility issues regarding setUp and tearDown phpunit methods.

## [1.0.0] - 2019-02-25

[Unreleased]: https://github.com/OXID-eSales/geo-blocking-module/compare/b-1.x...master
[1.1.1]: https://github.com/OXID-eSales/geo-blocking-module/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/OXID-eSales/geo-blocking-module/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/OXID-eSales/geo-blocking-module/compare/c0cb05009601a58d0815efa9e09bd4ad758b1595...v1.0.0
