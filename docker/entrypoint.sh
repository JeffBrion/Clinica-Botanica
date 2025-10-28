#!/usr/bin/env sh
set -e

cd /var/www/html

# Ajustar Apache al puerto dinámico si Railway define $PORT
if [ -n "$PORT" ]; then
  echo "[entrypoint] Usando puerto $PORT"
  sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf || true
  sed -ri "s#<VirtualHost \*:.*>#<VirtualHost *:${PORT}>#" /etc/apache2/sites-available/000-default.conf || true
fi

# Asegurar .env y APP_KEY si no está configurado por variables de entorno
if [ ! -f .env ] && [ -f .env.example ]; then
  echo "[entrypoint] Copiando .env desde .env.example"
  cp .env.example .env || true
fi

if [ -z "${APP_KEY}" ]; then
  echo "[entrypoint] APP_KEY no definido; generando uno temporal para este entorno"
  GENERATED_KEY=$(php artisan key:generate --show 2>/dev/null || true)
  if [ -n "$GENERATED_KEY" ]; then
    export APP_KEY="$GENERATED_KEY"
    # Persistir en .env para futuros arranques del mismo contenedor
    if [ -f .env ]; then
      if grep -q '^APP_KEY=' .env; then
        sed -i "s#^APP_KEY=.*#APP_KEY=${APP_KEY}#g" .env || true
      else
        echo "APP_KEY=${APP_KEY}" >> .env
      fi
    fi
  else
    echo "[entrypoint] No se pudo generar APP_KEY; verifica que PHP/Artisan esté operativo" >&2
  fi
fi

# Asegurar enlace de storage/public
if [ ! -e "public/storage" ]; then
  echo "[entrypoint] Creando storage:link"
  php artisan storage:link || true
fi

# Cache de config y rutas (continúa aunque fallen)
echo "[entrypoint] Cacheando config, rutas y vistas"
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
