#!/bin/bash

# Vérifier si des paramètres ont été passés
if [ $# -eq 0 ]; then
    echo "Usage: $0 param1 param2 param3 ..."
    exit 1
fi

# Afficher chaque paramètre sur une ligne, puis trier
printf '%s\n' "$@" | sort