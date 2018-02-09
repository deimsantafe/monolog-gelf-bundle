STG Monolog GELF Bundle
==================
Symfony Bundle para utilizar GELF como handler de Monolog.

Prerequisitos
-------------

Este bundle requiere Symfony 2.8+.

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

Agregar [`deimsantafe/monolog-gelf-bundle`](https://github.com/deimsantafe/monolog-gelf-bundle)
a tu archivo `composer.json`:


``` bash
composer require "deimsantafe/monolog-gelf-bundle"
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
```

Configurar Handler en Monolog(ejemplo):

```yml
monolog:
    handlers:
        service:
            type: service
            id: stg.monolog.gelf_handler
```
