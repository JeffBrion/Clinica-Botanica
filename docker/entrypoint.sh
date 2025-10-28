#!/usr/bin/env sh
set -e

cd /var/www/html

# Ajustar Apache al puerto dinámico si Railway define $PORT
if [ -n "$PORT" ]; then
  echo "[entrypoint] Usando puerto $PORT"
  sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf || true
  sed -ri "s#<VirtualHost \*:.*>#<VirtualHost *:${PORT}>#" /etc/apache2/sites-available/000-default.conf || true
fi

# Asegurar enlace de storage/public
if [ ! -e "public/storage" ]; then
  echo "[entrypoint] Creando storage:link"
  php artisan storage:link || true
fi

# Cache de config y rutas (no falla si .env existe)
echo "[entrypoint] Cacheando config y rutas"
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan config:cache || true
php artisan route:cache || true

# Migraciones opcionales controladas por variable de entorno
if [ "${RUN_MIGRATIONS}" = "true" ]; then
  echo "[entrypoint] Ejecutando migraciones --force"
  ATTEMPTS=${MIGRATIONS_MAX_RETRIES:-10}
  SLEEP_SECS=${MIGRATIONS_RETRY_DELAY:-3}
  i=0
  until php artisan migrate --force; do
    i=$((i+1))
    if [ "$i" -ge "$ATTEMPTS" ]; then
      echo "[entrypoint] Migraciones fallaron tras ${ATTEMPTS} intentos" >&2
      break
    fi
    echo "[entrypoint] DB no lista, reintentando en ${SLEEP_SECS}s... (${i}/${ATTEMPTS})"
    sleep "$SLEEP_SECS"
  done
fi

# Iniciar Apache en primer plano
exec apache2-foreground
