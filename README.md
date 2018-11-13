# tptickets
El tp
lucas petero
tu vieja es petera


28/10 franco
usercontroller modifique check email con db
usercontroller check pass dentro del update.. determine q el email no se pueda modificar(readonly)
adminuser interfaz arreglada

29/10 franco
model seattype
controladora dao y vista

30/10 franco
model calendar
controladora daos y vista

model seatevent
controladora daos y vista(con error->revisar)

footer.php
data modificado
login.php vista ->ligado a controladora user/index por defecto
user/login  detallado peque;o error

31/10
modificacion importante user/login le di mas responsabilidades a la controladora home/login
setSession
daouser db
homecontroler/login
vista login.php



usercontroller
homecontroller.adduser
navbar con session 
singin vista
adminuser vista metodo add
le di la responsabilidad de addUser a la controladora home 


Agregada clase Ticket y su dao (no testeados)


6/11 
agregue $image al model de evento
modifique daos, vista, sql con una columna de mas y controladora
falta implementar filecontroller dentro de esta controladora (preguntar)

13/11

agregue array de artista al calendario y placeevent. cambie los parametros del modelo(calendario) para q trabajemos
con objetos y no con ids. cambios en daos y db. Quedo con un error al intentar cargar una calendario
Viene por el lado de la coneccion con la bd. Si alguien le echa un ojo genial.
Habria que reveer el modelo de Calendario para utilizar el artistaxCalendario o nose ya toy quemado
homecontroller search y vista search no terminadas sin funcionar