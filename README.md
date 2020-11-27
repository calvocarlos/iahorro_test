# Consideraciones especiales

Teniendo en cuenta que *el email del cliente debe ser único*, por simplificación, integrare la tabla "**clients**" y "**mortgage_applications**" en una sola tabla llamada "**mortgage_applications**", sin embargo, es posible que ha futuro, un cliente pueda realizar varias solicitudes (en distintos periodos de tiempo o con distintos ingresos o montos solicitados) y convenga tener estos datos registrados en tablas distintas para hacer un resumen general de los datos de un cliente. 

**La asignación aleatoria de las solicitudes de hipoteca a los expertos** se realiza de forma automática con un comando programado para ejecutarse los días de semana a las 7 de la mañana. También se pueden ejecutar de forma manual para efectos de la prueba.  

Con respecto a la franja horaria, entiendo que este es el tiempo en el que el cliente quiere ser atendido. Pudiera incluso tener varias franjas (por día de la semana o en el mismo día) lo que requiere una nueva tabla. Sin embargo, por simplicidad, asumiré que solo se indica una franja horaria que va desde la 0 a la 23.

Se requieren más validaciones durante el registro de una solicitud, sin embargo, se han colocado las más básicas siguiendo la estructura sugerida por Laravel.

Queda pendiente la documentación de la API con herramientas como:
  - [Swagger](https://swagger.io/)
  - [Laravel API Documentation Generator](https://github.com/mpociot/laravel-apidoc-generator)

Por último, me he centrado más en la estructura del código que en el resultado de la prueba en sí, puesto que considero que es más importante dado que no deja de ser una prueba.

# Instalación

Clonamos el proyecto de **Github** en la ubicacion deseada
```
git clone https://github.com/calvocarlos/iahorro_test.git
```

Instalamos las dependencias de PHP con **Composer**
```
composer install
```

Lanzamos un servidor
```
php artisan serve
```

# Configuración

### Credenciales de la Base de Datos

Se encuentran el archivo **.env**, modificar según sea el caso.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iahorro_ccalvo
DB_USERNAME=iahorro_user
DB_PASSWORD=iahorro_pw
```

### Ejecutamos las migración de la Base de Datos

Se crean algunos datos de prueba para realizar los tests de la aplicación.  
Se crearán:
  - **50** solicitudes y 
  - **5** expertos.
```
php artisan migrate:fresh --seed
```

### Asignamos las solicitudes de hipoteca a los expertos

La asignación se realiza de manera aleatoria
```
php artisan iahorro:assign_mortgage_applications_to_mortgage_experts
```

### Ejecutamos todas las pruebas con PHPUnit

Verificamos que se ejecuten todas las pruebas con éxito para comprobar que la configuración ha sido correcta.
```
php artisan test
```

# Pruebas

Asumiendo que **APP_URL=http://localhost**, tenemos los siguiente endpoints para la prueba desde el navegador, postman o cualquier otro entorno.

### Registro
[Registro de solicitudes de hipotecas](https://app.getpostman.com/run-collection/4ec5586771e94654ed1d)  
  
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/4ec5586771e94654ed1d)
```
Bodyform-data

first_name: 'Carlos'
last_name: 'Calvo'
email: 'calvocarlos.es@gmail.com'
phone_number: '+34692349002'
net_income: '36000.00'
requested_amount: '150000.00'
start_time_slot: '11'
end_time_slot: '17'
```


### Consultas

[Consulta de solicitudes de hipotecas por experto](http://127.0.0.1:8000/api/v1/mortgage-applications/expert/1) (ordenadas por **scoring** y dentro de la **franja horaria** seleccionada por el cliente)
``` http
http://127.0.0.1:8000/api/v1/mortgage-applications/expert/1
```
  
[Consulta de una solicitud de hipoteca](http://127.0.0.1:8000/api/v1/mortgage-applications/36)
``` http
http://127.0.0.1:8000/api/v1/mortgage-applications/36
```

[Consulta de todas las solicitudes de hipotecas](http://127.0.0.1:8000/api/v1/mortgage-applications)
``` http
http://127.0.0.1:8000/api/v1/mortgage-applications
```

[Consulta de un experto en hipotecas](http://127.0.0.1:8000/api/v1/mortgage-experts/1)
``` http
http://127.0.0.1:8000/api/v1/mortgage-experts/1
```

[Consulta de todos los expertos en hipotecas](http://127.0.0.1:8000/api/v1/mortgage-experts)
``` http
http://127.0.0.1:8000/api/v1/mortgage-experts
```

### Manejo básico de errores

[Consulta no valida](http://127.0.0.1:8000/api/v1/mortgage-applications/bad-request)
``` http
http://127.0.0.1:8000/api/v1/mortgage-applications/bad-request
```

[Consulta de solicitud de hipoteca inexistente](http://127.0.0.1:8000/api/v1/mortgage-applications/99)
``` http
http://127.0.0.1:8000/api/v1/mortgage-applications/99
```
