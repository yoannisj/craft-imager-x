# Imager X Changelog

## unreleased

### Changed
- Imager morphed into Imager X. Namespace is now `spacecatninja\imagerx`, plugin handle is `imager-x`.
- Changed how extensions (external storages, effects, transformers and optimizers) are registered, we now use events.

### Added
- Added support for custom transformers.
- Added support for named transforms.
- Added support for auto generating transforms (on asset upload or element save).
- Added console commands for generating transforms.
- Added element action for generating transforms.
- Added basic support for GraphQL.
- Added opacity, gaussian blur, motion blur, radial blur, oil paint, adaptive blur, adaptive sharpen, despeckle, enhance and equalize effects.
- Added support for fallback image (used if an image cannot be found).
- Added support for mock image (used for every transform no matter what's passed in).
- Added a `preserveColorProfiles` config setting for preserving color profiles even if meta data is being stripped.

### Fixed 
- Fixed issues that would occur if external downloads are interrupted and the error can't be caught. Downloads are now saved to a temporary file first.
- Fixed issues that would occur if a file upload to an external storage fails. The transformed file is now deleted so that Imager can try again. 