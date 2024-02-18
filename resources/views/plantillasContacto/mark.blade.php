@component('mail::message')
![Laravel Logo](https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png)

# Formulario de contacto

## Enviado por: 
{{ $nombre }}

## Email de remitente:
**{{ $email }}**

## Mensaje:
> {{ $contenido }}

@endcomponent