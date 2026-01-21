<?php

function afficherArguments(...$args) {
    foreach ($args as $arg) {
        echo $arg . "\n";
    }
}

// Exemple d'utilisation
afficherArguments("pomme", "banane", 42, "zèbre", 3.14);