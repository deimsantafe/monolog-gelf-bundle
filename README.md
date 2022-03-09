STG Monolog GELF Bundle
==================
Symfony Bundle para utilizar GELF como handler de Monolog.

Prerequisitos
-------------

Este bundle requiere Symfony 5.0+.

Instalación
---------------

Agregar el repositorio en donde se encuentra el bundle a instalar. Si no 
existe la clave "repositories" debe ser creada en el primer nivel del 
archivo composer.json.

    {
    ...

        "repositories": [
            {
              "type": "git",
              "url": "https://github.com/deimsantafe/monolog-gelf-bundle"
            }
         ],

    ...
    }

Agregar [`stg/monolog-gelf-bundle`](https://github.com/deimsantafe/monolog-gelf-bundle)
a tu archivo `composer.json`:


``` bash
composer require "stg/monolog-gelf-bundle:^3.0"
```

Configurar archivo `.env` (o las respectivas variables de entorno) :

``` yaml
GELF_HOST: #host del servidor gelf
GELF_PORT: #puerto del servidor gelf
GELF_TAG: #tag para poder filtrar el log en el servidor
GELF_LEVEL: #nivel de error a loguear
            # 100-Debug
            # 200-Info
            # 250-Notice
            # 300-Warning
            # 400-Error
            # 500-Critical
            # 550-Alert
            # 600-Emergency
```
Configurar Handler en Monolog(ejemplo en archivo `config/packages/dev/monolog.yaml`):

```yml
monolog:
    handlers:
        service:
            type: service
            id: stg.monolog.gelf_handler
```
