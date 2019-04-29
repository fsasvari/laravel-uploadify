# Changelog

## v1.2.7 (2019-04-29)

### Added
- Added support for `Laravel 5.8` version

## v1.2.6 (2019-01-20)

### Added
- Added support for `Laravel 5.7` version

### Fixed
- Fixed image thumbnail show without extension

## v1.2.3 (2018-04-19)

### Added
- Added support for `Laravel 5.6` version
- Added "quality" value in configuration file

### Fixed
- Fixed getDisk() method in Image controller
- Fixed problem with Laravel Logger

## v1.2 (2017-11-28)

### Changed
- Rename `$images` and `$files` properties to more specific `$uploadifyImages` and `$uploadifyFiles`

## v1.1 (2017-10-23)

### Added
- Added setDisk() and setPath() methods in AbstractDriver class for easier setting different upload path that one provided in model

## v1.0 (2017-10-09)

### Added
- Add upload support via UploadedFile, InterventionImage, path and url

## v0.4.2 (2017-09-03)

### Fixed
- Fix service provider namespace in composer.json

## v0.4.1 (2017-09-03)

### Fixed
- Fix path to service provider in composer.json

## v0.4 (2017-09-03)

### Added
- Add support for Laravel 5.5 version

## v0.3 (2017-08-04)

### Added
- Create default `ImageController` for showing processed images

## v0.2.2 (2017-08-04)

### Changed
- Add `width` and `height` parameters at beginning of options array in `url()` method

## v0.2.1 (2017-08-04)

### Changed
- Add `width` and `height` parameters at beginning of options array in `url()` method

## v0.2 (2017-08-04)

### Added
- Add more processing image parameters like crop, effect, quality, blur...

### Changed
- Changed process image logic

## v0.1 (2017-08-02)
- Initial release
