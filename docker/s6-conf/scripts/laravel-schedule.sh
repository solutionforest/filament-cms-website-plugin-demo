#!/command/with-contenv bash

# Exit on error
set -e

# Check to see if an Artisan file exists and assume it means Laravel is configured.
if [ -f $APP_BASE_DIR/artisan ]; then
        echo "🏃‍♂️ Checking for Laravel Schedule ..."

        ############################################################################
        # Automated AUTORUN_LARAVEL_SCHEDULE
        ############################################################################
        if [ ${AUTORUN_LARAVEL_SCHEDULE:="true"} == "true" ]; then
            echo "🚀 Running schadule in every minute ..."
            while [ true ] 
            # Run every minute 
            do 
                # s6-setuidgid webuser php $APP_BASE_DIR/artisan schedule:run --verbose --no-interaction &
                php $APP_BASE_DIR/artisan schedule:run --verbose --no-interaction &
                sleep 60 
                # so we don't run out of memory, and to prevent the container from crashing
            done
        fi

else
    echo "👉 Skipping Laravel Schedule because we could not detect a Laravel install or it was specifically disabled..."
fi

exit 0