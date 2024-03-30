#!/bin/bash
echo "Starting Supervisor..."
supervisord -c /etc/supervisor/supervisord.conf
