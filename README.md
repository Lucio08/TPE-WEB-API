# API REST para el uso del recurso murals

## Prueba con postman - ENDPOINTS


# Method: GET, URL: carpetaProyecto/api/murals -
Este endpoint se usa para traer de la api todos los murales que tengo en la base de datos.

# Method: GET, URL: carpetaProyecto/api/murals?sort&order -
Tambien en la peticion  podemos decidir en que orden de columna de la tabla  nos trae dicho pedido.

Ejemplo: carpetaProyecto/api/murals?sort=anuario&order=DESC. Este endpoint nos va a ordenar la columna anuario en orden descendente.

# Method: GET, URL: carpetaProyecto/api/murals?linkTo&equalTo -
Con los parametros linkTo y equalTo podemos filtrar que tabla queremos traer.

Ejemplo: carpetaProyecto/api/murals?linkTo=anuario&equalTo=201. Este endpoint nos va a filtrar los murales con el año 2021.

# Method: GET, URL : carpetaProyecto/api/murals/:ID -
En este caso al endpoint agregandole un ID especifico logramos que nos traiga los detalles de un mural en especifico. 

# Method: DELETE, URL: carpetaProyecto/api/murals/:ID -
Luego con el metodo DELETE lo que logramos es poder eliminar un mural con un ID en especifico.

# Method: POST, URL: carpetaProyecto/api/murals -
Este caso es especial ya que para insertar un mural necesitamos el body en formato JSON, para poder completar los campos de dicho mural, un ejemplo seria:

{
"id_tipo": "1", (a que tipo de tecnica pertence)
"nombre": "mural", 
"descripcion":"ejemplo",
"ubicacion": "ejemplo",s
"lugar": "ejemplo",
"anuario": ejemplo,
"imagen": "url"
}
