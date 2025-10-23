# Usa una imagen oficial de PHP como base
FROM php:8.2-cli

# Establece el directorio de trabajo en /app
WORKDIR /app

# Copia todos los archivos del proyecto al contenedor
COPY . .

# Expone el puerto 10000
EXPOSE 10000

# Comando para iniciar el servidor PHP
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
