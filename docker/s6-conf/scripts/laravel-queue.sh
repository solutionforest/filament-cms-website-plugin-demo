#!/command/with-contenv bash

# Exit on error
set -e

# Check to see if an Artisan file exists and assume it means Laravel is configured.
if [ -f $APP_BASE_DIR/artisan ]; then
        echo "🏃‍♂️ Checking for Laravel Queue default ..."

        ############################################################################
        # Automated AUTORUN_LARAVEL_QUEUE
        ############################################################################
        if [ ${AUTORUN_LARAVEL_QUEUE:="true"} == "true" ]; then
            echo "🚀 Running queue default..."
            # s6-setuidgid webuser php $APP_BASE_DIR/artisan queue:work --sleep=3 --tries=3 --daemon --timeout=0
            php $APP_BASE_DIR/artisan queue:work --sleep=3 --tries=3 --daemon --timeout=0
        fi

else
    echo "👉 Skipping Laravel Queue because we could not detect a Laravel install or it was specifically disabled..."
fi

exit 0