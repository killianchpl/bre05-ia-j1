<?php

/**
 * Classe pour générer des utilisateurs aléatoires
 */
class UserGenerator
{
    private array $prenoms = [
        'Lucas', 'Emma', 'Gabriel', 'Jade', 'Léo', 'Louise', 'Raphaël', 'Alice',
        'Arthur', 'Chloé', 'Louis', 'Lina', 'Jules', 'Mia', 'Adam', 'Rose',
        'Hugo', 'Léa', 'Nathan', 'Anna', 'Tom', 'Inès', 'Théo', 'Camille',
        'Noah', 'Manon', 'Ethan', 'Sarah', 'Paul', 'Eva', 'Mathis', 'Zoé'
    ];

    private array $noms = [
        'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit',
        'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel',
        'Garcia', 'David', 'Bertrand', 'Roux', 'Vincent', 'Fournier', 'Morel',
        'Girard', 'André', 'Lefèvre', 'Mercier', 'Dupont', 'Lambert', 'Bonnet'
    ];

    private array $domaines = [
        'gmail.com', 'yahoo.fr', 'hotmail.com', 'outlook.fr', 'orange.fr',
        'free.fr', 'laposte.net', 'sfr.fr', 'icloud.com', 'protonmail.com'
    ];

    private array $villes = [
        'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg',
        'Montpellier', 'Bordeaux', 'Lille', 'Rennes', 'Reims', 'Saint-Étienne',
        'Toulon', 'Le Havre', 'Grenoble', 'Dijon', 'Angers', 'Nîmes', 'Brest'
    ];

    private array $rues = [
        'rue de la Paix', 'avenue des Champs-Élysées', 'boulevard Victor Hugo',
        'rue du Commerce', 'avenue de la République', 'rue Jean Jaurès',
        'place de la Mairie', 'rue Pasteur', 'avenue Gambetta', 'rue de la Gare'
    ];

    /**
     * Génère un utilisateur aléatoire
     */
    public function genererUtilisateur(): array
    {
        $prenom = $this->prenoms[array_rand($this->prenoms)];
        $nom = $this->noms[array_rand($this->noms)];
        
        return [
            'id' => uniqid(),
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $this->genererEmail($prenom, $nom),
            'mot_de_passe' => $this->genererMotDePasse(),
            'telephone' => $this->genererTelephone(),
            'date_naissance' => $this->genererDateNaissance(),
            'adresse' => $this->genererAdresse(),
            'date_inscription' => $this->genererDateInscription(),
            'actif' => (bool) random_int(0, 1)
        ];
    }

    /**
     * Génère plusieurs utilisateurs
     */
    public function genererUtilisateurs(int $nombre): array
    {
        $utilisateurs = [];
        for ($i = 0; $i < $nombre; $i++) {
            $utilisateurs[] = $this->genererUtilisateur();
        }
        return $utilisateurs;
    }

    /**
     * Génère une adresse email
     */
    private function genererEmail(string $prenom, string $nom): string
    {
        $domaine = $this->domaines[array_rand($this->domaines)];
        $formats = [
            strtolower($prenom) . '.' . strtolower($nom),
            strtolower($prenom[0]) . strtolower($nom),
            strtolower($prenom) . random_int(1, 99),
            strtolower($nom) . '.' . strtolower($prenom),
        ];
        $email = $this->normaliserChaine($formats[array_rand($formats)]);
        return $email . '@' . $domaine;
    }

    /**
     * Génère un mot de passe hashé
     */
    private function genererMotDePasse(): string
    {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%';
        $mdp = '';
        for ($i = 0; $i < 12; $i++) {
            $mdp .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }
        return password_hash($mdp, PASSWORD_DEFAULT);
    }

    /**
     * Génère un numéro de téléphone français
     */
    private function genererTelephone(): string
    {
        $prefixes = ['06', '07'];
        $numero = $prefixes[array_rand($prefixes)];
        for ($i = 0; $i < 8; $i++) {
            $numero .= random_int(0, 9);
        }
        return $numero;
    }

    /**
     * Génère une date de naissance (18-70 ans)
     */
    private function genererDateNaissance(): string
    {
        $anneeMin = (int) date('Y') - 70;
        $anneeMax = (int) date('Y') - 18;
        $annee = random_int($anneeMin, $anneeMax);
        $mois = random_int(1, 12);
        $jour = random_int(1, 28);
        return sprintf('%04d-%02d-%02d', $annee, $mois, $jour);
    }

    /**
     * Génère une adresse complète
     */
    private function genererAdresse(): array
    {
        return [
            'numero' => random_int(1, 150),
            'rue' => $this->rues[array_rand($this->rues)],
            'code_postal' => sprintf('%05d', random_int(1000, 95999)),
            'ville' => $this->villes[array_rand($this->villes)]
        ];
    }

    /**
     * Génère une date d'inscription récente (derniers 2 ans)
     */
    private function genererDateInscription(): string
    {
        $timestamp = random_int(strtotime('-2 years'), time());
        return date('Y-m-d H:i:s', $timestamp);
    }

    /**
     * Normalise une chaîne (supprime accents, espaces)
     */
    private function normaliserChaine(string $chaine): string
    {
        $chaine = str_replace(
            ['é', 'è', 'ê', 'ë', 'à', 'â', 'ä', 'ù', 'û', 'ü', 'ô', 'ö', 'î', 'ï', 'ç', ' ', '-'],
            ['e', 'e', 'e', 'e', 'a', 'a', 'a', 'u', 'u', 'u', 'o', 'o', 'i', 'i', 'c', '', ''],
            $chaine
        );
        return $chaine;
    }

    /**
     * Exporte les utilisateurs en JSON
     */
    public function exporterJSON(array $utilisateurs): string
    {
        return json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Exporte les utilisateurs en CSV
     */
    public function exporterCSV(array $utilisateurs): string
    {
        if (empty($utilisateurs)) {
            return '';
        }

        $csv = '';
        
        // En-têtes (colonnes plates)
        $colonnes = ['id', 'prenom', 'nom', 'email', 'telephone', 'date_naissance', 
                     'numero', 'rue', 'code_postal', 'ville', 'date_inscription', 'actif'];
        $csv .= implode(';', $colonnes) . "\n";

        // Données
        foreach ($utilisateurs as $user) {
            $ligne = [
                $user['id'],
                $user['prenom'],
                $user['nom'],
                $user['email'],
                $user['telephone'],
                $user['date_naissance'],
                $user['adresse']['numero'],
                $user['adresse']['rue'],
                $user['adresse']['code_postal'],
                $user['adresse']['ville'],
                $user['date_inscription'],
                $user['actif'] ? '1' : '0'
            ];
            $csv .= implode(';', $ligne) . "\n";
        }

        return $csv;
    }
}


// ============================================
// EXEMPLE D'UTILISATION
// ============================================

$generator = new UserGenerator();

// Générer un seul utilisateur
echo "=== UN UTILISATEUR ===\n";
$user = $generator->genererUtilisateur();
print_r($user);

echo "\n=== 5 UTILISATEURS EN JSON ===\n";
$utilisateurs = $generator->genererUtilisateurs(5);
echo $generator->exporterJSON($utilisateurs);

echo "\n\n=== 3 UTILISATEURS EN CSV ===\n";
$utilisateurs = $generator->genererUtilisateurs(3);
echo $generator->exporterCSV($utilisateurs);