# ACF Random String Field

ACF v5 field to generate a random 6 digit string and save it to a hidden field.
We use this to give our rows/bricks or page-blocks indidiual ID's.

_Note:_ This plugin was original create by [hcmedia](https://github.com/hcmedia/acf-field-randomstring).

-----------------------

### Compatibility

This ACF field type is compatible with:
* ACF 5


##### Install with Composer

1. Extend your `composer.json`
```javascript
{
  "repositories": {
        "acf-field-randomstring": {
            "type": "vcs",
            "url": "git@github.com:macherjek1/acf-field-randomstring.git"
        }
    },
    "require": {
      "macherjek1/acf-field-randomstring": "~2.0.0"
    }
  }
}
```

### Release History

* 0.0.3
  * Bugfixes
  * Composer Support
