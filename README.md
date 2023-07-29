# Tr Tax Number Faker

<div style="text-align: center">
<a href="https://packagist.org/packages/netkod-bilisim/tr-tax-number-verification" rel="nofollow">
    <img src="https://img.shields.io/packagist/v/netkod-bilisim/tr-tax-number-verification" alt="Latest Stable Version">
</a>

<a href="https://packagist.org/packages/netkod-bilisim/tr-tax-number-verification" rel="nofollow">
    <img src="https://img.shields.io/packagist/dt/netkod-bilisim/tr-tax-number-verification" alt="Total Downloads">
</a>

<a href="https://packagist.org/packages/netkod-bilisim/tr-tax-number-verification" rel="nofollow">
    <img src="https://poser.pugx.org/netkod-bilisim/tr-tax-number-verification/dependents.svg" alt="Dependents">
</a>

<a href="https://packagist.org/packages/netkod-bilisim/tr-tax-number-verification" rel="nofollow">
    <img src="https://img.shields.io/packagist/l/netkod-bilisim/tr-tax-number-verification" alt="License">
</a>
</div>

<div style="text-align: center">
<a href="https://packagist.org/packages/netkod-bilisim/tr-tax-number-verification" rel="nofollow">
    <img src="http://poser.pugx.org/netkod-bilisim/tr-tax-number-verification/require/php" alt="PHP Version">
</a>
<a href="https://scrutinizer-ci.com/g/netkod-bilisim/tr-tax-number-verification/badges/quality-score.png?b=master" rel="nofollow">
    <img src="https://scrutinizer-ci.com/g/netkod-bilisim/tr-tax-number-verification/badges/quality-score.png?b=master" alt="Scrutinizer">
</a>
<a href="https://github.styleci.io/repos/672299895?branch=master">
    <img src="https://github.styleci.io/repos/672299895/shield?branch=master" alt="StyleCI">
</a>

</div>

## <img src="public/assets/images/presentation.png" width="25" height="25"> Introduction

It checks the TR Tax Number.

## <img src="public/assets/images/requirement.png" width="25" height="25"> Requirements

- PHP >= 7.4

## <img src="public/assets/images/inbox.png" width="25" height="25"> Install

```bash
composer require netkod-bilisim/tr-tax-number-verification:"^1"
```

## <img src="public/assets/images/web-coding.png" width="25" height="25"> Usage

```php
use NetkodBilisim\TrTaxNumberVerification;

$company_type = 1; // 1: Real Entity, 2: Legal Entity
$tax_number = '3331970048';
$tax_office_code = '035267' // Tax office number registered on GIB;

$result = TrTaxNumberVerification::verify($company_type, $tax_number, $tax_office_code);
var_dump($result);    # Result: object

# If successful
#
#   return (object)[
#       'status' => false,
#       'data' => (object)[
#           'title' => 'title',
#           'tax_no' => 'tax_no',
#       ]
#   ];

# If not successful
#
#   return (object)[
#       'status' => false,
#       'error' => (object)[
#           'code' => 'code
#           'description' => 'description'
#       ]
#   ];
```

## <img src="public/assets/images/licensing.png" width="25" height="25"> License

This package is open source software licensed under
the [MIT License](https://opensource.org/license/mit/).

