# NEC ID PHP SDK

This package connects the NEC ID REST API with PHP.

API Documentation is available on https://docs.id.nec.com.au/en/latest/

### Installing

Simply require the package from composer.

```
composer require xequals-nz/nec-id-php
```

### In progress

This is the status of the API endpoints implemented by this library:

- Biometric
  - Subjects ✅
  - Tags ✅
  - Face ✅
  - Events: https://github.com/xequals-nz/nec-id-php/issues/1
  - Jobs: https://github.com/xequals-nz/nec-id-php/issues/2
- Tenant Management
  - Galleries ✅
  - Applications ✅ 

## Usage example with dotenv

Note that this could be instantiated without dot env, just pass the credentials
into the setCredentials method as an array.

1. Copy .env.example into .env and fill the required keys.

- Access Key
- Secret Key
- AWS Region (This value normally should be ap-southeast-2)
- API Endpoint (This value normally should be https://api.id.nec.com.au/v1.1)
- API Key of the application

2. Ensure that dotenv is loaded
```
require __DIR__ .'/../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
```

3. Load the credentials
```
\NecId\Resource::setCredentials();
```
4. Instance the class required, for instance, tags.
```
$tag_resource = new Tag();
```
5. Call the method, for instance, listing tags.
```
$tag_resource->listTags()
```

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* [XEQUALS](https://xequals.nz/) - Development and maintenance.
