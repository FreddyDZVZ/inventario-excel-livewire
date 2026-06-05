# Inventario Excel Livewire

Proyecto Laravel + Livewire para:

- Subir un Excel de inventario.
- Importar productos a PostgreSQL.
- Escanear código de barras.
- Buscar primero en inventario.
- Si no existe, buscar descripción en internet.
- Si no aparece en internet, capturar datos manualmente.

## Requisitos

- PHP 8.3 o superior.
- Composer.
- PostgreSQL.
- Extensiones PHP comunes: `pgsql`, `zip`, `xml`, `mbstring`, `curl`, `gd`.

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Edita `.env` si tu PostgreSQL usa otro puerto o nombre de base de datos.

Por defecto usa:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=inventario_excel
DB_USERNAME=postgres
DB_PASSWORD=root
```

Crea la base de datos:

```bash
sudo -u postgres psql
```

```sql
CREATE DATABASE inventario_excel;
\q
```

Migra:

```bash
php artisan migrate
```

Levanta:

```bash
php artisan serve
```

Abre:

```txt
http://127.0.0.1:8000
```

## Nota

No incluye carpeta `vendor`. Se descarga con `composer install`.
