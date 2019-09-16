STG Monolog GELF Bundle
==================
Symfony Bundle para utilizar GELF como handler de Monolog.

Prerequisitos
-------------

Este bundle requiere Symfony 2.8+. Para la versión compatible con Symfony 4, ingresar en [versión 2.x](https://github.com/deimsantafe/monolog-gelf-bundle/tree/2.x).

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
composer require "stg/monolog-gelf-bundle"
```

Registrar el bundle en el archivo `app/AppKernel.php`:

    public function registerBundles()
    {
        ...

        $bundles = array(
            ...

            new STG\Bundle\MonologGELFBundle\STGMonologGELFBundle(),

            ...
        );

        ...
    }


Configurar archivo `parameters.yml` :

``` yaml
gelf_host: #host del servidor gelf
gelf_port: #puerto del servidor gelf
gelf_tag: #tag para poder filtrar el log en el servidor
gelf_level: #nivel de error a loguear
            # 100-Debug
            # 200-Info
            # 250-Notice
            # 300-Warning
            # 400-Error
            # 500-Critical
            # 550-Alert
            # 600-Emergency
```

Configurar Handler en Monolog(ejemplo):

```yml
monolog:
    handlers:
        service:
            type: service
            id: stg.monolog.gelf_handler
```
