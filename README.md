# tptickets

Sistema de simulación de venta de tickets para eventos varios (conciertos, obras teatrales, deportes, etc).

Este programa permite, entre otras, las siguientes funcionalidades:

* Alta, baja y modificación de usuarios (Admin y usuario regular)
* Alta, baja y modificación de eventos con sus respectivas fechas (calendarios)
* Registro y control de ventas efectuadas
* Envío de e-mails al crear un usuario regular nuevo y al confirmar compras

## Setup y requisitos

Este programa precisa instalar dependencias mediante [composer](https://getcomposer.org).

Una vez instalado, para hacerse de las dependencias, simplemente escribir en la ventana de comandos `composer install`. Consultar la documentación en la página oficial para más detalles.

Importar las instrucciones SQL del archivo **db.sql** ubicado en la raíz del repositorio. *phpmyadmin* es preferible para esto.

Finalmente, una vez cargada la ṕágina principal, crear una cuenta de usuario regular o iniciar sesión como admin.

Credenciales de admin:

e-mail: `admin@tptickets.com`
contraseña: `123456`