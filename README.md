# @Package IC\ProjectAbsensi
## Usage Example
```php
<?php
use Ic\ProjectAbsensi\CodePresenter;
require __DIR__."/CodePresenter.php";

$nim = "11.11.1111";
$code = "abcde";
$cp = new CodePresenter($nim, $code);
echo $cp->execute(); // return response body.
```

## X API Key and Bundled Secret Key
```
/**
 * Ask for X_API_KEY to IC Departement.
 */
private const X_API_KEY = "";

/**
 * Ask for SECRET_KEY to IC Departement.
 *
 * After you have the SECRET_KEY, you need to generate
 * a bundled secret key by using the following algorithm.
 *
 * $hashedSecretKey = substr(md5(SECRET_KEY, true), 24);
 * for ($i = 16, $i2 = 0; $i2 < 8; $i2++, $i++)
 *   $hashedSecretKey[$i] = $hashedSecretKey[$i2];
 * $bundledSecretKey = $hashedSecretKey;
 *
 * This key will be used to encrypt the payload.
 */
private const BUNDLED_SECRET_KEY = "";
```
