# tptickets

Sistema de simulación de venta de tickets para eventos varios (conciertos, obras teatrales, deportes, etc).

Este programa permite, entre otras, las siguientes funcionalidades:

* Alta, baja y modificación de usuarios (Admin y usuario regular)
* Alta, baja y modificación de eventos con sus respectivas fechas (calendarios)
* Registro y control de ventas efectuadas
* Envío de e-mails al crear un usuario regular nuevo y al confirmar compras
* Búsqueda de eventos disponibles por nombre, fecha o categoría
* Consulta de historial de compras efectuadas por el usuario

## Setup y requisitos

### Dependencias

Este programa precisa instalar dependencias mediante [composer](https://getcomposer.org).

Una vez instalado, para hacerse de las dependencias, simplemente escribir en la ventana de comandos `composer install`. Consultar la documentación en la página oficial para más detalles.

### Base de datos

Este programa utiliza MySQL/MariaDB para la persistencia de datos.

Importar las instrucciones del archivo **db.sql** ubicado en la raíz del repositorio. *phpmyadmin* es preferible para esto.

### Configuración de envío de e-mails

Se necesita un proveedor de SMTP para el envío correcto de e-mails. De no disponerlo, es posible simular uno localmente mediante [smtp4dev](https://github.com/rnwood/smtp4dev).

Si no se desea hacer uso de esta funcionalidad, dejar comentadas las líneas de código donde se haga uso de ella. (Actualmente, [aquí](https://github.com/hiworld10/tptickets/blob/dev/app/controllers/Users.php#L254) y [aquí](https://github.com/hiworld10/tptickets/blob/dev/app/controllers/Purchases.php#L204).)

### Almacenamiento de credenciales

**Importante**: este programa está configurado para levantar la información correspondiente a las credenciales de base de datos y de proveedor de SMTP *fuera* del directorio raíz, más especificamente un directorio por encima del mismo, con el fin de evitar realizar commits con dicha información presente. Ver [aquí](https://github.com/hiworld10/tptickets/blob/dev/app/config/credentials_template.php) para instrucciones.

### Inicio de sesión

Finalmente, una vez cargada la página principal, crear una cuenta de usuario regular o iniciar sesión como admin.

Credenciales de admin:

e-mail: `admin@tptickets.com`
contraseña: `123456`